import { Head, usePage } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import SectionHeader from "@/Components/ui/SectionHeader";

export default function AboutIndex({ content }) {
    return (
        <>
            <Head title="About Us - English Learning Platform" />
            <div className="min-h-screen bg-white dark:bg-gray-900">
                <Header />
                <main>
                    {/* Hero Section */}
                    <div className="relative isolate overflow-hidden bg-white dark:bg-gray-900">
                        <div className="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
                            <div className="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-primary-200 to-secondary-200 opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style={{ clipPath: 'polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)' }}></div>
                        </div>
                        
                        <div className="py-24 sm:py-32 lg:pb-40">
                            <Container>
                                <div className="mx-auto max-w-2xl text-center">
                                    <h1 className="text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">
                                        {content.page_title}
                                    </h1>
                                    <p className="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                                        {content.page_subtitle}
                                    </p>
                                </div>
                            </Container>
                        </div>
                        
                        <div className="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
                            <div className="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-primary-200 to-secondary-200 opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style={{ clipPath: 'polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)' }}></div>
                        </div>
                    </div>

                    {/* Content Section */}
                    <section className="relative py-16 sm:py-24 bg-white dark:bg-gray-900">
                        <Container>
                            <div className="mx-auto max-w-7xl px-6 lg:px-8">
                                <div className="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-2">
                                    <div className="lg:pr-8 lg:pt-4">
                                        <div className="lg:max-w-lg">
                                            <div className="prose prose-lg prose-primary dark:prose-invert max-w-none">
                                                <div dangerouslySetInnerHTML={{ __html: content.content }} />
                                            </div>
                                        </div>
                                    </div>
                                    <div className="relative">
                                         <div className="relative rounded-2xl bg-gray-50 dark:bg-gray-800 p-8 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:p-10">
                                            <h3 className="text-xl font-semibold leading-7 text-primary-600 dark:text-primary-400">
                                                {content.sidebar_title}
                                            </h3>
                                            <dl className="mt-4 space-y-6 text-base leading-7 text-gray-600 dark:text-gray-300">
                                                <div className="flex gap-x-3">
                                                    <svg className="h-6 w-5 flex-none text-primary-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clipRule="evenodd" />
                                                    </svg>
                                                    <div>
                                                        <dt className="inline font-semibold text-gray-900 dark:text-white">{content.sidebar_item_1_title}</dt>{' '}
                                                        <dd className="inline">{content.sidebar_item_1_text}</dd>
                                                    </div>
                                                </div>
                                                <div className="flex gap-x-3">
                                                    <svg className="h-6 w-5 flex-none text-primary-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                       <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clipRule="evenodd" />
                                                    </svg>
                                                    <div>
                                                        <dt className="inline font-semibold text-gray-900 dark:text-white">{content.sidebar_item_2_title}</dt>{' '}
                                                        <dd className="inline">{content.sidebar_item_2_text}</dd>
                                                    </div>
                                                </div>
                                                <div className="flex gap-x-3">
                                                    <svg className="h-6 w-5 flex-none text-primary-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clipRule="evenodd" />
                                                    </svg>
                                                    <div>
                                                        <dt className="inline font-semibold text-gray-900 dark:text-white">{content.sidebar_item_3_title}</dt>{' '}
                                                        <dd className="inline">{content.sidebar_item_3_text}</dd>
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

