import { useEffect, useRef, useState } from "react";
import { Link, usePage } from "@inertiajs/react";
import Container from "../ui/Container";
import PrimaryButton from "../ui/PrimaryButton";
import SectionBackground from "../ui/SectionBackground";
import FreeClassModal from "@/Components/FreeClassModal";

export default function CTASection() {
    const { frontend_content } = usePage().props;
    const c = frontend_content?.why_choose_us || {};

    const [isVisible, setIsVisible] = useState(false);
    const [modalOpen, setModalOpen] = useState(false);
    const sectionRef = useRef(null);

    useEffect(() => {
        const el = sectionRef.current;
        if (!el) return;
        const observer = new IntersectionObserver(
            ([entry]) => { if (entry.isIntersecting) { setIsVisible(true); observer.disconnect(); } },
            { threshold: 0.15 },
        );
        observer.observe(el);
        return () => observer.disconnect();
    }, []);

    return (
        <>
            <section
                ref={sectionRef}
                className={`relative overflow-hidden py-16 sm:py-20 ${isVisible ? "section-visible" : ""}`}
            >
                <SectionBackground variant="a" />

                <Container className="relative z-10">
                    <div className="mx-auto max-w-2xl text-center">
                        <div className="section-animate section-animate-delay-1 mb-4">
                            <span className="inline-flex items-center gap-1.5 rounded-full bg-primary-50 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-primary-700 dark:bg-primary-900/40 dark:text-primary-200">
                                🎓 Start Today — It's Free
                            </span>
                        </div>
                        <h2 className="section-animate section-animate-delay-2 text-3xl font-extrabold text-gray-900 sm:text-4xl lg:text-5xl dark:text-white">
                            {c.page_cta_title || "Ready to Speak English with Confidence?"}
                        </h2>
                        <p className="section-animate section-animate-delay-3 mx-auto mt-5 max-w-xl text-base leading-relaxed text-gray-600 sm:text-lg dark:text-gray-300">
                            {c.page_cta_subtitle || "Join thousands of students who transformed their English skills. Register for a free class today — no commitment required."}
                        </p>
                        <div className="section-animate section-animate-delay-4 mt-8 flex flex-wrap justify-center gap-4">
                            <PrimaryButton
                                onClick={() => setModalOpen(true)}
                                showIcon={false}
                                className="px-8 py-3.5 text-base font-bold"
                            >
                                {c.btn_free_class_label || "Join Our Free Class"}
                            </PrimaryButton>
                            <Link
                                href={route("courses.index")}
                                className="inline-flex items-center gap-2 rounded-full border-2 border-gray-300 px-8 py-3.5 text-base font-semibold text-gray-700 transition-all hover:border-gray-900 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:border-white dark:hover:bg-white/5"
                            >
                                Browse All Courses
                                <svg className="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </Link>
                        </div>
                    </div>
                </Container>
            </section>

            <FreeClassModal open={modalOpen} onClose={() => setModalOpen(false)} content={c} />
        </>
    );
}
