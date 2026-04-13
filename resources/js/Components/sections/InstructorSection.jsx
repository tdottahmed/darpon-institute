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

                        <div className="section-animate section-animate-delay-3 text-gray-700 dark:text-gray-300 leading-relaxed text-base sm:text-lg max-w-5xl mx-auto relative">
                            {(() => {
                                const desc = content.description || "<p>With years of dedicated experience in English language education, I'm passionate about helping students achieve fluency and confidence in their English communication skills.</p>";
                                const isLongText = desc.length > 500;
                                
                                return (
                                    <>
                                        <div 
                                            className={`prose prose-lg dark:prose-invert max-w-none text-justify transition-all duration-700 overflow-hidden ${isLongText && !isExpanded ? 'max-h-[320px] relative' : 'max-h-[5000px]'}`}
                                        >
                                            <div dangerouslySetInnerHTML={{ __html: desc }} />
                                            {isLongText && !isExpanded && (
                                                <div className="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-gray-50 dark:from-gray-900 to-transparent pointer-events-none" />
                                            )}
                                        </div>
                                        
                                        {isLongText && (
                                            <div className="mt-8 flex justify-center text-center">
                                                <button 
                                                    onClick={() => setIsExpanded(!isExpanded)}
                                                    className="inline-flex items-center text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-semibold hover:underline bg-white/60 dark:bg-gray-800/60 backdrop-blur-md px-6 py-2 rounded-full shadow-sm ring-1 ring-primary-500/20 transition-all active:scale-95"
                                                >
                                                    {isExpanded ? "Show Less" : "Read More..."}
                                                </button>
                                            </div>
                                        )}
                                    </>
                                );
                            })()}
                        </div>
                    </div>
                </div>
            </Container>
        </section>
    );
}
