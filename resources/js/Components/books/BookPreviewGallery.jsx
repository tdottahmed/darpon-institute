import { useState, useEffect } from "react";

export default function BookPreviewGallery({
    previewImages,
    coverImage,
    bookTitle,
}) {
    const [selectedIndex, setSelectedIndex] = useState(0);
    const [isTurning, setIsTurning] = useState(false);
    const [direction, setDirection] = useState("next");

    // Combine cover image with preview images
    const allImages = coverImage
        ? [coverImage, ...(previewImages || [])]
        : previewImages || [];

    useEffect(() => {
        if (allImages.length === 0) return;

        // Auto-advance pages every 5 seconds
        const interval = setInterval(() => {
            if (selectedIndex < allImages.length - 1) {
                setDirection("next");
                setIsTurning(true);
                setTimeout(() => {
                    setSelectedIndex((prev) => prev + 1);
                    setIsTurning(false);
                }, 300);
            } else {
                setDirection("prev");
                setIsTurning(true);
                setTimeout(() => {
                    setSelectedIndex(0);
                    setIsTurning(false);
                }, 300);
            }
        }, 5000);

        return () => clearInterval(interval);
    }, [selectedIndex, allImages.length]);

    if (!allImages || allImages.length === 0) {
        return null;
    }

    const handleThumbnailClick = (index) => {
        if (index === selectedIndex) return;

        setDirection(index > selectedIndex ? "next" : "prev");
        setIsTurning(true);
        setTimeout(() => {
            setSelectedIndex(index);
            setIsTurning(false);
        }, 300);
    };

    const handlePrevious = () => {
        if (selectedIndex > 0) {
            setDirection("prev");
            setIsTurning(true);
            setTimeout(() => {
                setSelectedIndex((prev) => prev - 1);
                setIsTurning(false);
            }, 300);
        }
    };

    const handleNext = () => {
        if (selectedIndex < allImages.length - 1) {
            setDirection("next");
            setIsTurning(true);
            setTimeout(() => {
                setSelectedIndex((prev) => prev + 1);
                setIsTurning(false);
            }, 300);
        }
    };

    const getImageUrl = (imagePath) => {
        if (!imagePath) return null;
        if (imagePath.startsWith("http")) return imagePath;
        return `/storage/${imagePath}`;
    };

    return (
        <div className="space-y-4">
            {/* Main Image Display with Page Turn Effect */}
            <div className="relative aspect-[3/4] w-full overflow-hidden rounded-2xl bg-gray-100 dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700">
                {/* Book Page Turn Animation Container */}
                <div
                    className={`relative h-full w-full transition-transform duration-300 ${
                        isTurning
                            ? direction === "next"
                                ? "transform-gpu scale-x-0 origin-left"
                                : "transform-gpu scale-x-0 origin-right"
                            : "scale-x-100"
                    }`}
                >
                    <img
                        src={
                            getImageUrl(allImages[selectedIndex]) ||
                            "/assets/images/book-placeholder.png"
                        }
                        alt={`${bookTitle} - Preview ${selectedIndex + 1}`}
                        className="h-full w-full object-cover object-center"
                        loading="lazy"
                    />
                </div>

                {/* Navigation Arrows */}
                {allImages.length > 1 && (
                    <>
                        <button
                            onClick={handlePrevious}
                            disabled={selectedIndex === 0}
                            className={`absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-white/90 dark:bg-gray-800/90 p-2 shadow-lg transition-all duration-200 hover:bg-white dark:hover:bg-gray-700 ${
                                selectedIndex === 0
                                    ? "opacity-50 cursor-not-allowed"
                                    : "opacity-100 hover:scale-110"
                            }`}
                            aria-label="Previous page"
                        >
                            <svg
                                className="h-6 w-6 text-gray-800 dark:text-gray-200"
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
                        <button
                            onClick={handleNext}
                            disabled={selectedIndex === allImages.length - 1}
                            className={`absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-white/90 dark:bg-gray-800/90 p-2 shadow-lg transition-all duration-200 hover:bg-white dark:hover:bg-gray-700 ${
                                selectedIndex === allImages.length - 1
                                    ? "opacity-50 cursor-not-allowed"
                                    : "opacity-100 hover:scale-110"
                            }`}
                            aria-label="Next page"
                        >
                            <svg
                                className="h-6 w-6 text-gray-800 dark:text-gray-200"
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
                    </>
                )}

                {/* Page Counter */}
                {allImages.length > 1 && (
                    <div className="absolute bottom-4 left-1/2 -translate-x-1/2 rounded-full bg-black/60 backdrop-blur-sm px-4 py-1.5 text-sm font-medium text-white">
                        {selectedIndex + 1} / {allImages.length}
                    </div>
                )}
            </div>

            {/* Thumbnail Gallery */}
            {allImages.length > 1 && (
                <div className="flex gap-2 overflow-x-auto pb-2 scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-700 scrollbar-track-transparent">
                    {allImages.map((image, index) => {
                        const imageUrl = getImageUrl(image);
                        return (
                            <button
                                key={index}
                                onClick={() => handleThumbnailClick(index)}
                                className={`group relative flex-shrink-0 overflow-hidden rounded-lg border-2 transition-all duration-200 ${
                                    selectedIndex === index
                                        ? "border-primary-500 dark:border-primary-400 scale-105 shadow-lg"
                                        : "border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600"
                                }`}
                                aria-label={`View preview ${index + 1}`}
                            >
                                <div className="relative aspect-[3/4] w-20 sm:w-24 md:w-28">
                                    <img
                                        src={
                                            imageUrl ||
                                            "/assets/images/book-placeholder.png"
                                        }
                                        alt={`${bookTitle} - Thumbnail ${
                                            index + 1
                                        }`}
                                        className={`h-full w-full object-cover transition-all duration-200 ${
                                            selectedIndex === index
                                                ? "brightness-100"
                                                : "brightness-90 group-hover:brightness-100"
                                        }`}
                                        loading="lazy"
                                    />
                                    {/* Active Indicator */}
                                    {selectedIndex === index && (
                                        <div className="absolute inset-0 bg-primary-500/20"></div>
                                    )}
                                </div>
                                {/* Page Number Badge */}
                                <div
                                    className={`absolute bottom-1 right-1 rounded-full px-1.5 py-0.5 text-xs font-semibold transition-all duration-200 ${
                                        selectedIndex === index
                                            ? "bg-primary-500 text-white"
                                            : "bg-black/60 text-white opacity-0 group-hover:opacity-100"
                                    }`}
                                >
                                    {index + 1}
                                </div>
                            </button>
                        );
                    })}
                </div>
            )}
        </div>
    );
}
