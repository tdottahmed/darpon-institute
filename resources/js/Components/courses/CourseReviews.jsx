import { useForm } from "@inertiajs/react";
import PrimaryButton from "@/Components/ui/PrimaryButton";
import Avatar from "@/Components/ui/Avatar";
import SecondaryButton from "@/Components/ui/SecondaryButton";

export default function CourseReviews({
    course,
    isEnrolled,
    userReview,
    submitReview,
    data,
    setData,
    processing,
    errors,
}) {
    const reviews = course.reviews || [];
    const averageRating =
        reviews.length > 0
            ? (
                  reviews.reduce((acc, rev) => acc + rev.rating, 0) /
                  reviews.length
              ).toFixed(1)
            : 0;

    return (
        <div className="mt-12 lg:col-span-2">
            <div className="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div>
                    <h3 className="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        Student Reviews
                    </h3>
                    <div className="flex items-center gap-4">
                        <div className="flex text-yellow-400 text-xl font-bold">
                            {[...Array(5)].map((_, i) => (
                                <span key={i}>
                                    {i < Math.round(averageRating) ? "★" : "☆"}
                                </span>
                            ))}
                        </div>
                        <span className="text-gray-600 dark:text-gray-400 font-medium">
                            {averageRating} out of 5 ({reviews.length} reviews)
                        </span>
                    </div>
                </div>

                {isEnrolled && (
                    <SecondaryButton
                        href="#write-review"
                        showIcon={false}
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
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                            />
                        </svg>
                        {userReview ? "Update your review" : "Write a review"}
                    </SecondaryButton>
                )}
            </div>

            <div className="grid gap-8 mb-16">
                {reviews.length > 0 ? (
                    reviews.map((review) => (
                        <div
                            key={review.id}
                            className="bg-white dark:bg-gray-800/40 p-6 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow"
                        >
                            <div className="flex items-start gap-4">
                                <Avatar
                                    name={review.user.name}
                                    src={review.user.avatar}
                                    size="lg"
                                    className="ring-2 ring-primary-50 dark:ring-primary-900/20"
                                />
                                <div className="flex-1 min-w-0">
                                    <div className="flex flex-wrap items-center justify-between gap-2 mb-2">
                                        <h4 className="font-bold text-gray-900 dark:text-white truncate">
                                            {review.user.name}
                                        </h4>
                                        <span className="text-sm text-gray-500 dark:text-gray-400">
                                            {new Date(
                                                review.created_at
                                            ).toLocaleDateString(undefined, {
                                                year: "numeric",
                                                month: "short",
                                                day: "numeric",
                                            })}
                                        </span>
                                    </div>
                                    <div className="flex text-yellow-400 text-sm mb-3">
                                        {[...Array(5)].map((_, i) => (
                                            <span key={i}>
                                                {i < review.rating ? "★" : "☆"}
                                            </span>
                                        ))}
                                    </div>
                                    <p className="text-gray-600 dark:text-gray-300 leading-relaxed italic">
                                        "{review.review}"
                                    </p>
                                </div>
                            </div>
                        </div>
                    ))
                ) : (
                    <div className="text-center py-12 px-4 rounded-3xl bg-gray-50 dark:bg-gray-800/30 border-2 border-dashed border-gray-200 dark:border-gray-700">
                        <div className="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 mb-4">
                            <svg
                                className="w-8 h-8"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                                />
                            </svg>
                        </div>
                        <p className="text-gray-500 dark:text-gray-400 font-medium">
                            No reviews yet. Be the first to share your
                            experience!
                        </p>
                    </div>
                )}
            </div>

            {isEnrolled && (
                <div
                    id="write-review"
                    className="bg-gradient-to-br from-primary-50 to-secondary-50 dark:from-primary-900/10 dark:to-secondary-900/10 rounded-3xl p-8 border border-primary-100 dark:border-primary-900/20"
                >
                    <div className="flex items-center gap-4 mb-6">
                        <div className="p-3 bg-white dark:bg-gray-800 rounded-2xl shadow-sm text-primary-600 dark:text-primary-400">
                            <svg
                                className="w-6 h-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                />
                            </svg>
                        </div>
                        <div>
                            <h4 className="text-xl font-bold text-gray-900 dark:text-white">
                                {userReview
                                    ? "Update your review"
                                    : "Share your thoughts"}
                            </h4>
                            <p className="text-gray-600 dark:text-gray-400 text-sm">
                                Your feedback helps other students make informed
                                decisions.
                            </p>
                        </div>
                    </div>

                    <form onSubmit={submitReview} className="space-y-6">
                        <div>
                            <label className="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                How would you rate this course?
                            </label>
                            <div className="flex gap-3">
                                {[1, 2, 3, 4, 5].map((star) => (
                                    <button
                                        key={star}
                                        type="button"
                                        onClick={() => setData("rating", star)}
                                        className={`text-4xl focus:outline-none transition-all duration-200 transform hover:scale-125 ${
                                            data.rating >= star
                                                ? "text-yellow-400 drop-shadow-sm"
                                                : "text-gray-300 hover:text-yellow-200"
                                        }`}
                                    >
                                        ★
                                    </button>
                                ))}
                            </div>
                            {errors.rating && (
                                <div className="text-red-500 text-sm mt-2 font-medium">
                                    {errors.rating}
                                </div>
                            )}
                        </div>

                        <div>
                            <label className="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                Detailed Review
                            </label>
                            <textarea
                                className="w-full rounded-2xl border-gray-200 bg-white/80 py-4 px-5 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800/80 dark:border-gray-700 dark:text-gray-200 transition-all duration-300 resize-none"
                                rows="5"
                                value={data.comment}
                                onChange={(e) =>
                                    setData("comment", e.target.value)
                                }
                                placeholder="What did you like about the course? How can it be improved?"
                            ></textarea>
                            {errors.comment && (
                                <div className="text-red-500 text-sm mt-2 font-medium">
                                    {errors.comment}
                                </div>
                            )}
                        </div>

                        <PrimaryButton
                            className="px-10 h-14"
                            disabled={processing}
                            showIcon={true}
                        >
                            {processing ? (
                                <span className="flex items-center gap-2">
                                    <svg
                                        className="animate-spin h-5 w-5"
                                        viewBox="0 0 24 24"
                                    >
                                        <circle
                                            className="opacity-25"
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="currentColor"
                                            strokeWidth="4"
                                            fill="none"
                                        />
                                        <path
                                            className="opacity-75"
                                            fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"
                                        />
                                    </svg>
                                    Submitting...
                                </span>
                            ) : userReview ? (
                                "Update Review"
                            ) : (
                                "Submit Review"
                            )}
                        </PrimaryButton>
                    </form>
                </div>
            )}
        </div>
    );
}
