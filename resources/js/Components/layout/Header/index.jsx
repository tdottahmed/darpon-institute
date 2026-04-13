import { useState } from "react";
import { usePage } from "@inertiajs/react";
import ToastListener from "../../ToastListener";
import LanguageSwitcher from "../../LanguageSwitcher";
import DarkModeToggle from "../../DarkModeToggle";
import Logo from "./Logo";
import Navigation from "./Navigation";
import UserMenu from "./UserMenu";
import AuthButtons from "./AuthButtons";
import MobileMenuButton from "./MobileMenuButton";
import MobileMenu from "./MobileMenu";
import Search from "./Search";

export default function Header() {
    const { auth, translations, frontend_content } = usePage().props;
    const t = translations?.common || {};
    const content = frontend_content?.header || {};
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

    const navigationItems = [
        {
            name: content.menu_home || "Home",
            href: route("home"),
        },
        {
            name: content.menu_courses || "Courses",
            href: route("courses.index"),
        },
        {
            name: content.menu_books || "Books",
            href: route("books.index"),
        },
        {
            name: content.menu_gallery || "Gallery",
            href: route("galleries.index"),
        },
        {
            name: content.menu_contact || "Contact",
            href: route("contact"),
        },
    ].map((item) => ({
        ...item,
        onClick: () => setMobileMenuOpen(false),
    }));

    return (
        <header className="sticky top-0 left-0 right-0 z-50 bg-[var(--header-footer-bg-light)] dark:bg-[var(--header-footer-bg-dark)] text-[var(--header-footer-text-light)] dark:text-[var(--header-footer-text-dark)] backdrop-blur-md border-b border-gray-200 dark:border-gray-800 shadow-sm transition-colors duration-300">
            <ToastListener />
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex h-16 items-center justify-between">
                    {/* Logo */}
                    <Logo />

                    {/* Desktop Navigation */}
                    <Navigation items={navigationItems} />

                    {/* Right Side Actions */}
                    <div className="hidden lg:flex items-center space-x-3">
                        <Search />
                        <LanguageSwitcher />
                        <DarkModeToggle />
                        {auth?.user ? (
                            <UserMenu content={content} />
                        ) : (
                            <AuthButtons content={content} />
                        )}
                    </div>

                    {/* Mobile Actions */}
                    <div className="flex items-center lg:hidden space-x-1">
                        <Search />
                        <MobileMenuButton
                            isOpen={mobileMenuOpen}
                            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                        />
                    </div>
                </div>

                {/* Mobile Menu */}
                <MobileMenu
                    isOpen={mobileMenuOpen}
                    onClose={() => setMobileMenuOpen(false)}
                    navigationItems={navigationItems}
                    content={content}
                />
            </div>
        </header>
    );
}
