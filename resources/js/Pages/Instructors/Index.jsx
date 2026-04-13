import { Head, Link, useForm } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import SectionBackground from "@/Components/ui/SectionBackground";
import TeacherCard from "@/Components/cards/TeacherCard";
import CTASection from "@/Components/sections/CTASection";

export default function InstructorIndex({ instructors, filters }) {
    const { data, setData, get } = useForm({
        search: filters.search || "",
    });

    const handleSearch = (e) => {
        e.preventDefault();
        get(route("instructors.index"), {
            preserveState: true,
            preserveScroll: true,
        });
    };

    return (
        <>
            <Head title="Instructors" />
            <div className="min-h-screen bg-white dark:bg-gray-900 flex flex-col">
                <Header />
                <main className="flex-grow">
                    {/* Hero Section */}
                    <section className="relative overflow-hidden py-12 sm:py-8 lg:py-12">
                        <SectionBackground variant="b" />
                        <Container className="relative z-10">
                            <div className="mx-auto max-w-2xl text-center">
                                <h1 className="text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">
                                    Our Instructors
                                </h1>
                                <p className="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                                    Meet our expert instructors dedicated to your success.
                                </p>
                            </div>

                            {/* Search Form */}
                            <div className="mt-10 mx-auto max-w-xl">
                                <form onSubmit={handleSearch} className="flex gap-2">
                                    <input
                                        type="text"
                                        value={data.search}
                                        onChange={(e) => setData("search", e.target.value)}
                                        placeholder="Search instructors by name, designation, or department..."
                                        className="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400"
                                    />
                                    <button
                                        type="submit"
                                        className="rounded-lg bg-primary-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 transition-all duration-200"
                                    >
                                        Search
                                    </button>
                                </form>
                            </div>
                        </Container>
                    </section>

                    {/* Instructors Section */}
                    <section className="py-16 sm:py-24">
                        <Container>
                            {instructors.data && instructors.data.length > 0 ? (
                                <>
                                    <div className="grid grid-cols-1 gap-6 sm:gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                                        {instructors.data.map((teacher, index) => (
                                            <Link href={route("instructors.show", teacher.id)} key={teacher.id}>
                                                <div className="transition-all duration-300 hover:-translate-y-1 h-full">
                                                    <TeacherCard teacher={teacher} />
                                                </div>
                                            </Link>
                                        ))}
                                    </div>

                                    {/* Pagination */}
                                    {instructors.links && instructors.links.length > 3 && (
                                        <div className="mt-12 flex justify-center">
                                            <div className="flex gap-2">
                                                {instructors.links.map((link, index) => (
                                                    <Link
                                                        key={index}
                                                        href={link.url || "#"}
                                                        className={`px-4 py-2 rounded-lg text-sm font-medium transition-colors ${
                                                            link.active
                                                                ? "bg-primary-600 text-white"
                                                                : "bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                                        } ${!link.url ? "opacity-50 cursor-not-allowed" : ""}`}
                                                        dangerouslySetInnerHTML={{ __html: link.label }}
                                                    />
                                                ))}
                                            </div>
                                        </div>
                                    )}
                                </>
                            ) : (
                                <div className="text-center py-16">
                                    <div className="inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary-100 dark:bg-primary-900/30 mb-6">
                                        <svg
                                            className="w-10 h-10 text-primary-600 dark:text-primary-400"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                strokeWidth={2}
                                                d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z"
                                            />
                                        </svg>
                                    </div>
                                    <h3 className="text-2xl font-bold text-gray-900 dark:text-white mb-3">
                                        No instructors found
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-400">
                                        Try adjusting your search query.
                                    </p>
                                    {data.search && (
                                        <button
                                            onClick={() => {
                                                setData("search", "");
                                                get(route("instructors.index"));
                                            }}
                                            className="mt-6 text-primary-600 hover:text-primary-700 font-semibold"
                                        >
                                            Clear Search
                                        </button>
                                    )}
                                </div>
                            )}
                        </Container>
                    </section>
                </main>
                <CTASection />
                <Footer />
            </div>
        </>
    );
}
