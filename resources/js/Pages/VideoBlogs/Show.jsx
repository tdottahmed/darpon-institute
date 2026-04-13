import { Head, Link } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import BlogSection from "@/Components/sections/BlogSection";
import parse from "html-react-parser";
import CTASection from "@/Components/sections/CTASection";

function stripHtml(html) {
    if (html == null || typeof html !== "string") return "";
    return html.replace(/<[^>]*>/g, "").trim();
}

export default function Show({ videoBlog, relatedVideoBlogs }) {
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

    const hasShort = stripHtml(videoBlog.short_description);
    const hasLong =
        videoBlog.long_description &&
        videoBlog.long_description.trim().length > 0;

    return (
        <>
            <Head title={`${stripHtml(videoBlog.title)} - Video Blogs`} />
            <div className="min-h-screen bg-gray-50 dark:bg-gray-950">
                <Header />

                <main className="py-8 sm:py-12">
                    <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        {/* Breadcrumbs */}
                        <nav className="mb-6 sm:mb-10" aria-label="Breadcrumb">
                            <ol className="flex flex-wrap items-center gap-x-2 gap-y-1 text-sm">
                                <li>
                                    <Link
                                        href={route("home")}
                                        className="text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400 transition-colors"
                                    >
                                        Home
                                    </Link>
                                </li>
                                <li
                                    className="text-gray-400 dark:text-gray-500"
                                    aria-hidden="true"
                                >
                                    /
                                </li>
                                <li>
                                    <Link
                                        href={route("video_blogs.index")}
                                        className="text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400 transition-colors"
                                    >
                                        Video Blogs
                                    </Link>
                                </li>
                                <li
                                    className="text-gray-400 dark:text-gray-500"
                                    aria-hidden="true"
                                >
                                    /
                                </li>
                                <li className="text-gray-900 dark:text-white font-medium truncate max-w-[12rem] sm:max-w-xs">
                                    {stripHtml(videoBlog.title)}
                                </li>
                            </ol>
                        </nav>

                        {/* Article card */}
                        <article className="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                            {/* Video */}
                            <div className="aspect-video w-full overflow-hidden bg-black">
                                {videoBlog.video_type === "youtube" &&
                                youtubeId ? (
                                    <iframe
                                        className="h-full w-full"
                                        src={`https://www.youtube.com/embed/${youtubeId}?rel=0&modestbranding=1`}
                                        title={stripHtml(videoBlog.title)}
                                        frameBorder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowFullScreen
                                    />
                                ) : videoBlog.video_type === "upload" &&
                                  videoBlog.video_file ? (
                                    <video
                                        controls
                                        className="h-full w-full"
                                        poster={
                                            videoBlog.thumbnail
                                                ? `/storage/${videoBlog.thumbnail}`
                                                : undefined
                                        }
                                    >
                                        <source
                                            src={`/storage/${videoBlog.video_file}`}
                                            type="video/mp4"
                                        />
                                        Your browser does not support the video
                                        tag.
                                    </video>
                                ) : (
                                    <div className="flex h-full w-full items-center justify-center bg-gray-800 text-gray-300">
                                        Video content unavailable
                                    </div>
                                )}
                            </div>

                            <div className="p-6 sm:p-8 md:p-10">
                                {/* Meta */}
                                <div className="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    <time dateTime={videoBlog.created_at}>
                                        {new Date(
                                            videoBlog.created_at,
                                        ).toLocaleDateString(undefined, {
                                            year: "numeric",
                                            month: "long",
                                            day: "numeric",
                                        })}
                                    </time>
                                    {videoBlog.tags &&
                                        videoBlog.tags.length > 0 && (
                                            <>
                                                <span
                                                    className="text-gray-300 dark:text-gray-600"
                                                    aria-hidden
                                                >
                                                    ·
                                                </span>
                                                <div className="flex flex-wrap gap-2">
                                                    {videoBlog.tags.map(
                                                        (tag, i) => (
                                                            <span
                                                                key={i}
                                                                className="rounded-full bg-primary-50 px-2.5 py-0.5 text-xs font-medium text-primary-700 dark:bg-primary-900/40 dark:text-primary-300"
                                                            >
                                                                {tag}
                                                            </span>
                                                        ),
                                                    )}
                                                </div>
                                            </>
                                        )}
                                </div>

                                <h1 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-3xl md:text-4xl leading-tight">
                                    {stripHtml(videoBlog.title)}
                                </h1>

                                {/* Short description (lead) */}
                                {hasShort && (
                                    <p className="mt-5 text-lg text-gray-600 dark:text-gray-300 leading-relaxed border-b border-gray-100 dark:border-gray-800 pb-6">
                                        {stripHtml(videoBlog.short_description)}
                                    </p>
                                )}

                                {/* Long description (full content) */}
                                {hasLong && (
                                    <div className="prose prose-lg text-gray-600 dark:text-gray-300 dark:prose-invert max-w-none mt-6 prose-headings:font-semibold prose-a:text-primary-600 dark:prose-a:text-primary-400">
                                        {parse(videoBlog.long_description)}
                                    </div>
                                )}

                                {!hasShort && !hasLong && (
                                    <p className="mt-4 text-gray-500 dark:text-gray-400 italic">
                                        No description available.
                                    </p>
                                )}
                            </div>
                        </article>
                    </div>
                </main>

                {/* Related Videos */}
                {relatedVideoBlogs && relatedVideoBlogs.length > 0 && (
                    <section className="border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 py-12 sm:py-16">
                        <BlogSection videoBlogs={relatedVideoBlogs} />
                    </section>
                )}
                <CTASection />

                <Footer />
            </div>
        </>
    );
}
