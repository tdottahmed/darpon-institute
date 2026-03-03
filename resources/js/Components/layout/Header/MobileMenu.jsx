import { Link, usePage } from "@inertiajs/react";
import Avatar from "../../ui/Avatar";
import Button from "../../ui/Button";
import Navigation from "./Navigation";
import LanguageSwitcher from "../../LanguageSwitcher";
import DarkModeToggle from "../../DarkModeToggle";
import Search from "./Search";

export default function MobileMenu({
    isOpen,
    onClose,
    navigationItems,
    content = {},
}) {
    const { auth } = usePage().props;
    const user = auth?.user;

    if (!isOpen) return null;

    return (
        <div className="lg:hidden py-3 border-t border-gray-200 dark:border-gray-800 animate-in slide-in-from-top-2 duration-200">
            {/* Search */}
            <div className="px-3 mb-4">
                <Search mobile={true} onClose={onClose} />
            </div>

            {/* Navigation Links */}
            <Navigation items={navigationItems} mobile={true} />

            {/* User Section */}
            <div className="pt-4 border-t border-gray-200 dark:border-gray-800 space-y-3">
                {user ? (
                    <>
                        <div className="flex items-center space-x-3 px-3 py-2 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                            <Avatar
                                name={user.name}
                                email={user.email}
                                size="md"
                            />
                            <div className="flex-1 min-w-0">
                                <p className="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {user.name}
                                </p>
                                <p className="text-xs text-gray-500 dark:text-gray-400 truncate">
                                    {user.email}
                                </p>
                            </div>
                        </div>
                        <div className="space-y-1">
                            {user.user_type === "admin" && (
                                <Link
                                    href={route("admin.dashboard")}
                                    className="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                                    onClick={onClose}
                                >
                                    <span>Admin Dashboard</span>
                                </Link>
                            )}
                            <Link
                                href={route("dashboard")}
                                className="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                                onClick={onClose}
                            >
                                <span>
                                    {content.auth_dashboard || "Dashboard"}
                                </span>
                            </Link>
                            <Link
                                href={route("profile.edit")}
                                className="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                                onClick={onClose}
                            >
                                <span>{content.auth_profile || "Profile"}</span>
                            </Link>
                            <Link
                                href={route("logout")}
                                method="post"
                                as="button"
                                className="flex items-center space-x-3 w-full text-left px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 transition-colors"
                                onClick={onClose}
                            >
                                <span>{content.auth_logout || "Log Out"}</span>
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
                            onClick={onClose}
                        >
                            {content.auth_login || "Log in"}
                        </Button>
                        <Button
                            href={route("register")}
                            variant="primary"
                            size="sm"
                            className="w-full justify-center"
                            onClick={onClose}
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
    );
}
