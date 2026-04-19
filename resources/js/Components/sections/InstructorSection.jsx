import { useEffect, useMemo, useRef, useState } from "react";
import Container from "../ui/Container";
import SectionBackground from "../ui/SectionBackground";
import PrimaryButton from "../ui/PrimaryButton";
import { usePage } from "@inertiajs/react";

/** Word caps by breakpoint — short on phones, longer on tablets, full on large screens */
function getWordLimitForWidth(width) {
    if (width < 640) return 48;
    if (width < 1024) return 80;
    return 125;
}

function stripHtmlToText(html) {
    return html
        .replace(/<\/p>/gi, "\n\n")
        .replace(/<br\s*\/?>/gi, "\n")
        .replace(/<[^>]*>/gm, "")
        .replace(/&nbsp;/g, " ")
        .replace(/&amp;/g, "&")
        .replace(/&lt;/g, "<")
        .replace(/&gt;/g, ">")
        .trim();
}

function isHtml(str) {
    return /<[a-z][\s\S]*>/i.test(str);
}

const HTML_PROSE =
    "text-gray-700 dark:text-gray-300 text-sm sm:text-base leading-relaxed " +
    "[&_p]:mb-3 [&_ul]:list-disc [&_ul]:pl-5 [&_ul]:mb-3 [&_ol]:list-decimal [&_ol]:pl-5 [&_ol]:mb-3 " +
    "[&_li]:mb-1 [&_strong]:font-semibold [&_em]:italic [&_a]:text-primary-600 [&_a]:underline " +
    "[&_h1]:text-xl [&_h1]:font-bold [&_h1]:mb-2 [&_h2]:text-lg [&_h2]:font-bold [&_h2]:mb-2 " +
    "[&_h3]:text-base [&_h3]:font-semibold [&_h3]:mb-1";

