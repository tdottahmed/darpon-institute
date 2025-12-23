import { Link } from "@inertiajs/react";
import Badge from "../ui/Badge";

export default function VideoBlogCard({ video }) {
    return (
        <div className="group relative flex h-full flex-col overflow-hidden rounded-2xl bg-white shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            {/* Thumbnail */}
            <div className="relative aspect-video overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-900 dark:to-gray-800">
                {video.thumbnail ? (
                    <img
                        src={`/storage/${video.thumbnail}`}
                        alt={video.title}
                        className="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                        loading="lazy"
                    />
                ) : (
                    <div className="flex h-full w-full items-center justify-center bg-gradient-to-br from-primary-50 via-secondary-50 to-primary-50 dark:from-gray-800 dark:via-gray-900 dark:to-gray-800">
                        <svg
                            className="h-16 w-16 text-primary-400/80 dark:text-primary-600/50"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={1}
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"
                            />
                        </svg>
                    </div>
                )}

                {/* Overlay Gradient */}
                <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>

                {/* Play Button Overlay */}
                <div className="absolute inset-0 flex items-center justify-center">
                    <div className="flex h-16 w-16 items-center justify-center rounded-full bg-white/95 backdrop-blur-sm shadow-xl transition-all duration-300 group-hover:scale-110 group-hover:bg-white dark:bg-gray-900/95 dark:group-hover:bg-gray-900">
                        <svg
                            className="h-8 w-8 text-primary-600 dark:text-primary-400 ml-1"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path d="M8 5v14l11-7z" />
                        </svg>
                    </div>
                </div>

                {/* Badge */}
                <div className="absolute left-4 top-4 z-10">
                    <Badge
                        variant="secondary"
                        className="bg-black/70 text-white backdrop-blur-sm border-0"
                    >
                        {video.video_type === "youtube" ? "YouTube" : "Video"}
                    </Badge>
                </div>
            </div>

            {/* Content */}
            <div className="flex flex-1 flex-col p-6">
                {/* Meta Info */}
                <div className="mb-3 flex items-center gap-2 text-xs font-medium text-gray-500 dark:text-gray-400">
                    <span>
                        {new Date(video.created_at).toLocaleDateString(
                            "en-US",
                            { month: "short", day: "numeric", year: "numeric" }
                        )}
                    </span>
                    {video.tags && video.tags.length > 0 && (
                        <>
                            <span>•</span>
                            <Badge
                                variant="primary"
                                className="bg-primary-50 text-primary-700 dark:bg-primary-900/30 dark:text-primary-400 text-xs px-2 py-0.5"
                            >
                                {video.tags[0]}
                            </Badge>
                        </>
                    )}
                </div>

                {/* Title */}
                <Link
                    href={route("video_blogs.show", video.slug)}
                    className="group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-200 mb-3"
                >
                    <h3 className="line-clamp-2 text-xl font-bold text-gray-900 dark:text-white leading-tight">
                        {video.title}
                    </h3>
                </Link>

                {/* Description */}
                <p className="mb-4 line-clamp-2 text-sm text-gray-600 dark:text-gray-400 leading-relaxed flex-1">
                    {video.short_description}
                </p>

                {/* Footer */}
                <div className="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700">
                    <Link
                        href={route("video_blogs.show", video.slug)}
                        className="group/link inline-flex items-center gap-2 text-sm font-semibold text-primary-600 transition-all duration-200 hover:text-primary-700 hover:gap-3 dark:text-primary-400 dark:hover:text-primary-300"
                    >
                        <span>Watch Video</span>
                        <svg
                            className="h-4 w-4 transition-transform duration-200 group-hover/link:translate-x-1"
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
