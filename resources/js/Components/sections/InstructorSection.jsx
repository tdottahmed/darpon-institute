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

                        <div className="section-animate section-animate-delay-3 text-gray-700 dark:text-gray-300 leading-relaxed text-base sm:text-lg max-w-4xl mx-auto">
                            <p className="text-justify whitespace-pre-line">
                                {(() => {
                                    const desc = content.description || "With years of dedicated experience in English language education, I'm passionate about helping students achieve fluency and confidence in their English communication skills.";
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

                        {/* Skills as pills */}
                        {/* {skills.length > 0 && (
                            <div className="section-animate section-animate-delay-4 flex flex-col items-center">
                                <p className="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 text-center">
                                    Expertise
                                </p>
                                <div className="flex flex-wrap justify-center gap-2">
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
                        )} */}

                        {/* Experience card */}
                        {/* {experience && (
                            <div className="section-animate section-animate-delay-5 flex justify-center">
                                <div className="flex items-center gap-5 p-5 sm:p-6 rounded-2xl bg-white dark:bg-gray-800/80 border border-gray-200/80 dark:border-gray-700/80 shadow-lg shadow-gray-200/50 dark:shadow-none hover:shadow-xl dark:hover:shadow-none hover:border-primary-200 dark:hover:border-primary-800 transition-all duration-300 w-fit">
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
                        )} */}
                    </div>
                </div>
            </Container>
        </section>
    );
}
