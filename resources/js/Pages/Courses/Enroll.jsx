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
import { useState } from "react";

export default function Enroll({ course }) {
    const { auth } = usePage().props;
    const { data, setData, post, processing, errors } = useForm({
        name: auth?.user?.name || "",
        email: auth?.user?.email || "",
        phone: "",
        address: "",
    });

    const [emailError, setEmailError] = useState("");

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
