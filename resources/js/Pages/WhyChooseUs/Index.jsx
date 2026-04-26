import { useEffect, useRef, useState } from "react";
import { Head, Link, usePage } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import SectionBackground from "@/Components/ui/SectionBackground";
import SectionHeader from "@/Components/ui/SectionHeader";
import PrimaryButton from "@/Components/ui/PrimaryButton";
import FreeClassModal from "@/Components/FreeClassModal";
import { useCountUp } from "@/hooks/useCountUp";

// ─── constants ───────────────────────────────────────────────────────────────

const CARD_COLORS = [
    { iconBg: "bg-primary-100 dark:bg-primary-900/40",    iconText: "text-primary-600 dark:text-primary-300",    border: "border-primary-200 dark:border-primary-800/40",   check: "text-primary-500" },
    { iconBg: "bg-secondary-100 dark:bg-secondary-900/40", iconText: "text-secondary-600 dark:text-secondary-300", border: "border-secondary-200 dark:border-secondary-800/40", check: "text-secondary-500" },
    { iconBg: "bg-accent-100 dark:bg-accent-900/40",      iconText: "text-accent-600 dark:text-accent-300",      border: "border-accent-200 dark:border-accent-800/40",       check: "text-accent-500" },
    { iconBg: "bg-emerald-100 dark:bg-emerald-900/40",    iconText: "text-emerald-600 dark:text-emerald-300",    border: "border-emerald-200 dark:border-emerald-800/40",     check: "text-emerald-500" },
    { iconBg: "bg-violet-100 dark:bg-violet-900/40",      iconText: "text-violet-600 dark:text-violet-300",      border: "border-violet-200 dark:border-violet-800/40",       check: "text-violet-500" },
    { iconBg: "bg-rose-100 dark:bg-rose-900/40",          iconText: "text-rose-600 dark:text-rose-300",          border: "border-rose-200 dark:border-rose-800/40",           check: "text-rose-500" },
];

const DEFAULT_FEATURES = [
    { icon: "🎯", title: "Expert Instructors",       description: "Learn from certified teachers with 10+ years of proven experience in English education." },
    { icon: "📚", title: "Comprehensive Curriculum",  description: "Structured lessons covering speaking, writing, listening and reading from beginner to advanced." },
    { icon: "🏆", title: "Certified Courses",         description: "Earn industry-recognized certificates that open doors in careers and higher education." },
    { icon: "💬", title: "Interactive Learning",      description: "Live sessions, group discussions and real-world practice scenarios that build true fluency." },
    { icon: "📱", title: "Learn Anywhere",            description: "Access all course materials on any device — phone, tablet or computer — anytime you want." },
    { icon: "🌟", title: "Proven Results",            description: "Over 5000+ students have transformed their English communication skills with us." },
];

const DEFAULT_STEPS = [
    { icon: "🔍", title: "Assess Your Level",         description: "We evaluate your current English skills through a comprehensive test to understand exactly where you are." },
    { icon: "🗺️", title: "Personalized Learning Plan", description: "Based on your results, we craft a custom curriculum aligned to your goals — career, exam, or daily use." },
    { icon: "💪", title: "Active Daily Practice",      description: "Engage in structured exercises, live speaking sessions and interactive lessons that accelerate progress." },
    { icon: "🎓", title: "Achieve & Get Certified",    description: "Complete your course, receive a recognized certificate and step into the world with real English confidence." },
];

const DEFAULT_OUTCOMES = [
    "Speak confidently in meetings & interviews",
    "Write professional emails & reports",
    "Pass IELTS / TOEFL with high scores",
    "Communicate with native speakers fluently",
    "Watch & understand English media without subtitles",
    "Build an extensive vocabulary rapidly",
    "Master professional English pronunciation",
    "Use English naturally in everyday life",
];

const DEFAULT_DIFF = [
    {
        icon: "🎯",
        title: "Hyper-personalized Learning",
        description: "Unlike generic classrooms that teach everyone the same way, we build a unique roadmap for every student's goals, pace, and learning style.",
        points: ["Individual skill gap analysis", "Custom homework & exercises", "Progress tracked every week"],
    },
    {
        icon: "🌐",
        title: "Real-world English Focus",
        description: "Every lesson is built around real communication situations — not textbook grammar. You learn the English people actually use.",
        points: ["Business & professional scenarios", "Social conversation practice", "Media, culture & idioms"],
    },
    {
        icon: "🤝",
        title: "Community & Lifetime Support",
        description: "You're never learning alone. Our active community, alumni network and instructor support stay with you long after the course ends.",
        points: ["Private student community", "Monthly alumni sessions", "Dedicated instructor access"],
    },
];

