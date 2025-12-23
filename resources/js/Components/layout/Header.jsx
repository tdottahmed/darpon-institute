import { useState } from "react";
import { Link, usePage } from "@inertiajs/react";
import Button from "../ui/Button";
import Avatar from "../ui/Avatar";
import Dropdown from "../Dropdown";
import LanguageSwitcher from "../LanguageSwitcher";
import DarkModeToggle from "../DarkModeToggle";
import ToastListener from "../ToastListener";

export default function Header() {
    const { auth, translations, frontend_content } = usePage().props;
    const t = translations?.common || {};
    const content = frontend_content?.header || {};
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

    const navigationItems = [
        {
            name: content.menu_home || "Home",
            href: route("home"),
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
            name: content.menu_courses || "Courses",
            href: route("courses.index"),
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
            name: content.menu_books || "Books",
            href: route("books.index"),
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
            name: content.menu_about || "About",
            href: "#about",
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
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
            ),
        },
        {
            name: content.menu_contact || "Contact",
            href: "#contact",
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
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                    />
                </svg>
            ),
        },
    ];

    return (
        <header className="sticky top-0 left-0 right-0 z-50 bg-white/95 dark:bg-gray-900/95 backdrop-blur-md border-b border-gray-200 dark:border-gray-800 shadow-sm">
            <ToastListener />
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex h-16 items-center justify-between">
                    {/* Logo */}
                    <Link
                        href={route("home")}
                        className="flex items-center space-x-3 group"
                    >
                        <div className="relative flex-shrink-0">
                            <img
                                src="/darponbdv.png"
                                alt="Darpon Logo"
                                className="h-12 w-auto transition-transform duration-300 group-hover:scale-105"
                            />
                        </div>
                    </Link>

                    {/* Desktop Navigation */}
                    <nav className="hidden lg:flex items-center space-x-1">
                        {navigationItems.map((item) => (
                            <Link
                                key={item.name}
                                href={item.href}
                                className="flex items-center space-x-2 px-3 py-1 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200"
                            >
                                <span>{item.name}</span>
                            </Link>
                        ))}
                    </nav>

                    {/* Right Side Actions */}
                    <div className="hidden lg:flex items-center space-x-3">
                        <LanguageSwitcher />
                        <DarkModeToggle />
                        {auth?.user ? (
                            <div className="relative">
                                <Dropdown>
                                    <Dropdown.Trigger>
                                        <button
                                            type="button"
                                            className="flex items-center space-x-2 rounded-lg px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                                        >
                                            <Avatar
                                                name={auth.user.name}
                                                email={auth.user.email}
                                                size="sm"
                                            />
                                            <div className="hidden xl:block text-left">
                                                <p className="text-sm font-medium text-gray-900 dark:text-white">
                                                    {auth.user.name}
                                                </p>
                                            </div>
                                        </button>
                                    </Dropdown.Trigger>

                                    <Dropdown.Content align="right" width="56">
                                        <div className="px-4 py-3 border-b border-gray-200 dark:border-gray-700 xl:hidden">
                                            <p className="text-sm font-medium text-gray-900 dark:text-white">
                                                {auth.user.name}
                                            </p>
                                            <p className="text-xs text-gray-500 dark:text-gray-400 truncate">
                                                {auth.user.email}
                                            </p>
                                        </div>
                                        {auth?.user &&
                                            auth.user.user_type === "admin" && (
                                                <>
                                                    <div className="border-t border-gray-200 dark:border-gray-700"></div>
                                                    <Dropdown.ExternalLink
                                                        href={route(
                                                            "admin.dashboard"
                                                        )}
                                                    >
                                                        Admin Dashboard
                                                    </Dropdown.ExternalLink>
                                                </>
                                            )}
                                        <Dropdown.Link
                                            href={route("dashboard")}
                                        >
                                            {content.auth_dashboard ||
                                                "Dashboard"}
                                        </Dropdown.Link>
                                        <Dropdown.Link
                                            href={route("profile.edit")}
                                        >
                                            {content.auth_profile || "Profile"}
                                        </Dropdown.Link>
                                        <div className="border-t border-gray-200 dark:border-gray-700"></div>
                                        <Dropdown.Link
                                            href={route("logout")}
                                            method="post"
                                            as="button"
                                            className="text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20"
                                        >
                                            {content.auth_logout || "Log Out"}
                                        </Dropdown.Link>
                                    </Dropdown.Content>
                                </Dropdown>
                            </div>
                        ) : (
                            <>
                                <Button
                                    href={route("login")}
                                    variant="text"
                                    size="sm"
                                    className="hidden xl:inline-flex"
                                >
                                    {content.auth_login || "Log in"}
                                </Button>
                                <Button
                                    href={route("register")}
                                    variant="primary"
                                    size="sm"
                                >
                                    {content.auth_register || "Get Started"}
                                </Button>
                            </>
                        )}
                    </div>

                    {/* Mobile Menu Button */}
                    <button
                        onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                        className="lg:hidden p-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                        aria-label="Toggle menu"
                    >
                        <svg
                            className="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            {mobileMenuOpen ? (
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            ) : (
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                            )}
                        </svg>
                    </button>
                </div>

                {/* Mobile Menu */}
                {mobileMenuOpen && (
                    <div className="lg:hidden py-3 border-t border-gray-200 dark:border-gray-800 animate-in slide-in-from-top-2 duration-200">
                        {/* Navigation Links */}
                        <nav className="flex flex-col space-y-1 mb-4">
                            {navigationItems.map((item) => (
                                <Link
                                    key={item.name}
                                    href={item.href}
                                    className="flex items-center space-x-3 px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                                    onClick={() => setMobileMenuOpen(false)}
                                >
                                    <span>{item.name}</span>
                                </Link>
                            ))}
                        </nav>

                        {/* User Section */}
                        <div className="pt-4 border-t border-gray-200 dark:border-gray-800 space-y-3">
                            {auth?.user ? (
                                <>
                                    <div className="flex items-center space-x-3 px-3 py-2 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                                        <Avatar
                                            name={auth.user.name}
                                            email={auth.user.email}
                                            size="md"
                                        />
                                        <div className="flex-1 min-w-0">
                                            <p className="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                {auth.user.name}
                                            </p>
                                            <p className="text-xs text-gray-500 dark:text-gray-400 truncate">
                                                {auth.user.email}
                                            </p>
                                        </div>
                                    </div>
                                    <div className="space-y-1">
                                        {auth.user.user_type === "admin" && (
                                            <Link
                                                href={route("admin.dashboard")}
                                                className="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                                                onClick={() =>
                                                    setMobileMenuOpen(false)
                                                }
                                            >
                                                <span>Admin Dashboard</span>
                                            </Link>
                                        )}
                                        <Link
                                            href={route("dashboard")}
                                            className="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                                            onClick={() =>
                                                setMobileMenuOpen(false)
                                            }
                                        >
                                            <span>
                                                {content.auth_dashboard ||
                                                    "Dashboard"}
                                            </span>
                                        </Link>
                                        <Link
                                            href={route("profile.edit")}
                                            className="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                                            onClick={() =>
                                                setMobileMenuOpen(false)
                                            }
                                        >
                                            <span>
                                                {content.auth_profile ||
                                                    "Profile"}
                                            </span>
                                        </Link>
                                        <Link
                                            href={route("logout")}
                                            method="post"
                                            as="button"
                                            className="flex items-center space-x-3 w-full text-left px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 transition-colors"
                                            onClick={() =>
                                                setMobileMenuOpen(false)
                                            }
                                        >
                                            <span>
                                                {content.auth_logout ||
                                                    "Log Out"}
                                            </span>
                                        </Link>
                                    </div>
                                </>
                            ) : (
                                <div className="flex flex-col space-y-2 px-3">
                                    <Button
                                        href={route("login")}
                                        variant="text"
                                        size="sm"
                                        className="w-full justify-center"
                                        onClick={() => setMobileMenuOpen(false)}
                                    >
                                        {content.auth_login || "Log in"}
                                    </Button>
                                    <Button
                                        href={route("register")}
                                        variant="primary"
                                        size="sm"
                                        className="w-full justify-center"
                                        onClick={() => setMobileMenuOpen(false)}
                                    >
                                        {content.auth_register || "Get Started"}
                                    </Button>
                                </div>
                            )}
                            {/* Language & Dark Mode Toggle */}
                            <div className="flex items-center justify-center space-x-4 px-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                <LanguageSwitcher />
                                <DarkModeToggle />
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </header>
    );
}
