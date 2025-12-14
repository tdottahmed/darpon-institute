import { Head, Link } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import CourseCard from "@/Components/courses/CourseCard";
import Button from "@/Components/ui/Button";
import Badge from "@/Components/ui/Badge";
import parse from 'html-react-parser';

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
            <div className="min-h-screen bg-white dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100 transition-colors duration-300">
                <Header />
                
                <main className="pt-20 pb-16">
                    {/* Breadcrumb - Clean & Simple */}
                    <div className="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                        <Container>
                             <nav className="flex items-center gap-2 py-4 text-sm text-gray-500 dark:text-gray-400">
                                <Link href="/" className="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Home</Link>
                                <span>/</span>
                                <Link href="/courses" className="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Courses</Link>
                                <span>/</span>
                                <span className="text-gray-900 dark:text-white font-medium truncate max-w-xs">{course.title}</span>
                            </nav>
                        </Container>
                    </div>

                    {/* Hero / Main Layout */}
                    <Container className="mt-8 lg:mt-12">
                        <div className="grid lg:grid-cols-3 gap-12">
                            {/* Left Column: Content */}
                            <div className="lg:col-span-2">
                                {/* Title & Meta */}
                                <div className="mb-8">
                                    <div className="flex flex-wrap gap-2 mb-4">
                                        {tags.map((tag, index) => (
                                            <Badge key={index} variant="secondary" className="bg-primary-50 text-primary-700 dark:bg-primary-900/30 dark:text-primary-300 border-none">
                                                {tag}
                                            </Badge>
                                        ))}
                                    </div>
                                    <h1 className="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-6 leading-tight">
                                        {course.title}
                                    </h1>
                                    
                                    {/* Short Description */}
                                    {course.short_description && (
                                        <div className="text-lg sm:text-xl text-gray-600 dark:text-gray-300 leading-relaxed max-w-3xl">
                                             {/* Using parse to render HTML safely if needed, or just text */}
                                            {typeof course.short_description === 'string' && course.short_description.includes('<') 
                                                ? parse(course.short_description) 
                                                : course.short_description}
                                        </div>
                                    )}

                                    {/* Meta Bar */}
                                    <div className="flex items-center gap-6 mt-6 pt-6 border-t border-gray-100 dark:border-gray-800">
                                         <div className="flex items-center gap-2">
                                            <div className="p-2 rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
                                                <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p className="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Duration</p>
                                                <p className="text-sm font-semibold text-gray-900 dark:text-white">{course.duration || 'Self-paced'}</p>
                                            </div>
                                         </div>
                                         
                                         {/* Placeholder for future specific meta like "Students Enrolled" or "Level" to mimic premium feel */}
                                          <div className="flex items-center gap-2">
                                            <div className="p-2 rounded-full bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400">
                                                <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p className="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Level</p>
                                                <p className="text-sm font-semibold text-gray-900 dark:text-white">Beginner Friendly</p>
                                            </div>
                                         </div>
                                    </div>
                                </div>

                                {/* Main Description Content */}
                                <div className="prose prose-lg dark:prose-invert max-w-none prose-headings:font-bold prose-headings:text-gray-900 dark:prose-headings:text-white prose-p:text-gray-600 dark:prose-p:text-gray-300 prose-img:rounded-xl">
                                    {course.long_description ? parse(course.long_description) : (
                                        <div className="p-8 bg-gray-50 dark:bg-gray-800 rounded-2xl text-center text-gray-500 dark:text-gray-400 italic">
                                            No detailed description available for this course.
                                        </div>
                                    )}
                                </div>
                            </div>

                            {/* Right Column: Sticky Sidebar Card */}
                            <div className="lg:col-span-1">
                                <div className="sticky top-24 space-y-8">
                                    <div className="rounded-2xl border border-gray-200 bg-white p-6 shadow-xl dark:border-gray-700 dark:bg-gray-800">
                                        {/* Video/Image Preview */}
                                        <div className="relative mb-6 overflow-hidden rounded-xl aspect-video bg-gray-100 dark:bg-gray-900 shadow-inner group">
                                            {videoUrl ? (
                                                <video
                                                    src={videoUrl}
                                                    controls
                                                    className="h-full w-full object-cover"
                                                    poster={thumbnailUrl}
                                                >
                                                    Your browser does not support the video tag.
                                                </video>
                                            ) : thumbnailUrl ? (
                                                <img
                                                    src={thumbnailUrl}
                                                    alt={course.title}
                                                    className="h-full w-full object-cover transition-transform duration-700 hover:scale-105"
                                                />
                                            ) : (
                                               <div className="flex h-full w-full items-center justify-center bg-gradient-to-br from-primary-100 to-secondary-100 dark:from-primary-900/40 dark:to-secondary-900/40">
                                                    <svg className="w-16 h-16 text-primary-400 dark:text-primary-500 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                </div>
                                            )}
                                        </div>

                                        {/* Actions */}
                                        <div className="space-y-3">
                                            <Button variant="primary" size="lg" href={route('courses.enroll', course.slug)} className="w-full justify-center text-lg font-bold shadow-lg shadow-primary-500/20 hover:shadow-primary-500/40 hover:-translate-y-0.5 transition-all">
                                                Start Learning Now
                                            </Button>
                                            <Button variant="outline" size="lg" className="w-full justify-center border-gray-300 dark:border-gray-600 hover:border-gray-900 dark:hover:border-white">
                                                Add to Wishlist
                                            </Button>
                                        </div>

                                        {/* Features List */}
                                        <div className="mt-8 space-y-4 border-t border-gray-100 dark:border-gray-700 pt-6">
                                            <h3 className="font-semibold text-gray-900 dark:text-white">This course includes:</h3>
                                            <ul className="space-y-3 text-sm text-gray-600 dark:text-gray-300">
                                                <li className="flex items-start gap-3">
                                                    <svg className="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span>Full lifetime access</span>
                                                </li>
                                                <li className="flex items-start gap-3">
                                                    <svg className="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span>Access on mobile and desktop</span>
                                                </li>
                                                 <li className="flex items-start gap-3">
                                                    <svg className="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span>Certificate of completion</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Related Courses Section */}
                        {relatedCourses && relatedCourses.length > 0 && (
                            <div className="mt-24 border-t border-gray-200 dark:border-gray-800 pt-16">
                                <div className="flex items-center justify-between mb-8">
                                    <h2 className="text-2xl font-bold text-gray-900 dark:text-white">
                                        More Courses You Might Like
                                    </h2>
                                    <Link href="/courses" className="text-primary-600 hover:text-primary-700 dark:text-primary-400 font-medium hover:underline">
                                        View All
                                    </Link>
                                </div>
                                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                                    {relatedCourses.map((relatedCourse) => (
                                        <div key={relatedCourse.id} className="h-full">
                                            <CourseCard course={relatedCourse} />
                                        </div>
                                    ))}
                                </div>
                            </div>
                        )}
                    </Container>
                </main>
                <Footer />
            </div>
        </>
    );
}
