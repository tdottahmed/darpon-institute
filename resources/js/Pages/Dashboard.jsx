import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Card from "@/Components/ui/Card";
import { Head, usePage } from "@inertiajs/react";

export default function Dashboard({ enrolledCourses }) {
    const { translations, auth } = usePage().props;
    const t = translations?.common || {};

    const stats = [
        {
            title: "Active Courses",
            value: "5",
            icon: "📚",
            color: "primary",
            change: "+2 this month",
        },
        {
            title: "Completed Lessons",
            value: "24",
            icon: "✅",
            color: "secondary",
            change: "+8 this week",
        },
        {
            title: "Study Hours",
            value: "42",
            icon: "⏱️",
            color: "accent",
            change: "+12 hours",
        },
        {
            title: "Certificates",
            value: "2",
            icon: "🎓",
            color: "primary",
            change: "1 pending",
        },
    ];

    const recentActivity = [
        {
            title: "Completed Lesson: Basic Grammar",
            time: "2 hours ago",
            type: "completed",
        },
        {
            title: "Started Course: Advanced Speaking",
            time: "1 day ago",
            type: "started",
        },
        {
            title: "Earned Certificate: Beginner Level",
            time: "3 days ago",
            type: "certificate",
        },
    ];

    return (
        <AuthenticatedLayout
            header={
                <div className="flex items-center justify-between">
                    <div>
                        <h2 className="text-2xl font-bold text-gray-900 dark:text-white">
                            {t.welcome || "Welcome"}, {auth.user.name}!
                        </h2>
                        <p className="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Here's your learning overview
                        </p>
                    </div>
                </div>
            }
        >
            <Head title={t.dashboard || "Dashboard"} />

            <div className="space-y-6">
                {/* Stats Grid */}
                <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    {stats.map((stat, index) => (
                        <Card
                            key={index}
                            variant="elevated"
                            padding="md"
                            className="hover:shadow-lg transition-shadow"
                        >
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm font-medium text-gray-600 dark:text-gray-400">
                                        {stat.title}
                                    </p>
                                    <p className="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                        {stat.value}
                                    </p>
                                    <p className="mt-1 text-xs text-gray-500 dark:text-gray-500">
                                        {stat.change}
                                    </p>
                                </div>
                                <div className="text-4xl">{stat.icon}</div>
                            </div>
                        </Card>
                    ))}
                </div>

                {/* Main Content Grid */}
                <div className="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    {/* Recent Activity */}
                    <Card
                        variant="elevated"
                        padding="lg"
                        className="lg:col-span-2"
                    >
                        <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Recent Activity
                        </h3>
                        <div className="space-y-4">
                            {recentActivity.map((activity, index) => (
                                <div
                                    key={index}
                                    className="flex items-start space-x-3 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-0 last:pb-0"
                                >
                                    <div className="flex-shrink-0">
                                        <div className="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                                            {activity.type === "completed" && (
                                                <span className="text-primary-600 dark:text-primary-400">
                                                    ✓
                                                </span>
                                            )}
                                            {activity.type === "started" && (
                                                <span className="text-secondary-600 dark:text-secondary-400">
                                                    ▶
                                                </span>
                                            )}
                                            {activity.type ===
                                                "certificate" && (
                                                <span className="text-accent-600 dark:text-accent-400">
                                                    🎓
                                                </span>
                                            )}
                                        </div>
                                    </div>
                                    <div className="flex-1 min-w-0">
                                        <p className="text-sm font-medium text-gray-900 dark:text-white">
                                            {activity.title}
                                        </p>
                                        <p className="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {activity.time}
                                        </p>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </Card>

                    {/* Quick Actions */}
                    <Card variant="elevated" padding="lg">
                        <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Quick Actions
                        </h3>
                        <div className="space-y-3">
                            <a
                                href="#"
                                className="flex items-center justify-between rounded-lg border border-gray-200 bg-white p-3 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 transition-colors"
                            >
                                <span className="text-sm font-medium text-gray-900 dark:text-white">
                                    Browse Courses
                                </span>
                                <svg
                                    className="h-5 w-5 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </a>
                            <a
                                href="#"
                                className="flex items-center justify-between rounded-lg border border-gray-200 bg-white p-3 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 transition-colors"
                            >
                                <span className="text-sm font-medium text-gray-900 dark:text-white">
                                    View Progress
                                </span>
                                <svg
                                    className="h-5 w-5 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </a>
                            <a
                                href={route("profile.edit")}
                                className="flex items-center justify-between rounded-lg border border-gray-200 bg-white p-3 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 transition-colors"
                            >
                                <span className="text-sm font-medium text-gray-900 dark:text-white">
                                    Edit Profile
                                </span>
                                <svg
                                    className="h-5 w-5 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </a>
                        </div>
                    </Card>
                </div>

                {/* Continue Learning */}
                <Card variant="elevated" padding="lg">
                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Continue Learning
                    </h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {enrolledCourses && enrolledCourses.length > 0 ? (
                            enrolledCourses.map((course) => (
                                <div key={course.id} className="rounded-lg border border-gray-200 bg-gradient-to-br from-primary-50 to-secondary-50 p-4 dark:border-gray-700 dark:from-primary-900/20 dark:to-secondary-900/20">
                                    <h4 className="font-semibold text-gray-900 dark:text-white mb-2">
                                        {course.title}
                                    </h4>
                                    <p className="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                        Active Course
                                    </p>
                                    <div className="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                        {/* Progress bar placeholder - can be dynamic if we track progress */}
                                        <div
                                            className="bg-primary-600 h-2 rounded-full dark:bg-primary-500"
                                            style={{ width: "10%" }}
                                        ></div>
                                    </div>
                                    <a href={route('courses.show', course.slug)} className="mt-3 block w-full text-center rounded-md bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600">
                                        Continue
                                    </a>
                                </div>
                            ))
                        ) : (
                             <div className="col-span-full p-6 text-center text-gray-500 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                You haven't enrolled in any courses yet.
                                <br />
                                <a href={route('courses.index')} className="text-primary-600 hover:underline mt-2 inline-block">Browse Courses</a>
                             </div>
                        )}
                    </div>
                </Card>
            </div>
        </AuthenticatedLayout>
    );
}
