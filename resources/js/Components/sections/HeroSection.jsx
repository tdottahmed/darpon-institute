import { usePage } from "@inertiajs/react";
import { useEffect, useRef, useState, useCallback } from "react";
import { useCountUp } from "@/hooks/useCountUp";
import PrimaryButton from "@/Components/ui/PrimaryButton";
import SecondaryButton from "@/Components/ui/SecondaryButton";
import Badge from "../ui/Badge";

const DEFAULT_IMAGE =
    "https://res.cloudinary.com/dztksqwip/image/upload/v1727787355/student-reading-book-PNG_vsw91r.png";

/**
 * Resolve image URL (backend may send a string or { en, bn }).
 * Empty string for current locale must not block fallback to `en` (common for hero_image).
 */
function resolveImageUrl(value, locale = "en") {
    if (value == null) return "";
    if (typeof value === "string") return value.trim();
    if (typeof value === "object") {
        for (const key of [locale, "en", "bn"]) {
            const v = value[key];
            if (typeof v === "string" && v.trim()) return v.trim();
        }
        for (const v of Object.values(value)) {
            if (typeof v === "string" && v.trim()) return v.trim();
        }
        return "";
    }
    return String(value).trim();
}

function normalizeHeroMode(raw) {
    const s = String(raw ?? "image").trim().toLowerCase();
    return s === "slider" ? "slider" : "image";
}

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
    const { frontend_content, locale } = usePage().props;
    const content = frontend_content?.hero || {};
    const loc = locale || "en";
    const sectionRef = useRef(null);
    const [isVisible, setIsVisible] = useState(false);
    const [currentSlide, setCurrentSlide] = useState(0);

    const heroMode = normalizeHeroMode(content.hero_mode);

    const sliderImages = [
        content.slider_image_1,
        content.slider_image_2,
        content.slider_image_3,
        content.slider_image_4,
        content.slider_image_5,
    ]
        .map((u) => resolveImageUrl(u, loc))
        .filter(Boolean);

    const staticImage =
        resolveImageUrl(content.hero_image, loc) ||
        resolveImageUrl(content.bg_image, loc) ||
        DEFAULT_IMAGE;

    /** Static background must ignore slider URLs whenever mode is not slider */
    const isSlider = heroMode === "slider" && sliderImages.length > 0;
    const bgImages = isSlider ? sliderImages : [staticImage];

    const goNext = useCallback(
        () => setCurrentSlide((p) => (p + 1) % bgImages.length),
        [bgImages.length],
    );
    const goPrev = useCallback(
        () =>
            setCurrentSlide((p) => (p - 1 + bgImages.length) % bgImages.length),
        [bgImages.length],
    );

    useEffect(() => {
        if (!isSlider || bgImages.length <= 1) return;
        const timer = setInterval(goNext, 5000);
        return () => clearInterval(timer);
    }, [isSlider, bgImages.length, goNext]);

    useEffect(() => {
        setCurrentSlide(0);
    }, [heroMode, staticImage, sliderImages.join("|")]);

    useEffect(() => {
        const el = sectionRef.current;
        if (!el) return;
        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) setIsVisible(true);
            },
            { threshold: 0.12, rootMargin: "0px 0px -40px 0px" },
        );
        observer.observe(el);
        return () => observer.disconnect();
    }, []);

    const hasStats =
        content.stat_1_value ||
        content.stat_2_value ||
        content.stat_3_value ||
        content.stat_4_value;

    return (
        <section
            ref={sectionRef}
            className={`relative z-10 min-h-[70vh] flex flex-col overflow-visible ${isVisible ? "hero-visible" : ""}`}
        >
            {/* Background images (crossfade) */}
            <div className="absolute inset-0">
                {bgImages.map((src, i) => (
                    <img
                        key={`${src}-${i}`}
                        src={src}
                        alt=""
                        className={`absolute inset-0 w-full h-full object-cover transition-opacity duration-700 ease-in-out ${i === currentSlide ? "opacity-100" : "opacity-0"}`}
                    />
                ))}
                <div
                    className="absolute inset-0 bg-black/45 dark:bg-black/60"
                    aria-hidden="true"
                />
                <div
                    className="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/30 dark:to-black/50"
                    aria-hidden="true"
                />
            </div>

            {/* Main content */}
            <div className="relative z-10 flex-1 flex items-center py-16 md:py-20">
                {/* Slider arrows */}
                {isSlider && bgImages.length > 1 && (
                    <>
                        <button
                            onClick={goPrev}
                            className="absolute left-3 md:left-6 top-1/2 -translate-y-1/2 z-10 rounded-full bg-black/30 p-2 text-white backdrop-blur-sm transition hover:bg-black/55"
                            aria-label="Previous slide"
                        >
                            <svg
                                className="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M15 19l-7-7 7-7"
                                />
                            </svg>
                        </button>
                        <button
                            onClick={goNext}
                            className="absolute right-3 md:right-6 top-1/2 -translate-y-1/2 z-10 rounded-full bg-black/30 p-2 text-white backdrop-blur-sm transition hover:bg-black/55"
                            aria-label="Next slide"
                        >
                            <svg
                                className="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>
                        </button>
                    </>
                )}

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
                        <PrimaryButton href={content.button_1_link || "/courses"}>
                            {content.button_1_text || "Find Courses"}
                        </PrimaryButton>
                        <SecondaryButton href={content.button_2_link || "/books"}>
                            {content.button_2_text || "Find Books"}
                        </SecondaryButton>
                    </div>
                </div>
            </div>

            {/* Slider dots */}
            {isSlider && bgImages.length > 1 && (
                <div className="relative z-10 flex justify-center gap-2 py-3">
                    {bgImages.map((_, i) => (
                        <button
                            key={i}
                            onClick={() => setCurrentSlide(i)}
                            className={`h-2 rounded-full transition-all duration-300 ${
                                i === currentSlide
                                    ? "w-6 bg-white"
                                    : "w-2 bg-white/50 hover:bg-white/75"
                            }`}
                            aria-label={`Go to slide ${i + 1}`}
                        />
                    ))}
                </div>
            )}

            {/* Stats bar */}
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
