import { Link, usePage } from "@inertiajs/react";
import VideoBlogCard from "@/Components/cards/VideoBlogCard";
import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";

export default function BlogSection({ videoBlogs }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.blog || {};

    if (!videoBlogs || videoBlogs.length === 0) return null;

    return (
        <section className="py-20 sm:py-20 bg-white dark:bg-gray-800/50">
            <Container>
                {/* Section Header */}
                <SectionHeader
                    badge={content.header_badge || "Latest Updates"}
                    title={
                        <>
                            {content.header_title_prefix || "Video"}{" "}
                            {content.header_title_highlight || "Blogs"}
                        </>
                    }
                    subtitle={
                        content.header_subtitle ||
                        "Watch our latest tutorials, insights, and updates directly from our team."
                    }
                    alignment="center"
                    className="mb-16"
                />

                {/* Grid */}
                <div className="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    {videoBlogs.map((video) => (
                        <div key={video.id} className="h-full">
                            <VideoBlogCard video={video} />
                        </div>
                    ))}
                </div>

                {/* View All Link */}
                <div className="text-center mt-12">
                    <Link
                        href={route("video_blogs.index")}
                        className="group inline-flex items-center gap-2 text-base font-semibold text-primary-600 transition-all duration-200 hover:text-primary-700 hover:gap-3 dark:text-primary-400 dark:hover:text-primary-300"
                    >
                        <span>
                            {content.view_all_link || "View all videos"}
                        </span>
                        <svg
                            className="h-5 w-5 transition-transform duration-200 group-hover:translate-x-1"
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
            </Container>
        </section>
    );
}