// ─── sub-components ──────────────────────────────────────────────────────────

function StatCounter({ value, label, isVisible }) {
    const display = useCountUp(value, isVisible, 1800);
    return (
        <div className="text-center">
            <div className="text-4xl font-black tracking-tight text-white sm:text-5xl tabular-nums">{display}</div>
            <div className="mt-2 text-sm font-medium text-white/70 sm:text-base">{label}</div>
        </div>
    );
}

function FeatureCard({ feature, color, index, isVisible }) {
    return (
        <div
            className={`section-card-animate group flex flex-col rounded-2xl border bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md dark:bg-gray-800/70 ${color.border}`}
            style={isVisible ? { animationDelay: `${0.08 + index * 0.07}s` } : undefined}
        >
            <div className={`mb-4 inline-flex h-14 w-14 items-center justify-center rounded-2xl text-2xl ${color.iconBg} ${color.iconText} transition-transform duration-300 group-hover:scale-110`}>
                {feature.icon}
            </div>
            <h3 className="mb-2 text-lg font-bold text-gray-900 dark:text-white">{feature.title}</h3>
            <p className="flex-1 text-sm leading-relaxed text-gray-600 dark:text-gray-400">{feature.description}</p>
            <div className={`mt-4 flex items-center gap-1.5 text-xs font-semibold ${color.check}`}>
                <svg className="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                </svg>
                Included in all plans
            </div>
        </div>
    );
}

function StepCard({ step, index, isVisible }) {
    const colors = ["from-primary-500 to-primary-700", "from-secondary-500 to-secondary-700", "from-accent-500 to-accent-700", "from-emerald-500 to-emerald-700"];
    const gradient = colors[index % colors.length];

    return (
        <div
            className="section-card-animate group relative"
            style={isVisible ? { animationDelay: `${0.1 + index * 0.1}s` } : undefined}
        >
            {/* connector line (hidden on last) */}
            {index < 3 && (
                <div className="absolute left-1/2 top-14 z-0 hidden h-0.5 w-full -translate-y-1/2 bg-gradient-to-r from-gray-200 to-gray-100 dark:from-gray-700 dark:to-gray-800 lg:block" style={{ left: "50%", width: "100%" }} />
            )}

            <div className="relative z-10 flex flex-col items-center text-center">
                {/* Step number circle */}
                <div className={`relative mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br ${gradient} shadow-lg ring-4 ring-white dark:ring-gray-900`}>
                    <span className="text-2xl">{step.icon}</span>
                    <span className="absolute -right-1 -top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white text-xs font-black text-gray-800 shadow-md dark:bg-gray-900 dark:text-white">
                        {index + 1}
                    </span>
                </div>
                <h3 className="mb-2 text-base font-bold text-gray-900 dark:text-white sm:text-lg">{step.title}</h3>
                <p className="text-sm leading-relaxed text-gray-600 dark:text-gray-400">{step.description}</p>
            </div>
        </div>
    );
}

function OutcomeChip({ text, index, isVisible }) {
    const colorSets = [
        "bg-primary-50 border-primary-200 text-primary-700 dark:bg-primary-900/30 dark:border-primary-700/50 dark:text-primary-300",
        "bg-secondary-50 border-secondary-200 text-secondary-700 dark:bg-secondary-900/30 dark:border-secondary-700/50 dark:text-secondary-300",
        "bg-emerald-50 border-emerald-200 text-emerald-700 dark:bg-emerald-900/30 dark:border-emerald-700/50 dark:text-emerald-300",
        "bg-violet-50 border-violet-200 text-violet-700 dark:bg-violet-900/30 dark:border-violet-700/50 dark:text-violet-300",
        "bg-amber-50 border-amber-200 text-amber-700 dark:bg-amber-900/30 dark:border-amber-700/50 dark:text-amber-300",
        "bg-rose-50 border-rose-200 text-rose-700 dark:bg-rose-900/30 dark:border-rose-700/50 dark:text-rose-300",
        "bg-cyan-50 border-cyan-200 text-cyan-700 dark:bg-cyan-900/30 dark:border-cyan-700/50 dark:text-cyan-300",
        "bg-orange-50 border-orange-200 text-orange-700 dark:bg-orange-900/30 dark:border-orange-700/50 dark:text-orange-300",
    ];
    return (
        <div
            className={`section-card-animate flex items-center gap-3 rounded-xl border px-4 py-3.5 text-sm font-semibold transition-all duration-200 hover:-translate-y-0.5 hover:shadow-sm ${colorSets[index % colorSets.length]}`}
            style={isVisible ? { animationDelay: `${0.05 + index * 0.06}s` } : undefined}
        >
            <svg className="h-4 w-4 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
            </svg>
            {text}
        </div>
    );
}

