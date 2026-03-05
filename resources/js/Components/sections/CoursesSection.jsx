import { useEffect, useRef, useState } from "react";
import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import SectionBackground from "../ui/SectionBackground";
import CourseCard from "../courses/CourseCard";
import Button from "../ui/Button";
import { usePage } from "@inertiajs/react";

const SECTION_PADDING = "py-16 sm:py-20 lg:py-28";

export default function CoursesSection({ courses = [] }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.courses || {};
    const displayedCourses = courses.slice(0, 6);
    const sectionRef = useRef(null);
    const [isVisible, setIsVisible] = useState(false);

    useEffect(() => {
        const el = sectionRef.current;
        if (!el) return;
        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) setIsVisible(true);
            },
            { threshold: 0.08, rootMargin: "0px 0px -20px 0px" }
        );
        observer.observe(el);
        return () => observer.disconnect();
    }, []);

    return (
        <section
            ref={sectionRef}
            className={`py-8 sm:py-4 lg:py-8 relative overflow-hidden ${SECTION_PADDING} ${isVisible ? "section-visible" : ""}`}
        >
            <SectionBackground variant="a" />
            <Container className="relative z-10">
                <div className="section-animate section-animate-delay-1 mb-10 sm:mb-12 lg:mb-16">
                    <SectionHeader
                        badge={content.header_badge || "Courses"}
                        title={content.header_title || "Featured Courses"}
                        subtitle={
                            content.header_subtitle ||
                            "Discover our most popular English learning courses designed to help you achieve fluency"
                        }
                        alignment="center"
                    />
                </div>

                {displayedCourses.length > 0 ? (
                    <>
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-10 sm:mb-12">
                            {displayedCourses.map((course, index) => (
                                <div
                                    key={course.id}
                                    className="section-card-animate"
                                    style={
                                        isVisible
                                            ? {
                                                  animationDelay: `${0.12 + index * 0.07}s`,
                                              }
                                            : undefined
                                    }
                                >
                                    <CourseCard course={course} />
                                </div>
                            ))}
                        </div>
                        <div className="section-animate section-animate-delay-2 text-center">
                            <Button
                                href="/courses"
                                variant="primary"
                                size="lg"
                                className="px-8 py-3"
                            >
                                {content.view_all_btn || "View All Courses"}
                            </Button>
                        </div>
                    </>
                ) : (
                    <div className="section-animate section-animate-delay-2 text-center py-8 sm:py-8 md:py-12">
                        <div className="inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary-100 dark:bg-primary-900/30 mb-6">
                            <svg
                                className="w-10 h-10 text-primary-600 dark:text-primary-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                />
                            </svg>
                        </div>
                        <h3 className="text-2xl font-bold text-gray-900 dark:text-white mb-3">
                            No courses available yet
                        </h3>
                        <p className="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                            Check back soon for exciting new courses!
                        </p>
                    </div>
                )}
            </Container>
        </section>
    );
}
