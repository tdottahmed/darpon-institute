import { useEffect, useRef, useState } from "react";
import { usePage } from "@inertiajs/react";
import Container from "../ui/Container";
import SectionBackground from "../ui/SectionBackground";
import SectionHeader from "../ui/SectionHeader";
import PrimaryButton from "../ui/PrimaryButton";
import FreeClassModal from "@/Components/FreeClassModal";

const DEFAULT_FEATURES = [
    { icon: "🎯", title: "Expert Instructors",       description: "Learn from certified teachers with 10+ years of experience in English language education." },
    { icon: "📚", title: "Comprehensive Curriculum",  description: "Structured lessons covering speaking, writing, listening and reading skills." },
    { icon: "🏆", title: "Certified Courses",         description: "Earn industry-recognized certificates upon completing your courses." },
    { icon: "💬", title: "Interactive Learning",      description: "Live sessions, group discussions and real-world English practice." },
    { icon: "📱", title: "Learn Anywhere",            description: "Access all course materials on any device, anytime you want." },
    { icon: "🌟", title: "Proven Results",            description: "Over 5000+ students have transformed their English skills with us." },
];

const CARD_COLORS = [
    { iconBg: "bg-primary-100 dark:bg-primary-900/40",    iconText: "text-primary-600 dark:text-primary-300",    accentBar: "bg-primary-500",   checkBg: "bg-primary-50 dark:bg-primary-900/30",    checkText: "text-primary-600 dark:text-primary-400" },
    { iconBg: "bg-secondary-100 dark:bg-secondary-900/40", iconText: "text-secondary-600 dark:text-secondary-300", accentBar: "bg-secondary-500", checkBg: "bg-secondary-50 dark:bg-secondary-900/30", checkText: "text-secondary-600 dark:text-secondary-400" },
    { iconBg: "bg-accent-100 dark:bg-accent-900/40",      iconText: "text-accent-600 dark:text-accent-300",      accentBar: "bg-accent-500",     checkBg: "bg-accent-50 dark:bg-accent-900/30",      checkText: "text-accent-600 dark:text-accent-400" },
    { iconBg: "bg-emerald-100 dark:bg-emerald-900/40",    iconText: "text-emerald-600 dark:text-emerald-300",    accentBar: "bg-emerald-500",   checkBg: "bg-emerald-50 dark:bg-emerald-900/30",    checkText: "text-emerald-600 dark:text-emerald-400" },
    { iconBg: "bg-violet-100 dark:bg-violet-900/40",      iconText: "text-violet-600 dark:text-violet-300",      accentBar: "bg-violet-500",     checkBg: "bg-violet-50 dark:bg-violet-900/30",      checkText: "text-violet-600 dark:text-violet-400" },
    { iconBg: "bg-rose-100 dark:bg-rose-900/40",          iconText: "text-rose-600 dark:text-rose-300",          accentBar: "bg-rose-500",       checkBg: "bg-rose-50 dark:bg-rose-900/30",          checkText: "text-rose-600 dark:text-rose-400" },
];

function FeatureCard({ feature, color, index, isVisible }) {
    return (
        <div
            className="section-card-animate group relative flex flex-col rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-lg dark:border-gray-700/60 dark:bg-gray-800/70"
            style={isVisible ? { animationDelay: `${0.1 + index * 0.08}s` } : undefined}
        >
            <div className={`absolute inset-x-0 top-0 h-1 rounded-t-2xl ${color.accentBar} scale-x-0 transition-transform duration-300 group-hover:scale-x-100`} />
            <div className={`mb-5 flex h-14 w-14 items-center justify-center rounded-2xl text-2xl ${color.iconBg} ${color.iconText} transition-transform duration-300 group-hover:scale-110`}>
                {feature.icon}
            </div>
            <h3 className="mb-2.5 text-lg font-bold text-gray-900 dark:text-white">{feature.title}</h3>
            <p className="flex-1 text-sm leading-relaxed text-gray-600 dark:text-gray-400">{feature.description}</p>
            {/* <div className={`mt-5 flex items-center gap-2 rounded-lg px-3 py-2 ${color.checkBg}`}>
                <svg className={`h-4 w-4 flex-shrink-0 ${color.checkText}`} viewBox="0 0 20 20" fill="currentColor">
                    <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                </svg>
                <span className={`text-xs font-semibold ${color.checkText}`}>Included</span>
            </div> */}
        </div>
    );
}

export default function WhyChooseUsSection() {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.why_choose_us || {};
    const sectionRef = useRef(null);
    const [isVisible, setIsVisible] = useState(false);
    const [modalOpen, setModalOpen] = useState(false);

    useEffect(() => {
        const el = sectionRef.current;
        if (!el) return;
        const observer = new IntersectionObserver(
            ([entry]) => { if (entry.isIntersecting) setIsVisible(true); },
            { threshold: 0.08, rootMargin: "0px 0px -40px 0px" },
        );
        observer.observe(el);
        return () => observer.disconnect();
    }, []);

    const features = DEFAULT_FEATURES.map((def, i) => ({
        icon:        content[`feature_${i + 1}_icon`]        || def.icon,
        title:       content[`feature_${i + 1}_title`]       || def.title,
        description: content[`feature_${i + 1}_description`] || def.description,
    }));

    return (
        <>
            <section
                ref={sectionRef}
                className={`relative overflow-hidden py-14 sm:py-20 lg:py-28 ${isVisible ? "section-visible" : ""}`}
            >
                <SectionBackground variant="b" />
                <Container className="relative z-10">
                    <div className="section-animate section-animate-delay-1 mb-12 sm:mb-16">
                        <SectionHeader
                            badge={content.section_badge || "Why Choose Us"}
                            title={content.section_title || "The Best Place to Learn English"}
                            subtitle={content.section_subtitle || "We combine expert teaching, modern methods and a supportive community to help you achieve real English fluency."}
                            alignment="center"
                        />
                    </div>
                    <div className="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        {features.map((feature, index) => (
                            <FeatureCard key={index} feature={feature} color={CARD_COLORS[index % CARD_COLORS.length]} index={index} isVisible={isVisible} />
                        ))}
                    </div>
                    <div className="section-animate section-animate-delay-6 mt-12 flex justify-center">
                        <PrimaryButton onClick={() => setModalOpen(true)} className="px-8 py-3.5 text-base shadow-lg shadow-primary-500/30">
                            {content.btn_free_class_label || "Join Our Free Class"}
                        </PrimaryButton>
                    </div>
                </Container>
            </section>

            <FreeClassModal open={modalOpen} onClose={() => setModalOpen(false)} content={content} />
        </>
    );
}
