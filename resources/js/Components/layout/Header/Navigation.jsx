import { Link } from "@inertiajs/react";

export default function Navigation({ items, mobile = false }) {
    const baseClasses = mobile
        ? "flex flex-col space-y-1"
        : "hidden lg:flex items-center space-x-1";

    const linkClasses = mobile
        ? "flex items-center space-x-3 px-3 py-2 rounded-lg text-base font-medium text-[var(--header-footer-text-light)] dark:text-[var(--header-footer-text-dark)] dark:hover:bg-gray-800 hover:bg-gray-100 transition-colors"
        : "flex items-center space-x-2 px-3 py-1 rounded-lg text-sm font-medium text-[var(--header-footer-text-light)] dark:text-[var(--header-footer-text-dark)] dark:hover:bg-gray-800 hover:bg-gray-100 transition-all duration-200";

    return (
        <nav className={baseClasses}>
            {items.map((item) => (
                <Link
                    key={item.name}
                    href={item.href}
                    className={linkClasses}
                    onClick={mobile && item.onClick ? item.onClick : undefined}
                >
                    {mobile && item.icon && (
                        <span className="flex-shrink-0">{item.icon}</span>
                    )}
                    <span>{item.name}</span>
                </Link>
            ))}
        </nav>
    );
}
