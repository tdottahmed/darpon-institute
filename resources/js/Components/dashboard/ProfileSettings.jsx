import Card from "@/Components/ui/Card";
import { Link } from "@inertiajs/react";

export default function ProfileSettings() {
    return (
        <Card variant="elevated" padding="lg">
            <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-6">
                Profile Settings
            </h3>
            <div className="space-y-4">
                <div className="flex items-center justify-between p-4 rounded-xl bg-gray-50 dark:bg-gray-800">
                    <div className="flex items-center gap-3">
                        <svg
                            className="h-5 w-5 text-gray-500 dark:text-gray-400"
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
                        <span className="text-sm font-medium text-gray-900 dark:text-white">
                            Personal Information
                        </span>
                    </div>
                    <Link
                        href={route("profile.edit")}
                        className="text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400"
                    >
                        Edit →
                    </Link>
                </div>
                <div className="flex items-center justify-between p-4 rounded-xl bg-gray-50 dark:bg-gray-800">
                    <div className="flex items-center gap-3">
                        <svg
                            className="h-5 w-5 text-gray-500 dark:text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                            />
                        </svg>
                        <span className="text-sm font-medium text-gray-900 dark:text-white">
                            Password & Security
                        </span>
                    </div>
                    <Link
                        href={route("profile.edit")}
                        className="text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400"
                    >
                        Edit →
                    </Link>
                </div>
            </div>
        </Card>
    );
}

