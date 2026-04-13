import DarkModeToggle from "@/Components/DarkModeToggle";
import LanguageSwitcher from "@/Components/LanguageSwitcher";
import { Link } from "@inertiajs/react";
import ToastListener from "@/Components/ToastListener";
import Logo from "@/Components/layout/Header/Logo";
import SectionBackground from "@/Components/ui/SectionBackground";

export default function GuestLayout({ children }) {
    return (
        <div className="relative flex min-h-screen flex-col items-center justify-center bg-slate-50 pt-6 dark:bg-slate-900 sm:pt-0 overflow-hidden">
            <SectionBackground variant="a" />
            <ToastListener />
            
            <div className="absolute right-6 top-6 z-50 flex items-center space-x-4">
                <LanguageSwitcher />
                <DarkModeToggle />
            </div>

            <div className="relative z-10 w-full overflow-hidden rounded-3xl bg-white/80 px-8 py-10 shadow-2xl backdrop-blur-xl dark:bg-gray-900/80 dark:shadow-primary-900/20 sm:max-w-md border border-white/50 dark:border-gray-700/50">
                <div className="mb-8 flex justify-center">
                    <Link href="/" className="transition-transform hover:scale-105 active:scale-95 duration-200">
                        <Logo />
                    </Link>
                </div>
                {children}
            </div>
        </div>
    );
}
