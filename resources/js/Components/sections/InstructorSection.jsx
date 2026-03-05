import { useEffect, useRef, useState } from "react";
import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import SectionBackground from "../ui/SectionBackground";
import { usePage } from "@inertiajs/react";

export default function InstructorSection() {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.instructor || {};
    const sectionRef = useRef(null);
    const [isVisible, setIsVisible] = useState(false);

    const skillsString =
        content.skills ||
        "English Teaching, Language Instruction, Curriculum Development";
    const skills = skillsString
        .split(",")
        .map((s) => s.trim())
        .filter(Boolean);
    const experience = content.experience || "10+ Years";

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

    return (
        <section
            ref={sectionRef}
            className={`relative overflow-hidden pt-24 sm:pt-28 pb-12 sm:pb-8 ${isVisible ? "section-visible" : ""}`}
        >
            <SectionBackground variant="a" />

            <Container className="relative z-10">
                {/* Section Header */}
                <div className="section-animate section-animate-delay-1 mb-14 sm:mb-16">
                    <SectionHeader
                        badge={content.header_badge || "Meet Your Instructor"}
                        title={content.header_title || "About the Instructor"}
                        subtitle={
                            content.header_subtitle ||
                            "Learn from an experienced and passionate English language expert"
                        }
                        alignment="center"
                    />
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 xl:gap-20 items-center">
                    {/* Left: Details */}
                    <div className="space-y-8 order-2 lg:order-1">
                        <div className="section-animate section-animate-delay-2">
                            <h3 className="text-3xl sm:text-4xl lg:text-[2.75rem] font-bold text-gray-900 dark:text-white mb-2 tracking-tight">
                                {content.name || "Instructor Name"}
                            </h3>
                            <p className="text-lg sm:text-xl text-primary-600 dark:text-primary-400 font-semibold">
                                {content.title || "Lead English Instructor"}
                            </p>
                        </div>

                        <p className="section-animate section-animate-delay-3 text-gray-700 dark:text-gray-300 leading-relaxed text-base sm:text-lg max-w-xl">
                            {content.description ||
                                "With years of dedicated experience in English language education, I'm passionate about helping students achieve fluency and confidence in their English communication skills."}
                        </p>

                        {/* Skills as pills */}
                        {skills.length > 0 && (
                            <div className="section-animate section-animate-delay-4">
                                <p className="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                                    Expertise
                                </p>
                                <div className="flex flex-wrap gap-2">
                                    {skills.map((skill, i) => (
                                        <span
                                            key={i}
                                            className="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-white dark:bg-gray-800/80 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 shadow-sm hover:border-primary-300 dark:hover:border-primary-700 hover:shadow-md transition-all duration-300"
                                        >
                                            {skill}
                                        </span>
                                    ))}
                                </div>
                            </div>
                        )}

                        {/* Experience card */}
                        {experience && (
                            <div className="section-animate section-animate-delay-5">
                                <div className="flex items-center gap-5 p-5 sm:p-6 rounded-2xl bg-white dark:bg-gray-800/80 border border-gray-200/80 dark:border-gray-700/80 shadow-lg shadow-gray-200/50 dark:shadow-none hover:shadow-xl dark:hover:shadow-none hover:border-primary-200 dark:hover:border-primary-800 transition-all duration-300">
                                    <div className="flex-shrink-0 w-14 h-14 rounded-xl bg-primary-100 dark:bg-primary-900/40 flex items-center justify-center">
                                        <svg
                                            className="w-7 h-7 text-primary-600 dark:text-primary-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
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
                                        <p className="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Experience
                                        </p>
                                        <p className="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-0.5">
                                            {experience}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        )}
                    </div>

                    {/* Right: Image */}
                    <div className="order-1 lg:order-2 flex justify-center lg:justify-end">
                        <div className="section-animate section-animate-delay-6 relative w-full max-w-md">
                            {/* Decorative frame */}
                            <div className="relative rounded-2xl overflow-hidden shadow-2xl shadow-gray-300/50 dark:shadow-black/40 ring-4 ring-white dark:ring-gray-800 ring-offset-4 ring-offset-gray-50 dark:ring-offset-gray-900">
                                <img
                                    src={
                                        content.image ||
                                        "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=800&auto=format&fit=crop"
                                    }
                                    alt={content.name || "Instructor"}
                                    className="w-full h-auto object-cover aspect-[3/4] transition-transform duration-500 hover:scale-105"
                                    loading="lazy"
                                />
                            </div>
                            {/* Optional corner accent */}
                            <div
                                className="absolute -z-10 -bottom-4 -right-4 w-full h-full rounded-2xl bg-gradient-to-br from-primary-200/60 to-primary-100/40 dark:from-primary-900/30 dark:to-primary-950/40"
                                aria-hidden="true"
                            />
                        </div>
                    </div>
                </div>
            </Container>
        </section>
    );
}
