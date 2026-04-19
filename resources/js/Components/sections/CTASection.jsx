import { useEffect, useRef, useState } from "react";
import Container from "../ui/Container";
import PrimaryButton from "../ui/PrimaryButton";
import SecondaryButton from "../ui/SecondaryButton";
import Badge from "../ui/Badge";
import SectionBackground from "../ui/SectionBackground";
import { usePage } from "@inertiajs/react";

export default function CTASection({ translations }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.cta || {};
    const t = translations?.common || {};
    const sectionRef = useRef(null);
    const [isVisible, setIsVisible] = useState(false);

    useEffect(() => {
        const el = sectionRef.current;
        if (!el) return;
        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) setIsVisible(true);
            },
            { threshold: 0.1 },
        );
        observer.observe(el);
        return () => observer.disconnect();
    }, []);

    return (
        <section
            ref={sectionRef}
            className={`relative overflow-hidden py-8 sm:py-12 lg:py-16 ${isVisible ? "section-visible" : ""}`}
        >
            <SectionBackground variant="b" />

            <Container className="relative z-10">
                <div className="max-w-4xl mx-auto text-center">
                    {/* Badge */}
                    <div className="section-animate section-animate-delay-1 mb-6">
                        <Badge
                            variant="primary"
                            icon={
                                <svg
                                    className="w-3 h-3"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            }
                            className="text-xs font-semibold uppercase tracking-widest px-4 py-1.5 gap-1.5"
                        >
                            {content.badge || "Start Learning Today"}
                        </Badge>
                    </div>

                    {/* Heading */}
                    <div className="section-animate section-animate-delay-2 mb-6">
                        <h2 className="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white leading-tight">
                            {content.title ? (
                                content.title
                            ) : (
                                <>
                                    Ready to Start Your{" "}
                                    <span className="relative inline-block">
                                        <span className="relative z-10 text-primary-600 dark:text-primary-400">
                                            English Journey?
                                        </span>
                                        <span className="absolute bottom-1 left-0 w-full h-3 bg-secondary-300/50 dark:bg-secondary-500/30 -rotate-1 rounded-sm" />
                                    </span>
                                </>
                            )}
                        </h2>
                    </div>

                    {/* Subtitle */}
                    <div className="section-animate section-animate-delay-3 mb-10">
                        <p className="text-lg sm:text-xl text-gray-600 dark:text-gray-300 leading-relaxed max-w-2xl mx-auto">
                            {content.subtitle ||
                                "Join thousands of students already learning with us. Get started today and transform your English skills!"}
                        </p>
                    </div>

                    {/* Buttons */}
                    <div className="section-animate section-animate-delay-5 flex flex-col sm:flex-row gap-4 justify-center">
                        <PrimaryButton href={route("courses.index")}>
                            {content.btn_primary ||
                                t.register ||
                                "Get Started Free"}
                        </PrimaryButton>
                        <SecondaryButton href={route("login")} showIcon={true}>
                            {content.btn_outline || t.login || "Log In"}
                        </SecondaryButton>
                    </div>
                </div>
            </Container>
        </section>
    );
}
