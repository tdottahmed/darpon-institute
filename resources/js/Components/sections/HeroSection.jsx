import { useState } from "react";
import Button from "../ui/Button";
import Container from "../ui/Container";
import Badge from "../ui/Badge";
import { Link, router, usePage } from "@inertiajs/react";

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
        <section className="relative min-h-screen flex items-center justify-center overflow-hidden py-12 sm:py-20">
            {/* Full Width Background Image */}
            <div 
                className="absolute inset-0 z-0 select-none"
            >
                <img 
                    src={content.bg_image || "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1920&auto=format&fit=crop"} 
                    alt="Background" 
                    className="w-full h-full object-cover"
                />
                <div className="absolute inset-0 bg-gray-900/70"></div>
                {/* Optional Texture/Gradient Overlay */}
                <div className="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-gray-900/50"></div>
            </div>

            <Container className="relative z-10">
                <div className="max-w-4xl mx-auto text-center space-y-8 sm:space-y-10">
                    {/* Welcome Badge */}
                    <div className="flex justify-center animate-fade-in">
                        <Badge
                            variant="primary" // You might need to adjust Badge variant styles if they don't contrast well, but usually primary works.
                            className="bg-primary-500/20 text-primary-100 border-primary-400/30 backdrop-blur-md"
                        >
                            {content.welcome_badge || t.welcome || "Start Learning Today"}
                        </Badge>
                    </div>

                    {/* Main Heading */}
                    <h1 className="text-3xl sm:text-5xl lg:text-7xl font-bold text-white leading-tight animate-fade-in-up drop-shadow-lg">
                        <span className="block mb-2">{content.title_line_1 || "Master English"}</span>
                        <span className="text-primary-300">{content.title_line_2 || "From Anywhere"}</span>
                    </h1>

                    {/* Subheading */}
                    <p
                        className="text-base sm:text-xl text-gray-200 max-w-2xl mx-auto leading-relaxed animate-fade-in-up drop-shadow-md whitespace-pre-line"
                        style={{ animationDelay: "0.2s" }}
                    >
                        {content.description || "Interactive learning platform with modern methods, digital diplomas, and personalized study plans designed to help you achieve fluency faster."}
                    </p>

                    {/* Search Bar */}
                    <form
                        onSubmit={handleSearch}
                        className="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto animate-fade-in-up"
                        style={{ animationDelay: "0.4s" }}
                    >
                        <div className="flex-1 relative group">
                            <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg
                                    className="h-5 w-5 text-gray-400 group-focus-within:text-primary-500 transition-colors"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                            </div>
                            <input
                                type="text"
                                placeholder="Search courses..."
                                value={searchQuery}
                                onChange={(e) =>
                                    setSearchQuery(e.target.value)
                                }
                                className="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-white/10 bg-white/10 backdrop-blur-md text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all shadow-lg hover:bg-white/20 text-base"
                            />
                        </div>
                        <Button
                            type="submit"
                            size="lg"
                            variant="primary"
                            className="whitespace-nowrap shadow-lg hover:shadow-xl hover:scale-105 active:scale-95 transition-all w-full sm:w-auto"
                        >
                            Search
                        </Button>
                    </form>

                    {/* Stats */}
                    <div
                        className="grid grid-cols-2 md:grid-cols-4 gap-8 justify-center pt-8 border-t border-white/10 animate-fade-in-up"
                        style={{ animationDelay: "0.8s" }}
                    >
                        <div className="text-center">
                            <div className="text-3xl font-bold text-white drop-shadow">
                                {content.stat_1_value || "10K+"}
                            </div>
                            <div className="text-sm text-gray-300">
                                {content.stat_1_label || "Happy Students"}
                            </div>
                        </div>
                        <div className="text-center">
                            <div className="text-3xl font-bold text-white drop-shadow">
                                {content.stat_2_value || "500+"}
                            </div>
                            <div className="text-sm text-gray-300">
                                {content.stat_2_label || "Courses"}
                            </div>
                        </div>
                        <div className="text-center">
                            <div className="text-3xl font-bold text-white drop-shadow">
                                {content.stat_3_value || "4.9"}
                            </div>
                            <div className="text-sm text-gray-300">
                                {content.stat_3_label || "User Rating"}
                            </div>
                        </div>
                        <div className="text-center">
                            <div className="text-3xl font-bold text-white drop-shadow">
                                {content.stat_4_value || "98%"}
                            </div>
                            <div className="text-sm text-gray-300">
                                {content.stat_4_label || "Success Rate"}
                            </div>
                        </div>
                    </div>
                </div>
            </Container>

            {/* Scroll Indicator */}
            <div className="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                <div className="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
                    <div className="w-1 h-3 bg-white/50 rounded-full mt-2 animate-pulse"></div>
                </div>
            </div>
        </section>
    );
}
