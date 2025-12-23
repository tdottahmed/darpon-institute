import { Head, Link, router, usePage } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import SectionHeader from "@/Components/ui/SectionHeader";
import { useState, useEffect } from "react";

export default function GalleryIndex({ galleries }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.gallery || {};
    const [selectedImage, setSelectedImage] = useState(null);
    const [selectedIndex, setSelectedIndex] = useState(0);

    // Get all gallery items for navigation
    const allGalleries = galleries?.data || [];

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
    }, [selectedImage, selectedIndex, allGalleries.length]);

    const openLightbox = (gallery, index) => {
        setSelectedImage(gallery);
        setSelectedIndex(index);
    };

    const handlePrevious = () => {
        const newIndex =
            selectedIndex > 0 ? selectedIndex - 1 : allGalleries.length - 1;
        setSelectedIndex(newIndex);
        setSelectedImage(allGalleries[newIndex]);
    };

    const handleNext = () => {
        const newIndex =
            selectedIndex < allGalleries.length - 1 ? selectedIndex + 1 : 0;
        setSelectedIndex(newIndex);
        setSelectedImage(allGalleries[newIndex]);
    };

    return (
        <>
            <Head title="Gallery - Image Gallery" />
            <div className="min-h-screen bg-white dark:bg-gray-900">
                <Header />
                <main>
                    {/* Hero Section */}
                    <section className="bg-gradient-to-br from-primary-50 to-secondary-50 dark:from-gray-800 dark:to-gray-900 py-16 sm:py-20">
                        <Container>
                            <div className="text-center max-w-3xl mx-auto">
                                <h1 className="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-4">
                                    {content.page_title || "Image Gallery"}
                                </h1>
                                <p className="text-lg sm:text-xl text-gray-600 dark:text-gray-300">
                                    {content.page_subtitle ||
                                        "Explore our collection of images from classes, events, and memorable moments"}
                                </p>
                            </div>
                        </Container>
                    </section>

                    {/* Gallery Section */}
                    <section className="py-16 sm:py-24">
                        <Container>
                            {/* Gallery Grid */}
                            {allGalleries.length > 0 ? (
                                <div className="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                                    {allGalleries.map((gallery, index) => (
                                        <div
                                            key={gallery.id}
                                            className="group relative aspect-square overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-800 cursor-pointer transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl"
                                            onClick={() =>
                                                openLightbox(gallery, index)
                                            }
                                        >
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
                                    ))}
                                </div>
                            ) : (
                                <div className="text-center py-16">
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
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                            />
                                        </svg>
                                    </div>
                                    <h3 className="text-2xl font-bold text-gray-900 dark:text-white mb-3">
                                        No images found
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-400">
                                        Check back soon for new gallery images!
                                    </p>
                                </div>
                            )}

                            {/* Pagination */}
                            {galleries.links && galleries.links.length > 3 && (
                                <div className="mt-12 flex justify-center">
                                    <div className="flex gap-2">
                                        {galleries.links.map((link, index) => (
                                            <Link
                                                key={index}
                                                href={link.url || "#"}
                                                className={`px-4 py-2 rounded-lg text-sm font-medium transition-colors ${
                                                    link.active
                                                        ? "bg-primary-600 text-white"
                                                        : "bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                                } ${
                                                    !link.url
                                                        ? "opacity-50 cursor-not-allowed"
                                                        : ""
                                                }`}
                                                dangerouslySetInnerHTML={{
                                                    __html: link.label,
                                                }}
                                            />
                                        ))}
                                    </div>
                                </div>
                            )}
                        </Container>
                    </section>
                </main>
                <Footer />

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
                            {allGalleries.length > 1 && (
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
                            {allGalleries.length > 1 && (
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
                        {allGalleries.length > 1 && (
                            <div className="absolute bottom-4 left-1/2 -translate-x-1/2 z-10 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md text-white text-sm font-medium">
                                {selectedIndex + 1} / {allGalleries.length}
                            </div>
                        )}

                        {/* Thumbnail Strip */}
                        {allGalleries.length > 1 && (
                            <div className="absolute bottom-16 left-1/2 -translate-x-1/2 z-10 flex gap-2 overflow-x-auto max-w-4xl px-4 pb-2 scrollbar-thin scrollbar-thumb-white/20 scrollbar-track-transparent">
                                {allGalleries.map((gallery, index) => (
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
            </div>
        </>
    );
}
