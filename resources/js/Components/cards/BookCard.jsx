import { Link } from "@inertiajs/react";

export default function BookCard({ book }) {
    // Calculate discount percentage if not already present, though backend might send it
    const hasDiscount = book.discount > 0;
    const discountedPrice = hasDiscount
        ? Number(book.price) - (Number(book.price) * Number(book.discount)) / 100
        : Number(book.price);

    return (
        <div className="group relative flex h-full flex-col overflow-hidden rounded-2xl bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
            {/* Image / Cover */}
            <div className="relative aspect-[3/4] overflow-hidden bg-gray-100 dark:bg-gray-900">
                <img
                    src={book.cover_image ? `/storage/${book.cover_image}` : '/assets/images/book-placeholder.png'}
                    alt={book.title}
                    className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                />
                
                {/* Badges */}
                <div className="absolute left-3 top-3 flex flex-col gap-2">
                     {hasDiscount && (
                        <span className="inline-flex items-center rounded-full bg-red-500 px-2.5 py-1 text-xs font-bold text-white shadow-md">
                            -{Math.round(book.discount)}%
                        </span>
                     )}
                     {/* Can add 'New' badge here if logic exists, e.g. created_at within 7 days */}
                </div>

                {/* Overlay Action */}
                <div className="absolute inset-x-0 bottom-0 flex translate-y-full items-center justify-center bg-gradient-to-t from-black/80 to-transparent p-4 transition-transform duration-300 group-hover:translate-y-0">
                    <Link
                        href={route("books.show", book.slug)}
                        className="w-full rounded-lg bg-white py-2.5 text-center text-sm font-semibold text-gray-900 shadow-lg transition-transform hover:scale-105 active:scale-95"
                    >
                        View Details
                    </Link>
                </div>
            </div>

            {/* Content */}
            <div className="flex flex-1 flex-col p-5">
                <div className="mb-2">
                    <p className="text-xs font-medium text-primary-600 dark:text-primary-400">
                        {book.author}
                    </p>
                </div>
                
                <Link href={route("books.show", book.slug)} className="group-hover:text-primary-600 transition-colors">
                    <h3 className="mb-2 line-clamp-2 text-lg font-bold text-gray-900 dark:text-white">
                        {book.title}
                    </h3>
                </Link>

                <div className="mt-auto flex items-end justify-between pt-4">
                    <div className="flex flex-col">
                        {hasDiscount && (
                            <span className="text-xs text-gray-500 line-through dark:text-gray-400">
                                ${Number(book.price).toFixed(2)}
                            </span>
                        )}
                        <span className="text-xl font-bold text-primary-600 dark:text-primary-400">
                            ${discountedPrice.toFixed(2)}
                        </span>
                    </div>
                    {/* Optional: Add to Cart button logic here if needed, or keeping it clean */}
                </div>
            </div>
        </div>
    );
}
