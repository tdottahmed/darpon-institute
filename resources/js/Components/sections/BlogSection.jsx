import { useEffect, useRef, useState } from "react";
import { usePage } from "@inertiajs/react";

import { Swiper, SwiperSlide } from "swiper/react";
import { Autoplay, Pagination, A11y } from "swiper/modules";
import "swiper/css";
import "swiper/css/pagination";
import VideoBlogCard from "@/Components/cards/VideoBlogCard";
import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import SectionBackground from "../ui/SectionBackground";
import SecondaryButton from "../ui/SecondaryButton";

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
            className={`relative py-8 sm:py-4 lg:py-8 overflow-hidden ${SECTION_PADDING} ${isVisible ? "section-visible" : ""}`}
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

                <div className="section-animate section-animate-delay-2">
                    <Swiper
                        modules={[Autoplay, Pagination, A11y]}
                        spaceBetween={24}
                        slidesPerView={1}
                        loop={true}
                        autoplay={{ delay: 3000, disableOnInteraction: false, pauseOnMouseEnter: true }}
                        breakpoints={{
                            640: { slidesPerView: 2, spaceBetween: 24 },
                            1024: { slidesPerView: 3, spaceBetween: 32 },
                        }}
                        pagination={{
                            clickable: true,
                            bulletClass:
                                "swiper-pagination-bullet !w-2 !h-2 !bg-gray-300 dark:!bg-gray-600 !opacity-100 !mx-1 transition-all duration-200",
                            bulletActiveClass:
                                "!w-6 !bg-primary-500 dark:!bg-primary-400 !rounded-full",
                        }}
                        className="!pb-10"
                    >
                        {videoBlogs.map((video, index) => (
                            <SwiperSlide
                                key={video.id}
                                className="h-auto"
                                style={
                                    isVisible
                                        ? { animationDelay: `${0.12 + index * 0.07}s` }
                                        : undefined
                                }
                            >
                                <div className="h-full section-card-animate">
                                    <VideoBlogCard video={video} />
                                </div>
                            </SwiperSlide>
                        ))}
                    </Swiper>
                </div>

                <div className="section-animate section-animate-delay-3 text-center mt-4">
                    <SecondaryButton href={route("video_blogs.index")}>
                        {content.view_all_link || "View all videos"}
                    </SecondaryButton>
                </div>
            </Container>
        </section>
    );
}
