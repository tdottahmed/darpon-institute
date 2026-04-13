import { useEffect, useRef, useState } from "react";
import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import SectionBackground from "../ui/SectionBackground";
import TeacherCard from "../cards/TeacherCard";
import SecondaryButton from "../ui/SecondaryButton";
import { usePage } from "@inertiajs/react";

export default function TeamSection({ teachers = [] }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.team || {};
    const sectionRef = useRef(null);
    const [isVisible, setIsVisible] = useState(false);

    useEffect(() => {
        const el = sectionRef.current;
        if (!el) return;
        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) setIsVisible(true);
            },
            { threshold: 0.08, rootMargin: "0px 0px -20px 0px" },
        );
        observer.observe(el);
        return () => observer.disconnect();
    }, []);

    if (!teachers || teachers.length === 0) return null;

    return (
        <section
            ref={sectionRef}
            className={`relative overflow-hidden py-12 sm:py-8 lg:py-12 ${isVisible ? "section-visible" : ""}`}
        >
            <SectionBackground variant="b" />

            <Container className="relative z-10">
                <div className="section-animate section-animate-delay-1 mb-10 sm:mb-12 lg:mb-16">
                    <SectionHeader
                        badge={content.header_badge || "Our Team"}
                        title={
                            content.header_title ||
                            "Meet Our Expert Instructors"
                        }
                        subtitle={
                            content.header_subtitle ||
                            "Learn from the best educators dedicated to your success"
                        }
                        alignment="center"
                    />
                </div>

                <div className="grid grid-cols-1 gap-6 sm:gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    {teachers.map((teacher, index) => (
                        <div
                            key={teacher.id}
                            className="section-card-animate"
                            style={
                                isVisible
                                    ? {
                                          animationDelay: `${0.12 + index * 0.07}s`,
                                      }
                                    : undefined
                            }
                        >
                            <TeacherCard teacher={teacher} />
                        </div>
                    ))}
                </div>

                <div className="section-animate section-animate-delay-2 text-center mt-10 sm:mt-12">
                    <SecondaryButton href={route("instructors.index")}>
                        {content.view_all_link || "View All Instructors"}
                    </SecondaryButton>
                </div>
            </Container>
        </section>
    );
}
