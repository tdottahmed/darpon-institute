import { Link } from "@inertiajs/react";
import { usePage } from "@inertiajs/react";
import Dropdown from "./Dropdown";

export default function LanguageSwitcher() {
    const { locale = "en" } = usePage().props;
    const languages = [
        { code: "en", name: "English", flag: "🇬🇧" },
        { code: "bn", name: "বাংলা", flag: "🇧🇩" },
    ];

    const current = languages.find((l) => l.code === locale) || languages[0];

    return (
        <Dropdown>
            <Dropdown.Trigger>
                <button className="flex items-center space-x-2 rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                    <span>{current.flag}</span>
                    <span className="hidden sm:inline">{current.name}</span>
                </button>
            </Dropdown.Trigger>

            <Dropdown.Content align="right" width="40">
                <div className="py-1 bg-white dark:bg-gray-800">
                    {languages.map((lang) => {
                        const isActive = lang.code === locale;
                        return (
                            <Dropdown.Link
                                key={lang.code}
                                href={route("language.switch", lang.code)}
                                className={
                                    isActive
                                        ? "bg-primary-50 dark:bg-primary-900/20"
                                        : ""
                                }
                            >
                                <span className="mr-3">{lang.flag}</span>
                                <span
                                    className={
                                        isActive
                                            ? "font-semibold text-primary-600 dark:text-primary-400"
                                            : ""
                                    }
                                >
                                    {lang.name}
                                </span>
                                {isActive && (
                                    <svg
                                        className="ml-auto h-4 w-4 text-primary-600 dark:text-primary-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>
                                )}
                            </Dropdown.Link>
                        );
                    })}
                </div>
            </Dropdown.Content>
        </Dropdown>
    );
}
