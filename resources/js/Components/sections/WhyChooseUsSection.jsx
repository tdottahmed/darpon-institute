import { useEffect, useRef, useState } from "react";
import { usePage } from "@inertiajs/react";
import { Dialog, DialogPanel, Transition, TransitionChild } from "@headlessui/react";
import Container from "../ui/Container";
import SectionBackground from "../ui/SectionBackground";
import SectionHeader from "../ui/SectionHeader";
import PrimaryButton from "../ui/PrimaryButton";

// ─── Helpers ────────────────────────────────────────────────────────────────

function formatBDPhone(raw) {
    const d = raw.replace(/\D/g, "").slice(0, 11);
    if (d.length <= 3) return d;
    if (d.length <= 7) return `${d.slice(0, 3)} ${d.slice(3)}`;
    return `${d.slice(0, 3)} ${d.slice(3, 7)} ${d.slice(7)}`;
}

function validatePhone(raw) {
    const d = raw.replace(/\D/g, "");
    if (!d) return "Phone number is required.";
    if (d.length !== 11) return "Must be 11 digits (e.g. 017XX XXXXXX).";
    if (!/^01[3-9]\d{8}$/.test(d)) return "Enter a valid BD mobile number.";
    return "";
}

// ─── Defaults ───────────────────────────────────────────────────────────────

const DEFAULT_FEATURES = [
    { icon: "🎯", title: "Expert Instructors",      description: "Learn from certified teachers with 10+ years of experience in English language education." },
    { icon: "📚", title: "Comprehensive Curriculum", description: "Structured lessons covering speaking, writing, listening and reading skills." },
    { icon: "🏆", title: "Certified Courses",        description: "Earn industry-recognized certificates upon completing your courses." },
    { icon: "💬", title: "Interactive Learning",     description: "Live sessions, group discussions and real-world English practice." },
    { icon: "📱", title: "Learn Anywhere",           description: "Access all course materials on any device, anytime you want." },
    { icon: "🌟", title: "Proven Results",           description: "Over 5000+ students have transformed their English skills with us." },
];

const CARD_COLORS = [
    { iconBg: "bg-primary-100 dark:bg-primary-900/40",   iconText: "text-primary-600 dark:text-primary-300",   accentBar: "bg-primary-500",   checkBg: "bg-primary-50 dark:bg-primary-900/30",   checkText: "text-primary-600 dark:text-primary-400" },
    { iconBg: "bg-secondary-100 dark:bg-secondary-900/40", iconText: "text-secondary-600 dark:text-secondary-300", accentBar: "bg-secondary-500", checkBg: "bg-secondary-50 dark:bg-secondary-900/30", checkText: "text-secondary-600 dark:text-secondary-400" },
    { iconBg: "bg-accent-100 dark:bg-accent-900/40",     iconText: "text-accent-600 dark:text-accent-300",     accentBar: "bg-accent-500",     checkBg: "bg-accent-50 dark:bg-accent-900/30",     checkText: "text-accent-600 dark:text-accent-400" },
    { iconBg: "bg-emerald-100 dark:bg-emerald-900/40",   iconText: "text-emerald-600 dark:text-emerald-300",   accentBar: "bg-emerald-500",   checkBg: "bg-emerald-50 dark:bg-emerald-900/30",   checkText: "text-emerald-600 dark:text-emerald-400" },
    { iconBg: "bg-violet-100 dark:bg-violet-900/40",     iconText: "text-violet-600 dark:text-violet-300",     accentBar: "bg-violet-500",     checkBg: "bg-violet-50 dark:bg-violet-900/30",     checkText: "text-violet-600 dark:text-violet-400" },
    { iconBg: "bg-rose-100 dark:bg-rose-900/40",         iconText: "text-rose-600 dark:text-rose-300",         accentBar: "bg-rose-500",       checkBg: "bg-rose-50 dark:bg-rose-900/30",         checkText: "text-rose-600 dark:text-rose-400" },
];

// ─── Feature card ────────────────────────────────────────────────────────────

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

            <h3 className="mb-2.5 text-lg font-bold text-gray-900 dark:text-white">
                {feature.title}
            </h3>

            <p className="flex-1 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                {feature.description}
            </p>

            <div className={`mt-5 flex items-center gap-2 rounded-lg px-3 py-2 ${color.checkBg}`}>
                <svg className={`h-4 w-4 flex-shrink-0 ${color.checkText}`} viewBox="0 0 20 20" fill="currentColor">
                    <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                </svg>
                <span className={`text-xs font-semibold ${color.checkText}`}>Included</span>
            </div>
        </div>
    );
}

// ─── Lead modal ──────────────────────────────────────────────────────────────

const STEP = { FORM: "form", LOADING: "loading", SUCCESS: "success" };

