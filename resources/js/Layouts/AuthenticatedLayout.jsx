import ApplicationLogo from "@/Components/ApplicationLogo";
import AuthenticatedFooter from "@/Components/layout/AuthenticatedFooter";
import Avatar from "@/Components/ui/Avatar";
import DarkModeToggle from "@/Components/DarkModeToggle";
import Dropdown from "@/Components/Dropdown";
import LanguageSwitcher from "@/Components/LanguageSwitcher";
import Sidebar from "@/Components/layout/Sidebar";
import { Link, usePage } from "@inertiajs/react";
import { useState } from "react";

export default function AuthenticatedLayout({ header, children }) {
    const { auth, translations } = usePage().props;
    const user = auth.user;
    const t = translations?.common || {};

    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [showingNavigationDropdown, setShowingNavigationDropdown] =
        useState(false);

    return (
        <div className="min-h-screen bg-gray-50 dark:bg-gray-900">
            {/* Top Navigation Bar */}
            <nav className="fixed top-0 left-0 right-0 z-30 border-b border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div className="px-4 sm:px-6 lg:px-8">
                    <div className="flex h-16 justify-between">
                        {/* Left: Logo and Sidebar Toggle */}
                        <div className="flex items-center">
                            <button
                                onClick={() => setSidebarOpen(!sidebarOpen)}
                                className="mr-3 rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-700 dark:hover:text-gray-300 lg:hidden"
                            >
                                <svg
                                    className="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                </svg>
                            </button>
                            <Link href="/" className="flex items-center">
                                <div className="h-10 w-10 flex items-center justify-center">
                                    <ApplicationLogo variant="icon" />
                                </div>
                            </Link>
                        </div>

                        {/* Right: Language, Dark Mode, Avatar */}
                        <div className="flex items-center space-x-4">
                            <LanguageSwitcher />
                            <DarkModeToggle />
                            <div className="relative">
                                <Dropdown>
                                    <Dropdown.Trigger>
                                        <button
                                            type="button"
                                            className="flex items-center space-x-3 rounded-lg p-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                                        >
                                            <Avatar
                                                name={user.name}
                                                email={user.email}
                                                size="md"
                                            />
                                            <div className="hidden lg:block text-left">
                                                <p className="text-sm font-medium text-gray-900 dark:text-white">
                                                    {user.name}
                                                </p>
                                            </div>
                                            <svg
                                                className="hidden lg:block h-4 w-4 text-gray-500 dark:text-gray-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    strokeWidth={2}
                                                    d="M19 9l-7 7-7-7"
                                                />
                                            </svg>
                                        </button>
                                    </Dropdown.Trigger>

                                    <Dropdown.Content align="right" width="56">
                                        <div className="px-4 py-3 border-b border-gray-200 dark:border-gray-700 lg:hidden">
                                            <p className="text-sm font-medium text-gray-900 dark:text-white">
                                                {user.name}
                                            </p>
                                            <p className="text-xs text-gray-500 dark:text-gray-400 truncate">
                                                {user.email}
                                            </p>
                                        </div>
                                        <Dropdown.Link
                                            href={route("dashboard")}
                                        >
                                            <svg
                                                className="mr-3 h-5 w-5 text-gray-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    strokeWidth={2}
                                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                                                />
                                            </svg>
                                            {t.dashboard || "Dashboard"}
                                        </Dropdown.Link>
                                        <Dropdown.Link
                                            href={route("profile.edit")}
                                        >
                                            <svg
                                                className="mr-3 h-5 w-5 text-gray-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    strokeWidth={2}
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                                />
                                            </svg>
                                            {t.profile || "Profile"}
                                        </Dropdown.Link>
                                        {user.user_type === "admin" && (
                                            <>
                                                <div className="border-t border-gray-200 dark:border-gray-700"></div>
                                                <Dropdown.ExternalLink
                                                    href={route(
                                                        "admin.dashboard"
                                                    )}
                                                >
                                                    <svg
                                                        className="mr-3 h-5 w-5 text-gray-400"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            strokeLinecap="round"
                                                            strokeLinejoin="round"
                                                            strokeWidth={2}
                                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                                                        />
                                                    </svg>
                                                    Admin Dashboard
                                                </Dropdown.ExternalLink>
                                            </>
                                        )}
                                        <div className="border-t border-gray-200 dark:border-gray-700"></div>
                                        <Dropdown.Link
                                            href={route("logout")}
                                            method="post"
                                            as="button"
                                            className="text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20"
                                        >
                                            <svg
                                                className="mr-3 h-5 w-5 text-red-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    strokeWidth={2}
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                                />
                                            </svg>
                                            {t.logout || "Log Out"}
                                        </Dropdown.Link>
                                    </Dropdown.Content>
                                </Dropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            {/* Sidebar */}
            <Sidebar />

            {/* Mobile Sidebar Overlay */}
            {sidebarOpen && (
                <>
                    <div
                        className="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden"
                        onClick={() => setSidebarOpen(false)}
                    ></div>
                    <aside className="fixed left-0 top-0 z-50 h-screen w-64 border-r border-gray-200 bg-white pt-16 transition-transform dark:border-gray-700 dark:bg-gray-800 lg:hidden">
                        <div className="h-full overflow-y-auto px-3 py-4">
                            <div className="mb-6 flex items-center justify-between px-3">
                                <ApplicationLogo variant="icon" />
                                <button
                                    onClick={() => setSidebarOpen(false)}
                                    className="rounded-md p-2 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700"
                                >
                                    <svg
                                        className="h-6 w-6"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>
                            <ul className="space-y-2">
                                {[
                                    {
                                        name: t.dashboard || "Dashboard",
                                        href: route("dashboard"),
                                        icon: (
                                            <svg
                                                className="h-5 w-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    strokeWidth={2}
                                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                                                />
                                            </svg>
                                        ),
                                    },
                                    {
                                        name: "Courses",
                                        href: "#",
                                        icon: (
                                            <svg
                                                className="h-5 w-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    strokeWidth={2}
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                                />
                                            </svg>
                                        ),
                                    },
                                    {
                                        name: "My Learning",
                                        href: "#",
                                        icon: (
                                            <svg
                                                className="h-5 w-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    strokeWidth={2}
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                                                />
                                            </svg>
                                        ),
                                    },
                                    {
                                        name: "Progress",
                                        href: "#",
                                        icon: (
                                            <svg
                                                className="h-5 w-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    strokeWidth={2}
                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                                />
                                            </svg>
                                        ),
                                    },
                                    {
                                        name: "Certificates",
                                        href: "#",
                                        icon: (
                                            <svg
                                                className="h-5 w-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    strokeWidth={2}
                                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"
                                                />
                                            </svg>
                                        ),
                                    },
                                    {
                                        name: "Settings",
                                        href: route("profile.edit"),
                                        icon: (
                                            <svg
                                                className="h-5 w-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    strokeWidth={2}
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                                                />
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    strokeWidth={2}
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                />
                                            </svg>
                                        ),
                                    },
                                ].map((item) => {
                                    const isActive =
                                        route().current(
                                            item.href.replace("#", "")
                                        ) ||
                                        (item.href === route("dashboard") &&
                                            route().current("dashboard"));

                                    return (
                                        <li key={item.name}>
                                            <Link
                                                href={item.href}
                                                onClick={() =>
                                                    setSidebarOpen(false)
                                                }
                                                className={`flex items-center rounded-lg px-3 py-2.5 text-sm font-medium transition-colors ${
                                                    isActive
                                                        ? "bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-400"
                                                        : "text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                                                }`}
                                            >
                                                <span className="mr-3">
                                                    {item.icon}
                                                </span>
                                                {item.name}
                                            </Link>
                                        </li>
                                    );
                                })}
                            </ul>
                        </div>
                    </aside>
                </>
            )}

            {/* Main Content Area */}
            <div className="lg:pl-64 flex flex-col min-h-screen">
                {/* Header */}
                {header && (
                    <header className="sticky top-16 z-20 border-b border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div className="px-4 py-4 sm:px-6 lg:px-8">
                            {header}
                        </div>
                    </header>
                )}

                {/* Main Content */}
                <main className="flex-1">
                    <div className="px-4 py-8 sm:px-6 lg:px-8">{children}</div>
                </main>

                {/* Footer */}
                <AuthenticatedFooter />
            </div>
        </div>
    );
}
