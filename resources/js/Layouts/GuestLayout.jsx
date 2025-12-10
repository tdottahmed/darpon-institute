import ApplicationLogo from "@/Components/ApplicationLogo";
import DarkModeToggle from "@/Components/DarkModeToggle";
import LanguageSwitcher from "@/Components/LanguageSwitcher";
import { Link } from "@inertiajs/react";

export default function GuestLayout({ children }) {
    return (
        <div className="flex min-h-screen flex-col items-center justify-center bg-gradient-to-br from-primary-50 via-secondary-50 to-accent-50 pt-6 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 sm:pt-0">
            <div className="absolute right-4 top-4 flex items-center space-x-4">
                <LanguageSwitcher />
                <DarkModeToggle />
            </div>
            <div className="mb-6">
                <Link href="/">
                    <div className="flex items-center space-x-2">
                        <div className="h-12 w-12 rounded-lg bg-gradient-to-br from-primary-600 to-secondary-600 p-2 dark:from-primary-500 dark:to-secondary-500">
                            <ApplicationLogo className="h-full w-full fill-current text-white" />
                        </div>
                        <span className="text-2xl font-bold text-primary-600 dark:text-primary-400">
                            {import.meta.env.VITE_APP_NAME || "Darpon"}
                        </span>
                    </div>
                </Link>
            </div>

            <div className="w-full overflow-hidden rounded-xl bg-white px-8 py-8 shadow-xl dark:bg-gray-800 sm:max-w-md">
                {children}
            </div>
        </div>
    );
}
