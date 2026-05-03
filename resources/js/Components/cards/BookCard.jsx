import { Link } from "@inertiajs/react";
import { formatPrice } from "@/Utils/currency";
import PrimaryButton from "../ui/PrimaryButton";

function truncateWords(html, limit) {
    const text = html.replace(/<[^>]*>/g, " ").replace(/\s+/g, " ").trim();
    const words = text.split(" ");
    if (words.length <= limit) return text;
    return words.slice(0, limit).join(" ") + "…";
}

export default function BookCard({ book }) {
    const hasDiscount = book.discount > 0;
    const discountedPrice = hasDiscount
        ? Number(book.price) -
          (Number(book.price) * Number(book.discount)) / 100
        : Number(book.price);

    return (
        <div className="group relative flex h-full flex-col min-h-[480px] overflow-hidden rounded-2xl bg-white shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            {/* Image / Cover */}
            <div className="relative aspect-square overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-900 dark:to-gray-800">
                <img
                    src={
                        book.cover_image
                            ? `/storage/${book.cover_image}`
                            : "/assets/images/book-placeholder.png"
                    }
                    alt={book.title}
                    className="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                    loading="lazy"
                />
                <div className="absolute inset-0 flex items-center justify-center bg-black/60 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                    <Link
                        href={route("books.show", book.slug)}
                        className="transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-gray-900 shadow-xl hover:bg-gray-50"
                    >
                        View Details
                    </Link>
                </div>
            </div>

            {/* Content */}
            <div className="flex flex-1 flex-col p-6">
                {/* Title */}
                <Link
                    href={route("books.show", book.slug)}
                    className="group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-200 mb-2"
                >
                    <h3 className="line-clamp-2 text-lg font-bold text-gray-900 dark:text-white leading-tight">
                        {book.title}
                    </h3>
                </Link>

                {/* Author */}
                <p className="text-sm font-semibold text-primary-600 dark:text-primary-400 mb-3">
                    {book.author}
                </p>

                {/* Short Description */}
                {/* {book.short_description && (
                    <p className="mb-4 flex-1 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        {truncateWords(book.short_description, 20)}
                    </p>
                )} */}

                {/* Footer */}
                <div className="mt-auto space-y-3">
                    {/* Price */}
                    <div className="flex items-center justify-between gap-2">
                        <div className="flex items-baseline gap-2">
                            <span className="text-xl font-bold text-primary-600 dark:text-primary-400 leading-none">
                                {formatPrice(discountedPrice)}
                            </span>
                            {hasDiscount && (
                                <span className="text-sm text-gray-400 line-through leading-none">
                                    {formatPrice(book.price)}
                                </span>
                            )}
                        </div>
                        {hasDiscount && (
                            <span className="inline-flex items-center rounded-lg bg-red-50 px-2.5 py-1 text-sm font-bold text-red-600 dark:bg-red-900/20 dark:text-red-400">
                                -{Math.round(book.discount)}%
                            </span>
                        )}
                    </div>

                    {/* Action Button */}
                    <PrimaryButton
                        href={route("books.show", book.slug)}
                        className="w-full"
                    >
                        View Book
                    </PrimaryButton>
                </div>
            </div>
        </div>
    );
}
