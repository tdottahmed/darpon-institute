import { Link } from "@inertiajs/react";
import { usePage } from "@inertiajs/react";

export default function LanguageSwitcher() {
    const { locale, translations } = usePage().props;
    const languages = [
        { code: "en", name: "English", flag: "🇬🇧" },
        { code: "bn", name: "বাংলা", flag: "🇧🇩" },
    ];

    return (
        <div className="relative">
            <div className="flex items-center space-x-2">
                {languages.map((lang) => (
                    <Link
                        key={lang.code}
                        href={route("language.switch", lang.code)}
                        className={`flex items-center space-x-1 rounded-md px-3 py-2 text-sm font-medium transition-colors ${
                            locale === lang.code
                                ? "bg-primary-600 text-white"
                                : "text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                        }`}
                    >
                        <span>{lang.flag}</span>
                        <span>{lang.name}</span>
                    </Link>
                ))}
            </div>
        </div>
    );
}
