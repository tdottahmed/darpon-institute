import ApplicationLogo from "@/Components/ApplicationLogo";
import AuthenticatedFooter from "@/Components/layout/AuthenticatedFooter";
import Avatar from "@/Components/ui/Avatar";
import DarkModeToggle from "@/Components/DarkModeToggle";
import Dropdown from "@/Components/Dropdown";
import LanguageSwitcher from "@/Components/LanguageSwitcher";
import Sidebar from "@/Components/layout/Sidebar";
import { Link, usePage, router } from "@inertiajs/react";
import { useState } from "react";
import ToastListener from "@/Components/ToastListener";
import { Home, BookOpen, GraduationCap, User } from "lucide-react";

export default function AuthenticatedLayout({ header, children }) {
    const { auth, translations } = usePage().props;
    const user = auth.user;
    const t = translations?.common || {};

    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [showingNavigationDropdown, setShowingNavigationDropdown] =
        useState(false);

    return (
        <div className="min-h-screen bg-gray-50 dark:bg-gray-900">
            <ToastListener />

            {/* Top Navigation Bar - Fixed at top */}
            <nav className="fixed top-0 left-0 right-0 z-50 h-16 border-b border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div className="px-4 sm:px-6 lg:px-8">
                    <div className="flex h-16 items-center justify-between">
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
                            <Link
                                href={route("home")}
                                className="flex items-center gap-2 group"
                            >
                                <img
                                    src="/darponbdv.png"
                                    alt="Darpon Logo"
                                    className="h-10 w-auto transition-transform duration-200 group-hover:scale-105"
                                    onError={(e) => {
                                        e.target.style.display = "none";
                                        if (e.target.nextElementSibling) {
                                            e.target.nextElementSibling.style.display =
                                                "flex";
                                        }
                                    }}
                                />
                                <div className="h-10 w-10 hidden items-center justify-center">
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

            {/* Sidebar - Fixed below header */}
            <Sidebar />

            {/* Mobile Sidebar Overlay */}
            {sidebarOpen && (
                <>
                    <div
                        className="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden"
                        onClick={() => setSidebarOpen(false)}
                    ></div>
                    <aside className="fixed left-0 top-16 z-50 h-[calc(100vh-4rem)] w-64 border-r border-gray-200 bg-white transition-transform dark:border-gray-700 dark:bg-gray-800 lg:hidden">
                        <div className="h-full overflow-y-auto px-3 py-4">
                            <div className="mb-4 flex items-center justify-end">
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
                                {(() => {
                                    const urlParams = new URLSearchParams(
                                        window.location.search
                                    );
                                    const activeSection =
                                        urlParams.get("section") || "overview";

                                    const menuItems = [
                                        {
                                            id: "overview",
                                            name: "Overview",
                                            section: "overview",
                                            icon: Home,
                                        },
                                        {
                                            id: "books",
                                            name: "Purchased Books",
                                            section: "books",
                                            icon: BookOpen,
                                        },
                                        {
                                            id: "courses",
                                            name: "Purchased Courses",
                                            section: "courses",
                                            icon: GraduationCap,
                                        },
                                        {
                                            id: "profile",
                                            name: "Profile & Settings",
                                            section: "profile",
                                            icon: User,
                                        },
                                    ];

                                    return menuItems.map((item) => {
                                        const isActive =
                                            activeSection === item.section;
                                        const IconComponent = item.icon;

                                        return (
                                            <li key={item.id}>
                                                <button
                                                    onClick={() => {
                                                        router.get(
                                                            route("dashboard"),
                                                            {
                                                                section:
                                                                    item.section,
                                                            },
                                                            {
                                                                preserveState: true,
                                                                replace: true,
                                                            }
                                                        );
                                                        setSidebarOpen(false);
                                                    }}
                                                    className={`flex w-full items-center rounded-lg px-3 py-2.5 text-sm font-medium transition-colors ${
                                                        isActive
                                                            ? "bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-400"
                                                            : "text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                                                    }`}
                                                >
                                                    <IconComponent className="mr-3 h-5 w-5" />
                                                    {item.name}
                                                </button>
                                            </li>
                                        );
                                    });
                                })()}
                            </ul>
                        </div>
                    </aside>
                </>
            )}

            {/* Main Content Area - Starts below header, next to sidebar */}
            <div className="pt-16 lg:pl-64 flex flex-col min-h-screen">
                {/* Optional Page Header */}
                {header && (
                    <header className="sticky top-16 z-20 border-b border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div className="px-4 py-4 sm:px-6 lg:px-8">
                            {header}
                        </div>
                    </header>
                )}

                {/* Main Content */}
                <main className="flex-1 bg-gray-50 dark:bg-gray-900">
                    <div className="px-4 py-6 sm:px-6 lg:px-8">{children}</div>
                </main>

                {/* Footer */}
                <AuthenticatedFooter />
            </div>
        </div>
    );
}
