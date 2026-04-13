import { Head, useForm, usePage } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import CourseHero from "@/Components/courses/CourseHero";
import CourseMainContent from "@/Components/courses/CourseMainContent";
import CourseSidebar from "@/Components/courses/CourseSidebar";
import CourseReviews from "@/Components/courses/CourseReviews";
import RelatedCourses from "@/Components/courses/RelatedCourses";

export default function CourseShow({
    course,
    relatedCourses,
    isEnrolled,
    userReview,
}) {
    const { flash } = usePage().props;
    const { data, setData, post, processing, errors, reset } = useForm({
        rating: userReview ? userReview.rating : 5,
        comment: userReview ? userReview.review : "",
    });

    const submitReview = (e) => {
        e.preventDefault();
        post(route("courses.reviews.store", course.slug), {
            onSuccess: () => reset(),
        });
    };

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
            <div className="min-h-screen bg-white dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100 transition-colors duration-300">
                <Header />

                <main className="pt-20 pb-16">
                    {/* Success/Error Banner */}
                    {(flash?.success || flash?.error) && (
                        <div
                            className={`${
                                flash.success
                                    ? "bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800"
                                    : "bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800"
                            } border-b`}
                        >
                            <Container>
                                <div className="py-4 flex items-center gap-3">
                                    <svg
                                        className={`w-5 h-5 ${
                                            flash.success
                                                ? "text-green-600 dark:text-green-400"
                                                : "text-red-600 dark:text-red-400"
                                        }`}
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d={
                                                flash.success
                                                    ? "M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                    : "M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                            }
                                        />
                                    </svg>
                                    <p className="font-medium">
                                        {flash.success || flash.error}
                                    </p>
                                </div>
                            </Container>
                        </div>
                    )}
                    {/* Hero / Main Layout */}
                    <Container className="mt-8 lg:mt-12">
                        <div className="grid lg:grid-cols-3 gap-12">
                            {/* Left Column: Content */}
                            <div className="lg:col-span-2">
                                <CourseHero course={course} tags={tags} />
                                <CourseMainContent course={course} />
                                <CourseReviews
                                    course={course}
                                    isEnrolled={isEnrolled}
                                    userReview={userReview}
                                    submitReview={submitReview}
                                    data={data}
                                    setData={setData}
                                    processing={processing}
                                    errors={errors}
                                />
                            </div>

                            {/* Right Column: Sticky Sidebar Card */}
                            <div className="lg:col-span-1">
                                <CourseSidebar
                                    course={course}
                                    thumbnailUrl={thumbnailUrl}
                                    videoUrl={videoUrl}
                                    isEnrolled={isEnrolled}
                                />
                            </div>
                        </div>

                        <RelatedCourses relatedCourses={relatedCourses} />
                    </Container>
                </main>
                <Footer />
            </div>
        </>
    );
}
