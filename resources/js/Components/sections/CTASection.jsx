import { useEffect, useRef, useState } from "react";
import { Link, usePage } from "@inertiajs/react";
import Container from "../ui/Container";
import PrimaryButton from "../ui/PrimaryButton";
import FreeClassModal from "@/Components/FreeClassModal";

const BG_PATTERN = `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`;

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
                className={`relative overflow-hidden bg-gradient-to-br from-primary-600 via-primary-700 to-secondary-600 py-16 sm:py-20 dark:from-primary-800 dark:via-primary-900 dark:to-secondary-800 ${isVisible ? "section-visible" : ""}`}
            >
                <div className="absolute inset-0 opacity-10" style={{ backgroundImage: BG_PATTERN }} />
                <div className="absolute -left-24 top-0 h-64 w-64 rounded-full bg-white/5 blur-3xl" />
                <div className="absolute -right-24 bottom-0 h-80 w-80 rounded-full bg-white/5 blur-3xl" />

                <Container className="relative z-10">
                    <div className="mx-auto max-w-2xl text-center">
                        <div className="section-animate section-animate-delay-1 mb-4">
                            <span className="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-white backdrop-blur-sm">
                                🎓 Start Today — It's Free
                            </span>
                        </div>
                        <h2 className="section-animate section-animate-delay-2 text-3xl font-extrabold text-white sm:text-4xl lg:text-5xl">
                            {c.page_cta_title || "Ready to Speak English with Confidence?"}
                        </h2>
                        <p className="section-animate section-animate-delay-3 mx-auto mt-5 max-w-xl text-base leading-relaxed text-white/80 sm:text-lg">
                            {c.page_cta_subtitle || "Join thousands of students who transformed their English skills. Register for a free class today — no commitment required."}
                        </p>
                        <div className="section-animate section-animate-delay-4 mt-8 flex flex-wrap justify-center gap-4">
                            <PrimaryButton
                                onClick={() => setModalOpen(true)}
                                showIcon={false}
                                className="!bg-white !text-primary-700 !shadow-xl hover:!bg-white/90 px-8 py-3.5 text-base font-bold"
                            >
                                {c.btn_free_class_label || "Join Our Free Class"}
                            </PrimaryButton>
                            <Link
                                href={route("courses.index")}
                                className="inline-flex items-center gap-2 rounded-full border-2 border-white/40 px-8 py-3.5 text-base font-semibold text-white transition-all hover:border-white hover:bg-white/10"
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
