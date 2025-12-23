import { Head, Link } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import BlogSection from "@/Components/sections/BlogSection"; // Reusing for related videos
import parse from "html-react-parser";

export default function Show({ videoBlog, relatedVideoBlogs }) {
    // Helper to get YouTube ID from URL
    const getYoutubeId = (url) => {
        if (!url) return null;
        const regExp =
            /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
        const match = url.match(regExp);
        return match && match[2].length === 11 ? match[2] : null;
    };

    const youtubeId =
        videoBlog.video_type === "youtube"
            ? getYoutubeId(videoBlog.video_url)
            : null;

    return (
        <>
            <Head title={`${videoBlog.title} - Video Blogs`} />
            <div className="min-h-screen bg-white dark:bg-gray-900">
                <Header />

                <main className="py-12 bg-gray-50 dark:bg-gray-900">
                    <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        {/* Breadcrumbs */}
                        <nav
                            className="hidden md:flex mb-8"
                            aria-label="Breadcrumb"
                        >
                            <ol className="flex items-center space-x-2">
                                <li>
                                    <Link
                                        href={route("home")}
                                        className="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                                    >
                                        Home
                                    </Link>
                                </li>
                                <li className="text-gray-400">/</li>
                                <li>
                                    <Link
                                        href={route("video_blogs.index")}
                                        className="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                                    >
                                        Video Blogs
                                    </Link>
                                </li>
                                <li className="text-gray-400">/</li>
                                <li className="text-gray-900 font-medium dark:text-white truncate max-w-xs">
                                    {videoBlog.title}
                                </li>
                            </ol>
                        </nav>

                        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            {/* Main Content (Player & Description) */}
                            <div className="lg:col-span-2">
                                {/* Video Player Container */}
                                <div className="aspect-video w-full overflow-hidden rounded-2xl bg-black shadow-lg mb-8 relative z-10">
                                    {videoBlog.video_type === "youtube" &&
                                    youtubeId ? (
                                        <iframe
                                            className="h-full w-full"
                                            src={`https://www.youtube.com/embed/${youtubeId}?rel=0&modestbranding=1`}
                                            title={videoBlog.title}
                                            frameBorder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowFullScreen
                                        ></iframe>
                                    ) : videoBlog.video_type === "upload" &&
                                      videoBlog.video_file ? (
                                        <video
                                            controls
                                            className="h-full w-full"
                                            poster={
                                                videoBlog.thumbnail
                                                    ? `/storage/${videoBlog.thumbnail}`
                                                    : null
                                            }
                                        >
                                            <source
                                                src={`/storage/${videoBlog.video_file}`}
                                                type="video/mp4"
                                            />
                                            Your browser does not support the
                                            video tag.
                                        </video>
                                    ) : (
                                        <div className="flex h-full w-full items-center justify-center text-white">
                                            Video content unavailable
                                        </div>
                                    )}
                                </div>

                                {/* Title & Meta */}
                                <div className="space-y-4">
                                    <div className="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                                        <span>
                                            {new Date(
                                                videoBlog.created_at
                                            ).toLocaleDateString(undefined, {
                                                year: "numeric",
                                                month: "long",
                                                day: "numeric",
                                            })}
                                        </span>
                                        {videoBlog.tags && (
                                            <span className="text-gray-300">
                                                •
                                            </span>
                                        )}
                                        <div className="flex gap-2">
                                            {videoBlog.tags &&
                                                videoBlog.tags.map((tag, i) => (
                                                    <span
                                                        key={i}
                                                        className="font-medium text-primary-600 dark:text-primary-400 uppercase tracking-wider"
                                                    >
                                                        {tag}
                                                    </span>
                                                ))}
                                        </div>
                                    </div>

                                    <h1 className="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                                        {videoBlog.title}
                                    </h1>

                                    <div className="prose prose-lg text-gray-600 dark:text-gray-300 dark:prose-invert max-w-none mt-6">
                                        {videoBlog.long_description
                                            ? parse(videoBlog.long_description)
                                            : videoBlog.short_description}
                                    </div>
                                </div>
                            </div>

                            {/* Sidebar / Related (Optional, but using full width related section below instead for cleaner layout on mobile) */}
                            {/* For now, let's keep it clean and put related videos below main content if not using sidebar */}
                        </div>
                    </div>
                </main>

                {/* Related Videos */}
                {relatedVideoBlogs && relatedVideoBlogs.length > 0 && (
                    <div className="border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                        <BlogSection videoBlogs={relatedVideoBlogs} />
                    </div>
                )}

                <Footer />
            </div>
        </>
    );
}
