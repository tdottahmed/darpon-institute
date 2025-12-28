import { Head, useForm, usePage } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import Button from "@/Components/ui/Button";
import Card from "@/Components/ui/Card";
import TextInput from "@/Components/TextInput";
import InputLabel from "@/Components/InputLabel";
import InputError from "@/Components/InputError";
import ApplicationLogo from "@/Components/ApplicationLogo";
import { useState, useEffect } from "react";
import { formatPrice } from "@/Utils/currency";

export default function Enroll({ course, paymentGateways = [] }) {
    const { auth } = usePage().props;
    const variations = course.variations || [];
    const hasVariations = variations.length > 0;
    
    // Get variation from URL params
    const urlParams = new URLSearchParams(window.location.search);
    const variationFromUrl = urlParams.get("variation");
    const initialVariationId = variationFromUrl && hasVariations 
        ? variations.find(v => String(v.id) === String(variationFromUrl))?.id || null
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
    const [selectedVariationId, setSelectedVariationId] = useState(initialVariationId);

    // Update form data when variation changes
    useEffect(() => {
        setData("course_variation_id", selectedVariationId || "");
    }, [selectedVariationId]);

    // Calculate price based on selected variation or course
    const selectedVariation = selectedVariationId
        ? variations.find((v) => v.id === selectedVariationId)
        : null;

    const priceSource = selectedVariation || course;
    const hasDiscount = priceSource.discount > 0;
    const discountType = priceSource.discount_type || "percentage";

    let totalPrice = Number(priceSource.price) || 0;
    let originalPrice = Number(priceSource.price) || 0;

    if (hasDiscount && priceSource.price) {
        originalPrice = Number(priceSource.price);
        if (discountType === "flat") {
            totalPrice = Math.max(0, Number(priceSource.price) - Number(priceSource.discount));
        } else {
            totalPrice = Number(priceSource.price) - (Number(priceSource.price) * Number(priceSource.discount)) / 100;
        }
    }

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
            onSuccess: () => {
                // Success handled by redirect with flash message
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
                    {/* Background Decorative Elements */}
                    <div className="absolute top-0 left-0 w-full h-96 bg-gradient-to-br from-primary-50 via-secondary-50 to-primary-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 -z-10"></div>
                    <div className="absolute -top-10 right-0 w-96 h-96 bg-primary-200/20 rounded-full blur-3xl dark:bg-primary-900/10 -z-10"></div>
                    <div className="absolute bottom-0 left-0 w-96 h-96 bg-secondary-200/20 rounded-full blur-3xl dark:bg-secondary-900/10 -z-10"></div>

                    <Container>
                        <div className="text-center max-w-2xl mx-auto mb-12">
                            <div className="inline-flex items-center gap-2 px-4 py-2 bg-primary-100 dark:bg-primary-900/30 rounded-full mb-4">
                                <svg
                                    className="w-5 h-5 text-primary-600 dark:text-primary-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                <span className="text-sm font-semibold text-primary-700 dark:text-primary-300">
                                    Course Enrollment
                                </span>
                            </div>
                            <h1 className="text-3xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4 tracking-tight">
                                Complete Your Registration
                            </h1>
                            <p className="text-lg text-gray-600 dark:text-gray-300">
                                You are enrolling in{" "}
                                <span className="text-primary-600 dark:text-primary-400 font-semibold">
                                    {course.title}
                                </span>
                                .
                                {!auth?.user && (
                                    <span className="block mt-2 text-base">
                                        {" "}
                                        We'll create an account for you and send
                                        login credentials to your email.
                                    </span>
                                )}
                            </p>
                        </div>

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
                                        {/* Name Field */}
                                        <div>
                                            <InputLabel
                                                htmlFor="name"
                                                value="Full Name *"
                                                className="text-base font-semibold mb-2"
                                            />
                                            <TextInput
                                                id="name"
                                                type="text"
                                                className="mt-2 block w-full py-3 px-4 bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                                                value={data.name}
                                                onChange={(e) =>
                                                    setData(
                                                        "name",
                                                        e.target.value
                                                    )
                                                }
                                                required
                                                autoFocus
                                                placeholder="e.g. Tanbir Ahmed"
                                            />
                                            <InputError
                                                message={errors.name}
                                                className="mt-2"
                                            />
                                        </div>

                                        {/* Email Field - Mandatory */}
                                        <div>
                                            <InputLabel
                                                htmlFor="email"
                                                value="Email Address *"
                                                className="text-base font-semibold mb-2"
                                            >
                                                Email Address *
                                                {!auth?.user && (
                                                    <span className="ml-2 text-xs font-normal text-gray-500 dark:text-gray-400">
                                                        (We'll send your login
                                                        credentials here)
                                                    </span>
                                                )}
                                            </InputLabel>
                                            <div className="relative">
                                                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg
                                                        className="h-5 w-5 text-gray-400"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                    >
                                                        <path
                                                            strokeLinecap="round"
                                                            strokeLinejoin="round"
                                                            strokeWidth={2}
                                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                                        />
                                                    </svg>
                                                </div>
                                                <TextInput
                                                    id="email"
                                                    type="email"
                                                    className="mt-2 block w-full py-3 pl-10 pr-4 bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                                                    value={data.email}
                                                    onChange={(e) => {
                                                        setData(
                                                            "email",
                                                            e.target.value
                                                        );
                                                        if (emailError)
                                                            validateEmail(
                                                                e.target.value
                                                            );
                                                    }}
                                                    onBlur={() =>
                                                        validateEmail(
                                                            data.email
                                                        )
                                                    }
                                                    required
                                                    placeholder="you@email.com"
                                                />
                                            </div>
                                            {(errors.email || emailError) && (
                                                <InputError
                                                    message={
                                                        errors.email ||
                                                        emailError
                                                    }
                                                    className="mt-2"
                                                />
                                            )}
                                            {!auth?.user && !emailError && (
                                                <p className="mt-2 text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                                    <svg
                                                        className="w-4 h-4"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                    >
                                                        <path
                                                            strokeLinecap="round"
                                                            strokeLinejoin="round"
                                                            strokeWidth={2}
                                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                        />
                                                    </svg>
                                                    Your account credentials
                                                    will be sent to this email
                                                </p>
                                            )}
                                        </div>

                                        {/* Phone Field */}
                                        <div className="grid gap-6 sm:grid-cols-2">
                                            <div>
                                                <InputLabel
                                                    htmlFor="phone"
                                                    value="Phone Number *"
                                                    className="text-base font-semibold mb-2"
                                                />
                                                <div className="relative">
                                                    <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <svg
                                                            className="h-5 w-5 text-gray-400"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor"
                                                        >
                                                            <path
                                                                strokeLinecap="round"
                                                                strokeLinejoin="round"
                                                                strokeWidth={2}
                                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                                            />
                                                        </svg>
                                                    </div>
                                                    <TextInput
                                                        id="phone"
                                                        type="tel"
                                                        className="mt-2 block w-full py-3 pl-10 pr-4 bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                                                        value={data.phone}
                                                        onChange={(e) =>
                                                            setData(
                                                                "phone",
                                                                e.target.value
                                                            )
                                                        }
                                                        required
                                                        placeholder="+880 1XXX XXXXXX"
                                                    />
                                                </div>
                                                <InputError
                                                    message={errors.phone}
                                                    className="mt-2"
                                                />
                                            </div>

                                            <div>
                                                <InputLabel
                                                    htmlFor="address"
                                                    value="Address *"
                                                    className="text-base font-semibold mb-2"
                                                />
                                                <textarea
                                                    id="address"
                                                    className="mt-2 block w-full rounded-lg border-gray-200 bg-gray-50 dark:bg-gray-800 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:text-gray-300 dark:focus:border-primary-600 dark:focus:ring-primary-600 py-3 px-4 min-h-[100px] resize-none"
                                                    rows="3"
                                                    value={data.address}
                                                    onChange={(e) =>
                                                        setData(
                                                            "address",
                                                            e.target.value
                                                        )
                                                    }
                                                    required
                                                    placeholder="Street, Area, City"
                                                />
                                                <InputError
                                                    message={errors.address}
                                                    className="mt-2"
                                                />
                                            </div>
                                        </div>

                                        {/* Course Variation Selection */}
                                        {hasVariations && (
                                            <div className="space-y-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white">
                                                    Select Course Duration
                                                </h3>
                                                <div className="grid gap-3">
                                                    {variations.map((variation) => {
                                                        const varHasDiscount = variation.discount > 0;
                                                        const varDiscountType = variation.discount_type || "percentage";
                                                        let varDiscountedPrice = Number(variation.price) || 0;
                                                        let varOriginalPrice = Number(variation.price) || 0;

                                                        if (varHasDiscount && variation.price) {
                                                            varOriginalPrice = Number(variation.price);
                                                            if (varDiscountType === "flat") {
                                                                varDiscountedPrice = Math.max(
                                                                    0,
                                                                    Number(variation.price) - Number(variation.discount)
                                                                );
                                                            } else {
                                                                varDiscountedPrice =
                                                                    Number(variation.price) -
                                                                    (Number(variation.price) * Number(variation.discount)) / 100;
                                                            }
                                                        }

                                                        const isSelected = selectedVariationId === variation.id;

                                                        return (
                                                            <label
                                                                key={variation.id}
                                                                className={`relative flex cursor-pointer rounded-lg border-2 p-4 transition-all ${
                                                                    isSelected
                                                                        ? "border-primary-500 bg-primary-50 dark:bg-primary-900/20"
                                                                        : "border-gray-200 bg-white hover:border-gray-300 dark:border-gray-700 dark:bg-gray-800"
                                                                }`}
                                                            >
                                                                <input
                                                                    type="radio"
                                                                    name="course_variation_id"
                                                                    value={variation.id}
                                                                    checked={isSelected}
                                                                    onChange={(e) => {
                                                                        setSelectedVariationId(variation.id);
                                                                    }}
                                                                    className="sr-only"
                                                                />
                                                                <div className="flex-1">
                                                                    <div className="flex items-center justify-between">
                                                                        <div>
                                                                            <span className="text-sm font-semibold text-gray-900 dark:text-white">
                                                                                {variation.name}
                                                                            </span>
                                                                            {variation.duration && (
                                                                                <p className="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                                                    {variation.duration}
                                                                                </p>
                                                                            )}
                                                                        </div>
                                                                        <div className="text-right">
                                                                            <span className="text-lg font-bold text-primary-600 dark:text-primary-400">
                                                                                {formatPrice(varDiscountedPrice)}
                                                                            </span>
                                                                            {varHasDiscount && (
                                                                                <p className="text-xs text-gray-400 line-through">
                                                                                    {formatPrice(varOriginalPrice)}
                                                                                </p>
                                                                            )}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {isSelected && (
                                                                    <svg
                                                                        className="h-5 w-5 text-primary-600 dark:text-primary-400 ml-2"
                                                                        fill="currentColor"
                                                                        viewBox="0 0 20 20"
                                                                    >
                                                                        <path
                                                                            fillRule="evenodd"
                                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                            clipRule="evenodd"
                                                                        />
                                                                    </svg>
                                                                )}
                                                            </label>
                                                        );
                                                    })}
                                                </div>
                                                <InputError
                                                    message={errors.course_variation_id}
                                                    className="mt-2"
                                                />
                                            </div>
                                        )}

                                        {/* Price Summary */}
                                        {(totalPrice > 0 || selectedVariation) && (
                                            <div className="bg-primary-50 dark:bg-primary-900/10 rounded-lg p-4 border border-primary-200 dark:border-primary-800">
                                                <div className="flex items-center justify-between">
                                                    <span className="font-semibold text-gray-900 dark:text-white">
                                                        Total Amount:
                                                    </span>
                                                    <span className="text-2xl font-bold text-primary-600 dark:text-primary-400">
                                                        {formatPrice(totalPrice)}
                                                    </span>
                                                </div>
                                                {selectedVariation && (
                                                    <p className="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                        {selectedVariation.name}
                                                        {selectedVariation.duration && ` • ${selectedVariation.duration}`}
                                                    </p>
                                                )}
                                            </div>
                                        )}

                                        {/* Payment Gateway Selection */}
                                        {totalPrice > 0 &&
                                            paymentGateways.length > 0 && (
                                                <div className="space-y-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                                                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white">
                                                        Payment Information
                                                    </h3>

                                                    {/* Payment Gateway Selection */}
                                                    <div>
                                                        <InputLabel
                                                            htmlFor="payment_gateway_id"
                                                            value="Select Payment Method *"
                                                            className="text-base font-semibold mb-2"
                                                        />
                                                        <div className="grid gap-3 sm:grid-cols-2">
                                                            {paymentGateways.map(
                                                                (gateway) => (
                                                                    <label
                                                                        key={
                                                                            gateway.id
                                                                        }
                                                                        className={`relative flex cursor-pointer rounded-lg border-2 p-4 transition-all ${
                                                                            data.payment_gateway_id ==
                                                                            gateway.id
                                                                                ? "border-primary-500 bg-primary-50 dark:bg-primary-900/20"
                                                                                : "border-gray-200 bg-white hover:border-gray-300 dark:border-gray-700 dark:bg-gray-800"
                                                                        }`}
                                                                    >
                                                                        <input
                                                                            type="radio"
                                                                            name="payment_gateway_id"
                                                                            value={
                                                                                gateway.id
                                                                            }
                                                                            checked={
                                                                                data.payment_gateway_id ==
                                                                                gateway.id
                                                                            }
                                                                            onChange={(
                                                                                e
                                                                            ) =>
                                                                                setData(
                                                                                    "payment_gateway_id",
                                                                                    e
                                                                                        .target
                                                                                        .value
                                                                                )
                                                                            }
                                                                            className="sr-only"
                                                                        />
                                                                        <div className="flex-1">
                                                                            <div className="flex items-center justify-between">
                                                                                <span className="text-sm font-semibold text-gray-900 dark:text-white">
                                                                                    {
                                                                                        gateway.name
                                                                                    }
                                                                                </span>
                                                                                {data.payment_gateway_id ==
                                                                                    gateway.id && (
                                                                                    <svg
                                                                                        className="h-5 w-5 text-primary-600 dark:text-primary-400"
                                                                                        fill="currentColor"
                                                                                        viewBox="0 0 20 20"
                                                                                    >
                                                                                        <path
                                                                                            fillRule="evenodd"
                                                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                                            clipRule="evenodd"
                                                                                        />
                                                                                    </svg>
                                                                                )}
                                                                            </div>
                                                                            {gateway.account_number && (
                                                                                <p className="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                                                    {
                                                                                        gateway.account_number
                                                                                    }
                                                                                </p>
                                                                            )}
                                                                            {gateway.instructions && (
                                                                                <p className="mt-2 text-xs text-gray-600 dark:text-gray-300">
                                                                                    {
                                                                                        gateway.instructions
                                                                                    }
                                                                                </p>
                                                                            )}
                                                                        </div>
                                                                    </label>
                                                                )
                                                            )}
                                                        </div>
                                                        <InputError
                                                            message={
                                                                errors.payment_gateway_id
                                                            }
                                                            className="mt-2"
                                                        />
                                                    </div>

                                                    {/* Transaction ID */}
                                                    {data.payment_gateway_id && (
                                                        <>
                                                            <div>
                                                                <InputLabel
                                                                    htmlFor="transaction_id"
                                                                    value="Transaction ID *"
                                                                    className="text-base font-semibold mb-2"
                                                                />
                                                                <TextInput
                                                                    id="transaction_id"
                                                                    type="text"
                                                                    className="mt-2 block w-full py-3 px-4 bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                                                                    value={
                                                                        data.transaction_id
                                                                    }
                                                                    onChange={(
                                                                        e
                                                                    ) =>
                                                                        setData(
                                                                            "transaction_id",
                                                                            e
                                                                                .target
                                                                                .value
                                                                        )
                                                                    }
                                                                    required
                                                                    placeholder="Enter your transaction ID"
                                                                />
                                                                <InputError
                                                                    message={
                                                                        errors.transaction_id
                                                                    }
                                                                    className="mt-2"
                                                                />
                                                            </div>

                                                            {/* Payment Screenshot */}
                                                            <div>
                                                                <InputLabel
                                                                    htmlFor="payment_screenshot"
                                                                    value="Payment Screenshot (Optional)"
                                                                    className="text-base font-semibold mb-2"
                                                                />
                                                                <div className="mt-2">
                                                                    <input
                                                                        id="payment_screenshot"
                                                                        type="file"
                                                                        accept="image/*"
                                                                        onChange={(
                                                                            e
                                                                        ) =>
                                                                            setData(
                                                                                "payment_screenshot",
                                                                                e
                                                                                    .target
                                                                                    .files[0]
                                                                            )
                                                                        }
                                                                        className="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-300"
                                                                    />
                                                                    {data.payment_screenshot && (
                                                                        <p className="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                                                            Selected:{" "}
                                                                            {
                                                                                data
                                                                                    .payment_screenshot
                                                                                    .name
                                                                            }
                                                                        </p>
                                                                    )}
                                                                </div>
                                                                <InputError
                                                                    message={
                                                                        errors.payment_screenshot
                                                                    }
                                                                    className="mt-2"
                                                                />
                                                            </div>
                                                        </>
                                                    )}
                                                </div>
                                            )}

                                        {/* Info Box for New Users */}
                                        {!auth?.user && (
                                            <div className="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                                <div className="flex items-start gap-3">
                                                    <svg
                                                        className="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 shrink-0"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                    >
                                                        <path
                                                            strokeLinecap="round"
                                                            strokeLinejoin="round"
                                                            strokeWidth={2}
                                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                        />
                                                    </svg>
                                                    <div className="text-sm text-blue-800 dark:text-blue-200">
                                                        <p className="font-semibold mb-1">
                                                            New Account Creation
                                                        </p>
                                                        <p>
                                                            We'll automatically
                                                            create an account
                                                            for you and send
                                                            your login
                                                            credentials to the
                                                            email address
                                                            provided above. Make
                                                            sure to check your
                                                            inbox (and spam
                                                            folder) after
                                                            registration.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        )}

                                        {/* Submit Button */}
                                        <div className="pt-6">
                                            <Button
                                                type="submit"
                                                variant="primary"
                                                size="xl"
                                                className="w-full justify-center text-lg font-bold py-4 shadow-xl shadow-primary-500/30 hover:shadow-primary-500/50 hover:-translate-y-1 transition-all duration-300"
                                                disabled={
                                                    processing || !!emailError
                                                }
                                            >
                                                {processing ? (
                                                    <span className="flex items-center gap-2">
                                                        <svg
                                                            className="animate-spin h-5 w-5 text-white"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                        >
                                                            <circle
                                                                className="opacity-25"
                                                                cx="12"
                                                                cy="12"
                                                                r="10"
                                                                stroke="currentColor"
                                                                strokeWidth="4"
                                                            ></circle>
                                                            <path
                                                                className="opacity-75"
                                                                fill="currentColor"
                                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                                            ></path>
                                                        </svg>
                                                        Processing...
                                                    </span>
                                                ) : (
                                                    <>
                                                        <svg
                                                            className="w-5 h-5 mr-2"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor"
                                                        >
                                                            <path
                                                                strokeLinecap="round"
                                                                strokeLinejoin="round"
                                                                strokeWidth={2}
                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                            />
                                                        </svg>
                                                        Complete Registration
                                                    </>
                                                )}
                                            </Button>
                                            <p className="mt-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                                By clicking "Complete
                                                Registration", you agree to our
                                                Terms of Service and Privacy
                                                Policy.
                                            </p>
                                        </div>
                                    </form>
                                </Card>
                            </div>

                            {/* Right Column: Course Info */}
                            <div className="lg:col-span-2 order-1 lg:order-2 space-y-6">
                                <div className="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700 sticky top-24">
                                    <div className="aspect-video w-full rounded-xl overflow-hidden mb-6 relative group">
                                        {thumbnailUrl ? (
                                            <img
                                                src={thumbnailUrl}
                                                alt={course.title}
                                                className="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                                            />
                                        ) : (
                                            <div className="flex h-full items-center justify-center bg-gradient-to-br from-primary-100 to-secondary-100 dark:from-primary-900/40 dark:to-secondary-900/40">
                                                <ApplicationLogo className="h-16 w-16 opacity-30" />
                                            </div>
                                        )}
                                        <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                        <div className="absolute bottom-4 left-4 text-white">
                                            <p className="text-sm font-medium opacity-90">
                                                Course Preview
                                            </p>
                                            <h3 className="text-xl font-bold">
                                                {course.title}
                                            </h3>
                                        </div>
                                    </div>

                                    <h4 className="font-bold text-gray-900 dark:text-white mb-4 text-lg">
                                        What you'll get:
                                    </h4>
                                    <ul className="space-y-3">
                                        {[
                                            "Unlimited access to all course materials",
                                            "Expert instruction and support",
                                            "Certificate of completion",
                                            "Community access and networking",
                                            "Lifetime updates and new content",
                                        ].map((item, i) => (
                                            <li
                                                key={i}
                                                className="flex items-start gap-3 text-gray-600 dark:text-gray-300"
                                            >
                                                <div className="mt-1 h-5 w-5 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center flex-shrink-0 text-green-600 dark:text-green-400">
                                                    <svg
                                                        className="w-3 h-3"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                    >
                                                        <path
                                                            strokeLinecap="round"
                                                            strokeLinejoin="round"
                                                            strokeWidth={3}
                                                            d="M5 13l4 4L19 7"
                                                        />
                                                    </svg>
                                                </div>
                                                <span className="text-sm leading-relaxed">
                                                    {item}
                                                </span>
                                            </li>
                                        ))}
                                    </ul>
                                </div>

                                {/* Trust Indicators */}
                                <div className="bg-primary-50 dark:bg-primary-900/10 rounded-xl p-6 border border-primary-100 dark:border-primary-800/20">
                                    <div className="flex gap-1 text-yellow-500 mb-3">
                                        {[1, 2, 3, 4, 5].map((i) => (
                                            <span key={i} className="text-lg">
                                                ★
                                            </span>
                                        ))}
                                    </div>
                                    <p className="text-sm text-gray-700 dark:text-gray-300 italic mb-4">
                                        "This course changed the way I learn.
                                        Highly recommended for anyone looking to
                                        improve quickly."
                                    </p>
                                    <div className="flex items-center gap-3">
                                        <div className="h-10 w-10 rounded-full bg-primary-200 dark:bg-primary-800 flex items-center justify-center text-sm font-bold text-primary-700 dark:text-primary-300">
                                            SJ
                                        </div>
                                        <div>
                                            <p className="text-sm font-bold text-gray-900 dark:text-white">
                                                Sarah Johnson
                                            </p>
                                            <p className="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                                Student
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Container>
                </main>
                <Footer />
            </div>
        </>
    );
}
