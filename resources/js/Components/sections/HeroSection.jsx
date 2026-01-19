import { useState } from "react";
import Button from "../ui/Button";
import Badge from "../ui/Badge";
import { router, usePage } from "@inertiajs/react";

export default function HeroSection({ translations }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.hero || {};

    const t = translations?.common || {};
    const [searchQuery, setSearchQuery] = useState("");

    const handleSearch = (e) => {
        e.preventDefault();
        if (searchQuery.trim()) {
            router.visit(
                `/courses?search=${encodeURIComponent(searchQuery.trim())}`
            );
        }
    };

    return (
        <section className="relative min-h-[85vh] overflow-hidden py-12 sm:py-16 md:py-20">
            {/* Full Width Background Image */}
            <div className="absolute inset-0 z-0 select-none">
                <img
                    src={
                        content.bg_image ||
                        "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1920&auto=format&fit=crop"
                    }
                    alt="Background"
                    className="w-full h-full object-cover scale-105 transition-transform duration-700 ease-out"
                    loading="eager"
                />
                {/* Enhanced Overlay with Gradient - Lighter */}
                <div className="absolute inset-0 bg-gradient-to-b from-gray-900/40 via-gray-900/35 to-gray-900/45"></div>
                <div className="absolute inset-0 bg-gradient-to-t from-gray-900/50 via-gray-900/30 to-transparent"></div>
                {/* Accent Gradient Overlay */}
                <div className="absolute inset-0 bg-gradient-to-br from-primary-600/15 via-transparent to-secondary-600/15"></div>
            </div>

            <div className="relative z-10 min-h-[85vh] flex items-center">
                <div className="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {/* Main Heading - Enhanced Typography */}
                    {(content.title_line_1 || content.title_line_2) && (
                        <h1 className="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight tracking-tight animate-fade-in-up drop-shadow-2xl text-left">
                            {content.title_line_1 && (
                                <span className="block mb-2 sm:mb-3 bg-gradient-to-r from-white via-gray-100 to-white bg-clip-text text-transparent">
                                    {content.title_line_1}
                                </span>
                            )}
                            {content.title_line_2 && (
                                <span className="block bg-gradient-to-r from-white via-gray-100 to-white bg-clip-text text-transparent">
                                    {content.title_line_2}
                                </span>
                            )}
                        </h1>
                    )}
                </div>
            </div>

            {/* Enhanced Scroll Indicator */}
            <div className="absolute bottom-6 left-1/2 transform -translate-x-1/2 animate-bounce z-10">
                <div className="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center backdrop-blur-md bg-white/10 shadow-lg">
                    <div className="w-1.5 h-3 bg-gradient-to-b from-primary-400 to-primary-500 rounded-full mt-2 animate-pulse"></div>
                </div>
            </div>
        </section>
    );
}
