import { Link, usePage } from "@inertiajs/react";
import BookCard from "@/Components/cards/BookCard";
import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Autoplay } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";

export default function BookSection({ books }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.books || {};

    if (!books || books.length === 0) return null;

    return (
        <section className="py-20 sm:py-20 bg-gray-50 dark:bg-gray-800/50">
            <Container>
                {/* Section Header */}
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
                    className="mb-16"
                />

                {/* Slider */}
                <div className="relative">
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
                        {books.map((book) => (
                            <SwiperSlide key={book.id} className="h-auto">
                                <div className="h-full">
                                    <BookCard book={book} />
                                </div>
                            </SwiperSlide>
                        ))}
                    </Swiper>
                </div>

                {/* View All Link */}
                <div className="text-center mt-12">
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
