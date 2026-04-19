import { useEffect, useRef, useState } from "react";
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Pagination, A11y } from "swiper/modules";
import "swiper/css";
import "swiper/css/pagination";
import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import SectionBackground from "../ui/SectionBackground";
import CourseCard from "../courses/CourseCard";
import SecondaryButton from "../ui/SecondaryButton";
import { usePage } from "@inertiajs/react";

const SECTION_PADDING = "py-16 sm:py-20 lg:py-28";

function ChevronIcon({ direction }) {
    return (
        <svg
            className="w-5 h-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            strokeWidth={2.5}
        >
            <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d={direction === "left" ? "M15 19l-7-7 7-7" : "M9 5l7 7-7 7"}
            />
        </svg>
    );
}

export default function CoursesSection({ courses = [] }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.courses || {};
    const displayedCourses = courses.slice(0, 9);
    const sectionRef = useRef(null);
    const [isVisible, setIsVisible] = useState(false);
    const [swiper, setSwiper] = useState(null);
    const [isBeginning, setIsBeginning] = useState(true);
    const [isEnd, setIsEnd] = useState(false);

    useEffect(() => {
        const el = sectionRef.current;
        if (!el) return;
        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) setIsVisible(true);
            },
            { threshold: 0.08, rootMargin: "0px 0px -20px 0px" },
        );
        observer.observe(el);
        return () => observer.disconnect();
    }, []);

    const handleSlideChange = (sw) => {
        setIsBeginning(sw.isBeginning);
        setIsEnd(sw.isEnd);
    };

    return (
        <section
            ref={sectionRef}
            className={`py-8 sm:py-4 lg:py-8 relative overflow-hidden ${SECTION_PADDING} ${isVisible ? "section-visible" : ""}`}
        >
            <SectionBackground variant="a" />
            <Container className="relative z-10">
                <div className="section-animate section-animate-delay-1 mb-10 sm:mb-12 lg:mb-16">
                    <SectionHeader
                        badge={content.header_badge || "Courses"}
                        title={content.header_title || "Featured Courses"}
                        subtitle={
                            content.header_subtitle ||
                            "Discover our most popular English learning courses designed to help you achieve fluency"
                        }
                        alignment="center"
                    />
                </div>

                {displayedCourses.length > 0 ? (
                    <>
                        {/* Slider controls header */}
                        <div className="section-animate section-animate-delay-2 flex items-center justify-end mb-4 gap-2">
                            <button
                                onClick={() => swiper?.slidePrev()}
                                disabled={isBeginning}
                                aria-label="Previous courses"
                                className="inline-flex items-center justify-center w-10 h-10 rounded-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 shadow-sm transition-all duration-200 hover:bg-primary-50 hover:border-primary-300 hover:text-primary-600 dark:hover:bg-primary-900/30 dark:hover:border-primary-600 dark:hover:text-primary-400 disabled:opacity-35 disabled:cursor-not-allowed disabled:hover:bg-white dark:disabled:hover:bg-gray-800"
                            >
                                <ChevronIcon direction="left" />
                            </button>
                            <button
                                onClick={() => swiper?.slideNext()}
                                disabled={isEnd}
                                aria-label="Next courses"
                                className="inline-flex items-center justify-center w-10 h-10 rounded-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 shadow-sm transition-all duration-200 hover:bg-primary-50 hover:border-primary-300 hover:text-primary-600 dark:hover:bg-primary-900/30 dark:hover:border-primary-600 dark:hover:text-primary-400 disabled:opacity-35 disabled:cursor-not-allowed disabled:hover:bg-white dark:disabled:hover:bg-gray-800"
                            >
                                <ChevronIcon direction="right" />
                            </button>
                        </div>

                        <div className="section-animate section-animate-delay-2">
                            <Swiper
                                modules={[Navigation, Pagination, A11y]}
                                onSwiper={setSwiper}
                                onSlideChange={handleSlideChange}
                                spaceBetween={24}
                                slidesPerView={1}
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
                                {displayedCourses.map((course, index) => (
                                    <SwiperSlide
                                        key={course.id}
                                        className="h-auto"
                                        style={
                                            isVisible
                                                ? {
                                                      animationDelay: `${0.12 + index * 0.07}s`,
                                                  }
                                                : undefined
                                        }
                                    >
                                        <div className="h-full section-card-animate">
                                            <CourseCard course={course} />
                                        </div>
                                    </SwiperSlide>
                                ))}
                            </Swiper>
                        </div>

                        <div className="section-animate section-animate-delay-3 text-center mt-4">
                            <SecondaryButton href="/courses">
                                {content.view_all_btn || "View All Courses"}
                            </SecondaryButton>
                        </div>
                    </>
                ) : (
                    <div className="section-animate section-animate-delay-2 text-center py-8 sm:py-8 md:py-12">
                        <div className="inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary-100 dark:bg-primary-900/30 mb-6">
                            <svg
                                className="w-10 h-10 text-primary-600 dark:text-primary-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                />
                            </svg>
                        </div>
                        <h3 className="text-2xl font-bold text-gray-900 dark:text-white mb-3">
                            No courses available yet
                        </h3>
                        <p className="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                            Check back soon for exciting new courses!
                        </p>
                    </div>
                )}
            </Container>
        </section>
    );
}
