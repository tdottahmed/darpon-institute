import Footer from "@/Components/layout/Footer";
import Header from "@/Components/layout/Header";
import BlogSection from "@/Components/sections/BlogSection";
import BookSection from "@/Components/sections/BookSection";
import CoursesSection from "@/Components/sections/CoursesSection";
import CTASection from "@/Components/sections/CTASection";
import GallerySection from "@/Components/sections/GallerySection";
import HeroSection from "@/Components/sections/HeroSection";
import InstructorSection from "@/Components/sections/InstructorSection";
import TeamSection from "@/Components/sections/TeamSection";
import TestimonialsSection from "@/Components/sections/TestimonialsSection";
import { Head, usePage } from "@inertiajs/react";


export default function Welcome({
    courses,
    books,
    videoBlogs,
    testimonials,
    galleries,
    teachers,
}) {
    const { translations } = usePage().props;

    return (
        <>
            <Head title="English Learning Platform" />
            <div className="min-h-screen bg-white dark:bg-gray-900">
                <Header />
                <main>
                    <HeroSection translations={translations} />
                    <InstructorSection />
                    <TeamSection teachers={teachers || []} />
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
