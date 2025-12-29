import { usePage, router } from "@inertiajs/react";
import { Home, BookOpen, GraduationCap, User } from "lucide-react";

export default function Sidebar() {
    const { translations } = usePage().props;
    const t = translations?.common || {};

    // Get active section from URL params
    const urlParams = new URLSearchParams(window.location.search);
    const activeSection = urlParams.get("section") || "overview";

    const handleSectionChange = (sectionId) => {
        router.get(
            route("dashboard"),
            { section: sectionId },
            { preserveState: true, replace: true }
        );
    };

    const menuItems = [
        {
            id: "overview",
            name: "Overview",
            section: "overview",
            icon: Home,
        },
        {
            id: "books",
            name: "Purchased Books",
            section: "books",
            icon: BookOpen,
        },
        {
            id: "courses",
            name: "Purchased Courses",
            section: "courses",
            icon: GraduationCap,
        },
        {
            id: "profile",
            name: "Profile & Settings",
            section: "profile",
            icon: User,
        },
    ];

    return (
        <aside className="fixed left-0 top-16 z-40 hidden h-[calc(100vh-4rem)] w-64 border-r border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800 lg:block">
            <div className="flex h-full flex-col">
                {/* Navigation Menu */}
                <div className="flex-1 overflow-y-auto px-3 py-4 pt-4 scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-700 scrollbar-track-transparent">
                    <ul className="space-y-1">
                        {menuItems.map((item) => {
                            const isActive = activeSection === item.section;
                            const IconComponent = item.icon;

                            return (
                                <li key={item.id}>
                                    <button
                                        onClick={() =>
                                            handleSectionChange(item.section)
                                        }
                                        className={`group relative flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 ${
                                            isActive
                                                ? "bg-primary-600 text-white shadow-md shadow-primary-500/20"
                                                : "text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                                        }`}
                                    >
                                        {isActive && (
                                            <span className="absolute left-0 top-1/2 h-8 w-1 -translate-y-1/2 rounded-r-full bg-white"></span>
                                        )}
                                        <IconComponent
                                            className={`h-5 w-5 ${
                                                isActive
                                                    ? "text-white"
                                                    : "text-gray-500 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400"
                                            } transition-colors`}
                                        />
                                        <span className="flex-1 text-left">
                                            {item.name}
                                        </span>
                                        {isActive && (
                                            <svg
                                                className="h-4 w-4 text-white opacity-50"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    strokeWidth={2}
                                                    d="M9 5l7 7-7 7"
                                                />
                                            </svg>
                                        )}
                                    </button>
                                </li>
                            );
                        })}
                    </ul>
                </div>

                {/* User Info Footer */}
                <div className="border-t border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-800/50">
                    <div className="flex items-center gap-3">
                        <div className="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 via-secondary-500 to-accent-500 text-sm font-bold text-white shadow-lg ring-2 ring-white dark:ring-gray-900">
                            {usePage()
                                .props.auth?.user?.name?.charAt(0)
                                .toUpperCase() || "U"}
                        </div>
                        <div className="min-w-0 flex-1">
                            <p className="truncate text-sm font-semibold text-gray-900 dark:text-white">
                                {usePage().props.auth?.user?.name || "User"}
                            </p>
                            <p className="truncate text-xs text-gray-500 dark:text-gray-400">
                                {usePage().props.auth?.user?.email || ""}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    );
}
