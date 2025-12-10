import { useState } from "react";
import { Link, usePage } from "@inertiajs/react";
import Button from "../ui/Button";
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
                    <Link href="/" className="flex items-center space-x-2">
                        <div className="h-10 w-10 rounded-lg bg-gradient-to-br from-primary-600 to-secondary-600 p-2">
                            <span className="text-white text-xl font-bold">
                                D
                            </span>
                        </div>
                        <span className="text-xl font-bold text-primary-600 dark:text-primary-400">
                            {import.meta.env.VITE_APP_NAME || "Darpon"}
                        </span>
                    </Link>

                    {/* Desktop Navigation */}
                    <nav className="hidden md:flex items-center space-x-6">
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
                            <Button
                                href={route("dashboard")}
                                variant="primary"
                                size="sm"
                            >
                                {t.dashboard || "Dashboard"}
                            </Button>
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
                        <nav className="flex flex-col space-y-3">
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
                        <div className="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-800">
                            <div className="flex items-center space-x-2">
                                <LanguageSwitcher />
                                <DarkModeToggle />
                            </div>
                            <div className="flex items-center space-x-2">
                                {auth?.user ? (
                                    <Button
                                        href={route("dashboard")}
                                        variant="primary"
                                        size="sm"
                                    >
                                        Dashboard
                                    </Button>
                                ) : (
                                    <>
                                        <Button
                                            href={route("login")}
                                            variant="text"
                                            size="sm"
                                        >
                                            Log in
                                        </Button>
                                        <Button
                                            href={route("register")}
                                            variant="primary"
                                            size="sm"
                                        >
                                            Get Started
                                        </Button>
                                    </>
                                )}
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </header>
    );
}
