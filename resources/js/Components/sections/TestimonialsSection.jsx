import { useState, useEffect, useRef } from "react";
import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import SectionBackground from "../ui/SectionBackground";
import Card from "../ui/Card";
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Autoplay, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import { usePage } from "@inertiajs/react";

const SECTION_PADDING = "py-16 sm:py-20 lg:py-28";

export default function TestimonialsSection({ testimonials }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.testimonials || {};
    const sectionRef = useRef(null);
    const swiperRef = useRef(null);
    const [isVisible, setIsVisible] = useState(false);

    const REVIEW_CHAR_LIMIT = 200;
    const [expandedIds, setExpandedIds] = useState([]);

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

    const isExpanded = (id) => expandedIds.includes(id);

    const toggleExpand = (id) => {
        setExpandedIds((prev) =>
            prev.includes(id) ? prev.filter((x) => x !== id) : [...prev, id],
        );
    };

    const truncateText = (text, limit) => {
        if (!text) return "";
        if (text.length <= limit) return text;
        const truncated = text.slice(0, limit);
        const lastSpace = truncated.lastIndexOf(" ");
        return `${truncated.slice(0, lastSpace > 0 ? lastSpace : limit)}...`;
    };

    if (!testimonials || testimonials.length === 0) return null;

    return (
        <section
            id="testimonials"
            ref={sectionRef}
            className={`relative py-8 sm:py-4 lg:py-8 overflow-hidden ${SECTION_PADDING} ${isVisible ? "section-visible" : ""}`}
        >
            <SectionBackground variant="b" />
            <Container className="relative z-10">
                <div className="section-animate section-animate-delay-1 mb-10 sm:mb-12 lg:mb-16">
                    <SectionHeader
                        badge={content.header_badge || "Testimonials"}
                        title={content.header_title || "What Our Students Say"}
                        subtitle={
                            content.header_subtitle ||
                            "Real feedback from real learners"
                        }
                        alignment="center"
                    />
                </div>

                <div className="section-animate section-animate-delay-2 relative">
                    <Swiper
                        onSwiper={(swiper) => { swiperRef.current = swiper; }}
                        modules={[Navigation, Autoplay, Pagination]}
                        spaceBetween={32}
                        slidesPerView={1}
                        pagination={{
                            clickable: true,
                            dynamicBullets: true,
                        }}
                        autoplay={{
                            delay: 6000,
                            disableOnInteraction: false,
                        }}
                        breakpoints={{
                            640: {
                                slidesPerView: 2,
                                spaceBetween: 24,
                            },
                            1024: {
                                slidesPerView: 3,
                                spaceBetween: 32,
                            },
                        }}
                        className="!pb-12"
                    >
                        {testimonials.map((testimonial, index) => (
                            <SwiperSlide
                                key={testimonial.id}
                                className="h-auto"
                            >
                                <div
                                    className="h-full section-card-animate"
                                    style={
                                        isVisible
                                            ? {
                                                  animationDelay: `${0.2 + index * 0.06}s`,
                                              }
                                            : undefined
                                    }
                                >
                                    <Card
                                        variant="elevated"
                                        padding="lg"
                                        hover={true}
                                        radius="xl"
                                        className="flex flex-col h-full min-h-[280px] border border-gray-100 dark:border-gray-700"
                                    >
                                        <div className="mb-4">
                                            <svg
                                                className="w-8 h-8 text-primary-500 dark:text-primary-400 opacity-75"
                                                fill="currentColor"
                                                viewBox="0 0 32 32"
                                                aria-hidden="true"
                                            >
                                                <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                                            </svg>
                                        </div>
                                        <p className="text-gray-700 dark:text-gray-300 mb-6 flex-grow italic text-base leading-relaxed">
                                            {isExpanded(testimonial.id)
                                                ? testimonial.review
                                                : truncateText(
                                                      testimonial.review,
                                                      REVIEW_CHAR_LIMIT,
                                                  )}
                                            {testimonial.review &&
                                                testimonial.review.length >
                                                    REVIEW_CHAR_LIMIT && (
                                                    <button
                                                        onClick={() =>
                                                            toggleExpand(
                                                                testimonial.id,
                                                            )
                                                        }
                                                        className="ml-2 text-sm font-semibold text-primary-600 hover:text-primary-700 hover:underline dark:text-primary-400 dark:hover:text-primary-300 transition-colors"
                                                        aria-expanded={isExpanded(
                                                            testimonial.id,
                                                        )}
                                                    >
                                                        {isExpanded(
                                                            testimonial.id,
                                                        )
                                                            ? "Read less"
                                                            : "Read more"}
                                                    </button>
                                                )}
                                        </p>
                                        <div className="flex items-center gap-4 mt-auto pt-4 border-t border-gray-100 dark:border-gray-700">
                                            <div className="h-14 w-14 flex-shrink-0">
                                                {testimonial.avatar ? (
                                                    <img
                                                        src={`/storage/${testimonial.avatar}`}
                                                        alt={testimonial.name}
                                                        className="h-full w-full rounded-full object-cover ring-2 ring-primary-200 dark:ring-primary-800"
                                                    />
                                                ) : (
                                                    <div className="flex h-full w-full items-center justify-center rounded-full bg-primary-100 text-primary-600 font-bold text-xl dark:bg-primary-900/30 dark:text-primary-400">
                                                        {testimonial.name.charAt(
                                                            0,
                                                        )}
                                                    </div>
                                                )}
                                            </div>
                                            <div className="flex-1">
                                                <p className="font-bold text-gray-900 dark:text-white text-base">
                                                    {testimonial.name}
                                                </p>
                                                <p className="text-sm text-gray-600 dark:text-gray-400 mt-0.5">
                                                    {testimonial.role}
                                                </p>
                                            </div>
                                        </div>
                                        <div
                                            className="flex gap-1 mt-4"
                                            aria-label={`${testimonial.rating} out of 5 stars`}
                                            role="img"
                                        >
                                            {[...Array(5)].map((_, i) => (
                                                <span
                                                    key={i}
                                                    className={`text-lg ${
                                                        i < testimonial.rating
                                                            ? "text-yellow-400"
                                                            : "text-gray-300 dark:text-gray-600"
                                                    }`}
                                                    aria-hidden="true"
                                                >
                                                    ★
                                                </span>
                                            ))}
                                        </div>
                                    </Card>
                                </div>
                            </SwiperSlide>
                        ))}
                    </Swiper>

                    {/* Navigation buttons */}
                    <div className="flex justify-center items-center gap-3 mt-2">
                        <button
                            onClick={() => swiperRef.current?.slidePrev()}
                            className="flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm text-gray-600 dark:text-gray-300 hover:bg-primary-50 hover:border-primary-300 hover:text-primary-600 dark:hover:bg-primary-900/20 dark:hover:text-primary-400 transition-all duration-200"
                            aria-label="Previous testimonial"
                        >
                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button
                            onClick={() => swiperRef.current?.slideNext()}
                            className="flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm text-gray-600 dark:text-gray-300 hover:bg-primary-50 hover:border-primary-300 hover:text-primary-600 dark:hover:bg-primary-900/20 dark:hover:text-primary-400 transition-all duration-200"
                            aria-label="Next testimonial"
                        >
                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </Container>
        </section>
    );
}
