import { Link, usePage } from "@inertiajs/react";
import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import { useState } from "react";

export default function GallerySection({ galleries = [] }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.gallery || {};
    const displayedGalleries = galleries.slice(0, 8);
    const [selectedImage, setSelectedImage] = useState(null);

    // Check if gallery section should be shown (CMS control)
    const showOnLanding =
        content.show_on_landing !== "0" && content.show_on_landing !== "false";

    if (!showOnLanding || !galleries || galleries.length === 0) return null;

    return (
        <>
            <section className="py-20 sm:py-28 bg-white dark:bg-gray-900">
                <Container>
                    {/* Section Header */}
                    <SectionHeader
                        badge={content.header_badge || "Gallery"}
                        title={content.header_title || "Our Gallery"}
                        subtitle={
                            content.header_subtitle ||
                            "Explore moments from our classes, events, and student achievements"
                        }
                        alignment="center"
                        className="mb-16"
                    />

                    {/* Gallery Grid */}
                    <div className="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                        {displayedGalleries.map((gallery, index) => (
                            <div
                                key={gallery.id}
                                className="group relative aspect-square overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-800 cursor-pointer transition-all duration-300 hover:scale-105 hover:shadow-2xl"
                                onClick={() => setSelectedImage(gallery)}
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
                            </div>
                        ))}
                    </div>

                    {/* View All Link */}
                    {galleries.length > displayedGalleries.length && (
                        <div className="text-center mt-12">
                            <Link
                                href={route("galleries.index")}
                                className="group inline-flex items-center gap-2 text-base font-semibold text-primary-600 transition-all duration-200 hover:text-primary-700 hover:gap-3 dark:text-primary-400 dark:hover:text-primary-300"
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
                            </Link>
                        </div>
                    )}
                </Container>
            </section>

            {/* Lightbox Modal */}
            {selectedImage && (
                <div
                    className="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4"
                    onClick={() => setSelectedImage(null)}
                >
                    <div className="relative max-w-5xl w-full">
                        <button
                            onClick={() => setSelectedImage(null)}
                            className="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors"
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
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                        <img
                            src={
                                selectedImage.image
                                    ? `/storage/${selectedImage.image}`
                                    : "/assets/images/placeholder.png"
                            }
                            alt="Gallery Image"
                            className="w-full h-auto rounded-lg"
                        />
                    </div>
                </div>
            )}
        </>
    );
}
