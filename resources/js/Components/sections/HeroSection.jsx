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
        <section className="relative min-h-[85vh] flex items-center justify-center overflow-hidden py-12 sm:py-16 md:py-20">
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
                {/* Enhanced Overlay with Gradient */}
                <div className="absolute inset-0 bg-gradient-to-b from-gray-900/85 via-gray-900/80 to-gray-900/90"></div>
                <div className="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>
                {/* Accent Gradient Overlay */}
                <div className="absolute inset-0 bg-gradient-to-br from-primary-600/20 via-transparent to-secondary-600/20"></div>
            </div>

            <Container className="relative z-10">
                <div className="max-w-5xl mx-auto text-center space-y-6 sm:space-y-8 md:space-y-10">
                    {/* Welcome Badge - Enhanced */}
                    <div className="flex justify-center animate-fade-in">
                        <Badge
                            variant="primary"
                            className="bg-gradient-to-r from-primary-500/30 via-primary-400/30 to-secondary-500/30 text-primary-100 border-primary-300/40 backdrop-blur-lg px-4 py-1.5 text-xs sm:text-sm font-semibold shadow-lg shadow-primary-500/20 hover:scale-105 transition-transform duration-300"
                        >
                            <span className="flex items-center gap-1.5">
                                {content.welcome_badge ||
                                    t.welcome ||
                                    "Start Learning Today"}
                            </span>
                        </Badge>
                    </div>

                    {/* Main Heading - Enhanced Typography */}
                    <h1 className="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight tracking-tight animate-fade-in-up drop-shadow-2xl">
                        <span className="block mb-2 sm:mb-3 bg-gradient-to-r from-white via-gray-100 to-white bg-clip-text text-transparent">
                            {content.title_line_1 || "Master English"}
                        </span>
                        <span className="block bg-gradient-to-r from-primary-300 via-primary-400 to-secondary-400 bg-clip-text text-transparent">
                            {content.title_line_2 || "From Anywhere"}
                        </span>
                    </h1>

                    {/* Enhanced Description */}
                    <div
                        className="max-w-3xl mx-auto animate-fade-in-up"
                        style={{ animationDelay: "0.2s" }}
                    >
                        <p className="text-base sm:text-lg text-gray-200 font-normal leading-relaxed drop-shadow-lg">
                            {content.description ||
                                "Interactive learning platform with modern methods, digital diplomas, and personalized study plans designed to help you achieve fluency faster."}
                        </p>
                    </div>

                    {/* Enhanced Search Bar */}
                    <form
                        onSubmit={handleSearch}
                        className="flex flex-col sm:flex-row gap-3 max-w-2xl mx-auto animate-fade-in-up"
                        style={{ animationDelay: "0.4s" }}
                    >
                        <div className="flex-1 relative group">
                            <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg
                                    className="h-5 w-5 text-gray-400 group-focus-within:text-primary-400 transition-colors duration-300"
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
                                className="w-full pl-12 pr-4 py-3.5 rounded-xl border-2 border-white/30 bg-white/15 backdrop-blur-xl text-white placeholder-gray-300/80 focus:outline-none focus:ring-2 focus:ring-primary-400/50 focus:border-primary-400 transition-all duration-300 shadow-xl hover:bg-white/20 hover:border-white/40 text-sm sm:text-base font-medium"
                            />
                        </div>
                        <Button
                            type="submit"
                            size="lg"
                            variant="primary"
                            className="whitespace-nowrap shadow-xl hover:shadow-primary-500/50 hover:scale-105 active:scale-95 transition-all duration-300 w-full sm:w-auto px-6 py-3.5 text-sm sm:text-base font-semibold bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400"
                        >
                            <span className="flex items-center gap-1.5">
                                Search
                                <svg
                                    className="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                            </span>
                        </Button>
                    </form>

                    {/* Enhanced Stats */}
                    <div
                        className="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 lg:gap-8 justify-center pt-10 md:pt-12 border-t border-white/30 animate-fade-in-up"
                        style={{ animationDelay: "0.8s" }}
                    >
                        {[
                            {
                                value: content.stat_1_value || "10K+",
                                label: content.stat_1_label || "Happy Students",
                            },
                            {
                                value: content.stat_2_value || "500+",
                                label: content.stat_2_label || "Courses",
                            },
                            {
                                value: content.stat_3_value || "4.9",
                                label: content.stat_3_label || "User Rating",
                            },
                            {
                                value: content.stat_4_value || "98%",
                                label: content.stat_4_label || "Success Rate",
                            },
                        ].map((stat, index) => (
                            <div
                                key={index}
                                className="text-center group cursor-default"
                            >
                                <div className="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white mb-1.5 drop-shadow-2xl bg-gradient-to-b from-white to-gray-200 bg-clip-text text-transparent group-hover:scale-110 transition-transform duration-300">
                                    {stat.value}
                                </div>
                                <div className="text-xs sm:text-sm md:text-base text-gray-200 font-medium">
                                    {stat.label}
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </Container>

            {/* Enhanced Scroll Indicator */}
            <div className="absolute bottom-6 left-1/2 transform -translate-x-1/2 animate-bounce z-10">
                <div className="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center backdrop-blur-md bg-white/10 shadow-lg">
                    <div className="w-1.5 h-3 bg-gradient-to-b from-primary-400 to-primary-500 rounded-full mt-2 animate-pulse"></div>
                </div>
            </div>
        </section>
    );
}
