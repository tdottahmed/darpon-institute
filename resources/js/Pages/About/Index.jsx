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
                    <section className="relative overflow-hidden py-20 sm:py-28 lg:py-32">
                        <SectionBackground variant="a" />
                        <Container className="relative z-10">
                            <div className="mx-auto max-w-2xl text-center">
                                <h1 className="text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">
                                    {content.page_title}
                                </h1>
                                <p className="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                                    {content.page_subtitle}
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
                                                    dangerouslySetInnerHTML={{ __html: content.content }} 
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
                                                    <svg className="h-6 w-5 flex-none text-primary-600 dark:text-primary-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clipRule="evenodd" />
                                                    </svg>
                                                    <div className="text-gray-600 dark:text-gray-300">
                                                        <dt className="inline font-semibold text-gray-900 dark:text-white">{content.sidebar_item_1_title}</dt>{' '}
                                                        <dd className="inline text-gray-600 dark:text-gray-300">{content.sidebar_item_1_text}</dd>
                                                    </div>
                                                </div>
                                                <div className="flex gap-x-3">
                                                    <svg className="h-6 w-5 flex-none text-primary-600 dark:text-primary-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                       <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clipRule="evenodd" />
                                                    </svg>
                                                    <div className="text-gray-600 dark:text-gray-300">
                                                        <dt className="inline font-semibold text-gray-900 dark:text-white">{content.sidebar_item_2_title}</dt>{' '}
                                                        <dd className="inline text-gray-600 dark:text-gray-300">{content.sidebar_item_2_text}</dd>
                                                    </div>
                                                </div>
                                                <div className="flex gap-x-3">
                                                    <svg className="h-6 w-5 flex-none text-primary-600 dark:text-primary-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clipRule="evenodd" />
                                                    </svg>
                                                    <div className="text-gray-600 dark:text-gray-300">
                                                        <dt className="inline font-semibold text-gray-900 dark:text-white">{content.sidebar_item_3_title}</dt>{' '}
                                                        <dd className="inline text-gray-600 dark:text-gray-300">{content.sidebar_item_3_text}</dd>
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

