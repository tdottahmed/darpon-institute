import { useState } from "react";
import Button from "../ui/Button";
import Container from "../ui/Container";
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
        <section className="relative min-h-screen flex items-center justify-center overflow-hidden py-16 sm:py-24">
            {/* Full Width Background Image */}
            <div className="absolute inset-0 z-0 select-none">
                <img
                    src={
                        content.bg_image ||
                        "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1920&auto=format&fit=crop"
                    }
                    alt="Background"
                    className="w-full h-full object-cover"
                    loading="eager"
                />
                <div className="absolute inset-0 bg-gray-900/75"></div>
                <div className="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent"></div>
            </div>

            <Container className="relative z-10">
                <div className="max-w-5xl mx-auto text-center space-y-10 sm:space-y-12">
                    {/* Welcome Badge */}
                    <div className="flex justify-center animate-fade-in">
                        <Badge
                            variant="primary"
                            className="bg-primary-500/20 text-primary-100 border-primary-400/30 backdrop-blur-md px-4 py-2 text-sm font-semibold"
                        >
                            {content.welcome_badge ||
                                t.welcome ||
                                "Start Learning Today"}
                        </Badge>
                    </div>

                    {/* Main Heading */}
                    <h1 className="text-4xl sm:text-6xl lg:text-7xl xl:text-8xl font-bold text-white leading-tight animate-fade-in-up drop-shadow-2xl">
                        <span className="block mb-3">
                            {content.title_line_1 || "Master English"}
                        </span>
                        <span className="block text-primary-300 bg-gradient-to-r from-primary-300 to-primary-400 bg-clip-text text-transparent">
                            {content.title_line_2 || "From Anywhere"}
                        </span>
                    </h1>

                    {/* Subheading */}
                    <p
                        className="text-lg sm:text-xl lg:text-2xl text-gray-200 max-w-3xl mx-auto leading-relaxed animate-fade-in-up drop-shadow-lg"
                        style={{ animationDelay: "0.2s" }}
                    >
                        {content.description ||
                            "Interactive learning platform with modern methods, digital diplomas, and personalized study plans designed to help you achieve fluency faster."}
                    </p>

                    {/* Search Bar */}
                    <form
                        onSubmit={handleSearch}
                        className="flex flex-col sm:flex-row gap-4 max-w-2xl mx-auto animate-fade-in-up"
                        style={{ animationDelay: "0.4s" }}
                    >
                        <div className="flex-1 relative group">
                            <div className="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <svg
                                    className="h-6 w-6 text-gray-400 group-focus-within:text-primary-400 transition-colors duration-200"
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
                                onChange={(e) => setSearchQuery(e.target.value)}
                                className="w-full pl-14 pr-5 py-5 rounded-xl border-2 border-white/20 bg-white/10 backdrop-blur-md text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition-all duration-200 shadow-xl hover:bg-white/15 text-base sm:text-lg"
                            />
                        </div>
                        <Button
                            type="submit"
                            size="lg"
                            variant="primary"
                            className="whitespace-nowrap shadow-xl hover:shadow-2xl hover:scale-105 active:scale-95 transition-all duration-200 w-full sm:w-auto px-8 py-5 text-base sm:text-lg font-semibold"
                        >
                            Search
                        </Button>
                    </form>

                    {/* Stats */}
                    <div
                        className="grid grid-cols-2 md:grid-cols-4 gap-8 justify-center pt-12 border-t border-white/20 animate-fade-in-up"
                        style={{ animationDelay: "0.8s" }}
                    >
                        <div className="text-center">
                            <div className="text-4xl sm:text-5xl font-bold text-white drop-shadow-lg mb-2">
                                {content.stat_1_value || "10K+"}
                            </div>
                            <div className="text-sm sm:text-base text-gray-300 font-medium">
                                {content.stat_1_label || "Happy Students"}
                            </div>
                        </div>
                        <div className="text-center">
                            <div className="text-4xl sm:text-5xl font-bold text-white drop-shadow-lg mb-2">
                                {content.stat_2_value || "500+"}
                            </div>
                            <div className="text-sm sm:text-base text-gray-300 font-medium">
                                {content.stat_2_label || "Courses"}
                            </div>
                        </div>
                        <div className="text-center">
                            <div className="text-4xl sm:text-5xl font-bold text-white drop-shadow-lg mb-2">
                                {content.stat_3_value || "4.9"}
                            </div>
                            <div className="text-sm sm:text-base text-gray-300 font-medium">
                                {content.stat_3_label || "User Rating"}
                            </div>
                        </div>
                        <div className="text-center">
                            <div className="text-4xl sm:text-5xl font-bold text-white drop-shadow-lg mb-2">
                                {content.stat_4_value || "98%"}
                            </div>
                            <div className="text-sm sm:text-base text-gray-300 font-medium">
                                {content.stat_4_label || "Success Rate"}
                            </div>
                        </div>
                    </div>
                </div>
            </Container>

            {/* Scroll Indicator */}
            <div className="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce z-10">
                <div className="w-6 h-10 border-2 border-white/40 rounded-full flex justify-center backdrop-blur-sm">
                    <div className="w-1.5 h-3 bg-white/70 rounded-full mt-2 animate-pulse"></div>
                </div>
            </div>
        </section>
    );
}
