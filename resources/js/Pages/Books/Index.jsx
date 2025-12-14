import { Head, Link, router } from "@inertiajs/react";
import { useState, useEffect } from "react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import BookCard from "@/Components/cards/BookCard";

export default function Index({ books, filters }) {
    const [search, setSearch] = useState(filters.search || "");

    // Debounce search
    useEffect(() => {
        const timer = setTimeout(() => {
            if (search !== filters.search) {
                router.get(
                    route("books.index"),
                    { search: search, tag: filters.tag },
                    { preserveState: true, replace: true }
                );
            }
        }, 300);

        return () => clearTimeout(timer);
    }, [search]);

    return (
        <>
            <Head title="Library - English Learning Platform" />
            <div className="min-h-screen bg-white dark:bg-gray-900">
                <Header />
                
                <main className="py-20">
                    <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        {/* Header & Filter */}
                        <div className="mb-12 flex flex-col justify-between gap-6 md:flex-row md:items-end">
                            <div>
                                <h1 className="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                                    Our Books
                                </h1>
                                <p className="mt-4 max-w-2xl text-lg text-gray-600 dark:text-gray-400">
                                    Browse our complete collection of resources designed for your learning journey.
                                </p>
                            </div>
                            
                            <div className="w-full md:w-72">
                                <label htmlFor="search" className="sr-only">
                                    Search books
                                </label>
                                <div className="relative">
                                    <div className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg
                                            className="h-5 w-5 text-gray-400"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                fillRule="evenodd"
                                                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                                clipRule="evenodd"
                                            />
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        name="search"
                                        id="search"
                                        value={search}
                                        onChange={(e) => setSearch(e.target.value)}
                                        className="block w-full rounded-full border-0 py-2.5 pl-10 pr-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 dark:bg-gray-800 dark:ring-gray-700 dark:text-white sm:text-sm sm:leading-6"
                                        placeholder="Search by title or author..."
                                    />
                                </div>
                            </div>
                        </div>

                        {/* Grid */}
                        {books.data.length > 0 ? (
                            <div className="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                                {books.data.map((book) => (
                                    <div key={book.id} className="h-full">
                                        <BookCard book={book} />
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <div className="flex min-h-[400px] flex-col items-center justify-center rounded-2xl bg-gray-50 dark:bg-gray-800/50">
                                <svg
                                    className="h-16 w-16 text-gray-400 mb-4"
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
                                <h3 className="text-lg font-medium text-gray-900 dark:text-white">
                                    No books found
                                </h3>
                                <p className="mt-2 text-gray-500 text-center max-w-sm">
                                    We couldn't find any books matching your search. Try different keywords or browse all options.
                                </p>
                                {filters.search && (
                                    <button
                                        onClick={() => setSearch("")}
                                        className="mt-6 text-sm font-semibold text-primary-600 hover:text-primary-500"
                                    >
                                        Clear search
                                    </button>
                                )}
                            </div>
                        )}

                        {/* Pagination */}
                        {books.links && books.links.length > 3 && (
                            <div className="mt-16 flex justify-center">
                                <nav className="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                    {books.links.map((link, i) => (
                                        <Link
                                            key={i}
                                            href={link.url || "#"}
                                            disabled={!link.url}
                                            className={`relative inline-flex items-center px-4 py-2 text-sm font-semibold ${
                                                link.active
                                                    ? 'z-10 bg-primary-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600'
                                                    : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:text-gray-200 dark:ring-gray-700 dark:hover:bg-gray-800'
                                            } ${i === 0 ? 'rounded-l-md' : ''} ${i === books.links.length - 1 ? 'rounded-r-md' : ''}`}
                                            dangerouslySetInnerHTML={{ __html: link.label }}
                                        />
                                    ))}
                                </nav>
                            </div>
                        )}
                    </div>
                </main>
                
                <Footer />
            </div>
        </>
    );
}
