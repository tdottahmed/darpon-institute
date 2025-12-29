export default function DashboardSidebar({ activeSection, onSectionChange }) {
    const menuItems = [
        {
            id: "overview",
            name: "Overview",
            icon: (
                <svg
                    className="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth={2}
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                    />
                </svg>
            ),
        },
        {
            id: "books",
            name: "Purchased Books",
            icon: (
                <svg
                    className="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth={2}
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                    />
                </svg>
            ),
        },
        {
            id: "courses",
            name: "Purchased Courses",
            icon: (
                <svg
                    className="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth={2}
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                    />
                </svg>
            ),
        },
        {
            id: "profile",
            name: "Profile & Settings",
            icon: (
                <svg
                    className="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth={2}
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    />
                </svg>
            ),
        },
    ];

    return (
        <div className="space-y-2">
            {menuItems.map((item) => {
                const isActive = activeSection === item.id;

                return (
                    <button
                        key={item.id}
                        onClick={() => onSectionChange(item.id)}
                        className={`group relative flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 ${
                            isActive
                                ? "bg-primary-600 text-white shadow-md shadow-primary-500/20"
                                : "text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                        }`}
                    >
                        {isActive && (
                            <span className="absolute left-0 top-1/2 h-8 w-1 -translate-y-1/2 rounded-r-full bg-white"></span>
                        )}
                        <span
                            className={`${
                                isActive
                                    ? "text-white"
                                    : "text-gray-500 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400"
                            } transition-colors`}
                        >
                            {item.icon}
                        </span>
                        <span className="flex-1 text-left">{item.name}</span>
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
                );
            })}
        </div>
    );
}

