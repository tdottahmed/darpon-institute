import { Head, Link, router, usePage } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import CourseCard from "@/Components/courses/CourseCard";
import Button from "@/Components/ui/Button";
import SectionBackground from "@/Components/ui/SectionBackground";
import { useCallback, useEffect, useRef, useState } from "react";
import CTASection from "@/Components/sections/CTASection";

export default function CoursesIndex({ courses, filters }) {
    const { translations } = usePage().props;
    const [searchQuery, setSearchQuery] = useState(filters?.search || "");
    const [showFilters, setShowFilters] = useState(false);
    const [isSearching, setIsSearching] = useState(false);
    const debounceTimer = useRef(null);

    const doSearch = useCallback((query, tag) => {
        const params = {};
        if (query) params.search = query;
        if (tag) params.tag = tag;

        setIsSearching(true);
        router.get("/courses", params, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            onFinish: () => setIsSearching(false),
        });
    }, []);

    const handleSearchChange = (e) => {
        const value = e.target.value;
        setSearchQuery(value);

        clearTimeout(debounceTimer.current);
        debounceTimer.current = setTimeout(() => {
            doSearch(value, filters?.tag);
        }, 350);
    };

    const handleSearchSubmit = (e) => {
        e.preventDefault();
        clearTimeout(debounceTimer.current);
        doSearch(searchQuery, filters?.tag);
    };

    const handleClear = () => {
        setSearchQuery("");
        clearTimeout(debounceTimer.current);
        doSearch("", "");
    };

    useEffect(() => {
        return () => clearTimeout(debounceTimer.current);
    }, []);

    // Get all unique tags from courses
    const allTags = [];
    courses.data?.forEach((course) => {
        if (course.tags && Array.isArray(course.tags)) {
            course.tags.forEach((tag) => {
                if (!allTags.includes(tag)) {
                    allTags.push(tag);
                }
            });
        }
    });

    return (
        <>
            <Head title="All Courses - English Learning Platform" />
            <div className="min-h-screen bg-white dark:bg-gray-900">
                <Header />
                <main>
                    {/* Hero Section */}
                    <section className="relative py-12 sm:py-16 overflow-hidden bg-gradient-to-br from-primary-600 via-primary-700 to-secondary-600 dark:from-primary-800 dark:via-primary-900 dark:to-secondary-800">
                        {/* Background Pattern */}
                        <div className="absolute inset-0 opacity-10">
                            <div
                                className="absolute inset-0"
                                style={{
                                    backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`,
                                }}
                            ></div>
                        </div>

                        {/* Decorative Elements */}
                        <div className="absolute top-0 left-0 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
                        <div className="absolute bottom-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>

                        <Container>
                            <div className="relative z-10 text-center text-white">
                                <h1 className="text-4xl sm:text-5xl font-bold text-white mb-4">
                                    All Courses
                                </h1>
                                <p className="text-lg text-white/90 max-w-2xl mx-auto">
                                    Explore our comprehensive collection of
                                    English learning courses
                                </p>
                            </div>
                        </Container>
                    </section>

                    {/* Search and Filters */}
                    <section className="py-8 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 relative z-20 shadow-sm">
                        <Container>
                            <div className="flex flex-col gap-4">
                                <form
                                    onSubmit={handleSearchSubmit}
                                    className="flex flex-col sm:flex-row gap-4 w-full"
                                >
                                    <div className="flex-1 relative">
                                        <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            {isSearching ? (
                                                <svg className="h-5 w-5 text-primary-500 animate-spin" fill="none" viewBox="0 0 24 24">
                                                    <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
                                                    <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                                                </svg>
                                            ) : (
                                                <svg className="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                            )}
                                        </div>
                                        <input
                                            type="text"
                                            value={searchQuery}
                                            onChange={handleSearchChange}
                                            placeholder="Search courses..."
                                            autoComplete="off"
                                            className="w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 pl-11 pr-10 py-3 transition-colors"
                                        />
                                        {searchQuery && (
                                            <button
                                                type="button"
                                                onClick={handleClear}
                                                className="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors"
                                                aria-label="Clear search"
                                            >
                                                <svg className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        )}
                                    </div>
                                    <div className="flex gap-3">
                                        {allTags.length > 0 && (
                                            <button
                                                type="button"
                                                onClick={() => setShowFilters(!showFilters)}
                                                className={`flex items-center gap-2 px-5 py-3 rounded-xl border-2 transition-all font-medium ${
                                                    showFilters || filters?.tag
                                                        ? "border-primary-500 text-primary-600 bg-primary-50 dark:border-primary-500 dark:text-primary-400 dark:bg-primary-900/20"
                                                        : "border-gray-200 text-gray-700 bg-white hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700"
                                                }`}
                                            >
                                                <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                                                </svg>
                                                Filters
                                                {filters?.tag && (
                                                    <span className="flex h-2.5 w-2.5 relative ml-1">
                                                        <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                                                        <span className="relative inline-flex rounded-full h-2.5 w-2.5 bg-primary-500"></span>
                                                    </span>
                                                )}
                                            </button>
                                        )}

                                        {(searchQuery || filters?.tag) && (
                                            <button
                                                type="button"
                                                onClick={handleClear}
                                                className="flex items-center justify-center gap-2 px-5 py-3 rounded-xl border-2 border-gray-200 text-gray-600 hover:text-red-600 hover:border-red-200 hover:bg-red-50 dark:border-gray-700 dark:text-gray-400 dark:hover:text-red-400 dark:hover:border-red-900/30 dark:hover:bg-red-900/20 transition-all font-medium"
                                                title="Clear all filters"
                                            >
                                                <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Clear
                                            </button>
                                        )}
                                    </div>
                                </form>

                                {/* Tags Filter Dropdown */}
                                {allTags.length > 0 && (
                                    <div className={`overflow-hidden transition-all duration-300 ease-in-out ${showFilters ? "max-h-96 opacity-100 mt-2" : "max-h-0 opacity-0"}`}>
                                        <div className="p-5 rounded-2xl bg-gray-50 border border-gray-200 dark:bg-gray-800/80 dark:border-gray-700 shadow-sm">
                                            <div className="flex items-center gap-2 mb-4">
                                                <svg className="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                </svg>
                                                <h3 className="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">
                                                    Categories & Tags
                                                </h3>
                                            </div>
                                            <div className="flex flex-wrap gap-2.5">
                                                {allTags.map((tag) => (
                                                    <button
                                                        key={tag}
                                                        type="button"
                                                        onClick={() => doSearch(searchQuery, filters?.tag === tag ? "" : tag)}
                                                        className={`px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-200 ${
                                                            filters?.tag === tag
                                                                ? "bg-primary-500 text-white shadow-md shadow-primary-500/20 scale-105"
                                                                : "bg-white text-gray-600 border border-gray-200 hover:border-primary-300 hover:text-primary-600 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:border-primary-500 dark:hover:text-primary-400 dark:hover:bg-gray-600"
                                                        }`}
                                                    >
                                                        {tag}
                                                    </button>
                                                ))}
                                            </div>
                                        </div>
                                    </div>
                                )}
                            </div>
                        </Container>
                    </section>

                    {/* Courses Grid */}
                    <section className="py-12">
                        <Container>
                            {courses.data && courses.data.length > 0 ? (
                                <>
                                    <div className="mb-6">
                                        <p className="text-gray-600 dark:text-gray-400">
                                            Showing {courses.from} to{" "}
                                            {courses.to} of {courses.total}{" "}
                                            courses
                                        </p>
                                    </div>
                                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                        {courses.data.map((course) => (
                                            <CourseCard
                                                key={course.id}
                                                course={course}
                                            />
                                        ))}
                                    </div>

                                    {/* Pagination */}
                                    {courses.links &&
                                        courses.links.length > 3 && (
                                            <div className="mt-8 flex justify-center">
                                                <div className="flex gap-2">
                                                    {courses.links.map(
                                                        (link, index) => (
                                                            <Link
                                                                key={index}
                                                                href={
                                                                    link.url ||
                                                                    "#"
                                                                }
                                                                className={`px-4 py-2 rounded-lg transition-colors ${
                                                                    link.active
                                                                        ? "bg-primary-600 text-white"
                                                                        : "bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                                                } ${
                                                                    !link.url
                                                                        ? "opacity-50 cursor-not-allowed"
                                                                        : ""
                                                                }`}
                                                                dangerouslySetInnerHTML={{
                                                                    __html: link.label,
                                                                }}
                                                            />
                                                        )
                                                    )}
                                                </div>
                                            </div>
                                        )}
                                </>
                            ) : (
                                <div className="text-center py-12">
                                    <div className="text-6xl mb-4">🔍</div>
                                    <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                        No courses found
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-400 mb-4">
                                        {filters?.search || filters?.tag
                                            ? "Try adjusting your search or filters"
                                            : "Check back soon for new courses!"}
                                    </p>
                                    {(filters?.search || filters?.tag) && (
                                        <Link href="/courses">
                                            <Button variant="primary">
                                                View All Courses
                                            </Button>
                                        </Link>
                                    )}
                                </div>
                            )}
                        </Container>
                    </section>
                </main>
                <CTASection />
                <Footer />
            </div>
        </>
    );
}
