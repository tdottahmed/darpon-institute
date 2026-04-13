import { Head, Link, router } from "@inertiajs/react";
import { useState, useEffect } from "react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import VideoBlogCard from "@/Components/cards/VideoBlogCard";
import CTASection from "@/Components/sections/CTASection";

export default function Index({ videoBlogs, filters }) {
    const [search, setSearch] = useState(filters.search || "");

    // Debounce search
    useEffect(() => {
        const timer = setTimeout(() => {
            if (search !== filters.search) {
                router.get(
                    route("video_blogs.index"),
                    { search: search, tag: filters.tag },
                    { preserveState: true, replace: true }
                );
            }
        }, 300);

        return () => clearTimeout(timer);
    }, [search]);

    return (
        <>
            <Head title="Video Blogs - English Learning Platform" />
            <div className="min-h-screen bg-white dark:bg-gray-900">
                <Header />
                
                <main className="py-20">
                    <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        {/* Header & Filter */}
                        <div className="mb-12 flex flex-col justify-between gap-6 md:flex-row md:items-end">
                            <div>
                                <h1 className="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                                    Video Blogs
                                </h1>
                                <p className="mt-4 max-w-2xl text-lg text-gray-600 dark:text-gray-400">
                                    Watch insights, tutorials, and updates from our expert team.
                                </p>
                            </div>
                            
                            <div className="w-full md:w-72">
                                <label htmlFor="search" className="sr-only">
                                    Search videos
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
                                        placeholder="Search videos..."
                                    />
                                </div>
                            </div>
                        </div>

                        {/* Grid */}
                        {videoBlogs.data.length > 0 ? (
                            <div className="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                                {videoBlogs.data.map((video) => (
                                    <div key={video.id} className="h-full">
                                        <VideoBlogCard video={video} />
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <div className="flex min-h-[400px] flex-col items-center justify-center rounded-2xl bg-gray-50 dark:bg-gray-800/50">
                                <svg className="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1} d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <h3 className="text-lg font-medium text-gray-900 dark:text-white">
                                    No videos found
                                </h3>
                                <p className="mt-2 text-gray-500 text-center max-w-sm">
                                    We couldn't find any videos matching your search. Try different keywords.
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
                        {videoBlogs.links && videoBlogs.links.length > 3 && (
                            <div className="mt-16 flex justify-center">
                                <nav className="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                    {videoBlogs.links.map((link, i) => (
                                        <Link
                                            key={i}
                                            href={link.url || "#"}
                                            disabled={!link.url}
                                            className={`relative inline-flex items-center px-4 py-2 text-sm font-semibold ${
                                                link.active
                                                    ? 'z-10 bg-primary-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600'
                                                    : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:text-gray-200 dark:ring-gray-700 dark:hover:bg-gray-800'
                                            } ${i === 0 ? 'rounded-l-md' : ''} ${i === videoBlogs.links.length - 1 ? 'rounded-r-md' : ''}`}
                                            dangerouslySetInnerHTML={{ __html: link.label }}
                                        />
                                    ))}
                                </nav>
                            </div>
                        )}
                    </div>
                </main>
                <CTASection />
                <Footer />
            </div>
        </>
    );
}
