export default function ApplicationLogo({
    className = "",
    variant = "default",
    textColor = "gradient",
}) {
    // Variant: default (full logo), icon (just the logo), text (just text)
    // textColor: gradient (default), white, dark
    const showIcon = variant === "default" || variant === "icon";
    const showText = variant === "default" || variant === "text";

    const textColorClasses = {
        gradient:
            "bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent dark:from-primary-400 dark:to-secondary-400",
        white: "text-white",
        dark: "text-gray-900 dark:text-white",
    };

    return (
        <div className={`flex items-center gap-3 ${className}`}>
            {showIcon && (
                <div className="relative">
                    {/* Circular background with gradient */}
                    <svg
                        width="60"
                        height="60"
                        viewBox="0 0 60 60"
                        className="drop-shadow-lg"
                    >
                        {/* Outer ring */}
                        <circle
                            cx="30"
                            cy="30"
                            r="28"
                            fill="url(#logoGradient)"
                        />
                        {/* Inner ring outline */}
                        <circle
                            cx="30"
                            cy="30"
                            r="24"
                            fill="none"
                            stroke="url(#accentGradient)"
                            strokeWidth="1.5"
                        />
                        {/* Book */}
                        <g transform="translate(30, 30)">
                            {/* Book pages */}
                            <rect
                                x="-12"
                                y="-8"
                                width="24"
                                height="16"
                                rx="2"
                                fill="url(#bookGradient)"
                            />
                            {/* Book spine */}
                            <line
                                x1="0"
                                y1="-8"
                                x2="0"
                                y2="8"
                                stroke="url(#spineGradient)"
                                strokeWidth="2"
                            />
                            {/* Book lines */}
                            <line
                                x1="-8"
                                y1="-4"
                                x2="8"
                                y2="-4"
                                stroke="url(#lineGradient)"
                                strokeWidth="0.5"
                            />
                            <line
                                x1="-8"
                                y1="0"
                                x2="8"
                                y2="0"
                                stroke="url(#lineGradient)"
                                strokeWidth="0.5"
                            />
                            <line
                                x1="-8"
                                y1="4"
                                x2="8"
                                y2="4"
                                stroke="url(#lineGradient)"
                                strokeWidth="0.5"
                            />
                        </g>
                        {/* Quill pen */}
                        <g transform="translate(30, 15)">
                            {/* Feather */}
                            <path
                                d="M -8 -6 Q -6 -8 -4 -6 Q -2 -4 0 -2 Q 2 -4 4 -6 Q 6 -8 8 -6 L 6 -10 Q 4 -12 2 -10 Q 0 -8 -2 -10 Q -4 -12 -6 -10 Z"
                                fill="url(#quillGradient)"
                            />
                            {/* Quill body */}
                            <ellipse
                                cx="0"
                                cy="-2"
                                rx="1.5"
                                ry="8"
                                fill="url(#quillBodyGradient)"
                            />
                        </g>
                        {/* Shadow effect */}
                        <ellipse
                            cx="30"
                            cy="45"
                            rx="18"
                            ry="4"
                            fill="rgba(0, 0, 0, 0.1)"
                            className="dark:fill-black/20"
                        />
                        {/* Gradients */}
                        <defs>
                            <linearGradient
                                id="logoGradient"
                                x1="0%"
                                y1="0%"
                                x2="100%"
                                y2="100%"
                            >
                                <stop offset="0%" stopColor="#4E56C0" />
                                <stop offset="100%" stopColor="#9B5DE0" />
                            </linearGradient>
                            <linearGradient
                                id="accentGradient"
                                x1="0%"
                                y1="0%"
                                x2="100%"
                                y2="100%"
                            >
                                <stop offset="0%" stopColor="#D78FEE" />
                                <stop offset="100%" stopColor="#FDCFFA" />
                            </linearGradient>
                            <linearGradient
                                id="bookGradient"
                                x1="0%"
                                y1="0%"
                                x2="100%"
                                y2="100%"
                            >
                                <stop offset="0%" stopColor="#FFFFFF" />
                                <stop offset="100%" stopColor="#E5E7EB" />
                            </linearGradient>
                            <linearGradient
                                id="spineGradient"
                                x1="0%"
                                y1="0%"
                                x2="0%"
                                y2="100%"
                            >
                                <stop offset="0%" stopColor="#4E56C0" />
                                <stop offset="100%" stopColor="#9B5DE0" />
                            </linearGradient>
                            <linearGradient
                                id="lineGradient"
                                x1="0%"
                                y1="0%"
                                x2="100%"
                                y2="0%"
                            >
                                <stop offset="0%" stopColor="#9CA3AF" />
                                <stop offset="100%" stopColor="#D1D5DB" />
                            </linearGradient>
                            <linearGradient
                                id="quillGradient"
                                x1="0%"
                                y1="0%"
                                x2="100%"
                                y2="100%"
                            >
                                <stop offset="0%" stopColor="#D78FEE" />
                                <stop offset="50%" stopColor="#FDCFFA" />
                                <stop offset="100%" stopColor="#FFB4C8" />
                            </linearGradient>
                            <linearGradient
                                id="quillBodyGradient"
                                x1="0%"
                                y1="0%"
                                x2="0%"
                                y2="100%"
                            >
                                <stop offset="0%" stopColor="#4E56C0" />
                                <stop offset="100%" stopColor="#9B5DE0" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
            )}
            {showText && (
                <div className="flex flex-col">
                    <span
                        className={`text-2xl font-bold ${textColorClasses[textColor]}`}
                    >
                        DARPON
                    </span>
                    <span
                        className={`text-xs font-semibold uppercase tracking-wider ${
                            textColor === "white"
                                ? "text-gray-300"
                                : "text-gray-600 dark:text-gray-400"
                        }`}
                    >
                        English Teaching Zone
                    </span>
                </div>
            )}
        </div>
    );
}
