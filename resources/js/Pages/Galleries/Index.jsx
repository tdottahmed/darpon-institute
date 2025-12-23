import { Head, Link, router, usePage } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import SectionHeader from "@/Components/ui/SectionHeader";
import { useState } from "react";

export default function GalleryIndex({ galleries }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.gallery || {};
    const [selectedImage, setSelectedImage] = useState(null);

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
                            {galleries.data && galleries.data.length > 0 ? (
                                <div className="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                                    {galleries.data.map((gallery) => (
                                        <div
                                            key={gallery.id}
                                            className="group relative aspect-square overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-800 cursor-pointer transition-all duration-300 hover:scale-105 hover:shadow-2xl"
                                            onClick={() =>
                                                setSelectedImage(gallery)
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
            </div>
        </>
    );
}
