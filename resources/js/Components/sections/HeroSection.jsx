import { usePage, Link } from "@inertiajs/react";
import { useEffect, useRef, useState } from "react";
import { useCountUp } from "@/hooks/useCountUp";

function StatItem({ value, label, fallbackLabel, isVisible }) {
    const displayValue = useCountUp(value, isVisible, 1800);
    if (!value && !label) return null;
    return (
        <div className="text-center">
            <div className="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 dark:text-white tabular-nums">
                {displayValue}
            </div>
            <div className="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1">
                {label || fallbackLabel}
            </div>
        </div>
    );
}

export default function HeroSection({ translations }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.hero || {};
    const sectionRef = useRef(null);
    const [isVisible, setIsVisible] = useState(false);

    const heroImage =
        content.bg_image ||
        content.hero_image ||
        "https://res.cloudinary.com/dztksqwip/image/upload/v1727787355/student-reading-book-PNG_vsw91r.png";

    const hasStats =
        content.stat_1_value ||
        content.stat_2_value ||
        content.stat_3_value ||
        content.stat_4_value;

    useEffect(() => {
        const el = sectionRef.current;
        if (!el) return;

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    setIsVisible(true);
                }
            },
            { threshold: 0.12, rootMargin: "0px 0px -40px 0px" },
        );

        observer.observe(el);
        return () => observer.disconnect();
    }, []);

    return (
        <section
            ref={sectionRef}
            className={`relative z-10 min-h-[70vh] flex flex-col overflow-visible ${isVisible ? "hero-visible" : ""}`}
        >
            {/* Background image */}
            <div className="absolute inset-0">
                <img
                    src={heroImage}
                    alt=""
                    className="absolute inset-0 w-full h-full object-cover transition-transform duration-[1.4s] ease-out"
                    style={{
                        transform: isVisible ? "scale(1.03)" : "scale(1.12)",
                    }}
                />
                {/* Dark overlay for readability (works in light & dark mode) */}
                <div
                    className="absolute inset-0 bg-black/45 dark:bg-black/60"
                    aria-hidden="true"
                />
                {/* Gradient to keep content area brighter */}
                <div
                    className="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/30 dark:to-black/50"
                    aria-hidden="true"
                />
            </div>

            {/* Main content - centered */}
            <div className="relative z-10 flex-1 flex items-left py-16 md:py-20">
                <div className="container mx-auto max-w-6xl text-left">
                    <h1 className="hero-item hero-item-1 text-[2.25rem] sm:text-4xl md:text-5xl lg:text-[3.5rem] xl:text-6xl font-bold text-white leading-[1.15] tracking-tight drop-shadow-sm">
                        <span className="whitespace-pre-line block">
                            {content.title_line_1 || ""}
                        </span>
                        {content.title_line_2 && (
                            <span className="inline-block mt-3 bg-[#FFC510] dark:bg-yellow-500 text-gray-900 px-4 py-1.5 rounded-xl font-bold">
                                {content.title_line_2}
                            </span>
                        )}
                    </h1>
                    <p className="hero-item hero-item-2 mt-5 text-base sm:text-lg text-gray-200 dark:text-gray-300 max-w-3xl leading-relaxed">
                        {content.description || ""}
                    </p>

                    <div className="hero-item hero-item-3 flex flex-col sm:flex-row gap-4 justify-start mt-8">
                        <Link
                            href={content.button_1_link || "/courses"}
                            className="group inline-flex items-center justify-center gap-3 bg-[#5A45FF] hover:bg-[#4a34e0] dark:bg-indigo-500 dark:hover:bg-indigo-400 text-white rounded-full pl-6 pr-2 py-3 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-[1.02]"
                        >
                            <span className="font-semibold text-sm sm:text-base">
                                {content.button_1_text || "Find Courses"}
                            </span>
                            <span className="bg-white/20 rounded-full p-2 group-hover:bg-white/30 transition-colors">
                                <svg
                                    className="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2.5"
                                        d="M5 12h14M12 5l7 7-7 7"
                                    />
                                </svg>
                            </span>
                        </Link>
                        <Link
                            href={content.button_2_link || "/books"}
                            className="group inline-flex items-center justify-center gap-3 bg-[#FFC510] hover:bg-[#eab308] dark:bg-yellow-500 dark:hover:bg-yellow-600 text-gray-900 rounded-full pl-6 pr-2 py-3 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-[1.02]"
                        >
                            <span className="font-semibold text-sm sm:text-base">
                                {content.button_2_text || "Find Books"}
                            </span>
                            <span className="bg-gray-900/10 rounded-full p-2 group-hover:bg-gray-900/20 transition-colors">
                                <svg
                                    className="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2.5"
                                        d="M5 12h14M12 5l7 7-7 7"
                                    />
                                </svg>
                            </span>
                        </Link>
                    </div>
                </div>
            </div>

            {/* Stats bar - full width, overlaps next section */}
            {hasStats && (
                <div className="relative z-20 hero-stats-bar -mb-16 md:-mb-20">
                    <div className="w-full px-4 sm:px-6 lg:px-8">
                        <div className="max-w-7xl mx-auto grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 py-6 lg:py-8 px-6 lg:px-12 rounded-2xl bg-white/95 dark:bg-gray-900/95 backdrop-blur-md border-t border-x border-gray-200/80 dark:border-gray-700/80 shadow-[0_-8px_40px_rgba(0,0,0,0.1)] dark:shadow-none">
                            {(content.stat_1_value || content.stat_1_label) && (
                                <StatItem
                                    value={content.stat_1_value}
                                    label={content.stat_1_label}
                                    isVisible={isVisible}
                                />
                            )}
                            {(content.stat_2_value || content.stat_2_label) && (
                                <StatItem
                                    value={content.stat_2_value}
                                    label={content.stat_2_label}
                                    isVisible={isVisible}
                                />
                            )}
                            {(content.stat_3_value || content.stat_3_label) && (
                                <StatItem
                                    value={content.stat_3_value}
                                    label={content.stat_3_label}
                                    fallbackLabel="Ratings"
                                    isVisible={isVisible}
                                />
                            )}
                            {(content.stat_4_value || content.stat_4_label) && (
                                <StatItem
                                    value={content.stat_4_value}
                                    label={content.stat_4_label}
                                    isVisible={isVisible}
                                />
                            )}
                        </div>
                    </div>
                </div>
            )}
        </section>
    );
}
