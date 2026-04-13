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
import { Download, CheckCircle2, ArrowRight, Home, CreditCard } from "lucide-react";
import { generatePDF } from "@/Utils/pdfGenerator";

export default function Checkout({ book, order = null, isNewUser = false }) {
    const { data, setData, post, processing, errors } = useForm({
        name: "",
        email: "",
        phone: "",
        address: "",
        quantity: 1,
        shipping_method: "inside_dhaka",
        note: "",
    });

    const [shippingCost, setShippingCost] = useState(60);
    const [isGeneratingPDF, setIsGeneratingPDF] = useState(false);
    const invoiceContentRef = useRef(null);
    
    // Calculate price (handling discount if exists)
    const price = book.discount > 0 
        ? book.price - (book.price * (book.discount / 100)) 
        : book.price;

    const [total, setTotal] = useState(price + shippingCost);

    useEffect(() => {
        const cost = data.shipping_method === 'inside_dhaka' ? 60 : 120;
        setShippingCost(cost);
        setTotal((price * data.quantity) + cost);
    }, [data.shipping_method, data.quantity, price]);

    // Scroll to top when order is received
    useEffect(() => {
        if (order) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }, [order]);

    const submit = (e) => {
        e.preventDefault();
        post(route("books.checkout.store", book.slug), {
            preserveScroll: true,
        });
    };

    const handleDownloadPDF = async () => {
        if (!invoiceContentRef.current || !order) return;

        const invoiceNumber = `ORD-${String(order.id).padStart(6, "0")}`;
        const filename = `Invoice-${invoiceNumber}.pdf`;

        await generatePDF(invoiceContentRef.current, filename, {
            onStart: () => setIsGeneratingPDF(true),
            onSuccess: () => setIsGeneratingPDF(false),
            onError: () => setIsGeneratingPDF(false),
        });
    };

    // If order exists, show invoice instead of form
    if (order) {
        const unitPrice = (order.total_amount - order.shipping_cost) / order.quantity;
        
        return (
            <>
                <Head title={`Order Confirmation - ${book.title}`} />
                <div className="min-h-screen bg-gray-50 dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100">
                    <Header />

                    <main className="pt-24 pb-16">
                        <Container>
                            <div className="max-w-4xl mx-auto">
                                {/* Success Header */}
                                <div className="mb-6 text-center">
                                    <div className="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 dark:bg-green-900/30 mb-4">
                                        <CheckCircle2 className="h-8 w-8 text-green-600 dark:text-green-400" />
                                    </div>
                                    <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                        Order Confirmed!
                                    </h1>
                                    <p className="text-gray-600 dark:text-gray-400">
                                        Your order has been successfully placed
                                    </p>
                                </div>

                                {/* Invoice Card */}
                                <Card variant="elevated" className="p-6 sm:p-8 md:p-12">
                                    <div ref={invoiceContentRef} className="invoice-content">
                                        {/* Action Buttons */}
                                        <div className="mb-6 flex flex-col sm:flex-row items-center justify-between gap-4 pdf-exclude">
                                            <h2 className="text-2xl font-bold text-gray-900 dark:text-white">
                                                Order Invoice
                                            </h2>
                                            <button
                                                onClick={handleDownloadPDF}
                                                disabled={isGeneratingPDF}
                                                className="flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-lg transition-all hover:bg-primary-700 hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                                            >
                                                {isGeneratingPDF ? (
                                                    <>
                                                        <span className="animate-spin">⏳</span>
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

                                        {/* Invoice Header */}
                                        <div className="mb-8 rounded-xl bg-gradient-to-r from-primary-600 via-primary-700 to-secondary-600 p-6 text-white">
                                            <div className="flex flex-col justify-between sm:flex-row">
                                                <div>
                                                    <h1 className="mb-4 text-3xl font-bold">INVOICE</h1>
                                                    <div className="space-y-2 text-sm">
                                                        <div className="flex gap-4">
                                                            <span className="font-medium opacity-90">Invoice #:</span>
                                                            <span className="font-mono font-semibold">
                                                                ORD-{String(order.id).padStart(6, "0")}
                                                            </span>
                                                        </div>
                                                        <div className="flex gap-4">
                                                            <span className="font-medium opacity-90">Date:</span>
                                                            <span>
                                                                {new Date(order.created_at).toLocaleDateString("en-US", {
                                                                    year: "numeric",
                                                                    month: "long",
                                                                    day: "numeric",
                                                                })}
                                                            </span>
                                                        </div>
                                                        <div className="flex gap-4">
                                                            <span className="font-medium opacity-90">Status:</span>
                                                            <span className="rounded-full bg-white/20 px-3 py-1 text-xs font-semibold uppercase">
                                                                {order.status}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="mt-4 text-right sm:mt-0">
                                                    <div className="text-2xl font-bold">
                                                        {import.meta.env.VITE_APP_NAME || "Darpon"}
                                                    </div>
                                                    <div className="mt-1 text-sm opacity-90">Book Order Invoice</div>
                                                </div>
                                            </div>
                                        </div>

                                        {/* Customer Information */}
                                        <div className="mb-8">
                                            <h2 className="mb-4 border-b-2 border-gray-200 dark:border-gray-700 pb-2 text-lg font-bold text-gray-900 dark:text-white">
                                                Customer Information
                                            </h2>
                                            <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                                <div>
                                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-400">Name:</span>
                                                    <p className="text-gray-900 dark:text-white">{order.name}</p>
                                                </div>
                                                <div>
                                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-400">Email:</span>
                                                    <p className="text-gray-900 dark:text-white">{order.email}</p>
                                                </div>
                                                <div>
                                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-400">Phone:</span>
                                                    <p className="text-gray-900 dark:text-white">{order.phone}</p>
                                                </div>
                                                <div>
                                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-400">Shipping Method:</span>
                                                    <p className="text-gray-900 dark:text-white capitalize">
                                                        {order.shipping_method === "inside_dhaka" ? "Inside Dhaka" : "Outside Dhaka"}
                                                    </p>
                                                </div>
                                                <div className="sm:col-span-2">
                                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-400">Address:</span>
                                                    <p className="whitespace-pre-wrap text-gray-900 dark:text-white">{order.address}</p>
                                                </div>
                                            </div>
                                        </div>

                                        {/* Order Details */}
                                        <div className="mb-8">
                                            <h2 className="mb-4 border-b-2 border-gray-200 dark:border-gray-700 pb-2 text-lg font-bold text-gray-900 dark:text-white">
                                                Order Details
                                            </h2>
                                            <div className="overflow-x-auto">
                                                <table className="w-full">
                                                    <thead>
                                                        <tr className="border-b-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                                                            <th className="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Item</th>
                                                            <th className="px-4 py-3 text-center text-sm font-semibold text-gray-900 dark:text-white">Quantity</th>
                                                            <th className="px-4 py-3 text-right text-sm font-semibold text-gray-900 dark:text-white">Unit Price</th>
                                                            <th className="px-4 py-3 text-right text-sm font-semibold text-gray-900 dark:text-white">Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr className="border-b border-gray-100 dark:border-gray-700">
                                                            <td className="px-4 py-4">
                                                                <div className="font-semibold text-gray-900 dark:text-white">{book?.title || "Unknown Book"}</div>
                                                                {book?.author && (
                                                                    <div className="mt-1 text-sm text-gray-500 dark:text-gray-400">by {book.author}</div>
                                                                )}
                                                            </td>
                                                            <td className="px-4 py-4 text-center text-gray-700 dark:text-gray-300">{order.quantity}</td>
                                                            <td className="px-4 py-4 text-right text-gray-700 dark:text-gray-300">
                                                                {formatPrice(unitPrice)}
                                                            </td>
                                                            <td className="px-4 py-4 text-right font-semibold text-gray-900 dark:text-white">
                                                                {formatPrice(order.total_amount - order.shipping_cost)}
                                                            </td>
                                                        </tr>
                                                        <tr className="border-b border-gray-100 dark:border-gray-700">
                                                            <td colSpan={3} className="px-4 py-4 text-right text-gray-700 dark:text-gray-300">
                                                                Shipping Cost:
                                                            </td>
                                                            <td className="px-4 py-4 text-right text-gray-700 dark:text-gray-300">
                                                                {formatPrice(order.shipping_cost)}
                                                            </td>
                                                        </tr>
                                                        <tr className="bg-primary-50 dark:bg-primary-900/20">
                                                            <td colSpan={3} className="px-4 py-4 text-lg font-bold text-gray-900 dark:text-white">
                                                                Total Amount
                                                            </td>
                                                            <td className="px-4 py-4 text-right text-lg font-bold text-primary-600 dark:text-primary-400">
                                                                {formatPrice(order.total_amount)}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {/* Payment Information */}
                                        <div className="mb-8 rounded-lg border-l-4 border-primary-500 bg-primary-50 dark:bg-primary-900/20 p-4">
                                            <h3 className="mb-3 text-sm font-semibold text-gray-900 dark:text-white">Payment Information</h3>
                                            <div className="flex items-center gap-2">
                                                <CreditCard className="h-5 w-5 text-primary-600 dark:text-primary-400" />
                                                <span className="font-semibold text-gray-900 dark:text-white">Cash on Delivery (COD)</span>
                                            </div>
                                            <p className="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                                You will pay {formatPrice(order.total_amount)} when you receive your order.
                                            </p>
                                        </div>

                                        {/* Success Message */}
                                        <div className="mb-6 rounded-lg border-l-4 border-green-500 bg-green-50 dark:bg-green-900/20 p-4">
                                            <div className="flex items-start gap-3">
                                                <CheckCircle2 className="h-6 w-6 flex-shrink-0 text-green-600 dark:text-green-400" />
                                                <div>
                                                    <h3 className="font-semibold text-green-900 dark:text-green-100">Order Placed Successfully!</h3>
                                                    <p className="mt-1 text-sm text-green-700 dark:text-green-300">
                                                        Your order has been confirmed. We will contact you soon to arrange delivery.
                                                    </p>
                                                    {isNewUser && (
                                                        <p className="mt-2 text-sm font-medium text-green-800 dark:text-green-200">
                                                            ✓ An account has been created for you. Check your email for login credentials.
                                                        </p>
                                                    )}
                                                </div>
                                            </div>
                                        </div>

                                        {/* Footer */}
                                        <div className="border-t border-gray-200 dark:border-gray-700 pt-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                            <p>This is a computer-generated invoice. No signature required.</p>
                                        </div>
                                    </div>

                                    {/* Action Buttons */}
                                    <div className="mt-8 flex flex-col sm:flex-row gap-4 pdf-exclude">
                                        <Link
                                            href={route("dashboard", { section: "books" })}
                                            className="flex items-center justify-center gap-2 rounded-lg bg-primary-600 px-6 py-3 text-sm font-semibold text-white shadow-lg transition-all hover:bg-primary-700 hover:shadow-xl"
                                        >
                                            <Home className="h-4 w-4" />
                                            Go to Dashboard
                                        </Link>
                                        <Link
                                            href={route("books.show", book.slug)}
                                            className="flex items-center justify-center gap-2 rounded-lg border-2 border-gray-300 dark:border-gray-600 px-6 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300 transition-all hover:bg-gray-50 dark:hover:bg-gray-800"
                                        >
                                            View Book
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

    // Show checkout form
    return (
        <>
            <Head title={`Checkout - ${book.title}`} />
            <div className="min-h-screen bg-gray-50 dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100">
                <Header />

                <main className="pt-24 pb-16">
                    <Container>
                        <form onSubmit={submit} className="grid gap-8 lg:grid-cols-3">
                            {/* Left Column: Shipping & Details */}
                            <div className="lg:col-span-2 space-y-6">
                                <Card variant="elevated" className="p-6 sm:p-8">
                                    <h2 className="text-xl font-bold text-gray-900 dark:text-white mb-6">
                                        Shipping Information
                                    </h2>

                                    <div className="space-y-6">
                                        {/* Name & Phone */}
                                        <div className="grid gap-6 sm:grid-cols-2">
                                            <div>
                                                <InputLabel htmlFor="name" value="Full Name" />
                                                <TextInput
                                                    id="name"
                                                    type="text"
                                                    className="mt-1 block w-full"
                                                    value={data.name}
                                                    onChange={(e) => setData("name", e.target.value)}
                                                    required
                                                />
                                                <InputError message={errors.name} className="mt-2" />
                                            </div>
                                            <div>
                                                <InputLabel htmlFor="phone" value="Phone Number" />
                                                <TextInput
                                                    id="phone"
                                                    type="tel"
                                                    className="mt-1 block w-full"
                                                    value={data.phone}
                                                    onChange={(e) => setData("phone", e.target.value)}
                                                    required
                                                />
                                                <InputError message={errors.phone} className="mt-2" />
                                            </div>
                                        </div>

                                        {/* Email */}
                                        <div>
                                            <InputLabel htmlFor="email" value="Email Address" />
                                            <TextInput
                                                id="email"
                                                type="email"
                                                className="mt-1 block w-full"
                                                value={data.email}
                                                onChange={(e) => setData("email", e.target.value)}
                                                required
                                            />
                                            <InputError message={errors.email} className="mt-2" />
                                        </div>

                                        {/* Address */}
                                        <div>
                                            <InputLabel htmlFor="address" value="Delivery Address" />
                                            <textarea
                                                id="address"
                                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-primary-600 dark:focus:ring-primary-600"
                                                rows="3"
                                                value={data.address}
                                                onChange={(e) => setData("address", e.target.value)}
                                                required
                                                placeholder="House, Road, Area, City"
                                            />
                                            <InputError message={errors.address} className="mt-2" />
                                        </div>

                                        {/* Shipping Method */}
                                        <div>
                                            <InputLabel value="Shipping Area" className="mb-2" />
                                            <div className="grid gap-4 sm:grid-cols-2">
                                                <label className={`relative flex cursor-pointer rounded-lg border p-4 shadow-sm focus:outline-none ${data.shipping_method === 'inside_dhaka' ? 'border-primary-500 ring-2 ring-primary-500' : 'border-gray-300 dark:border-gray-700'}`}>
                                                    <input 
                                                        type="radio" 
                                                        name="shipping_method" 
                                                        value="inside_dhaka" 
                                                        className="sr-only" 
                                                        checked={data.shipping_method === 'inside_dhaka'}
                                                        onChange={(e) => setData("shipping_method", e.target.value)}
                                                    />
                                                    <span className="flex flex-1">
                                                        <span className="flex flex-col">
                                                            <span className="block text-sm font-medium text-gray-900 dark:text-white">Inside Dhaka</span>
                                                            <span className="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">2-3 Days Delivery</span>
                                                        </span>
                                                    </span>
                                                    <span className="mt-0.5 ml-4 flex cursor-pointer flex-col">
                                                        <span className="text-sm font-medium text-primary-600 dark:text-primary-400">{formatPrice(60)}</span>
                                                    </span>
                                                </label>

                                                <label className={`relative flex cursor-pointer rounded-lg border p-4 shadow-sm focus:outline-none ${data.shipping_method === 'outside_dhaka' ? 'border-primary-500 ring-2 ring-primary-500' : 'border-gray-300 dark:border-gray-700'}`}>
                                                    <input 
                                                        type="radio" 
                                                        name="shipping_method" 
                                                        value="outside_dhaka" 
                                                        className="sr-only"
                                                        checked={data.shipping_method === 'outside_dhaka'}
                                                        onChange={(e) => setData("shipping_method", e.target.value)}
                                                    />
                                                    <span className="flex flex-1">
                                                        <span className="flex flex-col">
                                                            <span className="block text-sm font-medium text-gray-900 dark:text-white">Outside Dhaka</span>
                                                            <span className="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">3-5 Days Delivery</span>
                                                        </span>
                                                    </span>
                                                    <span className="mt-0.5 ml-4 flex cursor-pointer flex-col">
                                                        <span className="text-sm font-medium text-primary-600 dark:text-primary-400">{formatPrice(120)}</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>

                                        {/* Note */}
                                        <div>
                                            <InputLabel htmlFor="note" value="Order Note (Optional)" />
                                            <TextInput
                                                id="note"
                                                type="text"
                                                className="mt-1 block w-full"
                                                value={data.note}
                                                onChange={(e) => setData("note", e.target.value)}
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
                                        
                                        {/* Product Info */}
                                        <div className="flex gap-4 mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                                            <div className="h-16 w-12 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 dark:border-gray-700">
                                                {book.cover_image ? (
                                                    <img 
                                                        src={`/storage/${book.cover_image}`} 
                                                        alt={book.title} 
                                                        className="h-full w-full object-cover object-center"
                                                    />
                                                ) : (
                                                    <div className="flex h-full w-full items-center justify-center bg-gray-100 text-xs">No Img</div>
                                                )}
                                            </div>
                                            <div className="flex flex-1 flex-col">
                                                 <div>
                                                    <div className="flex justify-between text-base font-medium text-gray-900 dark:text-white">
                                                        <h3 className="line-clamp-1">{book.title}</h3>
                                                        <p className="ml-4">{formatPrice(price)}</p>
                                                    </div>
                                                </div>
                                                <div className="flex flex-1 items-end justify-between text-sm">
                                                    <p className="text-gray-500 dark:text-gray-400">Qty {data.quantity}</p>
                                                </div>
                                            </div>
                                        </div>

                                        {/* Calculations */}
                                        <div className="space-y-2">
                                            <div className="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                                <p>Subtotal</p>
                                                <p>{formatPrice(price * data.quantity)}</p>
                                            </div>
                                            <div className="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                                <p>Shipping</p>
                                                <p>{formatPrice(shippingCost)}</p>
                                            </div>
                                            <div className="border-t border-gray-100 dark:border-gray-700 pt-2 flex justify-between text-base font-bold text-gray-900 dark:text-white">
                                                <p>Total</p>
                                                <p>{formatPrice(total)}</p>
                                            </div>
                                        </div>

                                        {/* Payment Method Info */}
                                        <div className="mt-6 rounded-md bg-gray-50 dark:bg-gray-800 p-4">
                                            <div className="flex items-center">
                                                <svg className="h-5 w-5 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                <span className="text-sm font-medium text-gray-900 dark:text-white">Cash on Delivery</span>
                                            </div>
                                            <p className="mt-1 text-xs text-gray-500 dark:text-gray-400 ml-7">
                                                Pay comfortably when you receive your order.
                                            </p>
                                        </div>

                                        <PrimaryButton
                                            className="w-full mt-6 justify-center"
                                            disabled={processing}
                                            showIcon={false}
                                        >
                                            {processing ? "Placing Order..." : "Confirm Order"}
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
