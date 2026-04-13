import { Head } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import SectionBackground from "@/Components/ui/SectionBackground";
import CTASection from "@/Components/sections/CTASection";

export default function InstructorShow({ instructor }) {
    return (
        <>
            <Head title={`${instructor.name} - Instructor`} />
            <div className="min-h-screen bg-white dark:bg-gray-900 flex flex-col">
                <Header />
                <main className="flex-grow">
                    <section className="relative overflow-hidden py-16 sm:py-24">
                        <SectionBackground variant="a" />
                        <Container className="relative z-10">
                            <div className="max-w-4xl mx-auto">
                                <div className="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden">
                                    <div className="md:flex">
                                        <div className="md:flex-shrink-0 md:w-1/3">
                                            <div className="h-64 md:h-full relative overflow-hidden bg-gray-100 dark:bg-gray-700">
                                                {instructor.image_path ? (
                                                    <img
                                                        src={`/storage/${instructor.image_path}`}
                                                        alt={instructor.name}
                                                        className="w-full h-full object-cover"
                                                    />
                                                ) : (
                                                    <div className="w-full h-full flex items-center justify-center bg-primary-50 dark:bg-primary-900/20 text-primary-300 dark:text-primary-700">
                                                        <svg
                                                            className="w-32 h-32"
                                                            fill="currentColor"
                                                            viewBox="0 0 24 24"
                                                        >
                                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                        </svg>
                                                    </div>
                                                )}
                                            </div>
                                        </div>
                                        <div className="p-8 md:p-12 md:w-2/3 flex flex-col justify-center">
                                            <div className="uppercase tracking-wide text-sm text-primary-600 dark:text-primary-400 font-semibold mb-1">
                                                {instructor.department || "Instructor"}
                                            </div>
                                            <h1 className="mt-1 text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white leading-tight">
                                                {instructor.name}
                                            </h1>
                                            <p className="mt-3 text-xl text-gray-500 dark:text-gray-400 font-medium">
                                                {instructor.designation}
                                            </p>
                                            
                                            <div className="mt-8 border-t border-gray-100 dark:border-gray-700 pt-8">
                                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                                    About {instructor.name}
                                                </h3>
                                                <p className="text-gray-600 dark:text-gray-300 leading-relaxed">
                                                    {instructor.name} is a dedicated {instructor.designation} in the {instructor.department} department. They are passionate about teaching and committed to helping students achieve their educational goals.
                                                </p>
                                                {/* In the future, if you add a bio to the teacher model, you can render it here instead of the default text. */}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </Container>
                    </section>
                </main>
                <CTASection />
                <Footer />
            </div>
        </>
    );
}
