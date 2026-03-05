import { useEffect, useRef, useState } from "react";
import { Link, usePage } from "@inertiajs/react";
import VideoBlogCard from "@/Components/cards/VideoBlogCard";
import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import SectionBackground from "../ui/SectionBackground";

const SECTION_PADDING = "py-16 sm:py-20 lg:py-28";

export default function BlogSection({ videoBlogs }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.blog || {};
    const sectionRef = useRef(null);
    const [isVisible, setIsVisible] = useState(false);

    useEffect(() => {
        const el = sectionRef.current;
        if (!el) return;
        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) setIsVisible(true);
            },
            { threshold: 0.08, rootMargin: "0px 0px -20px 0px" }
        );
        observer.observe(el);
        return () => observer.disconnect();
    }, []);

    if (!videoBlogs || videoBlogs.length === 0) return null;

    return (
        <section
            ref={sectionRef}
            className={`relative overflow-hidden ${SECTION_PADDING} ${isVisible ? "blog-visible" : ""}`}
        >
            <SectionBackground variant="a" />
            <Container className="relative z-10">
                <div className="section-animate section-animate-delay-1 mb-10 sm:mb-12 lg:mb-16">
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
                    />
                </div>

                <div className="grid grid-cols-1 gap-6 sm:gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    {videoBlogs.map((video, index) => (
                        <div
                            key={video.id}
                            className="section-card-animate h-full"
                            style={
                                isVisible
                                    ? {
                                          animationDelay: `${0.12 + index * 0.07}s`,
                                      }
                                    : undefined
                            }
                        >
                            <VideoBlogCard video={video} />
                        </div>
                    ))}
                </div>

                <div className="section-animate section-animate-delay-2 text-center mt-10 sm:mt-12">
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