function FreeClassModal({ open, onClose, content }) {
    const [step, setStep]     = useState(STEP.FORM);
    const [name, setName]     = useState("");
    const [phone, setPhone]   = useState("");   // raw digits
    const [phoneDisplay, setPhoneDisplay] = useState("");
    const [email, setEmail]   = useState("");
    const [errors, setErrors] = useState({});

    function reset() {
        setStep(STEP.FORM);
        setName(""); setPhone(""); setPhoneDisplay(""); setEmail(""); setErrors({});
    }

    function handleClose() {
        onClose();
        setTimeout(reset, 300);
    }

    function handlePhoneChange(e) {
        const raw = e.target.value.replace(/\D/g, "").slice(0, 11);
        setPhone(raw);
        setPhoneDisplay(formatBDPhone(raw));
        if (errors.phone) setErrors(prev => ({ ...prev, phone: validatePhone(raw) }));
    }

    function validate() {
        const errs = {};
        if (!name.trim())         errs.name  = "Name is required.";
        const pErr = validatePhone(phone);
        if (pErr)                 errs.phone = pErr;
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errs.email = "Enter a valid email address.";
        return errs;
    }

    async function handleSubmit(e) {
        e.preventDefault();
        const errs = validate();
        if (Object.keys(errs).length) { setErrors(errs); return; }

        setStep(STEP.LOADING);
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? "";
            const res = await window.axios.post("/free-class-leads", { name: name.trim(), phone, email: email.trim() || null }, {
                headers: { "X-CSRF-TOKEN": csrfToken },
            });
            if (res.status === 201) setStep(STEP.SUCCESS);
        } catch {
            setStep(STEP.FORM);
            setErrors({ general: "Something went wrong. Please try again." });
        }
    }

    return (
        <Transition show={open} leave="duration-200">
            <Dialog as="div" className="fixed inset-0 z-50 overflow-y-auto" onClose={handleClose}>
                {/* Backdrop */}
                <TransitionChild
                    enter="ease-out duration-300" enterFrom="opacity-0" enterTo="opacity-100"
                    leave="ease-in duration-200" leaveFrom="opacity-100" leaveTo="opacity-0"
                >
                    <div className="fixed inset-0 bg-gray-900/70 backdrop-blur-sm" aria-hidden="true" />
                </TransitionChild>

                {/* Panel */}
                <div className="flex min-h-full items-center justify-center p-4">
                    <TransitionChild
                        enter="ease-out duration-300" enterFrom="opacity-0 translate-y-4 scale-95" enterTo="opacity-100 translate-y-0 scale-100"
                        leave="ease-in duration-200" leaveFrom="opacity-100 translate-y-0 scale-100" leaveTo="opacity-0 translate-y-4 scale-95"
                    >
                        <DialogPanel className="relative w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl dark:bg-gray-900">

                            {/* Close button */}
                            <button
                                onClick={handleClose}
                                className="absolute right-4 top-4 z-10 rounded-full p-1.5 text-gray-400 transition-colors hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800"
                                aria-label="Close"
                            >
                                <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            {/* ── SUCCESS state ── */}
                            {step === STEP.SUCCESS && (
                                <div className="flex flex-col items-center px-8 py-12 text-center">
                                    <div className="mb-5 flex h-20 w-20 items-center justify-center rounded-full bg-green-100 text-4xl dark:bg-green-900/40">
                                        🎉
                                    </div>
                                    <h3 className="mb-2 text-2xl font-bold text-gray-900 dark:text-white">You're in!</h3>
                                    <p className="mb-8 text-gray-600 dark:text-gray-400 leading-relaxed">
                                        Thanks for registering. We'll reach out to you shortly to schedule your free class.
                                    </p>
                                    <button
                                        onClick={handleClose}
                                        className="w-full rounded-xl bg-primary-600 px-6 py-3 text-sm font-semibold text-white shadow-md shadow-primary-500/25 transition-colors hover:bg-primary-700"
                                    >
                                        Close
                                    </button>
                                </div>
                            )}

                            {/* ── FORM / LOADING state ── */}
                            {step !== STEP.SUCCESS && (
                                <>
                                    {/* Gradient header */}
                                    <div className="bg-gradient-to-br from-primary-600 to-secondary-600 px-6 pb-6 pt-8 text-white">
                                        <div className="mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 text-2xl backdrop-blur-sm">
                                            🎓
                                        </div>
                                        <h2 className="text-xl font-bold">
                                            {content.modal_title || "Register for a Free Class"}
                                        </h2>
                                        <p className="mt-1.5 text-sm text-white/80 leading-relaxed">
                                            {content.modal_subtitle || "Fill in your details and we'll reach out to schedule your free class."}
                                        </p>
                                    </div>

                                    <form onSubmit={handleSubmit} noValidate className="space-y-5 px-6 py-6">
                                        {errors.general && (
                                            <div className="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700 dark:bg-red-900/30 dark:text-red-300">
                                                {errors.general}
                                            </div>
                                        )}

                                        {/* Name */}
                                        <div>
                                            <label className="mb-1.5 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                Full Name <span className="text-red-500">*</span>
                                            </label>
                                            <input
                                                type="text"
                                                value={name}
                                                onChange={e => { setName(e.target.value); if (errors.name) setErrors(p => ({ ...p, name: "" })); }}
                                                placeholder="e.g. Rahim Uddin"
                                                autoComplete="name"
                                                className={`block w-full rounded-xl border px-4 py-3 text-sm shadow-sm transition-colors focus:outline-none focus:ring-2 dark:bg-gray-800 dark:text-white ${
                                                    errors.name
                                                        ? "border-red-400 focus:border-red-400 focus:ring-red-200"
                                                        : "border-gray-300 focus:border-primary-500 focus:ring-primary-200 dark:border-gray-600"
                                                }`}
                                            />
                                            {errors.name && <p className="mt-1.5 text-xs text-red-500">{errors.name}</p>}
                                        </div>

                                        {/* Phone */}
                                        <div>
                                            <label className="mb-1.5 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                Phone Number <span className="text-red-500">*</span>
                                            </label>
                                            <div className="relative">
                                                <span className="absolute inset-y-0 left-0 flex items-center pl-3.5 text-sm font-medium text-gray-500 dark:text-gray-400">
                                                    🇧🇩
                                                </span>
                                                <input
                                                    type="tel"
                                                    value={phoneDisplay}
                                                    onChange={handlePhoneChange}
                                                    onBlur={() => { if (phone) setErrors(p => ({ ...p, phone: validatePhone(phone) })); }}
                                                    placeholder="017XX XXXXXX"
                                                    autoComplete="tel"
                                                    className={`block w-full rounded-xl border py-3 pl-10 pr-4 text-sm shadow-sm transition-colors focus:outline-none focus:ring-2 dark:bg-gray-800 dark:text-white ${
                                                        errors.phone
                                                            ? "border-red-400 focus:border-red-400 focus:ring-red-200"
                                                            : "border-gray-300 focus:border-primary-500 focus:ring-primary-200 dark:border-gray-600"
                                                    }`}
                                                />
                                            </div>
                                            {errors.phone && <p className="mt-1.5 text-xs text-red-500">{errors.phone}</p>}
                                        </div>

                                        {/* Email */}
                                        <div>
                                            <label className="mb-1.5 flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                Email Address
                                                <span className="rounded-full bg-gray-100 px-2 py-0.5 text-[10px] font-medium text-gray-400 dark:bg-gray-700">Optional</span>
                                            </label>
                                            <input
                                                type="email"
                                                value={email}
                                                onChange={e => { setEmail(e.target.value); if (errors.email) setErrors(p => ({ ...p, email: "" })); }}
                                                placeholder="you@example.com"
                                                autoComplete="email"
                                                className={`block w-full rounded-xl border px-4 py-3 text-sm shadow-sm transition-colors focus:outline-none focus:ring-2 dark:bg-gray-800 dark:text-white ${
                                                    errors.email
                                                        ? "border-red-400 focus:border-red-400 focus:ring-red-200"
                                                        : "border-gray-300 focus:border-primary-500 focus:ring-primary-200 dark:border-gray-600"
                                                }`}
                                            />
                                            {errors.email && <p className="mt-1.5 text-xs text-red-500">{errors.email}</p>}
                                        </div>

                                        {/* Submit */}
                                        <button
                                            type="submit"
                                            disabled={step === STEP.LOADING}
                                            className="flex w-full items-center justify-center gap-2.5 rounded-xl bg-primary-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 transition-all hover:bg-primary-700 disabled:cursor-not-allowed disabled:opacity-70"
                                        >
                                            {step === STEP.LOADING ? (
                                                <>
                                                    <svg className="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                                        <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
                                                        <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                                                    </svg>
                                                    Registering…
                                                </>
                                            ) : (
                                                <>
                                                    Register for Free Class
                                                    <svg className="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                    </svg>
                                                </>
                                            )}
                                        </button>

                                        <p className="text-center text-xs text-gray-400">
                                            We'll never share your details with anyone.
                                        </p>
                                    </form>
                                </>
                            )}
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </Transition>
    );
}

