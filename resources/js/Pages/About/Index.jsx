import { Head, usePage } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import SectionHeader from "@/Components/ui/SectionHeader";

export default function AboutIndex() {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.about || {};

    return (
        <>
            <Head title="About Us - English Learning Platform" />
            <div className="min-h-screen bg-white dark:bg-gray-900">
                <Header />
                <main>
                    {/* Hero Section */}
                    <section className="bg-gradient-to-br from-primary-50 to-secondary-50 dark:from-gray-800 dark:to-gray-900 py-16 sm:py-20">
                        <Container>
                            <div className="text-center max-w-3xl mx-auto">
                                <h1 className="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-4">
                                    {content.page_title || "About Us"}
                                </h1>
                                <p className="text-lg sm:text-xl text-gray-600 dark:text-gray-300">
                                    {content.page_subtitle ||
                                        "Learn more about our mission, vision, and commitment to English education"}
                                </p>
                            </div>
                        </Container>
                    </section>

                    {/* Content Section */}
                    <section className="py-16 sm:py-24">
                        <Container>
                            <div className="max-w-4xl mx-auto prose prose-lg dark:prose-invert">
                                <div className="text-gray-700 dark:text-gray-300 space-y-6">
                                    {content.content ? (
                                        <div
                                            dangerouslySetInnerHTML={{
                                                __html: content.content,
                                            }}
                                        />
                                    ) : (
                                        <>
                                            <h2 className="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                                Our Mission
                                            </h2>
                                            <p className="text-lg leading-relaxed">
                                                We are dedicated to providing
                                                accessible, high-quality English
                                                education to students around the
                                                world. Our mission is to empower
                                                learners with the skills and
                                                confidence they need to succeed
                                                in their personal and
                                                professional lives.
                                            </p>

                                            <h2 className="text-3xl font-bold text-gray-900 dark:text-white mb-4 mt-12">
                                                Our Vision
                                            </h2>
                                            <p className="text-lg leading-relaxed">
                                                To become a leading platform for
                                                English language learning,
                                                recognized for innovation,
                                                quality, and student success. We
                                                envision a world where language
                                                barriers no longer limit
                                                opportunities.
                                            </p>

                                            <h2 className="text-3xl font-bold text-gray-900 dark:text-white mb-4 mt-12">
                                                Why Choose Us
                                            </h2>
                                            <ul className="list-disc list-inside space-y-3 text-lg">
                                                <li>
                                                    Interactive and engaging
                                                    learning methods
                                                </li>
                                                <li>
                                                    Experienced and qualified
                                                    instructors
                                                </li>
                                                <li>
                                                    Flexible learning schedules
                                                </li>
                                                <li>
                                                    Comprehensive course
                                                    materials
                                                </li>
                                                <li>
                                                    Personalized learning paths
                                                </li>
                                                <li>
                                                    Digital certificates upon
                                                    completion
                                                </li>
                                            </ul>
                                        </>
                                    )}
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
