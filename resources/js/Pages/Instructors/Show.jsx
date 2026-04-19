import { Head, Link } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import CTASection from "@/Components/sections/CTASection";

export default function InstructorShow({ instructor }) {
    return (
        <>
            <Head title={`${instructor.name} - Instructor`} />
            <div className="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col">
                <Header />
                <main className="flex-grow">

                    {/* Breadcrumb */}
                    <div className="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                        <Container className="py-3">
                            <nav className="flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 flex-wrap">
                                <Link href="/" className="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                    Home
                                </Link>
                                <ChevronIcon />
                                <Link href="/instructors" className="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                    Instructors
                                </Link>
                                <ChevronIcon />
                                <span className="text-gray-900 dark:text-gray-100 font-medium truncate max-w-[200px] sm:max-w-none">
                                    {instructor.name}
                                </span>
                            </nav>
                        </Container>
                    </div>

                    {/* Profile */}
                    <section className="py-10 sm:py-14 lg:py-20">
                        <Container>
                            <div className="max-w-5xl mx-auto">
                                <div className="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl shadow-xl overflow-hidden">

                                    {/* Top accent */}
                                    <div className="h-1.5 bg-gradient-to-r from-primary-500 to-primary-700" />

                                    <div className="lg:grid lg:grid-cols-[300px_1fr] xl:grid-cols-[340px_1fr]">

                                        {/* Image */}
                                        <div className="relative bg-gray-100 dark:bg-gray-700 lg:min-h-[460px]">
                                            {instructor.image_path ? (
                                                <img
                                                    src={`/storage/${instructor.image_path}`}
                                                    alt={instructor.name}
                                                    className="w-full h-auto lg:absolute lg:inset-0 lg:h-full lg:object-cover lg:object-top"
                                                />
                                            ) : (
                                                <div className="min-h-48 lg:absolute lg:inset-0 flex items-center justify-center bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/20">
                                                    <svg
                                                        className="w-28 h-28 text-primary-200 dark:text-primary-700"
                                                        fill="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                </div>
                                            )}
                                        </div>

                                        {/* Info */}
                                        <div className="p-6 sm:p-8 lg:p-10 xl:p-12 flex flex-col">

                                            {/* Department badge */}
                                            {instructor.department && (
                                                <span className="inline-flex self-start items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 border border-primary-100 dark:border-primary-800 mb-4">
                                                    <svg className="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fillRule="evenodd" clipRule="evenodd" d="M10.496 2.132a1 1 0 00-.992 0l-7 4A1 1 0 003 8v7a1 1 0 100 2h14a1 1 0 100-2V8a1 1 0 00.496-.868l-7-4zM6 9a1 1 0 000 2h8a1 1 0 100-2H6z" />
                                                    </svg>
                                                    {instructor.department}
                                                </span>
                                            )}

                                            {/* Name */}
                                            <h1 className="text-2xl sm:text-3xl xl:text-4xl font-bold text-gray-900 dark:text-white leading-tight">
                                                {instructor.name}
                                            </h1>

                                            {/* Designation */}
                                            {instructor.designation && (
                                                <p className="mt-2 text-base sm:text-lg text-primary-600 dark:text-primary-400 font-medium">
                                                    {instructor.designation}
                                                </p>
                                            )}

                                            <div className="my-6 border-t border-gray-100 dark:border-gray-700" />

                                            {/* About */}
                                            <div className="flex-1">
                                                <h2 className="flex items-center gap-2 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">
                                                    <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    About
                                                </h2>
                                                <p className="text-gray-600 dark:text-gray-400 leading-relaxed text-sm sm:text-base">
                                                    <span className="font-semibold text-gray-800 dark:text-gray-200">
                                                        {instructor.name}
                                                    </span>{" "}
                                                    is a dedicated{" "}
                                                    {instructor.designation && (
                                                        <span>{instructor.designation.toLowerCase()}</span>
                                                    )}
                                                    {instructor.department && (
                                                        <>
                                                            {" "}in the{" "}
                                                            <span className="font-medium text-gray-700 dark:text-gray-300">
                                                                {instructor.department}
                                                            </span>{" "}
                                                            department
                                                        </>
                                                    )}
                                                    . They are passionate about teaching and committed to
                                                    helping students achieve their educational goals.
                                                </p>
                                            </div>

                                            {/* Back */}
                                            <div className="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                                                <Link
                                                    href="/instructors"
                                                    className="inline-flex items-center gap-2 text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors"
                                                >
                                                    <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                                                    </svg>
                                                    View all instructors
                                                </Link>
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

function ChevronIcon() {
    return (
        <svg className="w-3.5 h-3.5 flex-shrink-0 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
        </svg>
    );
}
