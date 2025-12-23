import { Link } from "@inertiajs/react";
import ApplicationLogo from "../../ApplicationLogo";

export default function Logo() {
    return (
        <Link
            href={route("home")}
            className="flex items-center space-x-3 group"
        >
            <div className="relative flex-shrink-0">
                <img
                    src="/darponbdv.png"
                    alt="Darpon Logo"
                    className="h-12 w-auto transition-transform duration-300 group-hover:scale-105"
                    onError={(e) => {
                        e.target.style.display = "none";
                        if (e.target.nextElementSibling) {
                            e.target.nextElementSibling.style.display = "flex";
                        }
                    }}
                />
                <div className="h-12 w-12 hidden items-center justify-center">
                    <ApplicationLogo variant="icon" />
                </div>
            </div>
        </Link>
    );
}
