/**
 * Reusable section background with two variants for alternating sections.
 * Use variant="a" and variant="b" on consecutive sections for a stunning alternating look.
 */
export default function SectionBackground({ variant = "a" }) {
    const isA = variant === "a";

    return (
        <>
            {/* Base gradient - Variant A: warm primary tint | Variant B: cool, opposite flow */}
            <div
                className="absolute inset-0 dark:hidden"
                aria-hidden="true"
                style={{
                    background: isA
                        ? "linear-gradient(135deg, rgb(249 250 251) 0%, rgb(255 255 255) 45%, rgba(147, 51, 234, 0.07) 100%)"
                        : "linear-gradient(315deg, rgba(147, 51, 234, 0.05) 0%, rgb(255 255 255) 42%, rgb(243 244 246) 100%)",
                }}
            />
            <div
                className="absolute inset-0 hidden dark:block"
                aria-hidden="true"
                style={{
                    background: isA
                        ? "linear-gradient(135deg, rgb(17 24 39) 0%, rgb(17 24 39) 50%, rgba(76, 29, 149, 0.14) 100%)"
                        : "linear-gradient(315deg, rgba(76, 29, 149, 0.1) 0%, rgb(17 24 39) 48%, rgb(17 24 39) 100%)",
                }}
            />

            {/* Dot pattern - same effect, slightly different scale per variant */}
            <div
                className="absolute inset-0 opacity-[0.4] dark:opacity-[0.07]"
                style={{
                    backgroundImage: `radial-gradient(circle at 1px 1px, currentColor ${isA ? "1.25px" : "1px"}, transparent 0)`,
                    backgroundSize: isA ? "32px 32px" : "28px 28px",
                }}
                aria-hidden="true"
            />

            {/* Soft blobs - Variant A: top-right + bottom-left | Variant B: top-left + bottom-right */}
            {isA ? (
                <>
                    <div
                        className="absolute -top-40 -right-40 w-72 h-72 sm:w-80 sm:h-80 rounded-full bg-primary-200/40 dark:bg-primary-900/25 blur-3xl pointer-events-none"
                        aria-hidden="true"
                    />
                    <div
                        className="absolute -bottom-40 -left-40 w-72 h-72 sm:w-80 sm:h-80 rounded-full bg-primary-100/50 dark:bg-primary-900/30 blur-3xl pointer-events-none"
                        aria-hidden="true"
                    />
                </>
            ) : (
                <>
                    <div
                        className="absolute -top-40 -left-40 w-72 h-72 sm:w-80 sm:h-80 rounded-full bg-secondary-200/35 dark:bg-secondary-900/20 blur-3xl pointer-events-none"
                        aria-hidden="true"
                    />
                    <div
                        className="absolute -bottom-40 -right-40 w-72 h-72 sm:w-80 sm:h-80 rounded-full bg-primary-100/40 dark:bg-primary-900/25 blur-3xl pointer-events-none"
                        aria-hidden="true"
                    />
                </>
            )}
        </>
    );
}
