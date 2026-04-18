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
    const [isExpanded, setIsExpanded] = useState(false);

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
            className={`relative overflow-hidden py-8 sm:py-4 lg:py-8 ${isVisible ? "section-visible" : ""}`}>
            <SectionBackground variant="a" />

            <Container className="relative z-10">
                {/* Section Header */}
                {/* <div className="section-animate section-animate-delay-1 mb-14 sm:mb-16">
                    <SectionHeader
                        badge={content.header_badge || "Meet Your Instructor"}
                        title={content.header_title || "About the Instructor"}
                        subtitle={
                            content.header_subtitle ||
                            "Learn from an experienced and passionate English language expert"
                        }
                        alignment="center"
                    />
                </div> */}

                <div className="w-full">
                    {/* Details */}
                    <div className="space-y-8 m-8">
                        <div className="section-animate section-animate-delay-2 text-center">
                            <h3 className="text-3xl sm:text-4xl lg:text-[2.75rem] font-bold text-gray-900 dark:text-white mb-2 tracking-tight">
                                {content.name || "Instructor Name"}
                            </h3>
                            <p className="text-lg sm:text-xl text-primary-600 dark:text-primary-400 font-semibold">
                                {content.title || "Lead English Instructor"}
                            </p>
                        </div>

                        {/* center: Image */}
                        <div className="order-1 lg:order-2 flex justify-center">
                            <div className="section-animate section-animate-delay-6 relative w-full max-w-8xl">
                                {/* Decorative frame */}
                                <div className="relative rounded-2xl overflow-hidden shadow-2xl shadow-gray-300/50 dark:shadow-black/40 ring-4 ring-white dark:ring-gray-800 ring-offset-4 ring-offset-gray-50 dark:ring-offset-gray-900">
                                    <img
                                        src={
                                            content.image ||
                                            "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=800&auto=format&fit=crop"
                                        }
                                        alt={content.name || "Instructor"}
                                        className="w-full h-[500px] object-cover transition-transform duration-500 hover:scale-105"
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

                        <div className="section-animate section-animate-delay-3 text-gray-700 dark:text-gray-300 leading-relaxed text-base sm:text-lg max-w-8xl mx-auto">
                            <p className="text-justify whitespace-pre-line">
                                {(() => {
                                    const rawDesc = content.description || "With years of dedicated experience in English language education, I'm passionate about helping students achieve fluency and confidence in their English communication skills.";
                                    const desc = rawDesc.replace(/<\/p>/gi, '\n\n').replace(/<br\s*\/?>/gi, '\n').replace(/<[^>]*>?/gm, '').trim();
                                    const words = desc.split(/\s+/);
                                    const isLongText = words.length > 150;

                                    if (!isLongText) return desc;

                                    return (
                                        <>
                                            {isExpanded ? desc : words.slice(0, 150).join(" ") + "... "}
                                            <button
                                                onClick={() => setIsExpanded(!isExpanded)}
                                                className="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-semibold hover:underline ml-1 inline"
                                            >
                                                {isExpanded ? "Show Less" : "Read More..."}
                                            </button>
                                        </>
                                    );
                                })()}
                            </p>
                        </div>
                    </div>
                </div>
            </Container>
        </section>
    );
}
