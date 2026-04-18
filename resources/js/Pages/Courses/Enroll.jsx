import { Head, useForm, usePage, Link } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import Card from "@/Components/ui/Card";
import { useState, useEffect, useRef } from "react";
import { calculatePrice } from "@/Utils/priceCalculation";
import BackgroundDecorations from "@/Components/courses/enroll/BackgroundDecorations";
import EnrollHeader from "@/Components/courses/enroll/EnrollHeader";
import PersonalInformationSection from "@/Components/courses/enroll/PersonalInformationSection";
import CourseVariationSelector from "@/Components/courses/enroll/CourseVariationSelector";
import PriceSummary from "@/Components/courses/enroll/PriceSummary";
import PaymentGatewaySection from "@/Components/courses/enroll/PaymentGatewaySection";
import NewUserInfoBox from "@/Components/courses/enroll/NewUserInfoBox";
import CourseInfoSidebar from "@/Components/courses/enroll/CourseInfoSidebar";
import SubmitButton from "@/Components/courses/enroll/SubmitButton";
import {
    Download,
    CheckCircle2,
    ArrowRight,
    Home,
    Loader2,
    User,
    Mail,
    Phone,
    MapPin,
    Globe,
} from "lucide-react";
import { formatPrice } from "@/Utils/currency";
import { generatePDF } from "@/Utils/pdfGenerator";
import Logo from "@/Components/layout/Header/Logo";

