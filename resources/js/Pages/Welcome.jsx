import { Head, usePage } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import HeroSection from "@/Components/sections/HeroSection";
import FeaturesSection from "@/Components/sections/FeaturesSection";
import ExperienceSection from "@/Components/sections/ExperienceSection";
import DataSection from "@/Components/sections/DataSection";
import TestimonialsSection from "@/Components/sections/TestimonialsSection";
import BlogSection from "@/Components/sections/BlogSection";
import CTASection from "@/Components/sections/CTASection";

export default function Welcome() {
    const { translations } = usePage().props;

    return (
        <>
            <Head title="English Learning Platform" />
            <div className="min-h-screen bg-white dark:bg-gray-900">
                <Header />
                <main>
                    <HeroSection translations={translations} />
                    <div id="features">
                        <FeaturesSection />
                    </div>
                    <ExperienceSection />
                    <DataSection />
                    <div id="testimonials">
                        <TestimonialsSection />
                    </div>
                    <div id="blog">
                        <BlogSection />
                    </div>
                    <CTASection translations={translations} />
                </main>
                <Footer />
            </div>
        </>
    );
}