export default function InstructorSection() {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.instructor || {};
    const sectionRef = useRef(null);
    const [isVisible, setIsVisible] = useState(false);
    const [isExpanded, setIsExpanded] = useState(false);
    const [viewportWidth, setViewportWidth] = useState(() =>
        typeof window !== "undefined" ? window.innerWidth : 1024,
    );

    useEffect(() => {
        const onResize = () => setViewportWidth(window.innerWidth);
        onResize();
        window.addEventListener("resize", onResize);
        return () => window.removeEventListener("resize", onResize);
    }, []);

    useEffect(() => {
        const el = sectionRef.current;
        if (!el) return;
        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) setIsVisible(true);
            },
            { threshold: 0.08, rootMargin: "0px 0px -40px 0px" },
        );
        observer.observe(el);
        return () => observer.disconnect();
    }, []);

    const skillsString =
        content.skills ||
        "English Teaching, Language Instruction, Curriculum Development";
    const skills = skillsString
        .split(",")
        .map((s) => s.trim())
        .filter(Boolean);
    const experience = content.experience || "10+ Years";
    const skillsLabel = content.skills_label || "Areas of Expertise";

    const rawDescription =
        content.description ||
        "With years of dedicated experience in English language education, I'm passionate about helping students achieve fluency and confidence in their English communication skills.";

    const hasHtml = isHtml(rawDescription);
    const plainFull = hasHtml
        ? stripHtmlToText(rawDescription)
        : rawDescription;
    const wordLimit = getWordLimitForWidth(viewportWidth);

    const { isLong, truncatedPlain } = useMemo(() => {
        const words = plainFull.split(/\s+/).filter(Boolean);
        return {
            isLong: words.length > wordLimit,
            truncatedPlain: words.slice(0, wordLimit).join(" "),
        };
    }, [plainFull, wordLimit]);

    const imageUrl =
        content.image ||
        "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=1200&auto=format&fit=crop";

    const mainHeading =
        (content.header_title && String(content.header_title).trim()) ||
        (content.name && String(content.name).trim()) ||
        "Darpon English Teaching Zone";

    const subHeading =
        (content.header_subtitle && String(content.header_subtitle).trim()) ||
        (content.title && String(content.title).trim()) ||
        "Best Spoken English Coaching Centre In Bangladesh";

    const sectionHeadingId = "instructor-section-heading";
    const instructorName = content.name?.trim() || "Darpon Sir";
    const instructorTitle = content.title?.trim() || "Lead English Instructor";
    const ctaLabel = content.cta_label || "Contact Us";

    return (
        <section
            ref={sectionRef}
            aria-labelledby={sectionHeadingId}
            className={`relative overflow-hidden py-12 sm:py-16 lg:py-24 ${isVisible ? "section-visible" : ""}`}
        >
            <SectionBackground variant="a" />

            <Container className="relative z-10">
                <div className="mx-auto max-w-8xl">
                    {/* Section Header */}
                    <div className="section-animate section-animate-delay-1 mb-8 text-center sm:mb-12">
                        {content.header_badge && (
                            <p className="mb-4 inline-flex items-center gap-1.5 rounded-full bg-primary-100 px-3 py-1 text-[11px] font-semibold uppercase tracking-wider text-primary-800 dark:bg-primary-900/50 dark:text-primary-200">
                                {content.header_badge}
                            </p>
                        )}
                        <h2
                            id={sectionHeadingId}
                            className="text-balance text-2xl font-extrabold uppercase leading-tight tracking-wide text-slate-900 dark:text-white sm:text-3xl md:text-4xl"
                        >
                            {mainHeading}
                        </h2>
                        <p className="mx-auto mt-3 max-w-2xl text-pretty text-base font-medium text-primary-600 dark:text-primary-400 sm:text-lg">
                            {subHeading}
                        </p>
                    </div>

                    {/* Vertical Card: Image on top, content below */}
                    <div className="section-animate section-animate-delay-2 group/card">
                        <div className="overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-xl shadow-gray-300/20 transition-all duration-300 hover:shadow-2xl hover:shadow-gray-400/30 dark:border-gray-700/80 dark:bg-gray-900/60 dark:shadow-black/30 sm:rounded-3xl">
                            {/* Image Section - Responsive aspect ratios */}
                            <div className="relative overflow-hidden bg-gray-200 dark:bg-gray-800">
                                {/* Mobile: 4:3, Tablet: 16:9, Desktop: 21:9 (cinematic) */}
                                <div className="aspect-[4/3] w-full sm:aspect-[16/9] lg:aspect-[21/9]">
                                    <img
                                        src={imageUrl}
                                        alt={
                                            instructorName
                                                ? `${instructorName} — teaching at ${mainHeading}`
                                                : `${mainHeading} — instructor photo`
                                        }
                                        className="h-full w-full object-cover object-center transition-transform duration-700 ease-out group-hover/card:scale-[1.02]"
                                        loading="lazy"
                                        decoding="async"
                                        sizes="(max-width: 640px) 100vw, (max-width: 1024px) 90vw, 1200px"
                                    />
                                </div>
                                {/* Optional subtle gradient overlay for depth */}
                                <div className="absolute inset-0 bg-gradient-to-t from-black/10 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover/card:opacity-100" />
                            </div>

                            {/* Content Section */}
                            <div className="p-6 sm:p-8 lg:p-10">
                                {/* Instructor Name & Title */}
                                <div className="mb-5">
                                    <h3 className="text-2xl font-bold text-slate-900 dark:text-white sm:text-3xl">
                                        {instructorName}
                                    </h3>
                                    <div className="mt-2 flex items-center gap-2">
                                        <span className="inline-block h-1 w-8 rounded-full bg-primary-500" />
                                        <p className="text-base font-semibold text-primary-600 dark:text-primary-400">
                                            {instructorTitle}
                                        </p>
                                    </div>
                                </div>

                                {/* Description with Read More */}
                                <div className="mb-6">
                                    {hasHtml && isExpanded ? (
                                        <>
                                            <div
                                                className={HTML_PROSE}
                                                dangerouslySetInnerHTML={{
                                                    __html: rawDescription,
                                                }}
                                            />
                                            {isLong && (
                                                <button
                                                    type="button"
                                                    onClick={() =>
                                                        setIsExpanded(false)
                                                    }
                                                    className="mt-1 inline-flex items-center gap-1 rounded-lg px-2 py-1 text-sm font-semibold text-primary-600 underline-offset-4 transition-colors hover:text-primary-700 hover:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 dark:text-primary-400 dark:hover:text-primary-300"
                                                >
                                                    Show less
                                                    <svg
                                                        className="h-4 w-4"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                        strokeWidth={2}
                                                    >
                                                        <path
                                                            strokeLinecap="round"
                                                            strokeLinejoin="round"
                                                            d="M5 15l7-7 7 7"
                                                        />
                                                    </svg>
                                                </button>
                                            )}
                                        </>
                                    ) : (
                                        <p className="text-pretty text-sm leading-relaxed text-gray-600 dark:text-gray-300 sm:text-base">
                                            {isLong && !isExpanded
                                                ? `${truncatedPlain}… `
                                                : plainFull}
                                            {isLong && (
                                                <button
                                                    type="button"
                                                    onClick={() =>
                                                        setIsExpanded(true)
                                                    }
                                                    className="inline-flex items-center gap-1 rounded-lg px-1 py-0.5 text-sm font-semibold text-primary-600 underline-offset-4 transition-colors hover:text-primary-700 hover:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 dark:text-primary-400 dark:hover:text-primary-300"
                                                >
                                                    Read more
                                                    <svg
                                                        className="h-4 w-4"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                        strokeWidth={2}
                                                    >
                                                        <path
                                                            strokeLinecap="round"
                                                            strokeLinejoin="round"
                                                            d="M19 9l-7 7-7-7"
                                                        />
                                                    </svg>
                                                </button>
                                            )}
                                        </p>
                                    )}
                                </div>

                                {/* CTA Button */}
                                <div className="mt-4 text-center">
                                    <PrimaryButton
                                        href={route("contact")}
                                        showIcon={true}
                                    >
                                        {ctaLabel}
                                    </PrimaryButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Container>
        </section>
    );
}