export default function Enroll({
    course,
    paymentGateways = [],
    registration = null,
    totalPrice: registrationTotalPrice = 0,
    isNewUser = false,
}) {
    const { auth, settings } = usePage().props;
    const variations = course.variations || [];
    const hasVariations = variations.length > 0;

    // Get variation from URL params
    const urlParams = new URLSearchParams(window.location.search);
    const variationFromUrl = urlParams.get("variation");
    const initialVariationId =
        variationFromUrl && hasVariations
            ? variations.find((v) => String(v.id) === String(variationFromUrl))
                  ?.id || null
            : null;

    const { data, setData, post, processing, errors } = useForm({
        name: auth?.user?.name || "",
        email: auth?.user?.email || "",
        phone: "",
        address: "",
        payment_gateway_id: "",
        transaction_id: "",
        payment_screenshot: null,
        course_variation_id: initialVariationId || "",
    });

    const [emailError, setEmailError] = useState("");
    const [selectedVariationId, setSelectedVariationId] =
        useState(initialVariationId);
    const [isGeneratingPDF, setIsGeneratingPDF] = useState(false);
    const invoiceContentRef = useRef(null);

    // Update form data when variation changes
    useEffect(() => {
        setData("course_variation_id", selectedVariationId || "");
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [selectedVariationId]);

    // Scroll to top when registration is received
    useEffect(() => {
        if (registration) {
            window.scrollTo({ top: 0, behavior: "smooth" });
        }
    }, [registration]);

    // Calculate price based on selected variation or course
    const selectedVariation = selectedVariationId
        ? variations.find((v) => v.id === selectedVariationId)
        : null;

    const priceSource = selectedVariation || course;
    const { totalPrice } = calculatePrice(priceSource);

    const validateEmail = (email) => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            setEmailError("Email is required");
            return false;
        }
        if (!emailRegex.test(email)) {
            setEmailError("Please enter a valid email address");
            return false;
        }
        setEmailError("");
        return true;
    };

    const submit = (e) => {
        e.preventDefault();

        // Validate email before submission
        if (!validateEmail(data.email)) {
            return;
        }

        post(route("courses.enroll.store", course.slug), {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                // Invoice will be shown inline
            },
            onError: (errors) => {
                if (errors.email) {
                    setEmailError(errors.email);
                }
            },
        });
    };

    const handleDownloadPDF = async () => {
        if (!invoiceContentRef.current || !registration) return;

        const invoiceNumber = `ENR-${String(registration.id).padStart(6, "0")}`;
        const filename = `Invoice-${invoiceNumber}.pdf`;

        await generatePDF(invoiceContentRef.current, filename, {
            onStart: () => setIsGeneratingPDF(true),
            onSuccess: () => setIsGeneratingPDF(false),
            onError: () => setIsGeneratingPDF(false),
        });
    };

    const thumbnailUrl = course.thumbnail
        ? course.thumbnail.startsWith("http")
            ? course.thumbnail
            : `/storage/${course.thumbnail}`
        : null;

    const isPaidCourse = registrationTotalPrice > 0;
    const isFreeCourse = registrationTotalPrice === 0;

    // If registration exists, show invoice instead of form
    if (registration) {
        const invoiceNumber = `ENR-${String(registration.id).padStart(6, "0")}`;
        const isVerified =
            isFreeCourse || registration.payment_status === "verified";

        return (
            <>
                <Head title={`Enrollment Confirmation - ${course.title}`} />
                <div className="min-h-screen bg-gradient-to-b from-primary-50 via-white to-gray-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-900 font-sans flex flex-col">
                    <Header />

                    <main className="flex-grow pt-20 pb-12">
                        <Container>
                            <div className="max-w-2xl mx-auto">
                                {/* Top status bar */}
                                <div
                                    className={`mb-4 flex items-center justify-center gap-2.5 rounded-2xl px-5 py-3 text-sm font-semibold shadow-sm ${
                                        isVerified
                                            ? "bg-green-500 text-white"
                                            : "bg-blue-500 text-white"
                                    }`}
                                >
                                    <CheckCircle2 className="h-5 w-5 shrink-0" />
                                    {isFreeCourse
                                        ? "You're enrolled! Check your email for access details."
                                        : registration.payment_status ===
                                            "verified"
                                          ? "Payment verified — you're all set!"
                                          : "Registration received — we'll verify your payment soon."}
                                </div>

                                {/* Invoice document — outer shell is decorative only, ref is on the inner printable area */}
                                <div className="rounded-2xl overflow-hidden shadow-xl ring-1 ring-black/5 dark:ring-white/5">
                                    <div
                                        ref={invoiceContentRef}
                                        className="invoice-content bg-white dark:bg-gray-800"
                                    >
                                        {/* ── Header band ── */}
                                        <div className="relative bg-gradient-to-br from-primary-600 via-primary-700 to-secondary-600 overflow-hidden">
                                            {/* subtle dot pattern */}
                                            <div
                                                className="absolute inset-0 opacity-10"
                                                style={{
                                                    backgroundImage:
                                                        "radial-gradient(circle, white 1px, transparent 1px)",
                                                    backgroundSize: "18px 18px",
                                                }}
                                            />

                                            <div className="relative px-5 pt-6 pb-5 sm:px-8 sm:pt-7 sm:pb-6">
                                                {/* logo + label row */}
                                                <div className="flex items-start justify-between gap-4 mb-5">
                                                    <div>
                                                        <p className="text-xs font-semibold uppercase tracking-widest text-white/60 mb-1">
                                                            Course Enrollment
                                                        </p>
                                                        <h1 className="text-3xl sm:text-4xl font-black text-white tracking-tight">
                                                            INVOICE
                                                        </h1>
                                                    </div>
                                                    <Logo />
                                                </div>

                                                {/* meta table */}
                                                <table className="w-full text-xs border-collapse mt-1">
                                                    <tbody>
                                                        <tr className="border-b border-white/10">
                                                            <td className="py-1.5 pr-4 font-medium text-white/60 whitespace-nowrap">
                                                                Invoice #
                                                            </td>
                                                            <td className="py-1.5 font-mono font-bold text-white">
                                                                {invoiceNumber}
                                                            </td>
                                                        </tr>
                                                        <tr className="border-b border-white/10">
                                                            <td className="py-1.5 pr-4 font-medium text-white/60 whitespace-nowrap">
                                                                Date
                                                            </td>
                                                            <td className="py-1.5 text-white/90">
                                                                {new Date(
                                                                    registration.created_at,
                                                                ).toLocaleDateString(
                                                                    "en-US",
                                                                    {
                                                                        year: "numeric",
                                                                        month: "long",
                                                                        day: "numeric",
                                                                    },
                                                                )}
                                                            </td>
                                                        </tr>
                                                        <tr
                                                            className={
                                                                registration.payment_status
                                                                    ? "border-b border-white/10"
                                                                    : ""
                                                            }
                                                        >
                                                            <td className="py-1.5 pr-4 font-medium text-white/60 whitespace-nowrap">
                                                                Status
                                                            </td>
                                                            <td className="py-1.5">
                                                                <span className="inline-flexfont-semibold uppercase tracking-wide text-white">
                                                                    {
                                                                        registration.status
                                                                    }
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        {registration.payment_status && (
                                                            <tr>
                                                                <td className="py-1.5 pr-4 font-medium text-white/60 whitespace-nowrap">
                                                                    Payment
                                                                </td>
                                                                <td className="py-1.5">
                                                                    <span
                                                                        className={`inline-flex  font-semibold uppercase tracking-wide ${
                                                                            registration.payment_status ===
                                                                            "verified"
                                                                                ? "text-green-100"
                                                                                : registration.payment_status ===
                                                                                    "rejected"
                                                                                  ? " text-red-100"
                                                                                  : " text-yellow-100"
                                                                        }`}
                                                                    >
                                                                        {
                                                                            registration.payment_status
                                                                        }
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        )}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {/* ── Body ── */}
                                        <div className="px-5 py-6 sm:px-8 sm:py-7 space-y-6">
                                            {/* Student info — 2-col grid */}
                                            <section>
                                                <h2 className="mb-3 text-[11px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                                                    Student Information
                                                </h2>
                                                <div className="grid grid-cols-2 gap-3">
                                                    {[
                                                        {
                                                            icon: (
                                                                <User className="h-3.5 w-3.5" />
                                                            ),
                                                            label: "Full Name",
                                                            value: registration.name,
                                                        },
                                                        {
                                                            icon: (
                                                                <Mail className="h-3.5 w-3.5" />
                                                            ),
                                                            label: "Email",
                                                            value: registration.email,
                                                            mono: false,
                                                            truncate: true,
                                                        },
                                                        {
                                                            icon: (
                                                                <Phone className="h-3.5 w-3.5" />
                                                            ),
                                                            label: "Phone",
                                                            value:
                                                                registration.phone ||
                                                                "—",
                                                        },
                                                        {
                                                            icon: (
                                                                <Globe className="h-3.5 w-3.5" />
                                                            ),
                                                            label: "Type",
                                                            value:
                                                                registration.enrollment_type ||
                                                                "Online",
                                                            capitalize: true,
                                                        },
                                                    ].map(
                                                        ({
                                                            icon,
                                                            label,
                                                            value,
                                                            truncate,
                                                            capitalize,
                                                        }) => (
                                                            <div
                                                                key={label}
                                                                className="rounded-xl bg-gray-50 dark:bg-gray-700/50 px-3.5 py-3"
                                                            >
                                                                <div className="flex items-center gap-1.5 text-gray-400 dark:text-gray-500 mb-1">
                                                                    {icon}
                                                                    <span className="text-[10px] font-bold uppercase tracking-wider">
                                                                        {label}
                                                                    </span>
                                                                </div>
                                                                <p
                                                                    className={`text-sm font-semibold text-gray-900 dark:text-white ${truncate ? "truncate" : ""} ${capitalize ? "capitalize" : ""}`}
                                                                >
                                                                    {value}
                                                                </p>
                                                            </div>
                                                        ),
                                                    )}
                                                    {registration.address && (
                                                        <div className="col-span-2 rounded-xl bg-gray-50 dark:bg-gray-700/50 px-3.5 py-3">
                                                            <div className="flex items-center gap-1.5 text-gray-400 dark:text-gray-500 mb-1">
                                                                <MapPin className="h-3.5 w-3.5" />
                                                                <span className="text-[10px] font-bold uppercase tracking-wider">
                                                                    Address
                                                                </span>
                                                            </div>
                                                            <p className="text-sm font-semibold text-gray-900 dark:text-white whitespace-pre-wrap">
                                                                {
                                                                    registration.address
                                                                }
                                                            </p>
                                                        </div>
                                                    )}
                                                </div>
                                            </section>

                                            {/* Divider */}
                                            <div className="border-t border-dashed border-gray-200 dark:border-gray-700" />

                                            {/* Course */}
                                            <section>
                                                <h2 className="mb-3 text-[11px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                                                    Course Details
                                                </h2>
                                                <div className="rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                                                    <div className="flex items-start justify-between gap-4 px-4 py-4 bg-gray-50 dark:bg-gray-700/40">
                                                        <div className="min-w-0">
                                                            <p className="font-bold text-gray-900 dark:text-white leading-snug">
                                                                {course?.title ||
                                                                    "Unknown Course"}
                                                            </p>
                                                            {course?.duration && (
                                                                <p className="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                                                    Duration:{" "}
                                                                    {
                                                                        course.duration
                                                                    }
                                                                </p>
                                                            )}
                                                            {registration.course_variation && (
                                                                <div className="mt-2 flex flex-wrap items-center gap-2">
                                                                    <span className="rounded-full bg-primary-100 dark:bg-primary-900/40 px-2.5 py-0.5 text-xs font-semibold text-primary-700 dark:text-primary-300">
                                                                        {
                                                                            registration
                                                                                .course_variation
                                                                                .name
                                                                        }
                                                                    </span>
                                                                    {registration
                                                                        .course_variation
                                                                        .duration && (
                                                                        <span className="text-xs text-gray-500">
                                                                            {
                                                                                registration
                                                                                    .course_variation
                                                                                    .duration
                                                                            }
                                                                        </span>
                                                                    )}
                                                                </div>
                                                            )}
                                                        </div>
                                                        <div className="shrink-0 text-right">
                                                            {isFreeCourse ? (
                                                                <span className="text-base font-bold text-green-600 dark:text-green-400">
                                                                    FREE
                                                                </span>
                                                            ) : (
                                                                <span className="text-base font-bold text-gray-900 dark:text-white">
                                                                    {formatPrice(
                                                                        registrationTotalPrice,
                                                                    )}
                                                                </span>
                                                            )}
                                                        </div>
                                                    </div>
                                                    {isPaidCourse && (
                                                        <div className="flex items-center justify-between px-4 py-3 bg-primary-600 dark:bg-primary-700">
                                                            <span className="text-sm font-bold text-white/80">
                                                                Total Amount
                                                            </span>
                                                            <span className="text-xl font-black text-white">
                                                                {formatPrice(
                                                                    registrationTotalPrice,
                                                                )}
                                                            </span>
                                                        </div>
                                                    )}
                                                </div>
                                            </section>

                                            {/* Payment info */}
                                            {isPaidCourse &&
                                                registration.payment_gateway && (
                                                    <section>
                                                        <h2 className="mb-3 text-[11px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                                                            Payment Details
                                                        </h2>
                                                        <div className="rounded-xl border border-gray-100 dark:border-gray-700 divide-y divide-gray-100 dark:divide-gray-700 overflow-hidden">
                                                            <div className="flex justify-between items-center px-4 py-3">
                                                                <span className="text-xs text-gray-500 dark:text-gray-400 font-medium">
                                                                    Method
                                                                </span>
                                                                <span className="text-sm font-bold text-gray-900 dark:text-white">
                                                                    {
                                                                        registration
                                                                            .payment_gateway
                                                                            .name
                                                                    }
                                                                </span>
                                                            </div>
                                                            {registration
                                                                .payment_gateway
                                                                .account_number && (
                                                                <div className="flex justify-between items-center px-4 py-3">
                                                                    <span className="text-xs text-gray-500 dark:text-gray-400 font-medium">
                                                                        Account
                                                                    </span>
                                                                    <span className="text-sm font-mono font-bold text-gray-900 dark:text-white">
                                                                        {
                                                                            registration
                                                                                .payment_gateway
                                                                                .account_number
                                                                        }
                                                                    </span>
                                                                </div>
                                                            )}
                                                            {registration.transaction_id && (
                                                                <div className="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 px-4 py-3">
                                                                    <span className="text-xs text-gray-500 dark:text-gray-400 font-medium">
                                                                        Transaction
                                                                        ID
                                                                    </span>
                                                                    <span className="text-sm font-mono font-bold text-gray-900 dark:text-white break-all">
                                                                        {
                                                                            registration.transaction_id
                                                                        }
                                                                    </span>
                                                                </div>
                                                            )}
                                                        </div>
                                                    </section>
                                                )}

                                            {/* New user notice */}
                                            {isNewUser && (
                                                <div className="flex items-start gap-3 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 px-4 py-3">
                                                    <CheckCircle2 className="h-4 w-4 shrink-0 text-amber-600 dark:text-amber-400 mt-0.5" />
                                                    <p className="text-xs font-semibold text-amber-800 dark:text-amber-200">
                                                        Account created for you
                                                        — check your email for
                                                        login credentials.
                                                    </p>
                                                </div>
                                            )}

                                            {/* Footer */}
                                            <p className="text-center text-[11px] text-gray-400 dark:text-gray-600 pt-1">
                                                Computer-generated invoice · No
                                                signature required
                                            </p>
                                        </div>
                                    </div>
                                    {/* /invoiceContentRef */}
                                </div>
                                {/* /decorative rounded wrapper */}

                                {/* Action buttons — outside invoice, not in PDF */}
                                <div className="mt-4 grid grid-cols-2 gap-3 pdf-exclude">
                                    <button
                                        onClick={handleDownloadPDF}
                                        disabled={isGeneratingPDF}
                                        className="flex items-center justify-center gap-2 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300 shadow-sm transition-all hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        {isGeneratingPDF ? (
                                            <>
                                                <Loader2 className="h-4 w-4 animate-spin" />{" "}
                                                Generating…
                                            </>
                                        ) : (
                                            <>
                                                <Download className="h-4 w-4" />{" "}
                                                Download PDF
                                            </>
                                        )}
                                    </button>
                                    <Link
                                        href={route("dashboard", {
                                            section: "courses",
                                        })}
                                        className="flex items-center justify-center gap-2 rounded-xl bg-primary-600 px-4 py-3 text-sm font-semibold text-white shadow-lg transition-all hover:bg-primary-700"
                                    >
                                        <Home className="h-4 w-4" />
                                        Dashboard
                                    </Link>
                                    <Link
                                        href={route(
                                            "courses.show",
                                            course.slug,
                                        )}
                                        className="col-span-2 flex items-center justify-center gap-2 rounded-xl border-2 border-primary-200 dark:border-primary-800 text-primary-600 dark:text-primary-400 px-4 py-3 text-sm font-semibold transition-all hover:bg-primary-50 dark:hover:bg-primary-900/20"
                                    >
                                        View Course Page
                                        <ArrowRight className="h-4 w-4" />
                                    </Link>
                                </div>
                            </div>
                        </Container>
                    </main>
                    <Footer />
                </div>
            </>
        );
    }

    // Show enrollment form
    return (
        <>
            <Head title={`Enroll in ${course.title}`} />
            <div className="min-h-screen bg-white dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100 flex flex-col">
                <Header />

                <main className="flex-grow pt-24 pb-16 relative">
                    <BackgroundDecorations />

                    <Container>
                        <EnrollHeader course={course} auth={auth} />

                        <div className="grid gap-8 lg:grid-cols-5 max-w-6xl mx-auto">
                            {/* Left Column: Form */}
                            <div className="lg:col-span-3 order-2 lg:order-1">
                                <Card
                                    variant="elevated"
                                    className="p-8 sm:p-10 border-t-4 border-primary-500 shadow-2xl"
                                >
                                    <form
                                        onSubmit={submit}
                                        className="space-y-6"
                                    >
                                        <PersonalInformationSection
                                            data={data}
                                            setData={setData}
                                            errors={errors}
                                            emailError={emailError}
                                            validateEmail={validateEmail}
                                            auth={auth}
                                        />

                                        {hasVariations && (
                                            <CourseVariationSelector
                                                variations={variations}
                                                selectedVariationId={
                                                    selectedVariationId
                                                }
                                                setSelectedVariationId={
                                                    setSelectedVariationId
                                                }
                                                errors={errors}
                                            />
                                        )}

                                        <PriceSummary
                                            totalPrice={totalPrice}
                                            selectedVariation={
                                                selectedVariation
                                            }
                                        />

                                        <PaymentGatewaySection
                                            data={data}
                                            setData={setData}
                                            errors={errors}
                                            paymentGateways={paymentGateways}
                                            totalPrice={totalPrice}
                                        />

                                        {!auth?.user && <NewUserInfoBox />}

                                        <SubmitButton
                                            processing={processing}
                                            emailError={emailError}
                                        />
                                    </form>
                                </Card>
                            </div>

                            {/* Right Column: Course Info */}
                            <CourseInfoSidebar
                                course={course}
                                thumbnailUrl={thumbnailUrl}
                            />
                        </div>
                    </Container>
                </main>
                <Footer />
            </div>
        </>
    );
}
