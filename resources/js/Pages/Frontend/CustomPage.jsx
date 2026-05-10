import Footer from "@/Components/layout/Footer";
import Header from "@/Components/layout/Header";
import CTASection from "@/Components/sections/CTASection";

export default function CustomPage({ page }) {
    return (
        <>
            <div className="min-h-screen bg-white dark:bg-gray-900 flex flex-col">
                <Header />
                <main className="flex-1 bg-gray-50 pt-24 pb-16 dark:bg-gray-900">
                    <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
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
                <CTASection />
                <Footer />
            </div>
        </>
    );
}
