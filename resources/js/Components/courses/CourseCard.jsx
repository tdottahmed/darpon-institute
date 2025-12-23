import { Link } from "@inertiajs/react";
import Badge from "../ui/Badge";

export default function CourseCard({ course }) {
    const thumbnailUrl = course.thumbnail
        ? course.thumbnail.startsWith("http")
            ? course.thumbnail
            : `/storage/${course.thumbnail}`
        : null;

    const tags = Array.isArray(course.tags) ? course.tags : [];

    return (
        <div className="group relative flex h-full flex-col overflow-hidden rounded-2xl bg-white shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            {/* Thumbnail Container */}
            <div className="relative aspect-[16/9] w-full overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-900 dark:to-gray-800">
                {thumbnailUrl ? (
                    <img
                        src={thumbnailUrl}
                        alt={course.title}
                        className="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                        loading="lazy"
                    />
                ) : (
                    <div className="flex h-full w-full items-center justify-center bg-gradient-to-br from-primary-50 via-secondary-50 to-primary-50 dark:from-gray-800 dark:via-gray-900 dark:to-gray-800">
                        <div className="relative">
                            <div className="absolute -left-4 -top-4 h-24 w-24 rounded-full bg-primary-200/50 blur-2xl dark:bg-primary-900/30"></div>
                            <div className="absolute -bottom-4 -right-4 h-24 w-24 rounded-full bg-secondary-200/50 blur-2xl dark:bg-secondary-900/30"></div>
                            <svg
                                className="relative h-16 w-16 text-primary-400/80 dark:text-primary-600/50"
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
                    </div>
                )}

                {/* Overlay Gradient */}
                <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>

                {/* Badge */}
                <div className="absolute left-4 top-4 z-10">
                    <span className="inline-flex items-center rounded-lg bg-white/95 backdrop-blur-sm px-3 py-1 text-xs font-semibold text-gray-800 shadow-sm dark:bg-gray-900/95 dark:text-gray-200">
                        Course
                    </span>
                </div>

                {/* Tags Overlay (Bottom) */}
                {tags.length > 0 && (
                    <div className="absolute bottom-4 left-4 right-4 z-10 flex flex-wrap gap-2 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        {tags.slice(0, 2).map((tag, index) => (
                            <span
                                key={index}
                                className="inline-flex items-center rounded-md bg-white/95 backdrop-blur-sm px-2 py-1 text-xs font-medium text-primary-700 shadow-sm dark:bg-gray-900/95 dark:text-primary-300"
                            >
                                {tag}
                            </span>
                        ))}
                    </div>
                )}
            </div>

            {/* Content */}
            <div className="flex flex-1 flex-col p-6">
                {/* Tags (in content area) */}
                {tags.length > 0 && (
                    <div className="mb-3 flex flex-wrap gap-2">
                        {tags.slice(0, 2).map((tag, index) => (
                            <Badge
                                key={index}
                                variant="secondary"
                                className="bg-primary-50 text-primary-700 dark:bg-primary-900/30 dark:text-primary-400 text-xs"
                            >
                                {tag}
                            </Badge>
                        ))}
                    </div>
                )}

                {/* Title */}
                <Link
                    href={route("courses.show", course.slug)}
                    className="group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-200 mb-3"
                >
                    <h3 className="line-clamp-2 text-xl font-bold text-gray-900 dark:text-white leading-tight">
                        {course.title}
                    </h3>
                </Link>

                {/* Description */}
                <p className="mb-4 line-clamp-2 text-sm text-gray-600 dark:text-gray-400 flex-1 leading-relaxed">
                    {course.short_description?.replace(/<[^>]*>/g, "") ||
                        "No description available."}
                </p>

                {/* Footer */}
                <div className="mt-auto flex items-center justify-between border-t border-gray-100 pt-4 dark:border-gray-700">
                    {/* Duration */}
                    {course.duration ? (
                        <div className="flex items-center gap-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                            <svg
                                className="h-4 w-4 text-gray-400 dark:text-gray-500"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            <span>{course.duration}</span>
                        </div>
                    ) : (
                        <div className="flex items-center gap-2 text-sm text-gray-400 dark:text-gray-500">
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
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            <span>Self-paced</span>
                        </div>
                    )}

                    {/* View Link */}
                    <Link
                        href={route("courses.show", course.slug)}
                        className="flex items-center gap-1.5 text-sm font-semibold text-primary-600 transition-all duration-200 hover:text-primary-700 hover:gap-2 dark:text-primary-400 dark:hover:text-primary-300"
                    >
                        <span>View Details</span>
                        <svg
                            className="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M17 8l4 4m0 0l-4 4m4-4H3"
                            />
                        </svg>
                    </Link>
                </div>
            </div>
        </div>
    );
}
