import { Link } from "@inertiajs/react";
import BookCard from "@/Components/cards/BookCard";
import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';

export default function BookSection({ books }) {
    if (!books || books.length === 0) return null;

    return (
        <section className="py-20 bg-gray-50 dark:bg-gray-800/50">
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                {/* Header */}
                <div className="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12">
                    <div className="max-w-2xl">
                        <span className="inline-block py-1 px-3 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 text-xs font-semibold tracking-wide uppercase mb-3">
                            Our Library
                        </span>
                        <h2 className="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                            Latest <span className="text-primary-600">Books</span>
                        </h2>
                        <p className="mt-4 text-lg text-gray-600 dark:text-gray-400">
                            Explore our comprehensive collection of English learning resources designed to help you master the language.
                        </p>
                    </div>

                    <Link
                        href={route("books.index")}
                        className="group inline-flex items-center gap-2 text-sm font-semibold text-primary-600 transition-colors hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300"
                    >
                        View all books
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

                {/* Slider */}
                <div className="relative">
                    <Swiper
                        modules={[Navigation, Autoplay]}
                        spaceBetween={24}
                        slidesPerView={1}
                        navigation={{
                             nextEl: '.swiper-button-next-custom',
                             prevEl: '.swiper-button-prev-custom',
                        }}
                        autoplay={{
                            delay: 5000,
                            disableOnInteraction: false,
                        }}
                        breakpoints={{
                            640: {
                                slidesPerView: 2,
                            },
                            1024: {
                                slidesPerView: 3,
                            },
                             1280: {
                                slidesPerView: 4,
                            },
                        }}
                        className="!pb-12"
                    >
                        {books.map((book) => (
                            <SwiperSlide key={book.id} className="h-auto">
                                <div className="h-full py-2 pl-1">
                                    <BookCard book={book} />
                                </div>
                            </SwiperSlide>
                        ))}
                    </Swiper>
                    
                    {/* Navigation Buttons (Optional, if we want custom ones) */}
                    {/* 
                    <div className="swiper-button-prev-custom absolute top-1/2 -left-4 z-10 flex h-10 w-10 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full bg-white shadow-lg disabled:opacity-50 dark:bg-gray-800 dark:text-white">
                         <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" /></svg>
                    </div>
                    <div className="swiper-button-next-custom absolute top-1/2 -right-4 z-10 flex h-10 w-10 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full bg-white shadow-lg disabled:opacity-50 dark:bg-gray-800 dark:text-white">
                         <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" /></svg>
                    </div> 
                    */}
                </div>
            </div>
        </section>
    );
}
