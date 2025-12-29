import { Head, useForm, usePage } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import Card from "@/Components/ui/Card";
import CourseEnrollmentInvoiceDialog from "@/Components/CourseEnrollmentInvoiceDialog";
import { useState, useEffect } from "react";
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

export default function Enroll({
    course,
    paymentGateways = [],
    registration = null,
    totalPrice: registrationTotalPrice = 0,
    showInvoice = false,
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
    const [invoiceOpen, setInvoiceOpen] = useState(showInvoice);

    // Update form data when variation changes
    useEffect(() => {
        setData("course_variation_id", selectedVariationId || "");
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [selectedVariationId]);

    // Show invoice dialog if registration was just created
    useEffect(() => {
        if (showInvoice && registration) {
            setInvoiceOpen(true);
        }
    }, [showInvoice, registration]);

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
                // Success handled by invoice dialog
            },
            onError: (errors) => {
                if (errors.email) {
                    setEmailError(errors.email);
                }
            },
        });
    };

    const thumbnailUrl = course.thumbnail
        ? course.thumbnail.startsWith("http")
            ? course.thumbnail
            : `/storage/${course.thumbnail}`
        : null;

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

            {/* Invoice Dialog */}
            {registration && (
                <CourseEnrollmentInvoiceDialog
                    isOpen={invoiceOpen}
                    onClose={() => {
                        setInvoiceOpen(false);
                        // Optionally redirect to course page
                        window.location.href = route(
                            "courses.show",
                            course.slug
                        );
                    }}
                    registration={{ ...registration, is_new_user: isNewUser }}
                    course={course}
                    totalPrice={totalPrice}
                />
            )}
        </>
    );
}
