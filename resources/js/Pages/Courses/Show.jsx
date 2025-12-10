import { Head, Link } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import CourseCard from "@/Components/courses/CourseCard";
import Button from "@/Components/ui/Button";
import Badge from "@/Components/ui/Badge";

export default function CourseShow({ course, relatedCourses }) {
    const thumbnailUrl = course.thumbnail
        ? course.thumbnail.startsWith("http")
            ? course.thumbnail
            : `/storage/${course.thumbnail}`
        : null;

    const videoUrl = course.preview_video
        ? course.preview_video.startsWith("http")
            ? course.preview_video
            : `/storage/${course.preview_video}`
        : null;

    const tags = Array.isArray(course.tags) ? course.tags : [];

    return (
        <>
            <Head title={`${course.title} - English Learning Platform`} />
            <div className="min-h-screen bg-white dark:bg-gray-900">
                <Header />
                <main className="pt-20">
                    {/* Hero Section */}
                    <section className="bg-gradient-to-br from-primary-50 via-secondary-50 to-accent-50 dark:from-gray-800 dark:via-gray-900 py-12">
                        <Container>
                            <Link
                                href="/courses"
                                className="inline-flex items-center text-primary-600 hover:text-primary-700 dark:text-primary-400 mb-4"
                            >
                                <svg
                                    className="w-5 h-5 mr-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M15 19l-7-7 7-7"
                                    />
                                </svg>
                                Back to Courses
                            </Link>

                            <div className="grid lg:grid-cols-2 gap-8">
                                {/* Thumbnail/Video */}
                                <div>
                                    {videoUrl ? (
                                        <div className="rounded-xl overflow-hidden shadow-xl">
                                            <video
                                                src={videoUrl}
                                                controls
                                                className="w-full h-auto"
                                                poster={thumbnailUrl}
                                            >
                                                Your browser does not support
                                                the video tag.
                                            </video>
                                        </div>
                                    ) : thumbnailUrl ? (
                                        <img
                                            src={thumbnailUrl}
                                            alt={course.title}
                                            className="w-full rounded-xl shadow-xl"
                                        />
                                    ) : (
                                        <div className="w-full h-64 bg-gradient-to-br from-primary-400 to-secondary-400 rounded-xl shadow-xl flex items-center justify-center">
                                            <span className="text-9xl">📚</span>
                                        </div>
                                    )}
                                </div>

                                {/* Course Info */}
                                <div className="flex flex-col justify-center">
                                    {/* Tags */}
                                    {tags.length > 0 && (
                                        <div className="mb-4 flex flex-wrap gap-2">
                                            {tags.map((tag, index) => (
                                                <Badge
                                                    key={index}
                                                    variant="primary"
                                                >
                                                    {tag}
                                                </Badge>
                                            ))}
                                        </div>
                                    )}

                                    <h1 className="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                                        {course.title}
                                    </h1>

                                    {course.short_description && (
                                        <div
                                            className="text-lg text-gray-600 dark:text-gray-300 mb-6"
                                            dangerouslySetInnerHTML={{
                                                __html: course.short_description,
                                            }}
                                        />
                                    )}

                                    {/* Meta Info */}
                                    <div className="flex flex-wrap items-center gap-6 mb-6 text-gray-600 dark:text-gray-400">
                                        {course.duration && (
                                            <div className="flex items-center gap-2">
                                                <svg
                                                    className="w-5 h-5"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        strokeLinecap="round"
                                                        strokeLinejoin="round"
                                                        strokeWidth={2}
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                                    />
                                                </svg>
                                                <span>{course.duration}</span>
                                            </div>
                                        )}
                                    </div>

                                    {/* CTA Buttons */}
                                    <div className="flex flex-col sm:flex-row gap-4">
                                        <Button
                                            variant="primary"
                                            size="lg"
                                            className="flex-1"
                                        >
                                            Enroll Now
                                        </Button>
                                        <Button variant="outline" size="lg">
                                            Add to Wishlist
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </Container>
                    </section>

                    {/* Course Description */}
                    {course.long_description && (
                        <section className="py-12">
                            <Container>
                                <div className="max-w-4xl mx-auto">
                                    <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                                        Course Description
                                    </h2>
                                    <div
                                        className="prose prose-lg dark:prose-invert max-w-none"
                                        dangerouslySetInnerHTML={{
                                            __html: course.long_description,
                                        }}
                                    />
                                </div>
                            </Container>
                        </section>
                    )}

                    {/* Related Courses */}
                    {relatedCourses && relatedCourses.length > 0 && (
                        <section className="py-12 bg-gray-50 dark:bg-gray-800">
                            <Container>
                                <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-8">
                                    Related Courses
                                </h2>
                                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                    {relatedCourses.map((relatedCourse) => (
                                        <CourseCard
                                            key={relatedCourse.id}
                                            course={relatedCourse}
                                        />
                                    ))}
                                </div>
                            </Container>
                        </section>
                    )}
                </main>
                <Footer />
            </div>
        </>
    );
}
