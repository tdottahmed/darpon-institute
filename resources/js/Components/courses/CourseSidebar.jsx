import { useState } from "react";
import Button from "@/Components/ui/Button";
import { formatPrice } from "@/Utils/currency";

export default function CourseSidebar({
    course,
    thumbnailUrl,
    videoUrl,
    isEnrolled,
}) {
    const variations = course.variations || [];
    const hasVariations = variations.length > 0;
    const [selectedVariationId, setSelectedVariationId] = useState(null);

    // Get selected variation or use course pricing
    const selectedVariation = selectedVariationId
        ? variations.find((v) => v.id === selectedVariationId)
        : null;

    const priceSource = selectedVariation || course;
    const hasDiscount = priceSource.discount > 0;
    const discountType = priceSource.discount_type || "percentage";

    let discountedPrice = Number(priceSource.price) || 0;
    let discountDisplay = "";
    let originalPrice = Number(priceSource.price) || 0;

    if (hasDiscount && priceSource.price) {
        originalPrice = Number(priceSource.price);
        if (discountType === "flat") {
            discountedPrice = Math.max(
                0,
                Number(priceSource.price) - Number(priceSource.discount)
            );
            discountDisplay = formatPrice(priceSource.discount);
        } else {
            discountedPrice =
                Number(priceSource.price) -
                (Number(priceSource.price) * Number(priceSource.discount)) / 100;
            discountDisplay = `${Math.round(priceSource.discount)}%`;
        }
    }

    return (
        <div className="sticky top-24 space-y-8">
            <div className="rounded-2xl border border-gray-200 bg-white p-6 shadow-xl dark:border-gray-700 dark:bg-gray-800">
                {/* Video/Image Preview */}
                <div className="relative mb-6 overflow-hidden rounded-xl aspect-video bg-gray-100 dark:bg-gray-900 shadow-inner group">
                    {videoUrl ? (
                        <video
                            src={videoUrl}
                            controls
                            className="h-full w-full object-cover"
                            poster={thumbnailUrl}
                        >
                            Your browser does not support the video tag.
                        </video>
                    ) : thumbnailUrl ? (
                        <img
                            src={thumbnailUrl}
                            alt={course.title}
                            className="h-full w-full object-cover transition-transform duration-700 hover:scale-105"
                        />
                    ) : (
                        <div className="flex h-full w-full items-center justify-center bg-gradient-to-br from-primary-100 to-secondary-100 dark:from-primary-900/40 dark:to-secondary-900/40">
                            <svg
                                className="w-16 h-16 text-primary-400 dark:text-primary-500 opacity-50"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={1}
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                />
                            </svg>
                        </div>
                    )}
                </div>

                {/* Variations Selection */}
                {hasVariations && !isEnrolled && (
                    <div className="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <label className="block text-sm font-semibold text-gray-900 dark:text-white mb-3">
                            Select Duration:
                        </label>
                        <div className="space-y-2">
                            {variations.map((variation) => {
                                const varHasDiscount = variation.discount > 0;
                                const varDiscountType = variation.discount_type || "percentage";
                                let varDiscountedPrice = Number(variation.price) || 0;
                                let varOriginalPrice = Number(variation.price) || 0;

                                if (varHasDiscount && variation.price) {
                                    varOriginalPrice = Number(variation.price);
                                    if (varDiscountType === "flat") {
                                        varDiscountedPrice = Math.max(
                                            0,
                                            Number(variation.price) - Number(variation.discount)
                                        );
                                    } else {
                                        varDiscountedPrice =
                                            Number(variation.price) -
                                            (Number(variation.price) * Number(variation.discount)) / 100;
                                    }
                                }

                                const isSelected = selectedVariationId === variation.id;

                                return (
                                    <button
                                        key={variation.id}
                                        type="button"
                                        onClick={() => setSelectedVariationId(variation.id)}
                                        className={`w-full text-left p-3 rounded-lg border-2 transition-all ${
                                            isSelected
                                                ? "border-primary-500 bg-primary-50 dark:bg-primary-900/20"
                                                : "border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600"
                                        }`}
                                    >
                                        <div className="flex items-center justify-between">
                                            <div>
                                                <div className="font-semibold text-gray-900 dark:text-white">
                                                    {variation.name}
                                                </div>
                                                {variation.duration && (
                                                    <div className="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                        {variation.duration}
                                                    </div>
                                                )}
                                            </div>
                                            <div className="text-right">
                                                <div className="font-bold text-primary-600 dark:text-primary-400">
                                                    {formatPrice(varDiscountedPrice)}
                                                </div>
                                                {varHasDiscount && (
                                                    <div className="text-xs text-gray-400 line-through">
                                                        {formatPrice(varOriginalPrice)}
                                                    </div>
                                                )}
                                            </div>
                                        </div>
                                    </button>
                                );
                            })}
                        </div>
                    </div>
                )}

                {/* Price Section */}
                {(course.price || selectedVariation) && (
                    <div className="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div className="flex items-baseline gap-3">
                            <span className="text-3xl font-bold text-primary-600 dark:text-primary-400">
                                {formatPrice(discountedPrice)}
                            </span>
                            {hasDiscount && (
                                <span className="text-xl font-medium text-gray-400 line-through dark:text-gray-500">
                                    {formatPrice(originalPrice)}
                                </span>
                            )}
                        </div>
                        {selectedVariation && (
                            <p className="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {selectedVariation.name}
                                {selectedVariation.duration && ` • ${selectedVariation.duration}`}
                            </p>
                        )}
                        {!course.price && !selectedVariation && (
                            <p className="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Free Course
                            </p>
                        )}
                    </div>
                )}

                {/* Enrollment Status */}
                {isEnrolled ? (
                    <div className="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                        <div className="flex items-center gap-2 mb-2">
                            <svg
                                className="w-5 h-5 text-green-600 dark:text-green-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            <span className="font-semibold text-green-800 dark:text-green-200">
                                You're Enrolled!
                            </span>
                        </div>
                        <p className="text-sm text-green-700 dark:text-green-300">
                            Access your course materials from your dashboard.
                        </p>
                        <Button
                            variant="primary"
                            size="md"
                            href={route("dashboard")}
                            className="w-full mt-3"
                        >
                            Go to Dashboard
                        </Button>
                    </div>
                ) : (
                    <>
                        {/* Actions */}
                        <div className="space-y-3">
                            <Button
                                variant="primary"
                                size="lg"
                                href={
                                    selectedVariationId
                                        ? `${route("courses.enroll", course.slug)}?variation=${selectedVariationId}`
                                        : route("courses.enroll", course.slug)
                                }
                                className="w-full justify-center text-lg font-bold shadow-lg shadow-primary-500/20 hover:shadow-primary-500/40 hover:-translate-y-0.5 transition-all"
                            >
                                <svg
                                    className="w-5 h-5 mr-2"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M12 4v16m8-8H4"
                                    />
                                </svg>
                                Enroll Now
                            </Button>
                            {hasVariations && !selectedVariationId && (
                                <p className="text-xs text-center text-gray-500 dark:text-gray-400">
                                    Please select a duration above
                                </p>
                            )}
                        </div>

                        {/* Features List */}
                        <div className="mt-8 space-y-4 border-t border-gray-100 dark:border-gray-700 pt-6">
                            <h3 className="font-semibold text-gray-900 dark:text-white mb-4">
                                What you'll get:
                            </h3>
                            <ul className="space-y-3 text-sm text-gray-600 dark:text-gray-300">
                                <li className="flex items-start gap-3">
                                    <svg
                                        className="w-5 h-5 text-green-500 shrink-0 mt-0.5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>
                                    <span>Full lifetime access</span>
                                </li>
                                <li className="flex items-start gap-3">
                                    <svg
                                        className="w-5 h-5 text-green-500 shrink-0 mt-0.5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>
                                    <span>Access on mobile and desktop</span>
                                </li>
                                <li className="flex items-start gap-3">
                                    <svg
                                        className="w-5 h-5 text-green-500 shrink-0 mt-0.5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>
                                    <span>Certificate of completion</span>
                                </li>
                                <li className="flex items-start gap-3">
                                    <svg
                                        className="w-5 h-5 text-green-500 shrink-0 mt-0.5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>
                                    <span>Expert support and guidance</span>
                                </li>
                            </ul>
                        </div>
                    </>
                )}
            </div>
        </div>
    );
}
