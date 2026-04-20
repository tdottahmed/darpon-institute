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
 * Empty string for current locale must not block fallback to `en`.
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
            <div className="text-xl sm:text-3xl lg:text-4xl font-black text-gray-900 dark:text-white tabular-nums">
                {displayValue}
            </div>
            <div className="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1">
                {label || fallbackLabel}
            </div>
        </div>
    );
}

export default function HeroSection() {
    const { frontend_content, locale } = usePage().props;
    const content = frontend_content?.hero || {};
    const loc = locale || "en";

    const sectionRef  = useRef(null);
    const imageRefs   = useRef([]);   // per-slide <img> refs for Ken Burns reset
    const animTimer   = useRef(null); // text animation timer

    const [isVisible,    setIsVisible]    = useState(false);
    const [currentSlide, setCurrentSlide] = useState(0);
    const [textAnim,     setTextAnim]     = useState(""); // "" | "exiting" | "entering"

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

    const isSlider = heroMode === "slider" && sliderImages.length > 0;
    const bgImages = isSlider ? sliderImages : [staticImage];

    // ── Ken Burns: restart animation on newly-active slide ──────────────────
    useEffect(() => {
        bgImages.forEach((_, i) => {
            const el = imageRefs.current[i];
            if (!el) return;
            if (i === currentSlide) {
                el.style.animation = "none";
                void el.offsetHeight; // force reflow so animation restarts
                el.style.animation = "hero-kenburns 6s ease-in-out forwards";
            } else {
                el.style.animation = "none";
            }
        });
    // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [currentSlide, bgImages.length]);

    // ── Slide transition: animate text out → change slide → animate text in ─
    const triggerSlide = useCallback((updater) => {
        if (animTimer.current) clearTimeout(animTimer.current);
        setTextAnim("exiting");
        animTimer.current = setTimeout(() => {
            setCurrentSlide(updater);
            setTextAnim("entering");
            animTimer.current = setTimeout(() => setTextAnim(""), 520);
        }, 260);
    }, []);

    const goNext = useCallback(
        () => triggerSlide((p) => (p + 1) % bgImages.length),
        [bgImages.length, triggerSlide],
    );
    const goPrev = useCallback(
        () => triggerSlide((p) => (p - 1 + bgImages.length) % bgImages.length),
        [bgImages.length, triggerSlide],
    );

    // Autoplay
    useEffect(() => {
        if (!isSlider || bgImages.length <= 1) return;
        const timer = setInterval(goNext, 5000);
        return () => clearInterval(timer);
    }, [isSlider, bgImages.length, goNext]);

    // Reset slide (no animation) when content/mode changes
    useEffect(() => {
        setCurrentSlide(0);
        setTextAnim("");
    // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [heroMode, staticImage, sliderImages.join("|")]);

    // Cleanup on unmount
    useEffect(() => () => { if (animTimer.current) clearTimeout(animTimer.current); }, []);

    // Intersection observer for initial reveal
    useEffect(() => {
        const el = sectionRef.current;
        if (!el) return;
        const observer = new IntersectionObserver(
            ([entry]) => { if (entry.isIntersecting) setIsVisible(true); },
            { threshold: 0.1, rootMargin: "0px 0px -40px 0px" },
        );
        observer.observe(el);
        return () => observer.disconnect();
    }, []);

    const hasStats =
        content.stat_1_value || content.stat_2_value ||
        content.stat_3_value || content.stat_4_value;

    const textAnimClass =
        textAnim === "exiting"  ? "hero-text-exiting"  :
        textAnim === "entering" ? "hero-text-entering"  : "";

    return (
        <section
            ref={sectionRef}
            className={`relative z-10 min-h-[62vh] md:min-h-[82vh] lg:min-h-[90vh] flex flex-col overflow-visible ${isVisible ? "hero-visible" : ""}`}
        >
            {/* ── Background images (crossfade + Ken Burns) ── */}
            <div className="absolute inset-0 overflow-hidden">
                {bgImages.map((src, i) => (
                    <img
                        key={`${src}-${i}`}
                        ref={(el) => { imageRefs.current[i] = el; }}
                        src={src}
                        alt=""
                        className={`absolute inset-0 w-full h-full object-cover transition-opacity duration-700 ease-in-out will-change-transform ${
                            i === currentSlide ? "opacity-100" : "opacity-0"
                        }`}
                    />
                ))}

                {/* Dark overlay */}
                <div className="absolute inset-0 bg-black/50 dark:bg-black/65" aria-hidden="true" />

                {/* Bottom gradient for stats-bar bleed */}
                <div className="absolute inset-0 bg-gradient-to-b from-black/10 via-transparent to-black/40 dark:to-black/55" aria-hidden="true" />
            </div>

            {/* ── Main content ── */}
            <div className="relative z-10 flex-1 flex items-center py-10 md:py-20 lg:py-28">

                {/* Slider prev/next arrows */}
                {isSlider && bgImages.length > 1 && (
                    <>
                        <button
                            onClick={goPrev}
                            className="absolute left-3 md:left-6 top-1/2 -translate-y-1/2 z-20 rounded-full bg-black/30 hover:bg-black/55 p-2.5 text-white backdrop-blur-sm transition-all duration-200 hover:scale-110 focus-visible:outline focus-visible:outline-2 focus-visible:outline-white"
                            aria-label="Previous slide"
                        >
                            <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button
                            onClick={goNext}
                            className="absolute right-3 md:right-6 top-1/2 -translate-y-1/2 z-20 rounded-full bg-black/30 hover:bg-black/55 p-2.5 text-white backdrop-blur-sm transition-all duration-200 hover:scale-110 focus-visible:outline focus-visible:outline-2 focus-visible:outline-white"
                            aria-label="Next slide"
                        >
                            <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </>
                )}

                {/* Text content — animated on slide change */}
                <div className={`container mx-auto max-w-5xl text-center px-4 sm:px-6 ${textAnimClass}`}>
                    {content.badge && (
                        <div className="hero-item hero-item-1 mb-3 sm:mb-5">
                            <Badge
                                variant="secondary"
                                className="text-[11px] sm:text-xs font-semibold uppercase tracking-widest px-3 py-1 sm:px-4 sm:py-1.5"
                            >
                                {content.badge}
                            </Badge>
                        </div>
                    )}

                    <h1 className="hero-item hero-item-2 text-[1.7rem] sm:text-4xl md:text-5xl lg:text-[3.25rem] xl:text-[3.75rem] font-bold text-white leading-[1.15] tracking-tight drop-shadow-md">
                        <span className="whitespace-pre-line block">
                            {content.title_line_1 || ""}
                        </span>
                        {content.title_line_2 && (
                            <span className="inline-block mt-2 sm:mt-3 text-white/90 font-semibold text-base sm:text-xl md:text-2xl xl:text-3xl">
                                {content.title_line_2}
                            </span>
                        )}
                    </h1>

                    <div
                        className="hero-item hero-item-3 mt-3 sm:mt-5 text-sm sm:text-base md:text-lg text-white/80 max-w-2xl mx-auto leading-relaxed drop-shadow-sm line-clamp-3 sm:line-clamp-none"
                        dangerouslySetInnerHTML={{ __html: content.description || "" }}
                    />

                    <div className="hero-item hero-item-4 flex flex-row flex-wrap gap-2.5 sm:gap-4 justify-center mt-5 sm:mt-8 md:mt-10">
                        <PrimaryButton href={content.button_1_link || "/courses"}>
                            {content.button_1_text || "Find Courses"}
                        </PrimaryButton>
                        <SecondaryButton href={content.button_2_link || "/books"}>
                            {content.button_2_text || "Find Books"}
                        </SecondaryButton>
                    </div>
                </div>
            </div>

            {/* ── Slider dots ── */}
            {isSlider && bgImages.length > 1 && (
                <div className="relative z-10 flex justify-center items-center gap-2 py-4">
                    {bgImages.map((_, i) => (
                        <button
                            key={i}
                            onClick={() => triggerSlide(() => i)}
                            className={`rounded-full transition-all duration-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-white ${
                                i === currentSlide
                                    ? "w-7 h-2.5 bg-white shadow-lg"
                                    : "w-2.5 h-2.5 bg-white/40 hover:bg-white/65"
                            }`}
                            aria-label={`Go to slide ${i + 1}`}
                            aria-current={i === currentSlide ? "true" : undefined}
                        />
                    ))}
                </div>
            )}

            {/* ── Stats bar ── */}
            {hasStats && (
                <div className="relative z-20 hero-stats-bar bg-white/95 dark:bg-gray-900/95 backdrop-blur-md shadow-[0_-8px_40px_rgba(0,0,0,0.12)] dark:shadow-none">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-10 py-4 sm:py-6 lg:py-8">
                            {(content.stat_1_value || content.stat_1_label) && (
                                <StatItem value={content.stat_1_value} label={content.stat_1_label} isVisible={isVisible} />
                            )}
                            {(content.stat_2_value || content.stat_2_label) && (
                                <StatItem value={content.stat_2_value} label={content.stat_2_label} isVisible={isVisible} />
                            )}
                            {(content.stat_3_value || content.stat_3_label) && (
                                <StatItem value={content.stat_3_value} label={content.stat_3_label} fallbackLabel="Ratings" isVisible={isVisible} />
                            )}
                            {(content.stat_4_value || content.stat_4_label) && (
                                <StatItem value={content.stat_4_value} label={content.stat_4_label} isVisible={isVisible} />
                            )}
                        </div>
                    </div>
                </div>
            )}
        </section>
    );
}
