import { useState } from "react";
import { Link, usePage } from "@inertiajs/react";
import Button from "../ui/Button";
import ApplicationLogo from "../ApplicationLogo";
import Avatar from "../ui/Avatar";
import Dropdown from "../Dropdown";
import LanguageSwitcher from "../LanguageSwitcher";
import DarkModeToggle from "../DarkModeToggle";

export default function Header() {
    const { auth, translations } = usePage().props;
    const t = translations?.common || {};
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

    return (
        <header className="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex h-16 items-center justify-between">
                    {/* Logo */}
                    <Link href="/" className="flex items-center">
                        <ApplicationLogo variant="default" />
                    </Link>

                    <nav className="hidden md:flex items-center space-x-6">
                        <Link
                            href="#courses"
                            className="text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400 transition-colors"
                        >
                            Courses
                        </Link>
                        <Link
                            href="#features"
                            className="text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400 transition-colors"
                        >
                            Features
                        </Link>
                        <Link
                            href="#testimonials"
                            className="text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400 transition-colors"
                        >
                            Testimonials
                        </Link>
                        <Link
                            href="#blog"
                            className="text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400 transition-colors"
                        >
                            Blog
                        </Link>
                    </nav>

                    {/* Right Side Actions */}
                    <div className="hidden md:flex items-center space-x-4">
                        <LanguageSwitcher />
                        <DarkModeToggle />
                        {auth?.user ? (
                            <div className="relative">
                                <Dropdown>
                                    <Dropdown.Trigger>
                                        <button
                                            type="button"
                                            className="flex items-center space-x-3 rounded-lg p-2 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                                        >
                                            <Avatar
                                                name={auth.user.name}
                                                email={auth.user.email}
                                                size="md"
                                            />
                                            <div className="hidden lg:block text-left">
                                                <p className="text-sm font-medium text-gray-900 dark:text-white">
                                                    {auth.user.name}
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
                        ) : (
                            <>
                                <Button
                                    href={route("login")}
                                    variant="text"
                                    size="sm"
                                >
                                    {t.login || "Log in"}
                                </Button>
                                <Button
                                    href={route("register")}
                                    variant="primary"
                                    size="sm"
                                >
                                    {t.register || "Get Started"}
                                </Button>
                            </>
                        )}
                    </div>

                    {/* Mobile Menu Button */}
                    <button
                        onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                        className="md:hidden p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800"
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
                    <div className="md:hidden py-4 space-y-4 border-t border-gray-200 dark:border-gray-800">
                        {!auth?.user && (
                            <nav className="flex flex-col space-y-3">
                                <Link
                                    href="#courses"
                                    className="text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400"
                                    onClick={() => setMobileMenuOpen(false)}
                                >
                                    Courses
                                </Link>
                                <Link
                                    href="#features"
                                    className="text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400"
                                    onClick={() => setMobileMenuOpen(false)}
                                >
                                    Features
                                </Link>
                                <Link
                                    href="#testimonials"
                                    className="text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400"
                                    onClick={() => setMobileMenuOpen(false)}
                                >
                                    Testimonials
                                </Link>
                                <Link
                                    href="#blog"
                                    className="text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400"
                                    onClick={() => setMobileMenuOpen(false)}
                                >
                                    Blog
                                </Link>
                            </nav>
                        )}
                        <div className="pt-4 border-t border-gray-200 dark:border-gray-800 space-y-4">
                            {auth?.user && (
                                <div className="flex items-center space-x-3 pb-4 border-b border-gray-200 dark:border-gray-700">
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
                            )}
                            {auth?.user && (
                                <div className="space-y-2">
                                    <Link
                                        href={route("dashboard")}
                                        className="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                                        onClick={() => setMobileMenuOpen(false)}
                                    >
                                        {t.dashboard || "Dashboard"}
                                    </Link>
                                    <Link
                                        href={route("profile.edit")}
                                        className="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                                        onClick={() => setMobileMenuOpen(false)}
                                    >
                                        {t.profile || "Profile"}
                                    </Link>
                                    <Link
                                        href={route("logout")}
                                        method="post"
                                        as="button"
                                        className="block w-full text-left px-3 py-2 rounded-md text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20"
                                        onClick={() => setMobileMenuOpen(false)}
                                    >
                                        {t.logout || "Log Out"}
                                    </Link>
                                </div>
                            )}
                            {!auth?.user && (
                                <div className="flex flex-col space-y-2">
                                    <Button
                                        href={route("login")}
                                        variant="text"
                                        size="sm"
                                        className="w-full justify-center"
                                    >
                                        {t.login || "Log in"}
                                    </Button>
                                    <Button
                                        href={route("register")}
                                        variant="primary"
                                        size="sm"
                                        className="w-full justify-center"
                                    >
                                        {t.register || "Get Started"}
                                    </Button>
                                </div>
                            )}
                            <div className="flex items-center justify-center space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
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
