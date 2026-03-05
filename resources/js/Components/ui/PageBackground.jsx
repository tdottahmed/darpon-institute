/**
 * Full-page background for dashboard / marketing pages.
 * Use once per layout, underneath content (absolute inset-0, z-0).
 * Sections can still use SectionBackground on top if needed.
 */
export default function PageBackground({ variant = "default" }) {
    const isAlt = variant === "alt";

    return (
        <div
            className="absolute inset-0 -z-10 overflow-hidden pointer-events-none"
            aria-hidden="true"
        >
            {/* Base gradient linked to header/footer theme but richer */}
            <div
                className="absolute inset-0 dark:hidden"
                style={{
                    background: isAlt
                        ? "radial-gradient(circle at top left, rgba(79,70,229,0.06) 0, transparent 55%), radial-gradient(circle at bottom right, rgba(14,165,233,0.05) 0, transparent 55%), linear-gradient(180deg, rgb(249 250 251) 0%, rgb(255 255 255) 45%, rgb(241 245 249) 100%)"
                        : "radial-gradient(circle at top right, rgba(79,70,229,0.06) 0, transparent 55%), radial-gradient(circle at bottom left, rgba(34,197,94,0.05) 0, transparent 55%), linear-gradient(180deg, rgb(248 250 252) 0%, rgb(255 255 255) 40%, rgb(241 245 249) 100%)",
                }}
            />
            <div
                className="absolute inset-0 hidden dark:block"
                style={{
                    background: isAlt
                        ? "radial-gradient(circle at top left, rgba(129,140,248,0.16) 0, transparent 55%), radial-gradient(circle at bottom right, rgba(56,189,248,0.14) 0, transparent 55%), linear-gradient(180deg, rgb(15 23 42) 0%, rgb(15 23 42) 40%, rgb(15 23 42) 100%)"
                        : "radial-gradient(circle at top right, rgba(129,140,248,0.18) 0, transparent 55%), radial-gradient(circle at bottom left, rgba(34,197,94,0.16) 0, transparent 55%), linear-gradient(180deg, rgb(15 23 42) 0%, rgb(15 23 42) 35%, rgb(15 23 42) 100%)",
                }}
            />

            {/* Global grid, very soft */}
            <div
                className="absolute inset-0 opacity-[0.06] dark:opacity-[0.04]"
                style={{
                    backgroundImage:
                        "linear-gradient(to right, rgba(148,163,184,0.4) 1px, transparent 1px), linear-gradient(to bottom, rgba(148,163,184,0.4) 1px, transparent 1px)",
                    backgroundSize: isAlt ? "80px 80px" : "64px 64px",
                    WebkitMaskImage:
                        "radial-gradient(circle at center, black 40%, transparent 80%)",
                    maskImage:
                        "radial-gradient(circle at center, black 40%, transparent 80%)",
                }}
            />

            {/* Ambient orbs for depth */} 
            <div className="absolute w-[720px] h-[720px] -top-72 left-[-10%] rounded-full bg-primary-500/10 dark:bg-primary-500/14 blur-[120px]" />
            <div className="absolute w-[640px] h-[640px] -bottom-72 right-[-5%] rounded-full bg-emerald-400/10 dark:bg-emerald-400/14 blur-[120px]" />

            {/* Soft diagonal streaks */} 
            <div className="absolute inset-0">
                <div className="absolute w-[160%] h-px -rotate-6 top-1/3 left-[-30%] bg-gradient-to-r from-transparent via-white/35 dark:via-slate-200/15 to-transparent" />
                <div className="absolute w-[150%] h-px rotate-6 bottom-1/4 right-[-25%] bg-gradient-to-r from-transparent via-primary-400/30 dark:via-primary-400/20 to-transparent" />
            </div>

            {/* Subtle education glyphs (static, very low opacity) */}
            <svg
                className="absolute w-16 h-16 top-24 left-[6%] text-primary-500/10 dark:text-primary-400/10"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                strokeWidth="1.3"
                strokeLinecap="round"
                strokeLinejoin="round"
            >
                <path d="M4 4h16v4H4z" />
                <path d="M6 8v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V8" />
                <path d="M10 12h4" />
            </svg>

            <svg
                className="absolute w-14 h-14 bottom-28 right-[8%] text-secondary-500/10 dark:text-secondary-400/10"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                strokeWidth="1.3"
                strokeLinecap="round"
                strokeLinejoin="round"
            >
                <path d="M3 17h18" />
                <path d="M7 17V7l5-3 5 3v10" />
                <path d="M9 13h6" />
            </svg>
        </div>
    );
}

