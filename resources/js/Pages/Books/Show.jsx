import { Head, Link } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import BookSection from "@/Components/sections/BookSection";
import Button from "@/Components/ui/Button";
import parse from "html-react-parser";
import { formatPrice } from "@/Utils/currency";

export default function Show({ book, relatedBooks }) {
    // Discount Calculation
    const hasDiscount = book.discount > 0;
    const discountedPrice = hasDiscount
        ? Number(book.price) - (Number(book.price) * Number(book.discount)) / 100
        : Number(book.price);

    return (
         <>
            <Head title={`${book.title} - English Learning Platform`} />
            <div className="min-h-screen bg-white dark:bg-gray-900">
                <Header />

                <main className="py-12 bg-gray-50 dark:bg-gray-900">
                    <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        {/* Breadcrumbs */}
                        <nav className="flex mb-8" aria-label="Breadcrumb">
                            <ol className="flex items-center space-x-2">
                                <li>
                                    <Link href={route("home")} className="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                        Home
                                    </Link>
                                </li>
                                <li className="text-gray-400">/</li>
                                <li>
                                    <Link href={route("books.index")} className="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                        Books
                                    </Link>
                                </li>
                                <li className="text-gray-400">/</li>
                                <li className="text-gray-900 font-medium dark:text-white truncate max-w-xs">{book.title}</li>
                            </ol>
                        </nav>

                        {/* Product Detail Layout */}
                        <div className="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
                            {/* Image Gallery / Cover */}
                            <div className="product-image-wrapper">
                                <div className="aspect-[3/4] w-full overflow-hidden rounded-2xl bg-gray-100 dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700">
                                     <img
                                        src={book.cover_image ? `/storage/${book.cover_image}` : '/assets/images/book-placeholder.png'}
                                        alt={book.title}
                                        className="h-full w-full object-cover object-center"
                                    />
                                </div>
                                {/* If we had multiple preview images, they would go here as a small grid */}
                            </div>

                            {/* Product Info */}
                            <div className="mt-10 px-4 sm:mt-16 sm:px-0 lg:mt-0">
                                <span className="inline-flex items-center rounded-full bg-primary-100 px-3 py-1 text-sm font-medium text-primary-600 dark:bg-primary-900/30 dark:text-primary-400 mb-4">
                                     {book.author}
                                </span>
                                
                                <h1 className="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                                    {book.title}
                                </h1>

                                <div className="mt-6">
                                    <h2 className="sr-only">Product information</h2>
                                    <div className="flex items-baseline gap-4">
                                         {hasDiscount && (
                                            <p className="text-xl text-gray-500 line-through dark:text-gray-400">
                                                {formatPrice(book.price)}
                                            </p>
                                        )}
                                        <p className="text-3xl font-bold tracking-tight text-primary-600 dark:text-primary-400">
                                            {formatPrice(discountedPrice)}
                                        </p>
                                        {hasDiscount && (
                                            <span className="inline-flex items-center rounded-md bg-red-100 px-2.5 py-0.5 text-sm font-medium text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                                 Save {Math.round(book.discount)}%
                                            </span>
                                        )}
                                    </div>
                                </div>

                                <div className="mt-8">
                                    <h3 className="sr-only">Description</h3>
                                    <div className="prose prose-sm xl:prose-base text-gray-600 dark:text-gray-300 dark:prose-invert max-w-none">
                                         {/* Render HTML content safely */}
                                         {book.long_description ? parse(book.long_description) : book.short_description}
                                    </div>
                                </div>

                                {/* Tags */}
                                {book.tags && book.tags.length > 0 && (
                                    <div className="mt-8 border-t border-gray-200 pt-8 dark:border-gray-700">
                                        <h3 className="text-sm font-medium text-gray-900 dark:text-white">Tags</h3>
                                        <div className="mt-4 flex flex-wrap gap-2">
                                            {book.tags.map((tag, i) => (
                                                <Link
                                                    key={i}
                                                    href={route('books.index', { tag: tag })}
                                                    className="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-800 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition-colors"
                                                >
                                                    #{tag}
                                                </Link>
                                            ))}
                                        </div>
                                    </div>
                                )}

                                {/* Sticky Mobile Buy / Desktop Action */}
                                <div className="mt-10 flex gap-4">
                                     {/* Add to Cart or Enroll logic would go here. For now, a placeholder button */}
                                     {book.stock_quantity > 0 ? (
                                        <Button 
                                            variant="primary" 
                                            size="lg" 
                                            href={route('books.checkout', book.slug)}
                                            className="flex-1 justify-center shadow-lg shadow-primary-500/20 hover:shadow-primary-500/40 hover:-translate-y-0.5 transition-all"
                                        >
                                            Buy Now
                                        </Button>
                                     ) : (
                                         <button disabled className="flex w-full items-center justify-center rounded-xl bg-gray-300 px-8 py-4 text-base font-bold text-gray-500 cursor-not-allowed dark:bg-gray-800 dark:text-gray-600">
                                            Out of Stock
                                        </button>
                                     )}
                                </div>
                                <div className="mt-4 text-center">
                                    <p className="text-sm text-gray-500 dark:text-gray-400">
                                        {book.stock_quantity > 0 ? `${book.stock_quantity} copies available` : 'Currently unavailable'}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

                {/* Related Books */}
                {relatedBooks && relatedBooks.length > 0 && (
                     <div className="border-t border-gray-200 dark:border-gray-800">
                        <BookSection books={relatedBooks} />
                     </div>
                )}

                <Footer />
            </div>
         </>
    );
}