function DiffCard({ item, index, isVisible }) {
    return (
        <div
            className="section-card-animate group flex flex-col rounded-2xl border border-gray-100 bg-white p-8 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-lg dark:border-gray-700/60 dark:bg-gray-800/70"
            style={isVisible ? { animationDelay: `${0.1 + index * 0.12}s` } : undefined}
        >
            <div className="mb-5 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-primary-50 text-3xl dark:bg-primary-900/30 transition-transform duration-300 group-hover:scale-110">
                {item.icon}
            </div>
            <h3 className="mb-3 text-xl font-bold text-gray-900 dark:text-white">{item.title}</h3>
            <p className="mb-6 text-sm leading-relaxed text-gray-600 dark:text-gray-400">{item.description}</p>
            <ul className="mt-auto space-y-2.5">
                {item.points.map((pt, i) => (
                    <li key={i} className="flex items-center gap-2.5 text-sm text-gray-700 dark:text-gray-300">
                        <span className="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-primary-100 dark:bg-primary-900/40">
                            <svg className="h-3 w-3 text-primary-600 dark:text-primary-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                            </svg>
                        </span>
                        {pt}
                    </li>
                ))}
            </ul>
        </div>
    );
}

// ─── page ─────────────────────────────────────────────────────────────────────

export default function WhyChooseUsIndex() {
    const { frontend_content } = usePage().props;
    const c = frontend_content?.why_choose_us || {};

    const [modalOpen, setModalOpen] = useState(false);

    // section visibility refs
    const heroRef    = useRef(null);
    const featRef    = useRef(null);
    const stepsRef   = useRef(null);
    const outRef     = useRef(null);
    const statsRef   = useRef(null);
    const diffRef    = useRef(null);
    const ctaRef     = useRef(null);

    const [heroVis,  setHeroVis]  = useState(false);
    const [featVis,  setFeatVis]  = useState(false);
    const [stepsVis, setStepsVis] = useState(false);
    const [outVis,   setOutVis]   = useState(false);
    const [statsVis, setStatsVis] = useState(false);
    const [diffVis,  setDiffVis]  = useState(false);
    const [ctaVis,   setCtaVis]   = useState(false);

    useEffect(() => {
        const pairs = [
            [heroRef,  setHeroVis],
            [featRef,  setFeatVis],
            [stepsRef, setStepsVis],
            [outRef,   setOutVis],
            [statsRef, setStatsVis],
            [diffRef,  setDiffVis],
            [ctaRef,   setCtaVis],
        ];
        const observers = pairs.map(([ref, setter]) => {
            const obs = new IntersectionObserver(
                ([e]) => { if (e.isIntersecting) setter(true); },
                { threshold: 0.08, rootMargin: "0px 0px -40px 0px" },
            );
            if (ref.current) obs.observe(ref.current);
            return obs;
        });
        return () => observers.forEach(o => o.disconnect());
    }, []);

    // Resolve features
    const features = DEFAULT_FEATURES.map((d, i) => ({
        icon:        c[`feature_${i + 1}_icon`]        || d.icon,
        title:       c[`feature_${i + 1}_title`]       || d.title,
        description: c[`feature_${i + 1}_description`] || d.description,
    }));

    // Resolve steps
    const steps = DEFAULT_STEPS.map((d, i) => ({
        icon:        c[`step_${i + 1}_icon`]        || d.icon,
        title:       c[`step_${i + 1}_title`]       || d.title,
        description: c[`step_${i + 1}_description`] || d.description,
    }));

    // Resolve outcomes
    const outcomes = DEFAULT_OUTCOMES.map((d, i) => c[`outcome_${i + 1}_text`] || d);

    // Resolve differentiators
    const diffs = DEFAULT_DIFF.map((d, i) => ({
        icon:        c[`diff_${i + 1}_icon`]        || d.icon,
        title:       c[`diff_${i + 1}_title`]       || d.title,
        description: c[`diff_${i + 1}_description`] || d.description,
        points:      [
            c[`diff_${i + 1}_point_1`] || d.points[0],
            c[`diff_${i + 1}_point_2`] || d.points[1],
            c[`diff_${i + 1}_point_3`] || d.points[2],
        ],
    }));

    const stats = [
        { value: c.page_stat_1_value || "5000+", label: c.page_stat_1_label || "Students Taught" },
        { value: c.page_stat_2_value || "10+",   label: c.page_stat_2_label || "Years of Excellence" },
        { value: c.page_stat_3_value || "98%",   label: c.page_stat_3_label || "Student Success Rate" },
        { value: c.page_stat_4_value || "50+",   label: c.page_stat_4_label || "Expert Courses" },
    ];

    const BG_PATTERN = `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`;

    return (
        <>
            <Head title={`${c.page_hero_title || "Why Choose Us"} — Darpon English`} />
            <div className="min-h-screen bg-white dark:bg-gray-900">
                <Header />
                <main>

                    {/* ══════════════════════════════════════════════════════
                        1. HERO
                    ══════════════════════════════════════════════════════ */}
                    <section
                        ref={heroRef}
                        className={`relative overflow-hidden bg-gradient-to-br from-primary-600 via-primary-700 to-secondary-600 py-16 sm:py-20 lg:py-28 dark:from-primary-800 dark:via-primary-900 dark:to-secondary-800 ${heroVis ? "section-visible" : ""}`}
                    >
                        {/* Pattern + blobs */}
                        <div className="absolute inset-0 opacity-10" style={{ backgroundImage: BG_PATTERN }} />
                        <div className="absolute -left-32 -top-32 h-96 w-96 rounded-full bg-white/5 blur-3xl" />
                        <div className="absolute -bottom-32 -right-32 h-[30rem] w-[30rem] rounded-full bg-white/5 blur-3xl" />

                        <Container className="relative z-10">
                           
                            <div className="mx-auto max-w-3xl text-center">
                                <div className="section-animate section-animate-delay-1 mb-5">
                                    <span className="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-white backdrop-blur-sm">
                                        ✦ Discover Our Difference
                                    </span>
                                </div>

                                <h1 className="section-animate section-animate-delay-2 text-4xl font-extrabold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                                    {c.page_hero_title || "Why Thousands Choose Darpon"}
                                </h1>

                                <p className="section-animate section-animate-delay-3 mx-auto mt-6 max-w-2xl text-base leading-relaxed text-white/80 sm:text-lg">
                                    {c.page_hero_subtitle || "From absolute beginners to advanced professionals — we've helped over 5,000 students unlock real English fluency through expert teaching, structured learning and genuine care."}
                                </p>

                                {/* Hero stat pills */}
                                <div className="section-animate section-animate-delay-4 mt-8 flex flex-wrap justify-center gap-3">
                                    {stats.map((s, i) => (
                                        <div key={i} className="flex items-center gap-2 rounded-full bg-white/15 px-4 py-2 text-sm font-semibold text-white backdrop-blur-sm">
                                            <span className="text-base font-black">{s.value}</span>
                                            <span className="text-white/70">{s.label}</span>
                                        </div>
                                    ))}
                                </div>

                                <div className="section-animate section-animate-delay-5 mt-10 flex flex-wrap justify-center gap-4">
                                    <PrimaryButton
                                        onClick={() => setModalOpen(true)}
                                        showIcon={false}
                                        className="!bg-white !text-primary-700 !shadow-xl hover:!bg-white/90 px-8 py-3.5 text-base font-bold"
                                    >
                                        {c.btn_free_class_label || "Join Our Free Class"}
                                    </PrimaryButton>
                                    <Link
                                        href={route("courses.index")}
                                        className="inline-flex items-center gap-2 rounded-full border-2 border-white/40 px-8 py-3.5 text-base font-semibold text-white backdrop-blur-sm transition-all hover:border-white hover:bg-white/10"
                                    >
                                        Explore Courses
                                        <svg className="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </Link>
                                </div>
                            </div>
                        </Container>
                    </section>

                    {/* ══════════════════════════════════════════════════════
                        2. CORE FEATURES — 6 cards
                    ══════════════════════════════════════════════════════ */}
                    <section
                        ref={featRef}
                        className={`relative overflow-hidden py-16 sm:py-24 lg:py-28 ${featVis ? "section-visible" : ""}`}
                    >
                        <SectionBackground variant="a" />
                        <Container className="relative z-10">
                            <div className="section-animate section-animate-delay-1 mb-14">
                                <SectionHeader
                                    badge={c.section_badge || "Everything You Need"}
                                    title={c.section_title || "The Best Place to Learn English"}
                                    subtitle={c.section_subtitle || "We combine expert teaching, modern methods and a supportive community to help you achieve real English fluency."}
                                    alignment="center"
                                />
                            </div>
                            <div className="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                                {features.map((f, i) => (
                                    <FeatureCard key={i} feature={f} color={CARD_COLORS[i % CARD_COLORS.length]} index={i} isVisible={featVis} />
                                ))}
                            </div>
                        </Container>
                    </section>

                    {/* ══════════════════════════════════════════════════════
                        3. METHODOLOGY — 4 steps
                    ══════════════════════════════════════════════════════ */}
                    <section
                        ref={stepsRef}
                        className={`relative overflow-hidden bg-gray-50 py-16 sm:py-24 dark:bg-gray-800/50 ${stepsVis ? "section-visible" : ""}`}
                    >
                        <Container>
                            <div className="section-animate section-animate-delay-1 mb-14">
                                <SectionHeader
                                    badge={c.method_badge || "Our Approach"}
                                    title={c.method_title || "A Proven 4-Step Learning System"}
                                    subtitle={c.method_subtitle || "Every student follows our structured pathway designed to build real, lasting English proficiency — not just exam scores."}
                                    alignment="center"
                                />
                            </div>

                            <div className="relative grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
                                {steps.map((s, i) => (
                                    <StepCard key={i} step={s} index={i} isVisible={stepsVis} />
                                ))}
                            </div>
                        </Container>
                    </section>

                    {/* ══════════════════════════════════════════════════════
                        4. STUDENT OUTCOMES — chips
                    ══════════════════════════════════════════════════════ */}
                    <section
                        ref={outRef}
                        className={`relative overflow-hidden py-16 sm:py-24 ${outVis ? "section-visible" : ""}`}
                    >
                        <SectionBackground variant="b" />
                        <Container className="relative z-10">
                            <div className="section-animate section-animate-delay-1 mb-12">
                                <SectionHeader
                                    badge={c.outcome_badge || "Student Results"}
                                    title={c.outcome_title || "What Our Students Achieve"}
                                    subtitle={c.outcome_subtitle || "These are the real, measurable results our graduates walk away with — not promises, but proven outcomes."}
                                    alignment="center"
                                />
                            </div>

                            <div className="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                                {outcomes.map((text, i) => (
                                    <OutcomeChip key={i} text={text} index={i} isVisible={outVis} />
                                ))}
                            </div>

                            {/* Testimonial pull-quote */}
                            <div className="section-animate section-animate-delay-5 mx-auto mt-14 max-w-2xl rounded-2xl border border-primary-100 bg-primary-50 px-8 py-7 text-center dark:border-primary-900/30 dark:bg-primary-900/20">
                                <div className="mb-4 text-4xl">"</div>
                                <p className="text-base italic leading-relaxed text-gray-700 dark:text-gray-300 sm:text-lg">
                                    {c.testimonial_quote || "I spent years afraid to speak English in public. After just 3 months at Darpon, I gave a presentation in front of 50 colleagues — in English — and got a standing ovation."}
                                </p>
                                <p className="mt-4 text-sm font-semibold text-primary-600 dark:text-primary-400">
                                    — {c.testimonial_author || "Farhan A., Software Engineer"}
                                </p>
                            </div>
                        </Container>
                    </section>

                    {/* ══════════════════════════════════════════════════════
                        5. STATS BANNER — animated counters
                    ══════════════════════════════════════════════════════ */}
                    <section
                        ref={statsRef}
                        className="relative overflow-hidden bg-gradient-to-r from-primary-700 via-primary-600 to-secondary-600 py-14 sm:py-20 dark:from-primary-900 dark:via-primary-800 dark:to-secondary-900"
                    >
                        <div className="absolute inset-0 opacity-10" style={{ backgroundImage: BG_PATTERN }} />
                        <div className="absolute -left-40 top-0 h-80 w-80 rounded-full bg-white/5 blur-3xl" />
                        <div className="absolute -right-40 bottom-0 h-80 w-80 rounded-full bg-white/5 blur-3xl" />

                        <Container className="relative z-10">
                            <div className="grid grid-cols-2 gap-8 sm:gap-12 lg:grid-cols-4">
                                {stats.map((s, i) => (
                                    <StatCounter key={i} value={s.value} label={s.label} isVisible={statsVis} />
                                ))}
                            </div>
                        </Container>
                    </section>

                    {/* ══════════════════════════════════════════════════════
                        6. DIFFERENTIATORS — 3 comparison cards
                    ══════════════════════════════════════════════════════ */}
                    <section
                        ref={diffRef}
                        className={`relative overflow-hidden py-16 sm:py-24 lg:py-28 ${diffVis ? "section-visible" : ""}`}
                    >
                        <SectionBackground variant="a" />
                        <Container className="relative z-10">
                            <div className="section-animate section-animate-delay-1 mb-14">
                                <SectionHeader
                                    badge={c.diff_badge || "What Sets Us Apart"}
                                    title={c.diff_title || "We Do Things Differently"}
                                    subtitle={c.diff_subtitle || "Most English courses teach grammar rules. We teach you to think, feel and communicate in English — naturally and confidently."}
                                    alignment="center"
                                />
                            </div>

                            <div className="grid grid-cols-1 gap-6 md:grid-cols-3">
                                {diffs.map((d, i) => (
                                    <DiffCard key={i} item={d} index={i} isVisible={diffVis} />
                                ))}
                            </div>

                            {/* Comparison strip */}
                            <div className="section-animate section-animate-delay-5 mt-14 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm dark:border-gray-700/60 dark:bg-gray-800/70">
                                <div className="grid grid-cols-2 divide-x divide-gray-100 dark:divide-gray-700/60">
                                    <div className="p-6 sm:p-8">
                                        <div className="mb-4 flex items-center gap-2">
                                            <div className="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-base dark:bg-gray-700">❌</div>
                                            <h4 className="font-bold text-gray-500 dark:text-gray-400">Typical English Classes</h4>
                                        </div>
                                        <ul className="space-y-3 text-sm text-gray-500 dark:text-gray-400">
                                            {["One-size-fits-all curriculum", "Textbook grammar focus", "Passive listening exercises", "No feedback between classes", "Certificate with little real value"].map((t, i) => (
                                                <li key={i} className="flex items-start gap-2"><span className="mt-0.5 text-gray-300">✕</span>{t}</li>
                                            ))}
                                        </ul>
                                    </div>
                                    <div className="bg-primary-50 p-6 dark:bg-primary-900/20 sm:p-8">
                                        <div className="mb-4 flex items-center gap-2">
                                            <div className="flex h-8 w-8 items-center justify-center rounded-lg bg-primary-100 text-base dark:bg-primary-800/50">✅</div>
                                            <h4 className="font-bold text-primary-700 dark:text-primary-300">Darpon English</h4>
                                        </div>
                                        <ul className="space-y-3 text-sm text-gray-700 dark:text-gray-300">
                                            {["Personalized curriculum per student", "Real-world communication focus", "Active speaking & debate sessions", "Weekly 1-on-1 instructor feedback", "Recognized certificate + career support"].map((t, i) => (
                                                <li key={i} className="flex items-start gap-2">
                                                    <svg className="mt-0.5 h-4 w-4 flex-shrink-0 text-primary-600 dark:text-primary-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                                                    </svg>
                                                    {t}
                                                </li>
                                            ))}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </Container>
                    </section>

                    {/* ══════════════════════════════════════════════════════
                        7. BOTTOM CTA
                    ══════════════════════════════════════════════════════ */}
                    <section
                        ref={ctaRef}
                        className={`relative overflow-hidden bg-gradient-to-br from-primary-600 via-primary-700 to-secondary-600 py-16 sm:py-20 dark:from-primary-800 dark:via-primary-900 dark:to-secondary-800 ${ctaVis ? "section-visible" : ""}`}
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

                </main>
                <Footer />
            </div>

            <FreeClassModal open={modalOpen} onClose={() => setModalOpen(false)} content={c} />
        </>
    );
}
