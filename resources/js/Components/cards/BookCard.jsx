import { Link } from "@inertiajs/react";
import { formatPrice } from "@/Utils/currency";
import Badge from "../ui/Badge";
import PrimaryButton from "../ui/PrimaryButton";

export default function BookCard({ book }) {
    const hasDiscount = book.discount > 0;
    const discountedPrice = hasDiscount
        ? Number(book.price) -
          (Number(book.price) * Number(book.discount)) / 100
        : Number(book.price);

    const stockStatus =
        book.stock_quantity > 0
            ? { text: "In Stock", color: "text-green-600 dark:text-green-400" }
            : { text: "Out of Stock", color: "text-red-600 dark:text-red-400" };

    return (
        <div className="group relative flex h-full flex-col min-h-[520px] overflow-hidden rounded-2xl bg-white shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            {/* Image / Cover */}
            <div className="relative aspect-[3/4] overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-900 dark:to-gray-800">
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

                {/* Badges Overlay */}
                <div className="absolute left-4 top-4 z-10 flex flex-col gap-2">
                    {hasDiscount && (
                        <Badge
                            variant="primary"
                            className="bg-red-500 text-white shadow-lg font-bold"
                        >
                            -{Math.round(book.discount)}%
                        </Badge>
                    )}
                    {book.stock_quantity === 0 && (
                        <Badge
                            variant="secondary"
                            className="bg-gray-900/80 text-white backdrop-blur-sm"
                        >
                            Sold Out
                        </Badge>
                    )}
                </div>

                {/* Hover Overlay with Quick Action */}
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
                {/* Author */}
                <div className="mb-2">
                    <p className="text-xs font-semibold uppercase tracking-wide text-primary-600 dark:text-primary-400">
                        {book.author}
                    </p>
                </div>

                {/* Title */}
                <Link
                    href={route("books.show", book.slug)}
                    className="group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-200 mb-3"
                >
                    <h3 className="line-clamp-2 text-lg font-bold text-gray-900 dark:text-white leading-tight">
                        {book.title}
                    </h3>
                </Link>

                {/* Short Description */}
                {book.short_description && (
                    <p className="mb-4 line-clamp-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        {book.short_description.replace(/<[^>]*>/g, "")}
                    </p>
                )}

                {/* Footer */}
                <div className="mt-auto space-y-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                    {/* Price */}
                    <div className="flex items-baseline justify-between">
                        <div className="flex flex-col">
                            {hasDiscount && (
                                <span className="text-xs text-gray-500 line-through dark:text-gray-400">
                                    {formatPrice(book.price)}
                                </span>
                            )}
                            <span className="text-2xl font-bold text-primary-600 dark:text-primary-400">
                                {formatPrice(discountedPrice)}
                            </span>
                        </div>
                        {/* Stock Status */}
                        <span
                            className={`text-xs font-medium ${stockStatus.color}`}
                        >
                            {stockStatus.text}
                        </span>
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
