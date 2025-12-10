import { useState } from "react";
import Button from "../ui/Button";
import Container from "../ui/Container";
import Badge from "../ui/Badge";
import { Link } from "@inertiajs/react";

export default function HeroSection({ translations }) {
    const t = translations?.common || {};
    const [searchQuery, setSearchQuery] = useState("");

    return (
        <section className="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-primary-50 via-secondary-50 to-accent-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 pt-20 pb-32">
            <Container className="relative z-10">
                <div className="grid lg:grid-cols-2 gap-12 items-center">
                    {/* Hero Content */}
                    <div className="text-center lg:text-left space-y-6">
                        <Badge variant="primary" className="mb-4">
                            🎓 {t.welcome || "Start Learning Today"}
                        </Badge>

                        <h1 className="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white leading-tight">
                            <span className="bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent dark:from-primary-400 dark:to-secondary-400">
                                Master English
                            </span>
                            <br />
                            From Anywhere
                        </h1>

                        <p className="text-lg sm:text-xl text-gray-600 dark:text-gray-300 max-w-xl mx-auto lg:mx-0">
                            Interactive learning platform with modern methods,
                            digital diplomas, and personalized study plans.
                        </p>

                        {/* Search Bar */}
                        <div className="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto lg:mx-0">
                            <div className="flex-1">
                                <input
                                    type="text"
                                    placeholder="Search courses..."
                                    value={searchQuery}
                                    onChange={(e) =>
                                        setSearchQuery(e.target.value)
                                    }
                                    className="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400"
                                />
                            </div>
                            <Button size="lg" className="whitespace-nowrap">
                                Search
                            </Button>
                        </div>

                        {/* CTA Buttons */}
                        <div className="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <Button
                                href={route("register")}
                                variant="primary"
                                size="lg"
                            >
                                {t.register || "Get Started Free"}
                            </Button>
                            <Button
                                href={route("login")}
                                variant="outline"
                                size="lg"
                            >
                                {t.login || "Log In"}
                            </Button>
                        </div>
                    </div>

                    {/* Hero Image with Floating Cards */}
                    <div className="relative hidden lg:block">
                        <div className="relative">
                            {/* Main Image Placeholder */}
                            <div className="w-full h-96 bg-gradient-to-br from-primary-400 to-secondary-400 rounded-2xl shadow-2xl flex items-center justify-center">
                                <span className="text-8xl">📚</span>
                            </div>

                            {/* Floating Cards */}
                            <div className="absolute -top-4 -left-4 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-lg animate-float">
                                <div className="flex items-center gap-3">
                                    <span className="text-2xl">🌍</span>
                                    <div>
                                        <p className="text-sm font-semibold text-gray-900 dark:text-white">
                                            Remote Learning
                                        </p>
                                        <p className="text-xs text-gray-600 dark:text-gray-400">
                                            Learn from home
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div
                                className="absolute -bottom-4 -right-4 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-lg animate-float"
                                style={{ animationDelay: "1s" }}
                            >
                                <div className="flex items-center gap-3">
                                    <span className="text-2xl">📝</span>
                                    <div>
                                        <p className="text-sm font-semibold text-gray-900 dark:text-white">
                                            Digital Diploma
                                        </p>
                                        <p className="text-xs text-gray-600 dark:text-gray-400">
                                            Get certified
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div
                                className="absolute top-1/2 -right-8 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-lg animate-float"
                                style={{ animationDelay: "2s" }}
                            >
                                <div className="flex items-center gap-3">
                                    <span className="text-2xl">▶️</span>
                                    <div>
                                        <p className="text-sm font-semibold text-gray-900 dark:text-white">
                                            Interactive
                                        </p>
                                        <p className="text-xs text-gray-600 dark:text-gray-400">
                                            Modern methods
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Container>

            {/* Background Decoration */}
            <div className="absolute inset-0 overflow-hidden pointer-events-none">
                <div className="absolute top-20 left-10 w-72 h-72 bg-primary-200 dark:bg-primary-900/20 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
                <div
                    className="absolute top-40 right-10 w-72 h-72 bg-secondary-200 dark:bg-secondary-900/20 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"
                    style={{ animationDelay: "2s" }}
                ></div>
                <div
                    className="absolute -bottom-8 left-1/2 w-72 h-72 bg-accent-200 dark:bg-accent-900/20 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"
                    style={{ animationDelay: "4s" }}
                ></div>
            </div>
        </section>
    );
}
