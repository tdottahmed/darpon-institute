import Card from "@/Components/ui/Card";
import { Link } from "@inertiajs/react";

export default function ContactInformation({ user }) {
    return (
        <Card variant="elevated" padding="lg">
            <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-6">
                Contact Information
            </h3>
            <div className="space-y-4">
                <div className="flex items-start gap-4">
                    <div className="flex-shrink-0">
                        <div className="h-10 w-10 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
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
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                />
                            </svg>
                        </div>
                    </div>
                    <div className="flex-1">
                        <p className="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                            Full Name
                        </p>
                        <p className="text-base font-semibold text-gray-900 dark:text-white">
                            {user?.name || "N/A"}
                        </p>
                    </div>
                </div>
                <div className="flex items-start gap-4">
                    <div className="flex-shrink-0">
                        <div className="h-10 w-10 rounded-lg bg-secondary-100 dark:bg-secondary-900/30 flex items-center justify-center">
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
                    </div>
                    <div className="flex-1">
                        <p className="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                            Email Address
                        </p>
                        <p className="text-base font-semibold text-gray-900 dark:text-white">
                            {user?.email || "N/A"}
                        </p>
                    </div>
                </div>
                <div className="pt-4 border-t border-gray-200 dark:border-gray-700">
                    <Link
                        href={route("contact")}
                        className="inline-flex items-center gap-2 text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300"
                    >
                        <span>Update contact information</span>
                        <svg
                            className="h-4 w-4"
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
            </div>
        </Card>
    );
}

