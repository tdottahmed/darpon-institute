import { useState } from "react";
import { Dialog, DialogPanel, Transition, TransitionChild } from "@headlessui/react";

// ─── helpers ─────────────────────────────────────────────────────────────────

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

const STEP = { FORM: "form", LOADING: "loading", SUCCESS: "success" };

// ─── component ───────────────────────────────────────────────────────────────

export default function FreeClassModal({ open, onClose, content = {} }) {
    const [step, setStep]       = useState(STEP.FORM);
    const [name, setName]       = useState("");
    const [phone, setPhone]     = useState("");
    const [phoneDisplay, setPhoneDisplay] = useState("");
    const [email, setEmail]     = useState("");
    const [errors, setErrors]   = useState({});

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
        if (!name.trim()) errs.name = "Name is required.";
        const pErr = validatePhone(phone);
        if (pErr) errs.phone = pErr;
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
            errs.email = "Enter a valid email address.";
        return errs;
    }

    async function handleSubmit(e) {
        e.preventDefault();
        const errs = validate();
        if (Object.keys(errs).length) { setErrors(errs); return; }
        setStep(STEP.LOADING);
        try {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? "";
            const res  = await window.axios.post("/free-class-leads", {
                name: name.trim(), phone, email: email.trim() || null,
            }, { headers: { "X-CSRF-TOKEN": csrf } });
            if (res.status === 201) setStep(STEP.SUCCESS);
        } catch {
            setStep(STEP.FORM);
            setErrors({ general: "Something went wrong. Please try again." });
        }
    }

    return (
        <Transition show={open} leave="duration-200">
            <Dialog as="div" className="fixed inset-0 z-50 overflow-y-auto" onClose={handleClose}>
                <TransitionChild
                    enter="ease-out duration-300" enterFrom="opacity-0" enterTo="opacity-100"
                    leave="ease-in duration-200" leaveFrom="opacity-100" leaveTo="opacity-0"
                >
                    <div className="fixed inset-0 bg-gray-900/70 backdrop-blur-sm" aria-hidden="true" />
                </TransitionChild>

                <div className="flex min-h-full items-center justify-center p-4">
                    <TransitionChild
                        enter="ease-out duration-300"
                        enterFrom="opacity-0 translate-y-4 scale-95"
                        enterTo="opacity-100 translate-y-0 scale-100"
                        leave="ease-in duration-200"
                        leaveFrom="opacity-100 translate-y-0 scale-100"
                        leaveTo="opacity-0 translate-y-4 scale-95"
                    >
                        <DialogPanel className="relative w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl dark:bg-gray-900">
                            {/* Close */}
                            <button
                                onClick={handleClose}
                                className="absolute right-4 top-4 z-10 rounded-full p-1.5 text-gray-400 transition-colors hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800"
                                aria-label="Close"
                            >
                                <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            {/* ── SUCCESS ── */}
                            {step === STEP.SUCCESS && (
                                <div className="flex flex-col items-center px-8 py-12 text-center">
                                    <div className="mb-5 flex h-20 w-20 items-center justify-center rounded-full bg-green-100 text-4xl dark:bg-green-900/40">
                                        🎉
                                    </div>
                                    <h3 className="mb-2 text-2xl font-bold text-gray-900 dark:text-white">You're in!</h3>
                                    <p className="mb-8 leading-relaxed text-gray-600 dark:text-gray-400">
                                        Thanks for registering. We'll reach out shortly to schedule your free class.
                                    </p>
                                    <button
                                        onClick={handleClose}
                                        className="w-full rounded-xl bg-primary-600 px-6 py-3 text-sm font-semibold text-white shadow-md shadow-primary-500/25 transition-colors hover:bg-primary-700"
                                    >
                                        Close
                                    </button>
                                </div>
                            )}

                            {/* ── FORM / LOADING ── */}
                            {step !== STEP.SUCCESS && (
                                <>
                                    <div className="bg-gradient-to-br from-primary-600 to-secondary-600 px-6 pb-6 pt-8 text-white">
                                        <div className="mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 text-2xl backdrop-blur-sm">
                                            🎓
                                        </div>
                                        <h2 className="text-xl font-bold">
                                            {content.modal_title || "Register for a Free Class"}
                                        </h2>
                                        <p className="mt-1.5 text-sm leading-relaxed text-white/80">
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
