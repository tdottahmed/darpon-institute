import { useState } from "react";
import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import Card from "../ui/Card";
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Autoplay, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import { usePage } from "@inertiajs/react";

export default function TestimonialsSection({ testimonials }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.testimonials || {};

    const REVIEW_CHAR_LIMIT = 200;
    const [expandedIds, setExpandedIds] = useState([]);

    const isExpanded = (id) => expandedIds.includes(id);

    const toggleExpand = (id) => {
        setExpandedIds((prev) =>
            prev.includes(id) ? prev.filter((x) => x !== id) : [...prev, id]
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
            className="py-20 sm:py-28 bg-gray-50 dark:bg-gray-800/50"
        >
            <Container>
                <SectionHeader
                    badge={content.header_badge || "Testimonials"}
                    title={content.header_title || "What Our Students Say"}
                    subtitle={
                        content.header_subtitle ||
                        "Real feedback from real learners"
                    }
                    alignment="center"
                    className="mb-16"
                />

                <div className="relative">
                    <Swiper
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
                        className="!pb-16"
                    >
                        {testimonials.map((testimonial) => (
                            <SwiperSlide
                                key={testimonial.id}
                                className="h-auto"
                            >
                                <Card
                                    variant="elevated"
                                    padding="lg"
                                    hover={true}
                                    radius="xl"
                                    className="flex flex-col h-full min-h-[280px] border border-gray-100 dark:border-gray-700"
                                >
                                    {/* Quote Icon */}
                                    <div className="text-4xl text-primary-600 dark:text-primary-400 mb-4 font-serif leading-none">
                                        "
                                    </div>

                                    {/* Review Text */}
                                    <p className="text-gray-700 dark:text-gray-300 mb-6 flex-grow italic text-base leading-relaxed">
                                        {isExpanded(testimonial.id)
                                            ? testimonial.review
                                            : truncateText(
                                                  testimonial.review,
                                                  REVIEW_CHAR_LIMIT
                                              )}

                                        {testimonial.review &&
                                            testimonial.review.length >
                                                REVIEW_CHAR_LIMIT && (
                                                <button
                                                    onClick={() =>
                                                        toggleExpand(
                                                            testimonial.id
                                                        )
                                                    }
                                                    className="ml-2 text-sm font-semibold text-primary-600 hover:text-primary-700 hover:underline dark:text-primary-400 dark:hover:text-primary-300 transition-colors"
                                                    aria-expanded={isExpanded(
                                                        testimonial.id
                                                    )}
                                                >
                                                    {isExpanded(testimonial.id)
                                                        ? "Read less"
                                                        : "Read more"}
                                                </button>
                                            )}
                                    </p>

                                    {/* Author Info */}
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
                                                    {testimonial.name.charAt(0)}
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

                                    {/* Rating */}
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
                            </SwiperSlide>
                        ))}
                    </Swiper>
                </div>
            </Container>
        </section>
    );
}
