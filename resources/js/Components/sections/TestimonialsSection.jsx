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

    // limit for truncated review text
    const REVIEW_CHAR_LIMIT = 200;

    // keep track of expanded testimonials (by id)
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
        // avoid cutting mid-word
        const lastSpace = truncated.lastIndexOf(" ");
        return `${truncated.slice(0, lastSpace > 0 ? lastSpace : limit)}...`;
    };

    if (!testimonials || testimonials.length === 0) return null;

    return (
        <section
            id="testimonials"
            className="py-16 sm:py-24 bg-gray-50 dark:bg-gray-800"
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
                    className="mb-12"
                />

                <div className="relative">
                    <Swiper
                        modules={[Navigation, Autoplay, Pagination]}
                        spaceBetween={24}
                        slidesPerView={1}
                        pagination={{ clickable: true }}
                        autoplay={{
                            delay: 6000,
                            disableOnInteraction: false,
                        }}
                        breakpoints={{
                            640: {
                                slidesPerView: 2,
                            },
                            1024: {
                                slidesPerView: 3,
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
                                    className="flex flex-col h-full min-h-[220px]"
                                >
                                    <div className="text-3xl text-primary-600 dark:text-primary-400 mb-3 font-serif leading-none">
                                        “
                                    </div>
                                    <p className="text-gray-700 dark:text-gray-300 mb-4 flex-grow italic text-sm leading-relaxed">
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
                                                    className="ml-2 text-sm text-primary-600 hover:underline"
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
                                    <div className="flex items-center gap-4 mt-auto">
                                        <div className="h-12 w-12 flex-shrink-0">
                                            {testimonial.avatar ? (
                                                <img
                                                    src={`/storage/${testimonial.avatar}`}
                                                    alt={testimonial.name}
                                                    className="h-full w-full rounded-full object-cover"
                                                />
                                            ) : (
                                                <div className="flex h-full w-full items-center justify-center rounded-full bg-primary-100 text-primary-600 font-bold text-lg">
                                                    {testimonial.name.charAt(0)}
                                                </div>
                                            )}
                                        </div>
                                        <div>
                                            <p className="font-semibold text-gray-900 dark:text-white">
                                                {testimonial.name}
                                            </p>
                                            <p className="text-sm text-gray-600 dark:text-gray-400">
                                                {testimonial.role}
                                            </p>
                                        </div>
                                    </div>
                                    <div
                                        className="flex gap-1 mt-4"
                                        aria-label={`${testimonial.rating} out of 5`}
                                        role="img"
                                    >
                                        {[...Array(5)].map((_, i) => (
                                            <span
                                                key={i}
                                                className={`text-sm ${
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
