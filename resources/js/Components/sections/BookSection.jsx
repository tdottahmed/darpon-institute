import { useEffect, useRef, useState } from "react";
import { Link, usePage } from "@inertiajs/react";
import BookCard from "@/Components/cards/BookCard";
import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import SectionBackground from "../ui/SectionBackground";
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Autoplay } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";

const SECTION_PADDING = "py-16 sm:py-20 lg:py-28";

export default function BookSection({ books }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.books || {};
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

    if (!books || books.length === 0) return null;

    return (
        <section
            ref={sectionRef}
            className={`relative py-8 sm:py-4 lg:py-8 overflow-hidden ${SECTION_PADDING} ${isVisible ? "section-visible" : ""}`}
        >
            <SectionBackground variant="b" />
            <Container className="relative z-10">
                <div className="section-animate section-animate-delay-1 mb-10 sm:mb-8 lg:mb-12">
                    <SectionHeader
                        badge={content.header_badge || "Our Library"}
                        title={
                            <>
                                {content.header_title_prefix || "Latest"}{" "}
                                {content.header_title_highlight || "Books"}
                            </>
                        }
                        subtitle={
                            content.header_subtitle ||
                            "Explore our comprehensive collection of English learning resources designed to help you master the language."
                        }
                        alignment="center"
                    />
                </div>

                <div className="section-animate section-animate-delay-2 relative">
                    <Swiper
                        modules={[Navigation, Autoplay]}
                        spaceBetween={32}
                        slidesPerView={1}
                        navigation={{
                            nextEl: ".swiper-button-next-custom",
                            prevEl: ".swiper-button-prev-custom",
                        }}
                        autoplay={{
                            delay: 5000,
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
                            1280: {
                                slidesPerView: 4,
                                spaceBetween: 32,
                            },
                        }}
                        className="!pb-16"
                    >
                        {books.map((book, index) => (
                            <SwiperSlide key={book.id} className="h-auto">
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
                                    <BookCard book={book} />
                                </div>
                            </SwiperSlide>
                        ))}
                    </Swiper>
                </div>

                <div className="section-animate section-animate-delay-3 text-center">
                    <Link
                        href={route("books.index")}
                        className="group inline-flex items-center gap-2 text-base font-semibold text-primary-600 transition-all duration-200 hover:text-primary-700 hover:gap-3 dark:text-primary-400 dark:hover:text-primary-300"
                    >
                        <span>{content.view_all_link || "View all books"}</span>
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
