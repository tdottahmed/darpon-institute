import { Link, usePage } from "@inertiajs/react";
import { useState, useEffect, useRef } from "react";
import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import SectionBackground from "../ui/SectionBackground";
import Button from "../ui/Button";

const SECTION_PADDING = "py-16 sm:py-20 lg:py-28";

export default function GallerySection({ galleries = [] }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.gallery || {};
    const displayedGalleries = galleries.slice(0, 8);
    const [selectedImage, setSelectedImage] = useState(null);
    const [selectedIndex, setSelectedIndex] = useState(0);
    const sectionRef = useRef(null);
    const [isVisible, setIsVisible] = useState(false);

    // Check if gallery section should be shown (CMS control)
    const showOnLanding =
        content.show_on_landing !== "0" && content.show_on_landing !== "false";

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

    if (!showOnLanding || !galleries || galleries.length === 0) return null;

    // Handle keyboard navigation
    useEffect(() => {
        if (!selectedImage) return;

        const handleKeyDown = (e) => {
            if (e.key === "Escape") {
                setSelectedImage(null);
            } else if (e.key === "ArrowLeft") {
                handlePrevious();
            } else if (e.key === "ArrowRight") {
                handleNext();
            }
        };

        window.addEventListener("keydown", handleKeyDown);
        return () => window.removeEventListener("keydown", handleKeyDown);
    }, [selectedImage, selectedIndex]);

    const openLightbox = (gallery, index) => {
        setSelectedImage(gallery);
        setSelectedIndex(index);
    };

    const handlePrevious = () => {
        const newIndex =
            selectedIndex > 0
                ? selectedIndex - 1
                : displayedGalleries.length - 1;
        setSelectedIndex(newIndex);
        setSelectedImage(displayedGalleries[newIndex]);
    };

    const handleNext = () => {
        const newIndex =
            selectedIndex < displayedGalleries.length - 1
                ? selectedIndex + 1
                : 0;
        setSelectedIndex(newIndex);
        setSelectedImage(displayedGalleries[newIndex]);
    };

    return (
        <>
            <section
                ref={sectionRef}
                className={`relative py-8 sm:py-4 lg:py-8 overflow-hidden ${SECTION_PADDING} ${isVisible ? "section-visible" : ""}`}
            >
                <SectionBackground variant="a" />
                <Container className="relative z-10">
                    <div className="section-animate section-animate-delay-1 mb-10 sm:mb-12 lg:mb-16">
                        <SectionHeader
                            badge={content.header_badge || "Gallery"}
                            title={content.header_title || "Our Gallery"}
                            subtitle={
                                content.header_subtitle ||
                                "Explore moments from our classes, events, and student achievements"
                            }
                            alignment="center"
                        />
                    </div>

                    <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                        {displayedGalleries.map((gallery, index) => (
                            <div
                                key={gallery.id}
                                className="section-card-animate group relative overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-800 cursor-pointer transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl"
                                style={
                                    isVisible
                                        ? {
                                              animationDelay: `${0.12 + index * 0.05}s`,
                                          }
                                        : undefined
                                }
                                onClick={() => openLightbox(gallery, index)}
                            >
                                <div className="relative h-48 w-full">
                                    <img
                                        src={
                                            gallery.image
                                                ? `/storage/${gallery.image}`
                                                : "/assets/images/placeholder.png"
                                        }
                                        alt="Gallery Image"
                                        className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                        loading="lazy"
                                    />
                                    {/* Overlay on hover */}
                                    <div className="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center">
                                        <div className="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <svg
                                                className="h-12 w-12 text-white drop-shadow-lg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    strokeWidth={2}
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"
                                                />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>

                    <div className="section-animate section-animate-delay-2 text-center mt-10 sm:mt-12">
                        <div className="group inline-flex">
                            <Button
                                href={route("galleries.index")}
                                variant="primary"
                                size="lg"
                                className="inline-flex items-center gap-2"
                            >
                                <span>
                                    {content.view_all_link || "View All Images"}
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
                            </Button>
                        </div>
                    </div>
                </Container>
            </section>

            {/* Enhanced Lightbox Modal */}
            {selectedImage && (
                <div
                    className="fixed inset-0 z-50 flex items-center justify-center bg-black/95 backdrop-blur-sm p-4 animate-in fade-in duration-200"
                    onClick={(e) => {
                        if (e.target === e.currentTarget) {
                            setSelectedImage(null);
                        }
                    }}
                >
                    {/* Close Button - Top Right */}
                    <button
                        onClick={() => setSelectedImage(null)}
                        className="absolute top-4 right-4 z-10 p-3 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md text-white transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-white/50"
                        aria-label="Close lightbox"
                    >
                        <svg
                            className="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>

                    {/* Image Container */}
                    <div className="relative max-w-7xl w-full max-h-[90vh] flex items-center justify-center">
                        {/* Previous Button */}
                        {displayedGalleries.length > 1 && (
                            <button
                                onClick={(e) => {
                                    e.stopPropagation();
                                    handlePrevious();
                                }}
                                className="absolute left-4 z-10 p-3 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md text-white transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-white/50 disabled:opacity-50 disabled:cursor-not-allowed"
                                aria-label="Previous image"
                            >
                                <svg
                                    className="h-8 w-8"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M15 19l-7-7 7-7"
                                    />
                                </svg>
                            </button>
                        )}

                        {/* Main Image */}
                        <div className="relative w-full h-full flex items-center justify-center">
                            <img
                                src={
                                    selectedImage.image
                                        ? `/storage/${selectedImage.image}`
                                        : "/assets/images/placeholder.png"
                                }
                                alt="Gallery Image"
                                className="max-w-full max-h-[90vh] w-auto h-auto object-contain rounded-lg shadow-2xl"
                            />
                        </div>

                        {/* Next Button */}
                        {displayedGalleries.length > 1 && (
                            <button
                                onClick={(e) => {
                                    e.stopPropagation();
                                    handleNext();
                                }}
                                className="absolute right-4 z-10 p-3 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md text-white transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-white/50 disabled:opacity-50 disabled:cursor-not-allowed"
                                aria-label="Next image"
                            >
                                <svg
                                    className="h-8 w-8"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </button>
                        )}
                    </div>

                    {/* Image Counter */}
                    {displayedGalleries.length > 1 && (
                        <div className="absolute bottom-4 left-1/2 -translate-x-1/2 z-10 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md text-white text-sm font-medium">
                            {selectedIndex + 1} / {displayedGalleries.length}
                        </div>
                    )}

                    {/* Thumbnail Strip */}
                    {displayedGalleries.length > 1 && (
                        <div className="absolute bottom-16 left-1/2 -translate-x-1/2 z-10 flex gap-2 overflow-x-auto max-w-4xl px-4 pb-2 scrollbar-thin scrollbar-thumb-white/20 scrollbar-track-transparent">
                            {displayedGalleries.map((gallery, index) => (
                                <button
                                    key={gallery.id}
                                    onClick={(e) => {
                                        e.stopPropagation();
                                        openLightbox(gallery, index);
                                    }}
                                    className={`flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden border-2 transition-all duration-200 ${
                                        selectedIndex === index
                                            ? "border-white scale-110 shadow-lg"
                                            : "border-white/30 hover:border-white/60 opacity-70 hover:opacity-100"
                                    }`}
                                    aria-label={`View image ${index + 1}`}
                                >
                                    <img
                                        src={
                                            gallery.image
                                                ? `/storage/${gallery.image}`
                                                : "/assets/images/placeholder.png"
                                        }
                                        alt={`Thumbnail ${index + 1}`}
                                        className="h-full w-full object-cover"
                                    />
                                </button>
                            ))}
                        </div>
                    )}
                </div>
            )}
        </>
    );
}
