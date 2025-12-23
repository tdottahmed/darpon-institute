import Button from "@/Components/ui/Button";

export default function CourseSidebar({
    course,
    thumbnailUrl,
    videoUrl,
    isEnrolled,
}) {
    return (
        <div className="sticky top-24 space-y-8">
            <div className="rounded-2xl border border-gray-200 bg-white p-6 shadow-xl dark:border-gray-700 dark:bg-gray-800">
                {/* Video/Image Preview */}
                <div className="relative mb-6 overflow-hidden rounded-xl aspect-video bg-gray-100 dark:bg-gray-900 shadow-inner group">
                    {videoUrl ? (
                        <video
                            src={videoUrl}
                            controls
                            className="h-full w-full object-cover"
                            poster={thumbnailUrl}
                        >
                            Your browser does not support the video tag.
                        </video>
                    ) : thumbnailUrl ? (
                        <img
                            src={thumbnailUrl}
                            alt={course.title}
                            className="h-full w-full object-cover transition-transform duration-700 hover:scale-105"
                        />
                    ) : (
                        <div className="flex h-full w-full items-center justify-center bg-gradient-to-br from-primary-100 to-secondary-100 dark:from-primary-900/40 dark:to-secondary-900/40">
                            <svg
                                className="w-16 h-16 text-primary-400 dark:text-primary-500 opacity-50"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={1}
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                />
                            </svg>
                        </div>
                    )}
                </div>

                {/* Enrollment Status */}
                {isEnrolled ? (
                    <div className="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                        <div className="flex items-center gap-2 mb-2">
                            <svg
                                className="w-5 h-5 text-green-600 dark:text-green-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            <span className="font-semibold text-green-800 dark:text-green-200">
                                You're Enrolled!
                            </span>
                        </div>
                        <p className="text-sm text-green-700 dark:text-green-300">
                            Access your course materials from your dashboard.
                        </p>
                        <Button
                            variant="primary"
                            size="md"
                            href={route("dashboard")}
                            className="w-full mt-3"
                        >
                            Go to Dashboard
                        </Button>
                    </div>
                ) : (
                    <>
                        {/* Actions */}
                        <div className="space-y-3">
                            <Button
                                variant="primary"
                                size="lg"
                                href={route("courses.enroll", course.slug)}
                                className="w-full justify-center text-lg font-bold shadow-lg shadow-primary-500/20 hover:shadow-primary-500/40 hover:-translate-y-0.5 transition-all"
                            >
                                <svg
                                    className="w-5 h-5 mr-2"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M12 4v16m8-8H4"
                                    />
                                </svg>
                                Enroll Now
                            </Button>
                        </div>

                        {/* Features List */}
                        <div className="mt-8 space-y-4 border-t border-gray-100 dark:border-gray-700 pt-6">
                            <h3 className="font-semibold text-gray-900 dark:text-white mb-4">
                                What you'll get:
                            </h3>
                            <ul className="space-y-3 text-sm text-gray-600 dark:text-gray-300">
                                <li className="flex items-start gap-3">
                                    <svg
                                        className="w-5 h-5 text-green-500 shrink-0 mt-0.5"
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
                                    <span>Full lifetime access</span>
                                </li>
                                <li className="flex items-start gap-3">
                                    <svg
                                        className="w-5 h-5 text-green-500 shrink-0 mt-0.5"
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
                                    <span>Access on mobile and desktop</span>
                                </li>
                                <li className="flex items-start gap-3">
                                    <svg
                                        className="w-5 h-5 text-green-500 shrink-0 mt-0.5"
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
                                    <span>Certificate of completion</span>
                                </li>
                                <li className="flex items-start gap-3">
                                    <svg
                                        className="w-5 h-5 text-green-500 shrink-0 mt-0.5"
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
                                    <span>Expert support and guidance</span>
                                </li>
                            </ul>
                        </div>
                    </>
                )}
            </div>
        </div>
    );
}
