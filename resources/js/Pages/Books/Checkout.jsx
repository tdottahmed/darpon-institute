import { Head, useForm, usePage, Link } from "@inertiajs/react";
import Header from "@/Components/layout/Header";
import Footer from "@/Components/layout/Footer";
import Container from "@/Components/ui/Container";
import PrimaryButton from "@/Components/ui/PrimaryButton";
import Card from "@/Components/ui/Card";
import TextInput from "@/Components/TextInput";
import InputLabel from "@/Components/InputLabel";
import InputError from "@/Components/InputError";
import { useState, useEffect, useRef } from "react";
import { formatPrice } from "@/Utils/currency";
import {
    Download,
    CheckCircle2,
    ArrowRight,
    Home,
    CreditCard,
    User,
    Mail,
    Phone,
    MapPin,
    Truck,
    Loader2,
} from "lucide-react";
import { generatePDF } from "@/Utils/pdfGenerator";

// ── BD phone helpers ──────────────────────────────────────────────────────────
function formatBDPhone(digits) {
    const d = digits.replace(/\D/g, "").slice(0, 11);
    if (d.length <= 3) return d;
    if (d.length <= 7) return `${d.slice(0, 3)} ${d.slice(3)}`;
    return `${d.slice(0, 3)} ${d.slice(3, 7)} ${d.slice(7)}`;
}
function validateBDPhone(digits) {
    const d = digits.replace(/\D/g, "");
    if (!d) return "Phone number is required";
    if (d.length !== 11) return "Must be 11 digits (e.g. 017XX XXXXXX)";
    if (!/^01[3-9]\d{8}$/.test(d)) return "Enter a valid BD mobile number";
    return "";
}

