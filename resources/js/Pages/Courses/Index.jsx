import { Head, Link, usePage } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import CourseCard from "@/Components/courses/CourseCard";
import Button from "@/Components/ui/Button";
import { useState } from "react";

export default function CoursesIndex({ courses, filters }) {
    const { translations } = usePage().props;
    const [searchQuery, setSearchQuery] = useState(filters?.search || "");

    const handleSearch = (e) => {
        e.preventDefault();
        // Inertia will handle the search via URL params
        window.location.href = `/courses${
            searchQuery ? `?search=${encodeURIComponent(searchQuery)}` : ""
        }`;
    };

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
                <main className="pt-20">
                    {/* Hero Section */}
                    <section className="bg-gradient-to-br from-primary-50 via-secondary-50 to-accent-50 dark:from-gray-800 dark:via-gray-900 py-12 sm:py-16">
                        <Container>
                            <div className="text-center">
                                <h1 className="text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                                    All Courses
                                </h1>
                                <p className="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                                    Explore our comprehensive collection of
                                    English learning courses
                                </p>
                            </div>
                        </Container>
                    </section>

                    {/* Search and Filters */}
                    <section className="py-8 border-b border-gray-200 dark:border-gray-700">
                        <Container>
                            <form
                                onSubmit={handleSearch}
                                className="flex flex-col sm:flex-row gap-4"
                            >
                                <div className="flex-1">
                                    <input
                                        type="text"
                                        value={searchQuery}
                                        onChange={(e) =>
                                            setSearchQuery(e.target.value)
                                        }
                                        placeholder="Search courses..."
                                        className="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 px-4 py-2"
                                    />
                                </div>
                                <Button type="submit" variant="primary">
                                    Search
                                </Button>
                                {filters?.search && (
                                    <Link
                                        href="/courses"
                                        className="px-6 py-2 rounded-lg border-2 border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors"
                                    >
                                        Clear
                                    </Link>
                                )}
                            </form>

                            {/* Tags Filter */}
                            {allTags.length > 0 && (
                                <div className="mt-4 flex flex-wrap gap-2">
                                    <span className="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Filter by tag:
                                    </span>
                                    {allTags.map((tag) => (
                                        <Link
                                            key={tag}
                                            href={`/courses?tag=${encodeURIComponent(
                                                tag
                                            )}`}
                                            className={`px-3 py-1 rounded-full text-sm transition-colors ${
                                                filters?.tag === tag
                                                    ? "bg-primary-600 text-white"
                                                    : "bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                                            }`}
                                        >
                                            {tag}
                                        </Link>
                                    ))}
                                </div>
                            )}
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
                <Footer />
            </div>
        </>
    );
}
