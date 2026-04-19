import { useEffect, useRef, useState } from "react";
import Container from "../ui/Container";
import SectionBackground from "../ui/SectionBackground";
import PrimaryButton from "../ui/PrimaryButton";
import { usePage, Link } from "@inertiajs/react";

const WORD_LIMIT_MOBILE = 60;
const WORD_LIMIT_DESKTOP = 120;

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
    const [isMobile, setIsMobile] = useState(false);

    useEffect(() => {
        const check = () => setIsMobile(window.innerWidth < 1024);
        check();
        window.addEventListener("resize", check);
        return () => window.removeEventListener("resize", check);
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

    const rawDescription =
        content.description ||
        "With years of dedicated experience in English language education, I'm passionate about helping students achieve fluency and confidence in their English communication skills.";

    const hasHtml = isHtml(rawDescription);
    const plainFull = hasHtml
        ? stripHtmlToText(rawDescription)
        : rawDescription;
    const plainWords = plainFull.split(/\s+/).filter(Boolean);
    const wordLimit = isMobile ? WORD_LIMIT_MOBILE : WORD_LIMIT_DESKTOP;
    const isLong = plainWords.length > wordLimit;
    const truncatedPlain = plainWords.slice(0, wordLimit).join(" ");

    const imageUrl =
        content.image ||
        "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=800&auto=format&fit=crop";

    return (
        <section
            ref={sectionRef}
            className={`relative overflow-hidden py-12 sm:py-16 lg:py-24 ${isVisible ? "section-visible" : ""}`}
        >
            <SectionBackground variant="a" />

            <Container className="relative z-10">
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-10 lg:gap-16 items-center max-w-6xl mx-auto">
                    {/* ── Image ── */}
                    <div className="section-animate section-animate-delay-1 order-1 lg:order-2">
                        <div className="relative mx-auto max-w-sm sm:max-w-sm lg:max-w-none">
                            {/* Blob */}
                            <div
                                className="absolute -inset-3 sm:-inset-4 rounded-3xl bg-gradient-to-br from-primary-200/60 to-secondary-200/40 dark:from-primary-900/40 dark:to-secondary-900/30 blur-2xl"
                                aria-hidden="true"
                            />
                            {/* Offset border — desktop only */}
                            <div
                                className="hidden sm:block absolute -bottom-2.5 -right-2.5 lg:-bottom-3 lg:-right-3 w-full h-full rounded-2xl border-2 border-primary-200 dark:border-primary-800/50"
                                aria-hidden="true"
                            />

                            <div className="relative rounded-2xl overflow-hidden shadow-xl shadow-gray-300/30 dark:shadow-black/50 ring-2 sm:ring-4 ring-white dark:ring-gray-800">
                                <img
                                    src={imageUrl}
                                    alt={content.name || "Instructor"}
                                    className="w-full aspect-[3/4] sm:aspect-[4/3] lg:aspect-[4/5] object-cover object-top transition-transform duration-700 hover:scale-105"
                                    loading="lazy"
                                />
                                {/* Bottom gradient + badge */}
                                <div className="absolute inset-x-0 bottom-0 h-20 sm:h-28 bg-gradient-to-t from-black/60 to-transparent" />
                                <div className="absolute bottom-3 left-3 sm:bottom-5 sm:left-5 flex items-center gap-2 sm:gap-2.5 bg-white dark:bg-gray-900 rounded-xl px-3 py-2 sm:px-4 sm:py-2.5 shadow-lg">
                                    <div className="flex h-7 w-7 sm:h-9 sm:w-9 flex-shrink-0 items-center justify-center rounded-full bg-primary-100 dark:bg-primary-900/40">
                                        <svg
                                            className="w-3.5 h-3.5 sm:w-4 sm:h-4 text-primary-600 dark:text-primary-400"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                strokeWidth={2}
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                            />
                                        </svg>
                                    </div>
                                    <div>
                                        <p className="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400 leading-none">
                                            Experience
                                        </p>
                                        <p className="text-xs sm:text-sm font-bold text-gray-900 dark:text-white leading-tight mt-0.5">
                                            {experience}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* ── Content ── */}
                    <div className="order-2 lg:order-1 space-y-5 sm:space-y-6">
                        {/* Badge */}
                        <div className="section-animate section-animate-delay-1">
                            <span className="inline-flex items-center gap-1.5 rounded-full bg-primary-100 dark:bg-primary-900/40 px-3 sm:px-4 py-1 sm:py-1.5 text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-primary-700 dark:text-primary-300">
                                <svg
                                    className="w-3 h-3 sm:w-3.5 sm:h-3.5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                                {content.header_badge || "Meet the Instructor"}
                            </span>
                        </div>

                        {/* Name & Title */}
                        <div className="section-animate section-animate-delay-2">
                            <h2 className="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight leading-tight mb-1.5 sm:mb-2">
                                {content.name || "Instructor Name"}
                            </h2>
                            <p className="text-base sm:text-lg font-semibold text-primary-600 dark:text-primary-400">
                                {content.title || "Lead English Instructor"}
                            </p>
                        </div>

                        {/* Description */}
                        <div className="section-animate section-animate-delay-3">
                            {hasHtml && isExpanded ? (
                                <div
                                    className={HTML_PROSE}
                                    dangerouslySetInnerHTML={{
                                        __html: rawDescription,
                                    }}
                                />
                            ) : (
                                <p className="text-gray-700 dark:text-gray-300 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                                    {isLong && !isExpanded
                                        ? truncatedPlain + "…"
                                        : plainFull}
                                </p>
                            )}

                            {isLong && (
                                <button
                                    onClick={() => setIsExpanded(!isExpanded)}
                                    className="mt-2 inline-flex items-center gap-1 text-sm font-semibold text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 hover:underline transition-colors"
                                >
                                    {isExpanded ? (
                                        <>
                                            Show Less{" "}
                                            <span aria-hidden="true">↑</span>
                                        </>
                                    ) : (
                                        <>
                                            Read More{" "}
                                            <span aria-hidden="true">↓</span>
                                        </>
                                    )}
                                </button>
                            )}
                        </div>

                        {/* Skills */}
                        {skills.length > 0 && (
                            <div className="section-animate section-animate-delay-4">
                                <p className="text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 sm:mb-3">
                                    Areas of Expertise
                                </p>
                                <div className="flex flex-wrap gap-1.5 sm:gap-2">
                                    {skills.map((skill) => (
                                        <span
                                            key={skill}
                                            className="inline-flex items-center gap-1 sm:gap-1.5 rounded-full bg-gray-100 dark:bg-gray-700/60 border border-gray-200 dark:border-gray-600 px-2.5 sm:px-3 py-0.5 sm:py-1 text-[11px] sm:text-xs font-medium text-gray-700 dark:text-gray-300"
                                        >
                                            <span className="w-1 h-1 sm:w-1.5 sm:h-1.5 rounded-full bg-primary-500 flex-shrink-0" />
                                            {skill}
                                        </span>
                                    ))}
                                </div>
                            </div>
                        )}

                        {/* CTA */}
                        <div className="section-animate w-full flex flex-wrap items-center gap-3 pt-1 sm:pt-2">
                            <PrimaryButton
                                href={route("contact")}
                                showIcon={true}
                            >
                                {content.cta_label || "Contact Us"}
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </Container>
        </section>
    );
}
