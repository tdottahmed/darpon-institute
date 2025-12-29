import { Head, useForm, usePage, router, Link } from "@inertiajs/react";
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
import { Download, CheckCircle2, ArrowRight, Home } from "lucide-react";
import { formatPrice } from "@/Utils/currency";
import { generatePDF } from "@/Utils/pdfGenerator";

export default function Enroll({
    course,
    paymentGateways = [],
    registration = null,
    totalPrice: registrationTotalPrice = 0,
    isNewUser = false,
}) {
    const { auth } = usePage().props;
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
        return (
            <>
                <Head title={`Enrollment Confirmation - ${course.title}`} />
                <div className="min-h-screen bg-gray-50 dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100 flex flex-col">
                    <Header />

                    <main className="flex-grow pt-24 pb-16 relative">
                        <Container>
                            <div className="max-w-4xl mx-auto">
                                {/* Success Header */}
                                <div className="mb-6 text-center">
                                    <div className="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 dark:bg-green-900/30 mb-4">
                                        <CheckCircle2 className="h-8 w-8 text-green-600 dark:text-green-400" />
                                    </div>
                                    <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                        Enrollment Confirmed!
                                    </h1>
                                    <p className="text-gray-600 dark:text-gray-400">
                                        Your enrollment has been successfully
                                        submitted
                                    </p>
                                </div>

                                {/* Invoice Card */}
                                <Card
                                    variant="elevated"
                                    className="p-6 sm:p-8 md:p-12"
                                >
                                    <div
                                        ref={invoiceContentRef}
                                        className="invoice-content"
                                    >
                                        {/* Action Buttons */}
                                        <div className="mb-6 flex flex-col sm:flex-row items-center justify-between gap-4 pdf-exclude">
                                            <h2 className="text-2xl font-bold text-gray-900 dark:text-white">
                                                Enrollment Invoice
                                            </h2>
                                            <div className="flex gap-3">
                                                <button
                                                    onClick={handleDownloadPDF}
                                                    disabled={isGeneratingPDF}
                                                    className="flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-lg transition-all hover:bg-primary-700 hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                                                >
                                                    {isGeneratingPDF ? (
                                                        <>
                                                            <span className="animate-spin">
                                                                ⏳
                                                            </span>
                                                            Generating...
                                                        </>
                                                    ) : (
                                                        <>
                                                            <Download className="h-4 w-4" />
                                                            Download PDF
                                                        </>
                                                    )}
                                                </button>
                                            </div>
                                        </div>

                                        {/* Invoice Header */}
                                        <div className="mb-8 rounded-xl bg-gradient-to-r from-primary-600 via-primary-700 to-secondary-600 p-6 text-white">
                                            <div className="flex flex-col justify-between sm:flex-row">
                                                <div>
                                                    <h1 className="mb-4 text-3xl font-bold">
                                                        INVOICE
                                                    </h1>
                                                    <div className="space-y-2 text-sm">
                                                        <div className="flex gap-4">
                                                            <span className="font-medium opacity-90">
                                                                Invoice #:
                                                            </span>
                                                            <span className="font-mono font-semibold">
                                                                ENR-
                                                                {String(
                                                                    registration.id
                                                                ).padStart(
                                                                    6,
                                                                    "0"
                                                                )}
                                                            </span>
                                                        </div>
                                                        <div className="flex gap-4">
                                                            <span className="font-medium opacity-90">
                                                                Date:
                                                            </span>
                                                            <span>
                                                                {new Date(
                                                                    registration.created_at
                                                                ).toLocaleDateString(
                                                                    "en-US",
                                                                    {
                                                                        year: "numeric",
                                                                        month: "long",
                                                                        day: "numeric",
                                                                    }
                                                                )}
                                                            </span>
                                                        </div>
                                                        <div className="flex gap-4">
                                                            <span className="font-medium opacity-90">
                                                                Status:
                                                            </span>
                                                            <span className="rounded-full bg-white/20 px-3 py-1 text-xs font-semibold uppercase">
                                                                {
                                                                    registration.status
                                                                }
                                                            </span>
                                                        </div>
                                                        {registration.payment_status && (
                                                            <div className="flex gap-4">
                                                                <span className="font-medium opacity-90">
                                                                    Payment
                                                                    Status:
                                                                </span>
                                                                <span
                                                                    className={`rounded-full px-3 py-1 text-xs font-semibold ${
                                                                        registration.payment_status ===
                                                                        "verified"
                                                                            ? "bg-green-500/30 text-green-100"
                                                                            : registration.payment_status ===
                                                                              "rejected"
                                                                            ? "bg-red-500/30 text-red-100"
                                                                            : "bg-yellow-500/30 text-yellow-100"
                                                                    }`}
                                                                >
                                                                    {
                                                                        registration.payment_status
                                                                    }
                                                                </span>
                                                            </div>
                                                        )}
                                                    </div>
                                                </div>
                                                <div className="mt-4 text-right sm:mt-0">
                                                    <div className="text-2xl font-bold">
                                                        {import.meta.env
                                                            .VITE_APP_NAME ||
                                                            "Darpon"}
                                                    </div>
                                                    <div className="mt-1 text-sm opacity-90">
                                                        Course Enrollment
                                                        Invoice
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {/* Student Information */}
                                        <div className="mb-8">
                                            <h2 className="mb-4 border-b-2 border-gray-200 dark:border-gray-700 pb-2 text-lg font-bold text-gray-900 dark:text-white">
                                                Student Information
                                            </h2>
                                            <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                                <div>
                                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                        Name:
                                                    </span>
                                                    <p className="text-gray-900 dark:text-white">
                                                        {registration.name}
                                                    </p>
                                                </div>
                                                <div>
                                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                        Email:
                                                    </span>
                                                    <p className="text-gray-900 dark:text-white">
                                                        {registration.email}
                                                    </p>
                                                </div>
                                                <div>
                                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                        Phone:
                                                    </span>
                                                    <p className="text-gray-900 dark:text-white">
                                                        {registration.phone ||
                                                            "N/A"}
                                                    </p>
                                                </div>
                                                <div>
                                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                        Enrollment Type:
                                                    </span>
                                                    <p className="text-gray-900 dark:text-white capitalize">
                                                        {registration.enrollment_type ||
                                                            "Online"}
                                                    </p>
                                                </div>
                                                {registration.address && (
                                                    <div className="sm:col-span-2">
                                                        <span className="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                            Address:
                                                        </span>
                                                        <p className="whitespace-pre-wrap text-gray-900 dark:text-white">
                                                            {
                                                                registration.address
                                                            }
                                                        </p>
                                                    </div>
                                                )}
                                            </div>
                                        </div>

                                        {/* Course Details */}
                                        <div className="mb-8">
                                            <h2 className="mb-4 border-b-2 border-gray-200 dark:border-gray-700 pb-2 text-lg font-bold text-gray-900 dark:text-white">
                                                Course Details
                                            </h2>
                                            <div className="overflow-x-auto">
                                                <table className="w-full">
                                                    <thead>
                                                        <tr className="border-b-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                                                            <th className="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                                Course
                                                            </th>
                                                            {registration.course_variation && (
                                                                <th className="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                                                    Variation
                                                                </th>
                                                            )}
                                                            <th className="px-4 py-3 text-right text-sm font-semibold text-gray-900 dark:text-white">
                                                                Amount
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr className="border-b border-gray-100 dark:border-gray-700">
                                                            <td className="px-4 py-4">
                                                                <div className="font-semibold text-gray-900 dark:text-white">
                                                                    {course?.title ||
                                                                        "Unknown Course"}
                                                                </div>
                                                                {course?.duration && (
                                                                    <div className="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                                        Duration:{" "}
                                                                        {
                                                                            course.duration
                                                                        }
                                                                    </div>
                                                                )}
                                                            </td>
                                                            {registration.course_variation && (
                                                                <td className="px-4 py-4">
                                                                    <div className="font-medium text-gray-900 dark:text-white">
                                                                        {
                                                                            registration
                                                                                .course_variation
                                                                                .name
                                                                        }
                                                                    </div>
                                                                    {registration
                                                                        .course_variation
                                                                        .duration && (
                                                                        <div className="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                                            {
                                                                                registration
                                                                                    .course_variation
                                                                                    .duration
                                                                            }
                                                                        </div>
                                                                    )}
                                                                </td>
                                                            )}
                                                            <td className="px-4 py-4 text-right font-semibold text-gray-900 dark:text-white">
                                                                {isFreeCourse ? (
                                                                    <span className="text-green-600 dark:text-green-400">
                                                                        Free
                                                                    </span>
                                                                ) : (
                                                                    formatPrice(
                                                                        registrationTotalPrice
                                                                    )
                                                                )}
                                                            </td>
                                                        </tr>
                                                        {isPaidCourse && (
                                                            <tr className="bg-primary-50 dark:bg-primary-900/20">
                                                                <td
                                                                    colSpan={
                                                                        registration.course_variation
                                                                            ? 2
                                                                            : 1
                                                                    }
                                                                    className="px-4 py-4 text-lg font-bold text-gray-900 dark:text-white"
                                                                >
                                                                    Total Amount
                                                                </td>
                                                                <td className="px-4 py-4 text-right text-lg font-bold text-primary-600 dark:text-primary-400">
                                                                    {formatPrice(
                                                                        registrationTotalPrice
                                                                    )}
                                                                </td>
                                                            </tr>
                                                        )}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {/* Payment Information */}
                                        {isPaidCourse &&
                                            registration.payment_gateway && (
                                                <div className="mb-8 rounded-lg border-l-4 border-primary-500 bg-primary-50 dark:bg-primary-900/20 p-4">
                                                    <h3 className="mb-3 text-sm font-semibold text-gray-900 dark:text-white">
                                                        Payment Information
                                                    </h3>
                                                    <div className="space-y-2 text-sm">
                                                        <div>
                                                            <span className="font-medium text-gray-700 dark:text-gray-300">
                                                                Payment Method:
                                                            </span>
                                                            <span className="ml-2 text-gray-900 dark:text-white">
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
                                                            <div>
                                                                <span className="font-medium text-gray-700 dark:text-gray-300">
                                                                    Account:
                                                                </span>
                                                                <span className="ml-2 font-mono text-gray-900 dark:text-white">
                                                                    {
                                                                        registration
                                                                            .payment_gateway
                                                                            .account_number
                                                                    }
                                                                </span>
                                                            </div>
                                                        )}
                                                        {registration.transaction_id && (
                                                            <div>
                                                                <span className="font-medium text-gray-700 dark:text-gray-300">
                                                                    Transaction
                                                                    ID:
                                                                </span>
                                                                <span className="ml-2 font-mono text-gray-900 dark:text-white">
                                                                    {
                                                                        registration.transaction_id
                                                                    }
                                                                </span>
                                                            </div>
                                                        )}
                                                    </div>
                                                </div>
                                            )}

                                        {/* Success Message */}
                                        <div
                                            className={`mb-6 rounded-lg border-l-4 p-4 ${
                                                isFreeCourse
                                                    ? "border-green-500 bg-green-50 dark:bg-green-900/20"
                                                    : registration.payment_status ===
                                                      "verified"
                                                    ? "border-green-500 bg-green-50 dark:bg-green-900/20"
                                                    : "border-blue-500 bg-blue-50 dark:bg-blue-900/20"
                                            }`}
                                        >
                                            <div className="flex items-start gap-3">
                                                <CheckCircle2
                                                    className={`h-6 w-6 flex-shrink-0 ${
                                                        isFreeCourse ||
                                                        registration.payment_status ===
                                                            "verified"
                                                            ? "text-green-600 dark:text-green-400"
                                                            : "text-blue-600 dark:text-blue-400"
                                                    }`}
                                                />
                                                <div>
                                                    <h3
                                                        className={`font-semibold ${
                                                            isFreeCourse ||
                                                            registration.payment_status ===
                                                                "verified"
                                                                ? "text-green-900 dark:text-green-100"
                                                                : "text-blue-900 dark:text-blue-100"
                                                        }`}
                                                    >
                                                        {isFreeCourse
                                                            ? "Enrollment Completed Successfully!"
                                                            : registration.payment_status ===
                                                              "verified"
                                                            ? "Payment Verified - Enrollment Confirmed!"
                                                            : "Registration Submitted Successfully!"}
                                                    </h3>
                                                    <p
                                                        className={`mt-1 text-sm ${
                                                            isFreeCourse ||
                                                            registration.payment_status ===
                                                                "verified"
                                                                ? "text-green-700 dark:text-green-300"
                                                                : "text-blue-700 dark:text-blue-300"
                                                        }`}
                                                    >
                                                        {isFreeCourse
                                                            ? "You have been successfully enrolled in this course. Check your email for course access details."
                                                            : registration.payment_status ===
                                                              "verified"
                                                            ? "Your payment has been verified and your enrollment is confirmed. Check your email for course access details."
                                                            : "Your registration has been submitted. We will verify your payment and contact you soon. An invoice has been sent to your email address."}
                                                    </p>
                                                    {isNewUser && (
                                                        <p
                                                            className={`mt-2 text-sm font-medium ${
                                                                isFreeCourse ||
                                                                registration.payment_status ===
                                                                    "verified"
                                                                    ? "text-green-800 dark:text-green-200"
                                                                    : "text-blue-800 dark:text-blue-200"
                                                            }`}
                                                        >
                                                            ✓ An account has
                                                            been created for
                                                            you. Check your
                                                            email for login
                                                            credentials.
                                                        </p>
                                                    )}
                                                </div>
                                            </div>
                                        </div>

                                        {/* Footer */}
                                        <div className="border-t border-gray-200 dark:border-gray-700 pt-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                            <p>
                                                This is a computer-generated
                                                invoice. No signature required.
                                            </p>
                                        </div>
                                    </div>

                                    {/* Action Buttons */}
                                    <div className="mt-8 flex flex-col sm:flex-row gap-4 pdf-exclude">
                                        <Link
                                            href={route("dashboard", {
                                                section: "courses",
                                            })}
                                            className="flex items-center justify-center gap-2 rounded-lg bg-primary-600 px-6 py-3 text-sm font-semibold text-white shadow-lg transition-all hover:bg-primary-700 hover:shadow-xl"
                                        >
                                            <Home className="h-4 w-4" />
                                            Go to Dashboard
                                        </Link>
                                        <Link
                                            href={route(
                                                "courses.show",
                                                course.slug
                                            )}
                                            className="flex items-center justify-center gap-2 rounded-lg border-2 border-gray-300 dark:border-gray-600 px-6 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300 transition-all hover:bg-gray-50 dark:hover:bg-gray-800"
                                        >
                                            View Course
                                            <ArrowRight className="h-4 w-4" />
                                        </Link>
                                    </div>
                                </Card>
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
