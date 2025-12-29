import Card from "@/Components/ui/Card";
import { Link } from "@inertiajs/react";

export default function QuickActions() {
    return (
        <Card variant="elevated" padding="lg">
            <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-6">
                Quick Actions
            </h3>
            <div className="space-y-3">
                <Link
                    href={route("books.index")}
                    className="flex items-center justify-between rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 hover:border-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all duration-200 group"
                >
                    <div className="flex items-center gap-3">
                        <div className="h-10 w-10 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center group-hover:bg-primary-200 dark:group-hover:bg-primary-900/50 transition-colors">
                            <svg
                                className="h-5 w-5 text-primary-600 dark:text-primary-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                />
                            </svg>
                        </div>
                        <span className="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                            Browse Books
                        </span>
                    </div>
                    <svg
                        className="h-5 w-5 text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors"
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
                </Link>
                <Link
                    href={route("courses.index")}
                    className="flex items-center justify-between rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 hover:border-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all duration-200 group"
                >
                    <div className="flex items-center gap-3">
                        <div className="h-10 w-10 rounded-lg bg-accent-100 dark:bg-accent-900/30 flex items-center justify-center group-hover:bg-accent-200 dark:group-hover:bg-accent-900/50 transition-colors">
                            <svg
                                className="h-5 w-5 text-accent-600 dark:text-accent-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                />
                            </svg>
                        </div>
                        <span className="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                            Browse Courses
                        </span>
                    </div>
                    <svg
                        className="h-5 w-5 text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors"
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
                </Link>
                <Link
                    href={route("profile.edit")}
                    className="flex items-center justify-between rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 hover:border-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all duration-200 group"
                >
                    <div className="flex items-center gap-3">
                        <div className="h-10 w-10 rounded-lg bg-secondary-100 dark:bg-secondary-900/30 flex items-center justify-center group-hover:bg-secondary-200 dark:group-hover:bg-secondary-900/50 transition-colors">
                            <svg
                                className="h-5 w-5 text-secondary-600 dark:text-secondary-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                />
                            </svg>
                        </div>
                        <span className="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                            Profile Settings
                        </span>
                    </div>
                    <svg
                        className="h-5 w-5 text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors"
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
                </Link>
                <Link
                    href={route("contact")}
                    className="flex items-center justify-between rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 hover:border-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all duration-200 group"
                >
                    <div className="flex items-center gap-3">
                        <div className="h-10 w-10 rounded-lg bg-secondary-100 dark:bg-secondary-900/30 flex items-center justify-center group-hover:bg-secondary-200 dark:group-hover:bg-secondary-900/50 transition-colors">
                            <svg
                                className="h-5 w-5 text-secondary-600 dark:text-secondary-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                />
                            </svg>
                        </div>
                        <span className="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                            Contact Us
                        </span>
                    </div>
                    <svg
                        className="h-5 w-5 text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors"
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
                </Link>
            </div>
        </Card>
    );
}

