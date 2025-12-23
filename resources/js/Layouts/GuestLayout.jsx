import ApplicationLogo from "@/Components/ApplicationLogo";
import DarkModeToggle from "@/Components/DarkModeToggle";
import LanguageSwitcher from "@/Components/LanguageSwitcher";
import { Link } from "@inertiajs/react";
import ToastListener from "@/Components/ToastListener";

export default function GuestLayout({ children }) {
    return (
        <div className="flex min-h-screen flex-col items-center justify-center bg-gradient-to-br from-primary-50 via-secondary-50 to-accent-50 pt-6 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 sm:pt-0">
            <ToastListener />
            <div className="absolute right-4 top-4 flex items-center space-x-4">
                <LanguageSwitcher />
                <DarkModeToggle />
            </div>
            <div className="mb-6">
                <Link href="/">
                    <ApplicationLogo variant="default" />
                </Link>
            </div>

            <div className="w-full overflow-hidden rounded-xl bg-white px-8 py-8 shadow-xl dark:bg-gray-800 sm:max-w-md">
                {children}
            </div>
        </div>
    );
}
