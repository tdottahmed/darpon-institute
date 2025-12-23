import { Head, usePage } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import HeroSection from "@/Components/sections/HeroSection";
import FeaturesSection from "@/Components/sections/FeaturesSection";
import CoursesSection from "@/Components/sections/CoursesSection";
import BookSection from "@/Components/sections/BookSection";
import TestimonialsSection from "@/Components/sections/TestimonialsSection";
import BlogSection from "@/Components/sections/BlogSection";
import GallerySection from "@/Components/sections/GallerySection";
import CTASection from "@/Components/sections/CTASection";

// Imports removed

// Imports removed

export default function Welcome({
    courses,
    books,
    videoBlogs,
    testimonials,
    galleries,
}) {
    const { translations } = usePage().props;

    return (
        <>
            <Head title="English Learning Platform" />
            <div className="min-h-screen bg-white dark:bg-gray-900">
                <Header />
                <main>
                    <HeroSection translations={translations} />
                    <FeaturesSection />
                    <CoursesSection courses={courses || []} />
                    <BookSection books={books || []} />
                    <GallerySection galleries={galleries || []} />
                    <TestimonialsSection testimonials={testimonials || []} />
                    <BlogSection videoBlogs={videoBlogs || []} />
                    <CTASection translations={translations} />
                </main>
                <Footer />
            </div>
        </>
    );
}
