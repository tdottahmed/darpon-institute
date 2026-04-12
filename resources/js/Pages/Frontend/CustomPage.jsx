import Footer from "@/Components/layout/Footer";
import Header from "@/Components/layout/Header";
import { Head } from "@inertiajs/react";

export default function CustomPage({ page }) {
    return (
        <>
            <Head>
                <title>{page.meta_title ? page.meta_title : page.title}</title>
                {page.meta_description && (
                    <meta name="description" content={page.meta_description} />
                )}
            </Head>
            
            <div className="min-h-screen bg-white dark:bg-gray-900 flex flex-col">
                <Header />
                <main className="flex-1 bg-gray-50 pt-24 pb-16 dark:bg-gray-900">
                    <div className="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                        <div className="bg-white p-8 shadow rounded-2xl dark:bg-gray-800">
                            <h1 className="text-3xl font-bold mb-6 text-gray-900 dark:text-white border-b pb-4">
                                {page.title}
                            </h1>
                            <div 
                                className="prose prose-blue max-w-none dark:prose-invert"
                                dangerouslySetInnerHTML={{ __html: page.content }}
                            />
                        </div>
                    </div>
                </main>
                <Footer />
            </div>
        </>
    );
}
