import { Link } from "@inertiajs/react";
import Badge from "../ui/Badge";
import Button from "../ui/Button";

export default function CourseCard({ course }) {
    const thumbnailUrl = course.thumbnail
        ? course.thumbnail.startsWith("http")
            ? course.thumbnail
            : `/storage/${course.thumbnail}`
        : null;

    const tags = Array.isArray(course.tags) ? course.tags : [];

    return (
        <div className="group relative flex h-full flex-col overflow-hidden rounded-2xl bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
            {/* Thumbnail Container */}
            <div className="relative aspect-[16/9] w-full overflow-hidden bg-gray-100 dark:bg-gray-900">
                {thumbnailUrl ? (
                    <img
                        src={thumbnailUrl}
                        alt={course.title}
                        className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                    />
                ) : (
                    // Premium Placeholder
                    <div className="flex h-full w-full items-center justify-center bg-gradient-to-br from-primary-50 to-primary-100 dark:from-gray-800 dark:to-gray-900">
                        <div className="relative">
                            {/* Abstract background shape */}
                            <div className="absolute -left-4 -top-4 h-24 w-24 rounded-full bg-primary-200/50 blur-2xl dark:bg-primary-900/30"></div>
                            <div className="absolute -bottom-4 -right-4 h-24 w-24 rounded-full bg-secondary-200/50 blur-2xl dark:bg-secondary-900/30"></div>
                            
                            {/* Icon */}
                            <svg 
                                className="relative h-16 w-16 text-primary-400/80 dark:text-primary-600/50" 
                                fill="none" 
                                viewBox="0 0 24 24" 
                                stroke="currentColor"
                            >
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>
                )}
                
                {/* Overlay Gradient on Hover */}
                <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>

                 {/* Tags (Overlaid on image for better space usage, or kept in body? Let's keep in body for cleaner look, but maybe a 'Course' badge on top) */}
                <div className="absolute left-3 top-3">
                     <span className="inline-flex items-center rounded-md bg-white/90 px-2 py-1 text-xs font-medium text-gray-800 shadow-sm backdrop-blur-sm dark:bg-black/60 dark:text-gray-200">
                        Course
                    </span>
                </div>
            </div>

            {/* Content Content py-5 px-5 */}
            <div className="flex flex-1 flex-col p-5">
                {/* Tags */}
                {tags.length > 0 && (
                    <div className="mb-3 flex flex-wrap gap-2">
                        {tags.slice(0, 2).map((tag, index) => (
                            <span 
                                key={index} 
                                className="inline-flex items-center rounded-full bg-primary-50 px-2 py-0.5 text-xs font-medium text-primary-700 dark:bg-primary-900/30 dark:text-primary-400"
                            >
                                {tag}
                            </span>
                        ))}
                    </div>
                )}

                {/* Title */}
                <Link href={route("courses.show", course.slug)} className="group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                    <h3 className="mb-2 line-clamp-2 text-lg font-bold text-gray-900 dark:text-white">
                        {course.title}
                    </h3>
                </Link>

                {/* Description */}
                <p className="mb-4 line-clamp-2 text-sm text-gray-600 dark:text-gray-400 flex-1">
                    {course.short_description?.replace(/<[^>]*>/g, "") || "No description available."}
                </p>

                {/* Footer Info */}
                <div className="mt-auto flex items-center justify-between border-t border-gray-100 pt-4 dark:border-gray-700">
                     {/* Duration */}
                     {course.duration ? (
                        <div className="flex items-center gap-1.5 text-xs font-medium text-gray-500 dark:text-gray-400">
                            <svg className="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{course.duration}</span>
                        </div>
                    ) : (
                         <div className="text-xs text-gray-400">Self-paced</div>
                    )}

                    {/* View Text Link instead of full button to keep card clean */}
                    <Link 
                        href={route("courses.show", course.slug)}
                        className="flex items-center gap-1 text-sm font-semibold text-primary-600 transition-colors hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300"
                    >
                        View Details
                        <svg className="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </Link>
                </div>
            </div>
        </div>
    );
}
