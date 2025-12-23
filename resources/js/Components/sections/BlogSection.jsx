import { Link, usePage } from "@inertiajs/react";
import VideoBlogCard from "@/Components/cards/VideoBlogCard";

export default function BlogSection({ videoBlogs }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.blog || {};

    // If no video blogs passed, fallback to empty or return null
    if (!videoBlogs || videoBlogs.length === 0) return null;

    return (
        <section className="py-20 bg-white dark:bg-gray-900">
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                {/* Header */}
                <div className="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12">
                     <div className="max-w-2xl">
                        <span className="inline-block py-1 px-3 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 text-xs font-semibold tracking-wide uppercase mb-3">
                            {content.header_badge || "Latest Updates"}
                        </span>
                        <h2 className="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                            {content.header_title_prefix || "Video"}{" "}
                            <span className="text-primary-600">
                                {content.header_title_highlight || "Blogs"}
                            </span>
                        </h2>
                        <p className="mt-4 text-lg text-gray-600 dark:text-gray-400">
                            {content.header_subtitle ||
                                "Watch our latest tutorials, insights, and updates directly from our team."}
                        </p>
                    </div>

                    <Link
                        href={route("video_blogs.index")}
                        className="group inline-flex items-center gap-2 text-sm font-semibold text-primary-600 transition-colors hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300"
                    >
                        {content.view_all_link || "View all videos"}
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

                {/* Grid */}
                <div className="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    {/* Featured Layout: First one could be larger if we wanted, 
                        but standard grid is cleaner for 3 items. */}
                    {videoBlogs.map((video) => (
                        <div key={video.id} className="h-full">
                           <VideoBlogCard video={video} />
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
