/**
 * Modern section background for course/education site.
 * Variant A and B alternate for visual rhythm. Supports light + dark mode.
 */
export default function SectionBackground({ variant = "a" }) {
    const isA = variant === "a";

    return (
        <div
            className="absolute inset-0 overflow-hidden pointer-events-none"
            aria-hidden="true"
        >
            {/* Base gradient - theme-aware */}
            <div
                className="absolute inset-0 dark:hidden"
                style={{
                    background: isA
                        ? "linear-gradient(160deg, rgb(248 250 252) 0%, rgb(255 255 255) 35%, rgba(79, 70, 229, 0.05) 100%)"
                        : "linear-gradient(20deg, rgba(79, 70, 229, 0.04) 0%, rgb(255 255 255) 30%, rgb(241 245 249) 100%)",
                }}
            />
            <div
                className="absolute inset-0 hidden dark:block"
                style={{
                    background: isA
                        ? "linear-gradient(160deg, rgb(15 23 42) 0%, rgb(30 41 59) 40%, rgba(99, 102, 241, 0.09) 100%)"
                        : "linear-gradient(20deg, rgba(99, 102, 241, 0.07) 0%, rgb(15 23 42) 35%, rgb(30 41 59) 100%)",
                }}
            />

            {/* Ambient Multi-color Glowing Orbs */}
            <div
                className={`absolute w-[800px] h-[800px] rounded-full blur-[120px] opacity-30 dark:opacity-[0.15] pointer-events-none ${
                    isA
                        ? "-top-64 -right-32 bg-primary-400/40 dark:bg-primary-600/30"
                        : "-top-64 -left-32 bg-secondary-400/30 dark:bg-secondary-600/30"
                }`}
            />
            <div
                className={`absolute w-[600px] h-[600px] rounded-full blur-[100px] opacity-25 dark:opacity-10 pointer-events-none ${
                    isA
                        ? "-bottom-48 -left-48 bg-secondary-400/40 dark:bg-secondary-700/30"
                        : "-bottom-48 -right-48 bg-primary-400/30 dark:bg-primary-700/30"
                }`}
            />
            <div
                className={`absolute hidden md:block w-[500px] h-[500px] rounded-full blur-[100px] opacity-15 dark:opacity-5 pointer-events-none ${
                    isA
                        ? "top-1/4 left-1/3 bg-primary-300/30 dark:bg-primary-500/20"
                        : "top-1/4 right-1/3 bg-secondary-300/30 dark:bg-secondary-500/20"
                }`}
            />

            {/* Premium Fade-out Cartesian Grid */}
            <div
                className="absolute inset-0 opacity-[0.15] dark:opacity-[0.05] pointer-events-none"
                style={{
                    backgroundImage: `linear-gradient(to right, currentColor 1px, transparent 1px), linear-gradient(to bottom, currentColor 1px, transparent 1px)`,
                    backgroundSize: isA ? "64px 64px" : "48px 48px",
                    WebkitMaskImage: "radial-gradient(circle at center, black, transparent 80%)",
                    maskImage: "radial-gradient(circle at center, black, transparent 80%)"
                }}
            />

            {/* Subtle Diagonal Light Streaks (replaces dated waves) */}
            <div className="absolute inset-0 overflow-hidden pointer-events-none">
                <div
                    className={`absolute w-[150%] h-[2px] transform -rotate-12 bg-gradient-to-r from-transparent via-primary-500/20 dark:via-primary-400/10 to-transparent blur-[2px] ${
                        isA ? "top-1/4 -left-1/4" : "top-1/3 -right-1/4"
                    }`}
                />
                <div
                    className={`absolute w-[150%] h-[2px] transform rotate-12 bg-gradient-to-r from-transparent via-secondary-500/20 dark:via-secondary-400/10 to-transparent blur-[2px] ${
                        isA ? "bottom-1/3 -right-1/4" : "bottom-1/4 -left-1/4"
                    }`}
                />
            </div>

            {/* Floating vector shapes - abstract "cards" / "pages" (course vibe) */}
            <div
                className={`absolute top-[15%] ${isA ? "right-[12%]" : "left-[12%]"}`}
            >
                <div className="w-24 h-32 rounded-2xl border-2 border-primary-200/50 dark:border-primary-600/30 rotate-12 opacity-60 dark:opacity-30" />
            </div>
            <div
                className={`absolute top-[25%] ${isA ? "right-[22%]" : "left-[22%]"}`}
            >
                <div className="w-16 h-20 rounded-xl border-2 border-primary-300/40 dark:border-primary-500/25 -rotate-6 opacity-50 dark:opacity-25" />
            </div>
            <div
                className={`absolute bottom-[20%] ${isA ? "left-[15%]" : "right-[15%]"}`}
            >
                <div className="w-20 h-28 rounded-2xl border-2 border-secondary-200/50 dark:border-secondary-600/25 -rotate-12 opacity-50 dark:opacity-25" />
            </div>

            {/* Decorative circle clusters */}
            <div
                className={`absolute top-1/4 ${isA ? "left-[8%]" : "right-[8%]"}`}
            >
                <div className="w-3 h-3 rounded-full bg-primary-400/40 dark:bg-primary-500/30" />
                <div className="w-2 h-2 rounded-full bg-primary-300/50 dark:bg-primary-400/20 mt-4 ml-6" />
            </div>
            <div
                className={`absolute bottom-1/3 ${isA ? "right-[10%]" : "left-[10%]"}`}
            >
                <div className="w-2 h-2 rounded-full bg-secondary-400/40 dark:bg-secondary-500/25" />
                <div className="w-2.5 h-2.5 rounded-full bg-secondary-300/30 dark:bg-secondary-400/20 -mt-2 ml-8" />
            </div>

            {/* Subtle education icon: book outline (SVG) */}
            <svg
                className={`absolute h-16 w-16 opacity-[0.06] dark:opacity-[0.05] ${isA ? "bottom-[25%] left-[10%]" : "bottom-[25%] right-[10%]"}`}
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                strokeWidth="1.5"
                strokeLinecap="round"
                strokeLinejoin="round"
            >
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                <path d="M8 7h8" />
                <path d="M8 11h8" />
            </svg>

            {/* Subtle graduation cap icon */}
            <svg
                className={`absolute h-14 w-14 opacity-[0.05] dark:opacity-[0.04] ${isA ? "top-[18%] right-[8%]" : "top-[18%] left-[8%]"}`}
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                strokeWidth="1.2"
                strokeLinecap="round"
                strokeLinejoin="round"
            >
                <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                <path d="M6 12v5c3 3 9 3 12 0v-5" />
            </svg>

            {/* Play icon (video/course cue) */}
            <svg
                className={`absolute h-14 w-14 opacity-[0.06] dark:opacity-[0.05] text-primary-500 dark:text-primary-400 ${
                    isA ? "top-[55%] right-[18%]" : "top-[55%] left-[18%]"
                }`}
                viewBox="0 0 24 24"
                fill="currentColor"
            >
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z" />
            </svg>
        </div>
    );
}