// ─── Main section ─────────────────────────────────────────────────────────────

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
                    {/* Header */}
                    <div className="section-animate section-animate-delay-1 mb-12 sm:mb-16">
                        <SectionHeader
                            badge={content.section_badge || "Why Choose Us"}
                            title={content.section_title || "The Best Place to Learn English"}
                            subtitle={content.section_subtitle || "We combine expert teaching, modern methods and a supportive community to help you achieve real English fluency."}
                            alignment="center"
                        />
                    </div>

                    {/* Cards */}
                    <div className="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        {features.map((feature, index) => (
                            <FeatureCard
                                key={index}
                                feature={feature}
                                color={CARD_COLORS[index % CARD_COLORS.length]}
                                index={index}
                                isVisible={isVisible}
                            />
                        ))}
                    </div>

                    {/* CTA button */}
                    <div className="section-animate section-animate-delay-6 mt-12 flex justify-center">
                        <PrimaryButton
                            onClick={() => setModalOpen(true)}
                            className="px-8 py-3.5 text-base shadow-lg shadow-primary-500/30"
                        >
                            {content.btn_free_class_label || "Join Our Free Class"}
                        </PrimaryButton>
                    </div>
                </Container>
            </section>

            <FreeClassModal
                open={modalOpen}
                onClose={() => setModalOpen(false)}
                content={content}
            />
        </>
    );
}
