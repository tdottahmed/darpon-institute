import { useState } from "react";
import Button from "../ui/Button";
import Container from "../ui/Container";
import Badge from "../ui/Badge";
import { Link, router } from "@inertiajs/react";

export default function HeroSection({ translations }) {
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
        <section className="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-primary-50 via-white to-secondary-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 pt-20 pb-32">
            {/* Background Shapes */}
            <div className="absolute inset-0 overflow-hidden pointer-events-none">
                {/* Animated Blobs */}
                <div className="absolute top-20 left-10 w-96 h-96 bg-primary-200 dark:bg-primary-900/20 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob"></div>
                <div
                    className="absolute top-40 right-10 w-96 h-96 bg-secondary-200 dark:bg-secondary-900/20 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob"
                    style={{ animationDelay: "2s" }}
                ></div>
                <div
                    className="absolute -bottom-8 left-1/2 w-96 h-96 bg-accent-200 dark:bg-accent-900/20 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob"
                    style={{ animationDelay: "4s" }}
                ></div>

                {/* Geometric Shapes */}
                <div className="absolute top-32 right-20 w-64 h-64 border-4 border-primary-300/30 dark:border-primary-700/30 rotate-45 rounded-lg animate-pulse"></div>
                <div
                    className="absolute bottom-32 left-20 w-48 h-48 border-4 border-secondary-300/30 dark:border-secondary-700/30 rotate-12 rounded-full animate-pulse"
                    style={{ animationDelay: "1s" }}
                ></div>
                <div
                    className="absolute top-1/2 right-1/4 w-32 h-32 bg-accent-300/20 dark:bg-accent-700/20 rounded-full blur-2xl animate-pulse"
                    style={{ animationDelay: "3s" }}
                ></div>

                {/* Grid Pattern */}
                <div className="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px] opacity-30"></div>
            </div>

            <Container className="relative z-10">
                <div className="grid lg:grid-cols-2 gap-12 items-center">
                    {/* Hero Content */}
                    <div className="text-center lg:text-left space-y-8">
                        <Badge
                            variant="primary"
                            className="mb-4 animate-fade-in"
                        >
                            🎓 {t.welcome || "Start Learning Today"}
                        </Badge>

                        <h1 className="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold text-gray-900 dark:text-white leading-tight animate-fade-in-up">
                            <span className="bg-gradient-to-r from-primary-600 via-secondary-600 to-accent-600 bg-clip-text text-transparent dark:from-primary-400 dark:via-secondary-400 dark:to-accent-400">
                                Master English
                            </span>
                            <br />
                            <span className="text-gray-900 dark:text-white">
                                From Anywhere
                            </span>
                        </h1>

                        <p
                            className="text-lg sm:text-xl text-gray-600 dark:text-gray-300 max-w-xl mx-auto lg:mx-0 leading-relaxed animate-fade-in-up"
                            style={{ animationDelay: "0.2s" }}
                        >
                            Interactive learning platform with modern methods,
                            digital diplomas, and personalized study plans
                            designed to help you achieve fluency faster.
                        </p>

                        {/* Search Bar */}
                        <form
                            onSubmit={handleSearch}
                            className="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto lg:mx-0 animate-fade-in-up"
                            style={{ animationDelay: "0.4s" }}
                        >
                            <div className="flex-1 relative">
                                <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg
                                        className="h-5 w-5 text-gray-400"
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
                                    className="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-all shadow-lg hover:shadow-xl"
                                />
                            </div>
                            <Button
                                type="submit"
                                size="lg"
                                className="whitespace-nowrap shadow-lg hover:shadow-xl"
                            >
                                Search
                            </Button>
                        </form>

                        {/* CTA Buttons */}
                        <div
                            className="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start animate-fade-in-up"
                            style={{ animationDelay: "0.6s" }}
                        >
                            <Button
                                href={route("register")}
                                variant="primary"
                                size="lg"
                                className="shadow-lg hover:shadow-xl transform hover:scale-105 transition-all"
                            >
                                {t.register || "Get Started Free"}
                            </Button>
                            <Button
                                href={route("login")}
                                variant="outline"
                                size="lg"
                                className="shadow-lg hover:shadow-xl transform hover:scale-105 transition-all"
                            >
                                {t.login || "Log In"}
                            </Button>
                        </div>

                        {/* Stats */}
                        <div
                            className="flex flex-wrap gap-8 justify-center lg:justify-start pt-4 animate-fade-in-up"
                            style={{ animationDelay: "0.8s" }}
                        >
                            <div className="text-center lg:text-left">
                                <div className="text-3xl font-bold text-primary-600 dark:text-primary-400">
                                    10K+
                                </div>
                                <div className="text-sm text-gray-600 dark:text-gray-400">
                                    Happy Students
                                </div>
                            </div>
                            <div className="text-center lg:text-left">
                                <div className="text-3xl font-bold text-secondary-600 dark:text-secondary-400">
                                    500+
                                </div>
                                <div className="text-sm text-gray-600 dark:text-gray-400">
                                    Courses
                                </div>
                            </div>
                            <div className="text-center lg:text-left">
                                <div className="text-3xl font-bold text-accent-600 dark:text-accent-400">
                                    98%
                                </div>
                                <div className="text-sm text-gray-600 dark:text-gray-400">
                                    Success Rate
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Hero Image with Floating Cards */}
                    <div className="relative hidden lg:block">
                        <div className="relative">
                            {/* Main Image */}
                            <div className="relative w-full h-[600px] rounded-3xl shadow-2xl overflow-hidden group">
                                <img
                                    src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop&q=80"
                                    alt="Students learning English"
                                    className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                />
                                {/* Overlay Gradient */}
                                <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>

                                {/* Floating Badge on Image */}
                                <div className="absolute top-6 right-6 bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm px-4 py-2 rounded-full shadow-lg animate-float">
                                    <div className="flex items-center gap-2">
                                        <span className="text-xl">⭐</span>
                                        <span className="text-sm font-semibold text-gray-900 dark:text-white">
                                            4.9 Rating
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {/* Floating Cards */}
                            <div className="absolute -top-6 -left-6 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-2xl animate-float border-2 border-primary-100 dark:border-primary-900">
                                <div className="flex items-center gap-4">
                                    <div className="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-xl flex items-center justify-center">
                                        <span className="text-2xl">🌍</span>
                                    </div>
                                    <div>
                                        <p className="text-base font-bold text-gray-900 dark:text-white">
                                            Remote Learning
                                        </p>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">
                                            Learn from anywhere
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div
                                className="absolute -bottom-6 -right-6 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-2xl animate-float border-2 border-secondary-100 dark:border-secondary-900"
                                style={{ animationDelay: "1s" }}
                            >
                                <div className="flex items-center gap-4">
                                    <div className="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-secondary-500 to-accent-500 rounded-xl flex items-center justify-center">
                                        <span className="text-2xl">📝</span>
                                    </div>
                                    <div>
                                        <p className="text-base font-bold text-gray-900 dark:text-white">
                                            Digital Diploma
                                        </p>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">
                                            Get certified online
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div
                                className="absolute top-1/2 -right-12 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-2xl animate-float border-2 border-accent-100 dark:border-accent-900"
                                style={{ animationDelay: "2s" }}
                            >
                                <div className="flex items-center gap-4">
                                    <div className="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-accent-500 to-primary-500 rounded-xl flex items-center justify-center">
                                        <span className="text-2xl">▶️</span>
                                    </div>
                                    <div>
                                        <p className="text-base font-bold text-gray-900 dark:text-white">
                                            Interactive
                                        </p>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">
                                            Modern methods
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {/* Decorative Elements */}
                            <div className="absolute -top-4 left-1/4 w-20 h-20 bg-primary-400/20 dark:bg-primary-600/20 rounded-full blur-2xl animate-pulse"></div>
                            <div
                                className="absolute bottom-1/4 -left-8 w-16 h-16 bg-secondary-400/20 dark:bg-secondary-600/20 rounded-full blur-xl animate-pulse"
                                style={{ animationDelay: "2s" }}
                            ></div>
                        </div>
                    </div>
                </div>
            </Container>

            {/* Scroll Indicator */}
            <div className="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                <div className="w-6 h-10 border-2 border-gray-400 dark:border-gray-600 rounded-full flex justify-center">
                    <div className="w-1 h-3 bg-gray-400 dark:bg-gray-600 rounded-full mt-2 animate-pulse"></div>
                </div>
            </div>
        </section>
    );
}