export default function Checkout({ book, order = null, isNewUser = false }) {
    const { settings, auth } = usePage().props;
    const logoSrc = settings?.logo_light || "/darponbdv.png";
    const user = auth?.user;

    const { data, setData, post, processing, errors } = useForm({
        name: user?.name || "",
        email: user?.email || "",
        phone: "",
        address: "",
        quantity: 1,
        shipping_method: "inside_dhaka",
        note: "",
    });

    const [shippingCost, setShippingCost] = useState(60);
    const [isGeneratingPDF, setIsGeneratingPDF] = useState(false);
    const [phoneDisplay, setPhoneDisplay] = useState("");
    const [phoneError, setPhoneError] = useState("");
    const invoiceContentRef = useRef(null);

    const price =
        book.discount > 0
            ? book.price - book.price * (book.discount / 100)
            : book.price;

    const [total, setTotal] = useState(price + shippingCost);

    useEffect(() => {
        const cost = data.shipping_method === "inside_dhaka" ? 60 : 120;
        setShippingCost(cost);
        setTotal(price * data.quantity + cost);
    }, [data.shipping_method, data.quantity, price]);

    useEffect(() => {
        if (order) window.scrollTo({ top: 0, behavior: "smooth" });
    }, [order]);

    // Phone handlers
    const handlePhoneChange = (e) => {
        const raw = e.target.value.replace(/\D/g, "").slice(0, 11);
        setPhoneDisplay(formatBDPhone(raw));
        const intl =
            raw.length >= 2 && raw.startsWith("0")
                ? "+880" + raw.slice(1)
                : raw
                  ? "+880" + raw
                  : "";
        setData("phone", intl || raw);
        if (phoneError) setPhoneError(validateBDPhone(raw));
    };
    const handlePhoneBlur = () => {
        setPhoneError(validateBDPhone(phoneDisplay.replace(/\D/g, "")));
    };

    const submit = (e) => {
        e.preventDefault();
        const rawDigits = phoneDisplay.replace(/\D/g, "");
        const err = validateBDPhone(rawDigits);
        if (err) {
            setPhoneError(err);
            return;
        }
        post(route("books.checkout.store", book.slug), {
            preserveScroll: true,
        });
    };

    const handleDownloadPDF = async () => {
        if (!invoiceContentRef.current || !order) return;
        const invoiceNumber = `ORD-${String(order.id).padStart(6, "0")}`;
        await generatePDF(
            invoiceContentRef.current,
            `Invoice-${invoiceNumber}.pdf`,
            {
                onStart: () => setIsGeneratingPDF(true),
                onSuccess: () => setIsGeneratingPDF(false),
                onError: () => setIsGeneratingPDF(false),
            },
        );
    };

    // ── Invoice view ────────────────────────────────────────────────────────
    if (order) {
        const unitPrice =
            (order.total_amount - order.shipping_cost) / order.quantity;
        const invoiceNumber = `ORD-${String(order.id).padStart(6, "0")}`;

        return (
            <>
                <Head title={`Order Confirmation - ${book.title}`} />
                <div className="min-h-screen bg-gradient-to-b from-primary-50 via-white to-gray-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-900 font-sans flex flex-col">
                    <Header />

                    <main className="flex-grow pt-20 pb-12">
                        <Container>
                            <div className="max-w-2xl mx-auto">
                                {/* Status bar */}
                                <div className="mb-4 flex items-center justify-center gap-2.5 rounded-2xl bg-green-500 px-5 py-3 text-sm font-semibold text-white shadow-sm">
                                    <CheckCircle2 className="h-5 w-5 shrink-0" />
                                    Order placed! We'll contact you to arrange
                                    delivery.
                                </div>

                                {/* Decorative shell — NOT the ref */}
                                <div className="rounded-2xl overflow-hidden shadow-xl ring-1 ring-black/5 dark:ring-white/5">
                                    {/* Invoice printable area */}
                                    <div
                                        ref={invoiceContentRef}
                                        className="invoice-content bg-white dark:bg-gray-800"
                                    >
                                        {/* ── Header band ── */}
                                        <div className="relative bg-gradient-to-br from-primary-600 via-primary-700 to-secondary-600 overflow-hidden">
                                            <div
                                                className="absolute inset-0 opacity-10"
                                                style={{
                                                    backgroundImage:
                                                        "radial-gradient(circle, white 1px, transparent 1px)",
                                                    backgroundSize: "18px 18px",
                                                }}
                                            />

                                            <div className="relative px-5 pt-6 pb-5 sm:px-8 sm:pt-7 sm:pb-6">
                                                <div className="flex items-start justify-between gap-4 mb-5">
                                                    <div>
                                                        <p className="text-xs font-semibold uppercase tracking-widest text-white/60 mb-1">
                                                            Book Order
                                                        </p>
                                                        <h1 className="text-3xl sm:text-4xl font-black text-white tracking-tight">
                                                            INVOICE
                                                        </h1>
                                                    </div>
                                                    <img
                                                        src={logoSrc}
                                                        alt="Logo"
                                                        className="h-10 sm:h-12 w-auto object-contain brightness-0 invert mt-1"
                                                        onError={(e) => {
                                                            e.target.style.display =
                                                                "none";
                                                        }}
                                                    />
                                                </div>
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
                                                                    order.created_at,
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
                                                        <tr>
                                                            <td className="py-1.5 pr-4 font-medium text-white/60 whitespace-nowrap">
                                                                Status
                                                            </td>
                                                            <td className="py-1.5">
                                                                <span className="inline-flex font-semibold uppercase tracking-wide text-white">
                                                                    {
                                                                        order.status
                                                                    }
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {/* ── Body ── */}
                                        <div className="px-5 py-6 sm:px-8 sm:py-7 space-y-6">
                                            {/* Customer info */}
                                            <section>
                                                <h2 className="mb-3 text-[11px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                                                    Customer Information
                                                </h2>
                                                <div className="grid grid-cols-2 gap-3">
                                                    {[
                                                        {
                                                            icon: (
                                                                <User className="h-3.5 w-3.5" />
                                                            ),
                                                            label: "Full Name",
                                                            value: order.name,
                                                        },
                                                        {
                                                            icon: (
                                                                <Mail className="h-3.5 w-3.5" />
                                                            ),
                                                            label: "Email",
                                                            value: order.email,
                                                            truncate: true,
                                                        },
                                                        {
                                                            icon: (
                                                                <Phone className="h-3.5 w-3.5" />
                                                            ),
                                                            label: "Phone",
                                                            value: order.phone,
                                                        },
                                                        {
                                                            icon: (
                                                                <Truck className="h-3.5 w-3.5" />
                                                            ),
                                                            label: "Shipping",
                                                            value:
                                                                order.shipping_method ===
                                                                "inside_dhaka"
                                                                    ? "Inside Dhaka"
                                                                    : "Outside Dhaka",
                                                        },
                                                    ].map(
                                                        ({
                                                            icon,
                                                            label,
                                                            value,
                                                            truncate,
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
                                                                    className={`text-sm font-semibold text-gray-900 dark:text-white ${truncate ? "truncate" : ""}`}
                                                                >
                                                                    {value}
                                                                </p>
                                                            </div>
                                                        ),
                                                    )}
                                                    <div className="col-span-2 rounded-xl bg-gray-50 dark:bg-gray-700/50 px-3.5 py-3">
                                                        <div className="flex items-center gap-1.5 text-gray-400 dark:text-gray-500 mb-1">
                                                            <MapPin className="h-3.5 w-3.5" />
                                                            <span className="text-[10px] font-bold uppercase tracking-wider">
                                                                Delivery Address
                                                            </span>
                                                        </div>
                                                        <p className="text-sm font-semibold text-gray-900 dark:text-white whitespace-pre-wrap">
                                                            {order.address}
                                                        </p>
                                                    </div>
                                                </div>
                                            </section>

                                            <div className="border-t border-dashed border-gray-200 dark:border-gray-700" />

                                            {/* Order details */}
                                            <section>
                                                <h2 className="mb-3 text-[11px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                                                    Order Details
                                                </h2>
                                                <div className="rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                                                    {/* Item row */}
                                                    <div className="px-4 py-4 bg-gray-50 dark:bg-gray-700/40">
                                                        <div className="flex items-start justify-between gap-3">
                                                            <div className="min-w-0">
                                                                <p className="font-bold text-gray-900 dark:text-white leading-snug">
                                                                    {book?.title ||
                                                                        "Unknown Book"}
                                                                </p>
                                                                {book?.author && (
                                                                    <p className="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                                                        by{" "}
                                                                        {
                                                                            book.author
                                                                        }
                                                                    </p>
                                                                )}
                                                                <p className="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                                    {formatPrice(
                                                                        unitPrice,
                                                                    )}{" "}
                                                                    ×{" "}
                                                                    {
                                                                        order.quantity
                                                                    }
                                                                </p>
                                                            </div>
                                                            <span className="shrink-0 text-base font-bold text-gray-900 dark:text-white">
                                                                {formatPrice(
                                                                    order.total_amount -
                                                                        order.shipping_cost,
                                                                )}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    {/* Shipping row */}
                                                    <div className="flex items-center justify-between px-4 py-3 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
                                                        <span className="text-sm text-gray-500 dark:text-gray-400">
                                                            Shipping
                                                        </span>
                                                        <span className="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                            {formatPrice(
                                                                order.shipping_cost,
                                                            )}
                                                        </span>
                                                    </div>
                                                    {/* Total row */}
                                                    <div className="flex items-center justify-between px-4 py-3 bg-primary-600 dark:bg-primary-700">
                                                        <span className="text-sm font-bold text-white/80">
                                                            Total Amount
                                                        </span>
                                                        <span className="text-xl font-black text-white">
                                                            {formatPrice(
                                                                order.total_amount,
                                                            )}
                                                        </span>
                                                    </div>
                                                </div>
                                            </section>

                                            {/* Payment method */}
                                            <section>
                                                <div className="flex items-center gap-3 rounded-xl bg-primary-50 dark:bg-primary-900/20 border border-primary-100 dark:border-primary-800 px-4 py-3">
                                                    <CreditCard className="h-5 w-5 shrink-0 text-primary-600 dark:text-primary-400" />
                                                    <div>
                                                        <p className="text-sm font-bold text-gray-900 dark:text-white">
                                                            Cash on Delivery
                                                            (COD)
                                                        </p>
                                                        <p className="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                            Pay{" "}
                                                            {formatPrice(
                                                                order.total_amount,
                                                            )}{" "}
                                                            when you receive
                                                            your order.
                                                        </p>
                                                    </div>
                                                </div>
                                            </section>

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
                                {/* /decorative shell */}

                                {/* Action buttons — outside PDF capture */}
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
                                            section: "books",
                                        })}
                                        className="flex items-center justify-center gap-2 rounded-xl bg-primary-600 px-4 py-3 text-sm font-semibold text-white shadow-lg transition-all hover:bg-primary-700"
                                    >
                                        <Home className="h-4 w-4" />
                                        Dashboard
                                    </Link>
                                    <Link
                                        href={route("books.show", book.slug)}
                                        className="col-span-2 flex items-center justify-center gap-2 rounded-xl border-2 border-primary-200 dark:border-primary-800 text-primary-600 dark:text-primary-400 px-4 py-3 text-sm font-semibold transition-all hover:bg-primary-50 dark:hover:bg-primary-900/20"
                                    >
                                        View Book Page
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

    // ── Checkout form ────────────────────────────────────────────────────────
    return (
        <>
            <Head title={`Checkout - ${book.title}`} />
            <div className="min-h-screen bg-gray-50 dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100">
                <Header />

                <main className="pt-24 pb-16">
                    <Container>
                        <form
                            onSubmit={submit}
                            className="grid gap-8 lg:grid-cols-3"
                        >
                            {/* Left Column: Shipping */}
                            <div className="lg:col-span-2 space-y-6">
                                <Card variant="elevated" className="p-6 sm:p-8">
                                    <h2 className="text-xl font-bold text-gray-900 dark:text-white mb-6">
                                        Shipping Information
                                    </h2>

                                    <div className="space-y-6">
                                        {/* Name & Phone */}
                                        <div className="grid gap-6 sm:grid-cols-2">
                                            <div>
                                                <InputLabel
                                                    htmlFor="name"
                                                    value="Full Name"
                                                />
                                                <TextInput
                                                    id="name"
                                                    type="text"
                                                    className={`mt-1 block w-full ${user ? "bg-gray-50 dark:bg-gray-800 cursor-not-allowed opacity-75" : ""}`}
                                                    value={data.name}
                                                    onChange={(e) =>
                                                        !user &&
                                                        setData(
                                                            "name",
                                                            e.target.value,
                                                        )
                                                    }
                                                    readOnly={!!user}
                                                    required
                                                    placeholder="e.g. Tanbir Ahmed"
                                                />
                                                <InputError
                                                    message={errors.name}
                                                    className="mt-2"
                                                />
                                            </div>

                                            {/* BD Phone */}
                                            <div>
                                                <InputLabel
                                                    htmlFor="phone"
                                                    value="Phone Number"
                                                />
                                                <div className="mt-1 flex rounded-lg shadow-sm overflow-hidden border border-gray-300 dark:border-gray-600 focus-within:ring-2 focus-within:ring-primary-500 focus-within:border-primary-500 transition-all">
                                                    <div className="flex items-center gap-1.5 px-3 bg-gray-100 dark:bg-gray-700 border-r border-gray-300 dark:border-gray-600 shrink-0 select-none">
                                                        <span className="text-base leading-none">
                                                            🇧🇩
                                                        </span>
                                                        <span className="text-sm font-semibold text-gray-700 dark:text-gray-200">
                                                            +880
                                                        </span>
                                                    </div>
                                                    <input
                                                        id="phone"
                                                        type="tel"
                                                        inputMode="numeric"
                                                        className="flex-1 py-2.5 px-3 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none text-sm"
                                                        value={phoneDisplay}
                                                        onChange={
                                                            handlePhoneChange
                                                        }
                                                        onBlur={handlePhoneBlur}
                                                        required
                                                        placeholder="01X XXXX XXXX"
                                                        maxLength={14}
                                                    />
                                                </div>
                                                {errors.phone || phoneError ? (
                                                    <InputError
                                                        message={
                                                            errors.phone ||
                                                            phoneError
                                                        }
                                                        className="mt-2"
                                                    />
                                                ) : (
                                                    <p className="mt-1.5 text-xs text-gray-400 dark:text-gray-500">
                                                        11-digit Bangladeshi
                                                        number
                                                    </p>
                                                )}
                                            </div>
                                        </div>

                                        {/* Email */}
                                        <div>
                                            <InputLabel
                                                htmlFor="email"
                                                value="Email Address"
                                            />
                                            <TextInput
                                                id="email"
                                                type="email"
                                                className={`mt-1 block w-full ${user ? "bg-gray-50 dark:bg-gray-800 cursor-not-allowed opacity-75" : ""}`}
                                                value={data.email}
                                                onChange={(e) =>
                                                    !user &&
                                                    setData(
                                                        "email",
                                                        e.target.value,
                                                    )
                                                }
                                                readOnly={!!user}
                                                required
                                                placeholder="you@email.com"
                                            />
                                            {user && (
                                                <p className="mt-1.5 text-xs text-gray-400 dark:text-gray-500">
                                                    Linked to your account
                                                </p>
                                            )}
                                            <InputError
                                                message={errors.email}
                                                className="mt-2"
                                            />
                                        </div>

                                        {/* Address */}
                                        <div>
                                            <InputLabel
                                                htmlFor="address"
                                                value="Delivery Address"
                                            />
                                            <textarea
                                                id="address"
                                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-primary-600 dark:focus:ring-primary-600"
                                                rows="3"
                                                value={data.address}
                                                onChange={(e) =>
                                                    setData(
                                                        "address",
                                                        e.target.value,
                                                    )
                                                }
                                                required
                                                placeholder="House, Road, Area, City"
                                            />
                                            <InputError
                                                message={errors.address}
                                                className="mt-2"
                                            />
                                        </div>

                                        {/* Shipping Method */}
                                        <div>
                                            <InputLabel
                                                value="Shipping Area"
                                                className="mb-2"
                                            />
                                            <div className="grid gap-4 sm:grid-cols-2">
                                                {[
                                                    {
                                                        value: "inside_dhaka",
                                                        label: "Inside Dhaka",
                                                        time: "2–3 Days Delivery",
                                                        price: 60,
                                                    },
                                                    {
                                                        value: "outside_dhaka",
                                                        label: "Outside Dhaka",
                                                        time: "3–5 Days Delivery",
                                                        price: 120,
                                                    },
                                                ].map((opt) => (
                                                    <label
                                                        key={opt.value}
                                                        className={`relative flex cursor-pointer rounded-xl border p-4 shadow-sm transition-all ${
                                                            data.shipping_method ===
                                                            opt.value
                                                                ? "border-primary-500 ring-2 ring-primary-500 bg-primary-50 dark:bg-primary-900/20"
                                                                : "border-gray-300 dark:border-gray-700 hover:border-gray-400"
                                                        }`}
                                                    >
                                                        <input
                                                            type="radio"
                                                            name="shipping_method"
                                                            value={opt.value}
                                                            className="sr-only"
                                                            checked={
                                                                data.shipping_method ===
                                                                opt.value
                                                            }
                                                            onChange={(e) =>
                                                                setData(
                                                                    "shipping_method",
                                                                    e.target
                                                                        .value,
                                                                )
                                                            }
                                                        />
                                                        <span className="flex flex-1 flex-col">
                                                            <span className="text-sm font-semibold text-gray-900 dark:text-white">
                                                                {opt.label}
                                                            </span>
                                                            <span className="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                                                {opt.time}
                                                            </span>
                                                        </span>
                                                        <span className="text-sm font-bold text-primary-600 dark:text-primary-400 shrink-0">
                                                            {formatPrice(
                                                                opt.price,
                                                            )}
                                                        </span>
                                                    </label>
                                                ))}
                                            </div>
                                        </div>

                                        {/* Note */}
                                        <div>
                                            <InputLabel
                                                htmlFor="note"
                                                value="Order Note (Optional)"
                                            />
                                            <TextInput
                                                id="note"
                                                type="text"
                                                className="mt-1 block w-full"
                                                value={data.note}
                                                onChange={(e) =>
                                                    setData(
                                                        "note",
                                                        e.target.value,
                                                    )
                                                }
                                                placeholder="Any special instructions…"
                                            />
                                        </div>
                                    </div>
                                </Card>
                            </div>

                            {/* Right Column: Order Summary */}
                            <div className="lg:col-span-1">
                                <div className="sticky top-24 space-y-6">
                                    <Card variant="elevated" className="p-6">
                                        <h2 className="text-lg font-bold text-gray-900 dark:text-white mb-4">
                                            Order Summary
                                        </h2>

                                        <div className="flex gap-4 mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                                            <div className="h-16 w-12 shrink-0 overflow-hidden rounded-md border border-gray-200 dark:border-gray-700">
                                                {book.cover_image ? (
                                                    <img
                                                        src={`/storage/${book.cover_image}`}
                                                        alt={book.title}
                                                        className="h-full w-full object-cover object-center"
                                                    />
                                                ) : (
                                                    <div className="flex h-full w-full items-center justify-center bg-gray-100 dark:bg-gray-700 text-xs text-gray-400">
                                                        No img
                                                    </div>
                                                )}
                                            </div>
                                            <div className="flex flex-1 flex-col min-w-0">
                                                <div className="flex justify-between gap-2 text-sm font-semibold text-gray-900 dark:text-white">
                                                    <h3 className="line-clamp-2">
                                                        {book.title}
                                                    </h3>
                                                    <p className="shrink-0">
                                                        {formatPrice(price)}
                                                    </p>
                                                </div>
                                                <p className="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                    Qty {data.quantity}
                                                </p>
                                            </div>
                                        </div>

                                        <div className="space-y-2 text-sm">
                                            <div className="flex justify-between text-gray-600 dark:text-gray-400">
                                                <p>Subtotal</p>
                                                <p>
                                                    {formatPrice(
                                                        price * data.quantity,
                                                    )}
                                                </p>
                                            </div>
                                            <div className="flex justify-between text-gray-600 dark:text-gray-400">
                                                <p>Shipping</p>
                                                <p>
                                                    {formatPrice(shippingCost)}
                                                </p>
                                            </div>
                                            <div className="border-t border-gray-100 dark:border-gray-700 pt-2 flex justify-between font-bold text-gray-900 dark:text-white">
                                                <p>Total</p>
                                                <p>{formatPrice(total)}</p>
                                            </div>
                                        </div>

                                        <div className="mt-5 rounded-xl bg-gray-50 dark:bg-gray-800 p-4 flex items-start gap-3">
                                            <CreditCard className="h-5 w-5 text-primary-600 dark:text-primary-400 shrink-0 mt-0.5" />
                                            <div>
                                                <p className="text-sm font-semibold text-gray-900 dark:text-white">
                                                    Cash on Delivery
                                                </p>
                                                <p className="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                                    Pay when you receive your
                                                    order.
                                                </p>
                                            </div>
                                        </div>

                                        <PrimaryButton
                                            className="w-full mt-5 justify-center"
                                            disabled={processing}
                                            showIcon={false}
                                        >
                                            {processing
                                                ? "Placing Order…"
                                                : "Confirm Order"}
                                        </PrimaryButton>
                                    </Card>
                                </div>
                            </div>
                        </form>
                    </Container>
                </main>
                <Footer />
            </div>
        </>
    );
}
