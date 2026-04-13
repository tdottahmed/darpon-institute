#!/usr/bin/env bash
# make-patch.sh — Build frontend and create a deployment patch zip
#
# Usage:
#   ./make-patch.sh          # interactive commit picker
#   ./make-patch.sh <from>   # from that commit to HEAD (no prompt)
#   ./make-patch.sh <from> <to>  # exact range (no prompt)

set -euo pipefail

PATCH_DIR="patches"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")

# ── Helpers ───────────────────────────────────────────────────────────────────
pick_commit() {
    local prompt="$1"
    local default_index="${2:-}"

    # Build commit list: short-hash  date  message
    mapfile -t COMMITS < <(git log --oneline --format="%h  %ad  %s" --date=short | head -30)

    echo ""
    echo "$prompt"
    echo "──────────────────────────────────────────────────────────────────"
    for i in "${!COMMITS[@]}"; do
        printf "  [%2d]  %s\n" "$((i+1))" "${COMMITS[$i]}"
    done
    echo "──────────────────────────────────────────────────────────────────"
    echo "  (Enter a number, or paste any commit hash directly)"

    local choice resolved
    while true; do
        if [[ -n "$default_index" ]]; then
            read -rp "  Your choice [default: $default_index]: " choice
            choice="${choice:-$default_index}"
        else
            read -rp "  Your choice: " choice
        fi

        # Numeric → pick from list
        if [[ "$choice" =~ ^[0-9]+$ ]]; then
            if (( choice >= 1 && choice <= ${#COMMITS[@]} )); then
                echo "${COMMITS[$((choice-1))]}" | awk '{print $1}'
                return
            fi
            echo "  Invalid number. Pick 1–${#COMMITS[@]}, or paste a commit hash."
            continue
        fi

        # Looks like a hash → validate it with git
        if resolved=$(git rev-parse --verify --quiet "$choice^{commit}" 2>/dev/null); then
            echo "$resolved"
            return
        fi

        echo "  '$choice' is not a valid commit. Try again."
    done
}

# ── Determine diff range ──────────────────────────────────────────────────────
if [[ $# -ge 2 ]]; then
    FROM="$1"
    TO="$2"
elif [[ $# -eq 1 ]]; then
    FROM="$1"
    TO="HEAD"
else
    echo ""
    echo "  make-patch — interactive patch builder"
    echo ""
    echo "  Select the FROM commit (the last deployed commit, older one)."
    FROM=$(pick_commit "FROM commit — last deployed state (older):" "2")

    echo ""
    echo "  Select the TO commit (what you want to deploy now)."
    TO=$(pick_commit "TO commit — target state to deploy (newer):" "1")
fi

FROM_SHORT=$(git rev-parse --short "$FROM")
TO_SHORT=$(git rev-parse --short "$TO")

# Sanity check: FROM should be an ancestor of TO
if ! git merge-base --is-ancestor "$FROM_SHORT" "$TO_SHORT" 2>/dev/null; then
    echo ""
    echo "  Warning: $FROM_SHORT is not an ancestor of $TO_SHORT."
    echo "  The diff may include unexpected changes. Continue? (y/N)"
    read -rp "  " confirm
    [[ "$confirm" =~ ^[Yy]$ ]] || { echo "Aborted."; exit 1; }
fi

ZIP_NAME="${PATCH_DIR}/patch_${FROM_SHORT}_to_${TO_SHORT}_${TIMESTAMP}.zip"

echo ""
echo "==> Patch range: $FROM_SHORT → $TO_SHORT"

# ── Build frontend ────────────────────────────────────────────────────────────
echo "==> Running npm build..."
npm run build

# ── Collect changed files ─────────────────────────────────────────────────────
echo "==> Collecting changed files..."
CHANGED_FILES=$(git diff --name-only "$FROM" "$TO" -- . \
    | grep -v '^node_modules/' \
    | grep -v '^\.git/' \
    || true)

if [[ -z "$CHANGED_FILES" ]]; then
    echo "    No tracked files changed between $FROM_SHORT and $TO_SHORT."
else
    echo "    Changed files:"
    while IFS= read -r f; do
        # Mark deleted vs added/modified
        if [[ ! -e "$f" ]]; then
            echo "      - $f  (deleted)"
        else
            echo "      + $f"
        fi
    done <<< "$CHANGED_FILES"
fi

# ── Confirm before building zip ───────────────────────────────────────────────
echo ""
read -rp "==> Build patch zip? (Y/n): " go
go="${go:-Y}"
[[ "$go" =~ ^[Yy]$ ]] || { echo "Aborted."; exit 0; }

# ── Prepare staging area ──────────────────────────────────────────────────────
STAGING=$(mktemp -d)
trap 'rm -rf "$STAGING"' EXIT

if [[ -n "$CHANGED_FILES" ]]; then
    while IFS= read -r file; do
        if [[ ! -e "$file" ]]; then
            continue  # deleted — skip
        fi
        dest="$STAGING/$file"
        mkdir -p "$(dirname "$dest")"
        cp "$file" "$dest"
    done <<< "$CHANGED_FILES"
fi

# Always include public/build (Vite output, not tracked by git)
echo "==> Including public/build/..."
mkdir -p "$STAGING/public"
cp -r public/build "$STAGING/public/build"

# Include vendor only if composer files changed
if echo "$CHANGED_FILES" | grep -qE '^composer\.(json|lock)$'; then
    echo "==> composer.json/lock changed — including vendor/..."
    cp -r vendor "$STAGING/vendor"
fi

# ── Create zip ────────────────────────────────────────────────────────────────
mkdir -p "$PATCH_DIR"
echo "==> Creating $ZIP_NAME ..."
(cd "$STAGING" && zip -r - .) > "$ZIP_NAME"

echo ""
echo "  Done! Patch zip:"
echo "  $ZIP_NAME"
echo ""
echo "  Upload to hosting → cPanel File Manager → Extract into project root."
