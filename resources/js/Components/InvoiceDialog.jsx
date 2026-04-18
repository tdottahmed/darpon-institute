import { Fragment, useRef, useState } from "react";
import { Dialog, Transition } from "@headlessui/react";
import {
    Download,
    X,
    Loader2,
    CheckCircle2,
    CreditCard,
    User,
    Mail,
    Phone,
    MapPin,
    Truck,
} from "lucide-react";
import { formatPrice } from "@/Utils/currency";
import { generatePDF } from "@/Utils/pdfGenerator";
import { usePage } from "@inertiajs/react";
import Logo from "./layout/Header/Logo";

export default function InvoiceDialog({ isOpen, onClose, order, book }) {
    const invoiceContentRef = useRef(null);
    const [isGeneratingPDF, setIsGeneratingPDF] = useState(false);
    const { settings } = usePage().props;
    const logoSrc = settings?.logo_light || "/darponbdv.png";

    if (!order) return null;

    const handleDownloadPDF = async () => {
        if (!invoiceContentRef.current) return;

        const invoiceNumber = `ORD-${String(order.id).padStart(6, "0")}`;
        const filename = `Invoice-${invoiceNumber}.pdf`;

        await generatePDF(invoiceContentRef.current, filename, {
            onStart: () => setIsGeneratingPDF(true),
            onSuccess: () => setIsGeneratingPDF(false),
            onError: () => setIsGeneratingPDF(false),
        });
    };

    return (
        <Transition appear show={isOpen} as={Fragment}>
            <Dialog as="div" className="relative z-50" onClose={onClose}>
                <Transition.Child
                    as={Fragment}
                    enter="ease-out duration-300"
                    enterFrom="opacity-0"
                    enterTo="opacity-100"
                    leave="ease-in duration-200"
                    leaveFrom="opacity-100"
                    leaveTo="opacity-0"
                >
                    <div className="fixed inset-0 bg-black/30 backdrop-blur-sm" />
                </Transition.Child>

                <div className="fixed inset-0 overflow-y-auto">
                    <div className="flex min-h-full items-center justify-center p-4">
                        <Transition.Child
                            as={Fragment}
                            enter="ease-out duration-300"
                            enterFrom="opacity-0 scale-95"
                            enterTo="opacity-100 scale-100"
                            leave="ease-in duration-200"
                            leaveFrom="opacity-100 scale-100"
                            leaveTo="opacity-0 scale-95"
                        >
                            <Dialog.Panel className="w-full max-w-4xl transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all">
                                {/* Invoice Content */}
                                <div
                                    ref={invoiceContentRef}
                                    className="invoice-content p-6 sm:p-8 md:p-12 bg-white"
                                >
                                    {/* Header Actions */}
                                    <div className="mb-6 flex items-center justify-between pdf-exclude">
                                        <Dialog.Title className="text-2xl font-bold text-gray-900">
                                            Order Confirmation
                                        </Dialog.Title>
                                        <div className="flex gap-3">
                                            <button
                                                onClick={handleDownloadPDF}
                                                disabled={isGeneratingPDF}
                                                className="flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-lg transition-all hover:bg-primary-700 hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                                            >
                                                {isGeneratingPDF ? (
                                                    <>
                                                        <Loader2 className="h-4 w-4 animate-spin" />
                                                        Generating...
                                                    </>
                                                ) : (
                                                    <>
                                                        <Download className="h-4 w-4" />
                                                        Download PDF
                                                    </>
                                                )}
                                            </button>
                                            <button
                                                onClick={onClose}
                                                className="flex items-center gap-2 rounded-lg border-2 border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition-all hover:bg-gray-50"
                                            >
                                                <X className="h-4 w-4" />
                                                Close
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
                                                            ORD-
                                                            {String(
                                                                order.id,
                                                            ).padStart(6, "0")}
                                                        </span>
                                                    </div>
                                                    <div className="flex gap-4">
                                                        <span className="font-medium opacity-90">
                                                            Date:
                                                        </span>
                                                        <span>
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
                                                        </span>
                                                    </div>
                                                    <div className="flex items-center gap-4">
                                                        <span className="font-medium opacity-90">
                                                            Status:
                                                        </span>
                                                        <span className="rounded-full bg-white px-3 py-1 text-xs font-bold uppercase text-primary-700 shadow-sm">
                                                            {order.status}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="mt-4 flex flex-col items-end sm:mt-0">
                                                <Logo />
                                                <div className="mt-1 text-sm opacity-90">
                                                    Book Order Invoice
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {/* Customer Information */}
                                    <div className="mb-8 p-6 rounded-2xl bg-gray-50 border border-gray-100">
                                        <h2 className="mb-6 flex items-center gap-2 text-lg font-bold text-gray-900 border-b border-gray-200 pb-3">
                                            <User className="h-5 w-5 text-primary-600" />
                                            Customer Information
                                        </h2>
                                        <div className="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8 sm:gap-y-8">
                                            <div className="flex items-start gap-3">
                                                <div className="mt-1 p-2 bg-white rounded-lg border border-gray-100 shadow-sm">
                                                    <User className="h-4 w-4 text-gray-400" />
                                                </div>
                                                <div>
                                                    <span className="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                                        Full Name
                                                    </span>
                                                    <p className="text-sm font-semibold text-gray-900">
                                                        {order.name}
                                                    </p>
                                                </div>
                                            </div>

                                            <div className="flex items-start gap-3">
                                                <div className="mt-1 p-2 bg-white rounded-lg border border-gray-100 shadow-sm">
                                                    <Mail className="h-4 w-4 text-gray-400" />
                                                </div>
                                                <div>
                                                    <span className="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                                        Email Address
                                                    </span>
                                                    <p className="text-sm font-semibold text-gray-900">
                                                        {order.email}
                                                    </p>
                                                </div>
                                            </div>

                                            <div className="flex items-start gap-3">
                                                <div className="mt-1 p-2 bg-white rounded-lg border border-gray-100 shadow-sm">
                                                    <Phone className="h-4 w-4 text-gray-400" />
                                                </div>
                                                <div>
                                                    <span className="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                                        Phone Number
                                                    </span>
                                                    <p className="text-sm font-semibold text-gray-900">
                                                        {order.phone}
                                                    </p>
                                                </div>
                                            </div>

                                            <div className="flex items-start gap-3">
                                                <div className="mt-1 p-2 bg-white rounded-lg border border-gray-100 shadow-sm">
                                                    <Truck className="h-4 w-4 text-gray-400" />
                                                </div>
                                                <div>
                                                    <span className="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                                        Shipping Method
                                                    </span>
                                                    <p className="text-sm font-semibold text-gray-900">
                                                        {order.shipping_method ===
                                                        "inside_dhaka"
                                                            ? "Inside Dhaka"
                                                            : "Outside Dhaka"}
                                                    </p>
                                                </div>
                                            </div>

                                            <div className="sm:col-span-2 flex items-start gap-3">
                                                <div className="mt-1 p-2 bg-white rounded-lg border border-gray-100 shadow-sm">
                                                    <MapPin className="h-4 w-4 text-gray-400" />
                                                </div>
                                                <div>
                                                    <span className="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                                        Shipping Address
                                                    </span>
                                                    <p className="text-sm font-semibold text-gray-900 whitespace-pre-wrap">
                                                        {order.address}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {/* Order Details */}
                                    <div className="mb-8">
                                        <h2 className="mb-4 border-b-2 border-gray-200 pb-2 text-lg font-bold text-gray-900">
                                            Order Details
                                        </h2>
                                        <div className="overflow-x-auto">
                                            <table className="w-full">
                                                <thead>
                                                    <tr className="border-b-2 border-gray-200 bg-gray-50">
                                                        <th className="px-4 py-3 text-left text-sm font-semibold text-gray-900">
                                                            Item
                                                        </th>
                                                        <th className="px-4 py-3 text-center text-sm font-semibold text-gray-900">
                                                            Quantity
                                                        </th>
                                                        <th className="px-4 py-3 text-right text-sm font-semibold text-gray-900">
                                                            Unit Price
                                                        </th>
                                                        <th className="px-4 py-3 text-right text-sm font-semibold text-gray-900">
                                                            Subtotal
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr className="border-b border-gray-100">
                                                        <td className="px-4 py-4">
                                                            <div className="font-semibold text-gray-900">
                                                                {book?.title ||
                                                                    "Unknown Book"}
                                                            </div>
                                                            {book?.author && (
                                                                <div className="mt-1 text-sm text-gray-500">
                                                                    by{" "}
                                                                    {
                                                                        book.author
                                                                    }
                                                                </div>
                                                            )}
                                                        </td>
                                                        <td className="px-4 py-4 text-center text-gray-700">
                                                            {order.quantity}
                                                        </td>
                                                        <td className="px-4 py-4 text-right text-gray-700">
                                                            {formatPrice(
                                                                (order.total_amount -
                                                                    order.shipping_cost) /
                                                                    order.quantity,
                                                            )}
                                                        </td>
                                                        <td className="px-4 py-4 text-right font-semibold text-gray-900">
                                                            {formatPrice(
                                                                order.total_amount -
                                                                    order.shipping_cost,
                                                            )}
                                                        </td>
                                                    </tr>
                                                    <tr className="border-b border-gray-100">
                                                        <td
                                                            colSpan={3}
                                                            className="px-4 py-4 text-right text-gray-700"
                                                        >
                                                            Shipping Cost:
                                                        </td>
                                                        <td className="px-4 py-4 text-right text-gray-700">
                                                            {formatPrice(
                                                                order.shipping_cost,
                                                            )}
                                                        </td>
                                                    </tr>
                                                    <tr className="bg-primary-50">
                                                        <td
                                                            colSpan={3}
                                                            className="px-4 py-4 text-lg font-bold text-gray-900"
                                                        >
                                                            Total Amount
                                                        </td>
                                                        <td className="px-4 py-4 text-right text-lg font-bold text-primary-600">
                                                            {formatPrice(
                                                                order.total_amount,
                                                            )}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {/* Payment Information */}
                                    <div className="mb-8 rounded-lg border-l-4 border-primary-500 bg-primary-50 p-4">
                                        <h3 className="mb-3 text-sm font-semibold text-gray-900">
                                            Payment Information
                                        </h3>
                                        <div className="flex items-center gap-2">
                                            <CreditCard className="h-5 w-5 text-primary-600" />
                                            <span className="font-semibold text-gray-900">
                                                Cash on Delivery (COD)
                                            </span>
                                        </div>
                                        <p className="mt-2 text-sm text-gray-600">
                                            You will pay{" "}
                                            {formatPrice(order.total_amount)}{" "}
                                            when you receive your order.
                                        </p>
                                    </div>

                                    {/* Success Message */}
                                    <div className="mb-6 rounded-lg border-l-4 border-green-500 bg-green-50 p-4">
                                        <div className="flex items-start gap-3">
                                            <CheckCircle2 className="h-6 w-6 flex-shrink-0 text-green-600" />
                                            <div>
                                                <h3 className="font-semibold text-green-900">
                                                    Order Placed Successfully!
                                                </h3>
                                                <p className="mt-1 text-sm text-green-700">
                                                    Your order has been
                                                    confirmed. We will contact
                                                    you soon to arrange
                                                    delivery.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    {/* Footer */}
                                    <div className="border-t border-gray-200 pt-6 text-center text-sm text-gray-500">
                                        <p>
                                            This is a computer-generated
                                            invoice. No signature required.
                                        </p>
                                        <p className="mt-2">
                                            Generated on{" "}
                                            {new Date().toLocaleString(
                                                "en-US",
                                                {
                                                    year: "numeric",
                                                    month: "long",
                                                    day: "numeric",
                                                    hour: "numeric",
                                                    minute: "numeric",
                                                },
                                            )}
                                        </p>
                                    </div>
                                </div>
                            </Dialog.Panel>
                        </Transition.Child>
                    </div>
                </div>
            </Dialog>
        </Transition>
    );
}
