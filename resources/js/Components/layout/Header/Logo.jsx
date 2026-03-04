import { Link, usePage } from "@inertiajs/react";
import ApplicationLogo from "../../ApplicationLogo";

export default function Logo() {
    const { settings } = usePage().props;
    const lightLogo = settings?.logo_light || "/darponbdv.png";
    const darkLogo = settings?.logo_dark || lightLogo;

    return (
        <Link
            href={route("home")}
            className="flex items-center space-x-3 group"
        >
            {/* Light Logo */}
            <img
                src={lightLogo}
                alt="Darpon Logo"
                className={`h-12 w-auto transition-transform duration-300 group-hover:scale-105 ${darkLogo ? 'dark:hidden' : ''}`}
                onError={(e) => {
                    e.target.style.display = "none";
                }}
            />
            {/* Dark Logo */}
            {darkLogo && (
                <img
                    src={darkLogo}
                    alt="Darpon Logo"
                    className="h-12 w-auto hidden dark:block transition-transform duration-300 group-hover:scale-105"
                    onError={(e) => {
                        e.target.style.display = "none";
                    }}
                />
            )}
            {/* Fallback Logo */}
            <div className="h-12 w-12 hidden items-center justify-center">
                <ApplicationLogo variant="icon" />
            </div>
        </Link>
    );
}
