import { Head, usePage } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import SectionHeader from "@/Components/ui/SectionHeader";
import SectionBackground from "@/Components/ui/SectionBackground";

export default function AboutIndex({ content }) {
    return (
        <>
            <Head title="About Us - English Learning Platform" />
            <div className="min-h-screen bg-white dark:bg-gray-900">
                <Header />
                <main>
                    {/* Hero Section (matches home section background) */}
                    <section className="relative overflow-hidden py-12 sm:py-8 lg:py-12 bg-gradient-to-br from-primary-600 via-primary-700 to-secondary-600 dark:from-primary-800 dark:via-primary-900 dark:to-secondary-800">
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

                        <Container className="relative z-10">
                            <div className="mx-auto max-w-2xl text-center text-white">
                                <h1 className="text-4xl font-bold tracking-tight text-white sm:text-6xl">
                                    About Us
                                </h1>
                                <p className="mt-6 text-lg leading-8 text-white/90">
                                    Learn more about our mission and values
                                </p>
                            </div>
                        </Container>
                    </section>

                    {/* Content Section */}
                    <section className="relative py-16 sm:py-24 bg-white dark:bg-gray-900">
                        <Container>
                            <div className="mx-auto max-w-7xl px-6 lg:px-8">
                                <div className="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-2">
                                    <div className="lg:pr-8 lg:pt-4">
                                        <div className="lg:max-w-lg">
                                            <div className="prose prose-lg prose-primary dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 prose-headings:text-gray-900 dark:prose-headings:text-white prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-strong:text-gray-900 dark:prose-strong:text-white prose-a:text-primary-600 dark:prose-a:text-primary-400 prose-li:text-gray-700 dark:prose-li:text-gray-300 prose-ul:text-gray-700 dark:prose-ul:text-gray-300 prose-ol:text-gray-700 dark:prose-ol:text-gray-300 prose-blockquote:text-gray-700 dark:prose-blockquote:text-gray-300 prose-code:text-gray-900 dark:prose-code:text-gray-100 prose-pre:text-gray-100 dark:prose-pre:text-gray-100">
                                                <div
                                                    className="text-gray-700 dark:text-gray-300 [&>h1]:text-gray-900 dark:[&>h1]:text-white [&>h2]:text-gray-900 dark:[&>h2]:text-white [&>h3]:text-gray-900 dark:[&>h3]:text-white [&>h4]:text-gray-900 dark:[&>h4]:text-white [&>h5]:text-gray-900 dark:[&>h5]:text-white [&>h6]:text-gray-900 dark:[&>h6]:text-white [&>p]:text-gray-700 dark:[&>p]:text-gray-300 [&>strong]:text-gray-900 dark:[&>strong]:text-white [&>b]:text-gray-900 dark:[&>b]:text-white [&>li]:text-gray-700 dark:[&>li]:text-gray-300 [&>span]:text-gray-700 dark:[&>span]:text-gray-300 [&>div]:text-gray-700 dark:[&>div]:text-gray-300"
                                                    dangerouslySetInnerHTML={{
                                                        __html: content.content,
                                                    }}
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div className="relative">
                                        <div className="relative rounded-2xl bg-gray-50 dark:bg-gray-800 p-8 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:p-10">
                                            <h3 className="text-xl font-semibold leading-7 text-primary-600 dark:text-primary-400">
                                                {content.sidebar_title}
                                            </h3>
                                            <dl className="mt-4 space-y-6 text-base leading-7">
                                                <div className="flex gap-x-3">
                                                    <svg
                                                        className="h-6 w-5 flex-none text-primary-600 dark:text-primary-400"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                        aria-hidden="true"
                                                    >
                                                        <path
                                                            fillRule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                            clipRule="evenodd"
                                                        />
                                                    </svg>
                                                    <div className="text-gray-600 dark:text-gray-300">
                                                        <dt className="inline font-semibold text-gray-900 dark:text-white">
                                                            {
                                                                content.sidebar_item_1_title
                                                            }
                                                        </dt>{" "}
                                                        <dd className="inline text-gray-600 dark:text-gray-300">
                                                            {
                                                                content.sidebar_item_1_text
                                                            }
                                                        </dd>
                                                    </div>
                                                </div>
                                                <div className="flex gap-x-3">
                                                    <svg
                                                        className="h-6 w-5 flex-none text-primary-600 dark:text-primary-400"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                        aria-hidden="true"
                                                    >
                                                        <path
                                                            fillRule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                            clipRule="evenodd"
                                                        />
                                                    </svg>
                                                    <div className="text-gray-600 dark:text-gray-300">
                                                        <dt className="inline font-semibold text-gray-900 dark:text-white">
                                                            {
                                                                content.sidebar_item_2_title
                                                            }
                                                        </dt>{" "}
                                                        <dd className="inline text-gray-600 dark:text-gray-300">
                                                            {
                                                                content.sidebar_item_2_text
                                                            }
                                                        </dd>
                                                    </div>
                                                </div>
                                                <div className="flex gap-x-3">
                                                    <svg
                                                        className="h-6 w-5 flex-none text-primary-600 dark:text-primary-400"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                        aria-hidden="true"
                                                    >
                                                        <path
                                                            fillRule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                            clipRule="evenodd"
                                                        />
                                                    </svg>
                                                    <div className="text-gray-600 dark:text-gray-300">
                                                        <dt className="inline font-semibold text-gray-900 dark:text-white">
                                                            {
                                                                content.sidebar_item_3_title
                                                            }
                                                        </dt>{" "}
                                                        <dd className="inline text-gray-600 dark:text-gray-300">
                                                            {
                                                                content.sidebar_item_3_text
                                                            }
                                                        </dd>
                                                    </div>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </Container>
                    </section>
                </main>
                <Footer />
            </div>
        </>
    );
}
