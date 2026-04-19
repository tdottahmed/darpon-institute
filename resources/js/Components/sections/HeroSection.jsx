import { usePage, Link } from "@inertiajs/react";
import { useEffect, useRef, useState } from "react";
import { useCountUp } from "@/hooks/useCountUp";
import PrimaryButton from "@/Components/ui/PrimaryButton";
import SecondaryButton from "@/Components/ui/SecondaryButton";
import SectionHeader from "../ui/SectionHeader";
import Badge from "../ui/Badge";

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
    console.log(content);
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
                    className="absolute inset-0 w-full h-full object-cover"
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
            <div className="relative z-10 flex-1 flex items-center py-16 md:py-20">
                <div className="container mx-auto max-w-6xl text-center px-4">
                    <div className="mb-4">
                        <Badge
                            variant="secondary"
                            className="text-xs font-semibold uppercase tracking-wide px-3 py-1"
                        >
                            {content.badge}
                        </Badge>
                    </div>
                    <h1 className="hero-item hero-item-1 text-[2.25rem] sm:text-4xl md:text-5xl lg:text-[3.5rem] xl:text-6xl font-bold text-white leading-[1.15] tracking-tight drop-shadow-sm">
                        <span className="whitespace-pre-line block text-center">
                            {content.title_line_1 || ""}
                        </span>
                        {content.title_line_2 && (
                            <span className="inline-block mt-3 text-white font-bold text-2xl md:text-3xl xl:text-4xl">
                                {content.title_line_2}
                            </span>
                        )}
                    </h1>
                    <div
                        className="hero-item hero-item-2 mt-5 text-base sm:text-lg text-gray-200 dark:text-gray-300 max-w-3xl mx-auto leading-relaxed"
                        dangerouslySetInnerHTML={{
                            __html: content.description || "",
                        }}
                    />

                    <div className="hero-item hero-item-3 flex flex-row flex-wrap gap-3 sm:gap-4 justify-center mt-8">
                        <PrimaryButton
                            href={content.button_1_link || "/courses"}
                        >
                            {content.button_1_text || "Find Courses"}
                        </PrimaryButton>
                        <SecondaryButton
                            href={content.button_2_link || "/books"}
                        >
                            {content.button_2_text || "Find Books"}
                        </SecondaryButton>
                    </div>
                </div>
            </div>

            {/* Stats bar - full width, overlaps next section */}
            {hasStats && (
                <div className="relative z-20 hero-stats-bar bg-white/95 dark:bg-gray-900/95 backdrop-blur-md shadow-[0_-8px_40px_rgba(0,0,0,0.1)] dark:shadow-none">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 py-6 lg:py-8">
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
