import { Link } from "@inertiajs/react";

export default function PrimaryButton({
    href,
    className = "",
    children,
    icon = null,
    showIcon = true,
    ...props
}) {
    const defaultIcon = (
        <svg
            className="w-4 h-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2.5"
                d="M5 12h14M12 5l7 7-7 7"
            />
        </svg>
    );

    const renderIcon = icon || defaultIcon;

    const baseClasses = `group inline-flex items-center justify-center gap-3 bg-[#5A45FF] hover:bg-[#4a34e0] dark:bg-indigo-500 dark:hover:bg-indigo-400 text-white rounded-full ${
        showIcon ? "pl-6 pr-2 py-3" : "px-6 py-3"
    } transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-[1.02] ${className}`;

    const innerContent = (
        <>
            <span className="font-semibold text-sm sm:text-base">
                {children}
            </span>
            {showIcon && (
                <span className="bg-white/20 rounded-full p-2 group-hover:bg-white/30 transition-colors">
                    {renderIcon}
                </span>
            )}
        </>
    );

    if (href) {
        return (
            <Link href={href} className={baseClasses} {...props}>
                {innerContent}
            </Link>
        );
    }

    return (
        <button className={baseClasses} {...props}>
            {innerContent}
        </button>
    );
}
