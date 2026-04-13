#!/usr/bin/env bash
# make-patch.sh — Build frontend and create a deployment patch zip
#
# Usage:
#   ./make-patch.sh                    # diff from last tagged release
#   ./make-patch.sh <from-commit>      # diff from that commit to HEAD
#   ./make-patch.sh <from> <to>        # diff between two commits
#
# The zip is placed in ./patches/ and contains:
#   - All git-tracked files changed between the two refs
#   - public/build/  (always included — not tracked by git)
#   - vendor/        (included only if composer.json or composer.lock changed)

set -euo pipefail

PATCH_DIR="patches"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")

# ── Determine diff range ──────────────────────────────────────────────────────
if [[ $# -ge 2 ]]; then
    FROM="$1"
    TO="$2"
elif [[ $# -eq 1 ]]; then
    FROM="$1"
    TO="HEAD"
else
    # Default: last git tag → HEAD
    FROM=$(git describe --tags --abbrev=0 2>/dev/null || true)
    TO="HEAD"
    if [[ -z "$FROM" ]]; then
        echo "No tags found. Please pass a commit hash or tag as the first argument."
        echo "  e.g.: ./make-patch.sh abc1234"
        exit 1
    fi
fi

FROM_SHORT=$(git rev-parse --short "$FROM")
TO_SHORT=$(git rev-parse --short "$TO")
ZIP_NAME="${PATCH_DIR}/patch_${FROM_SHORT}_to_${TO_SHORT}_${TIMESTAMP}.zip"

echo "==> Patch range: $FROM_SHORT → $TO_SHORT"

# ── Build frontend ────────────────────────────────────────────────────────────
echo "==> Running npm build..."
npm run build

# ── Collect changed files (tracked by git) ───────────────────────────────────
echo "==> Collecting changed files..."
CHANGED_FILES=$(git diff --name-only "$FROM" "$TO" -- . \
    | grep -v '^node_modules/' \
    | grep -v '^\.git/' \
    || true)

if [[ -z "$CHANGED_FILES" ]]; then
    echo "    No tracked files changed between $FROM_SHORT and $TO_SHORT."
fi

# ── Prepare staging area ──────────────────────────────────────────────────────
STAGING=$(mktemp -d)
trap 'rm -rf "$STAGING"' EXIT

# Copy changed tracked files
if [[ -n "$CHANGED_FILES" ]]; then
    while IFS= read -r file; do
        # Skip deleted files
        if [[ ! -e "$file" ]]; then
            echo "    [deleted, skipping] $file"
            continue
        fi
        dest="$STAGING/$file"
        mkdir -p "$(dirname "$dest")"
        cp "$file" "$dest"
        echo "    + $file"
    done <<< "$CHANGED_FILES"
fi

# Always include public/build (frontend assets, not tracked by git)
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
echo "Done! Patch zip created:"
echo "  $ZIP_NAME"
echo ""
echo "Upload this zip to your hosting and extract it into the project root via"
echo "cPanel File Manager → Extract, or your FTP client's unzip feature."
