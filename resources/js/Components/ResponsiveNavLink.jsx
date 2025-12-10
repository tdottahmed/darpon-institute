import { Link } from "@inertiajs/react";

export default function ResponsiveNavLink({
    active = false,
    className = "",
    children,
    ...props
}) {
    return (
        <Link
            {...props}
            className={`flex w-full items-start border-l-4 py-2 pe-4 ps-3 ${
                active
                    ? "border-primary-500 bg-primary-50 text-primary-700 focus:border-primary-700 focus:bg-primary-100 focus:text-primary-800 dark:border-primary-400 dark:bg-primary-900/20 dark:text-primary-300 dark:focus:bg-primary-900/30 dark:focus:text-primary-200"
                    : "border-transparent text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800 focus:border-gray-300 focus:bg-gray-50 focus:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:bg-gray-700 dark:focus:text-gray-300"
            } text-base font-medium transition duration-150 ease-in-out focus:outline-none ${className}`}
        >
            {children}
        </Link>
    );
}
