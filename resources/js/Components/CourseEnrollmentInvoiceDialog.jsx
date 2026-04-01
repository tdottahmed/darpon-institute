import { Fragment, useRef, useState } from "react";
import { Dialog, Transition } from "@headlessui/react";
import { Download, X, Loader2, CheckCircle2, User, Mail, Phone, MapPin, Globe } from "lucide-react";
import { formatPrice } from "@/Utils/currency";
import { generatePDF } from "@/Utils/pdfGenerator";

export default function CourseEnrollmentInvoiceDialog({ isOpen, onClose, registration, course, totalPrice = 0 }) {
    const invoiceContentRef = useRef(null);
    const [isGeneratingPDF, setIsGeneratingPDF] = useState(false);

    if (!registration) return null;

    const handleDownloadPDF = async () => {
        if (!invoiceContentRef.current) return;

        const invoiceNumber = `ENR-${String(registration.id).padStart(6, "0")}`;
        const filename = `Invoice-${invoiceNumber}.pdf`;

        await generatePDF(invoiceContentRef.current, filename, {
            onStart: () => setIsGeneratingPDF(true),
            onSuccess: () => setIsGeneratingPDF(false),
            onError: () => setIsGeneratingPDF(false),
        });
    };

    const isPaidCourse = totalPrice > 0;
    const isFreeCourse = totalPrice === 0;
    const isNewUser = registration.is_new_user || false;

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
                                            Enrollment Confirmation
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
                                                <h1 className="mb-4 text-3xl font-bold">INVOICE</h1>
                                                <div className="space-y-2 text-sm">
                                                    <div className="flex gap-4">
                                                        <span className="font-medium opacity-90">Invoice #:</span>
                                                        <span className="font-mono font-semibold">
                                                            ENR-{String(registration.id).padStart(6, "0")}
                                                        </span>
                                                    </div>
                                                    <div className="flex gap-4">
                                                        <span className="font-medium opacity-90">Date:</span>
                                                        <span>{new Date(registration.created_at).toLocaleDateString("en-US", {
                                                            year: "numeric",
                                                            month: "long",
                                                            day: "numeric",
                                                        })}</span>
                                                    </div>
                                                    <div className="flex items-center gap-4">
                                                        <span className="font-medium opacity-90">Status:</span>
                                                        <span className="rounded-full bg-white px-3 py-1 text-xs font-bold uppercase text-primary-700 shadow-sm">
                                                            {registration.status}
                                                        </span>
                                                    </div>
                                                    {registration.payment_status && (
                                                        <div className="flex items-center gap-4">
                                                            <span className="font-medium opacity-90">Payment Status:</span>
                                                            <span className={`rounded-full px-3 py-1 text-xs font-bold uppercase shadow-sm ${
                                                                registration.payment_status === 'verified' 
                                                                    ? 'bg-green-50 text-green-700' 
                                                                    : registration.payment_status === 'rejected'
                                                                    ? 'bg-red-50 text-red-700'
                                                                    : 'bg-yellow-50 text-yellow-700'
                                                            }`}>
                                                                {registration.payment_status}
                                                            </span>
                                                        </div>
                                                    )}
                                                </div>
                                            </div>
                                            <div className="mt-4 text-right sm:mt-0">
                                                <div className="text-2xl font-bold">{import.meta.env.VITE_APP_NAME || "Darpon"}</div>
                                                <div className="mt-1 text-sm opacity-90">Course Enrollment Invoice</div>
                                            </div>
                                        </div>
                                    </div>

                                    {/* Student Information */}
                                    <div className="mb-8 p-6 rounded-2xl bg-gray-50 border border-gray-100">
                                        <h2 className="mb-6 flex items-center gap-2 text-lg font-bold text-gray-900 border-b border-gray-200 pb-3">
                                            <User className="h-5 w-5 text-primary-600" />
                                            Student Information
                                        </h2>
                                        <div className="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8 sm:gap-y-8">
                                            <div className="flex items-start gap-3">
                                                <div className="mt-1 p-2 bg-white rounded-lg border border-gray-100 shadow-sm">
                                                    <User className="h-4 w-4 text-gray-400" />
                                                </div>
                                                <div>
                                                    <span className="text-xs font-bold text-gray-400 uppercase tracking-wider">Full Name</span>
                                                    <p className="text-sm font-semibold text-gray-900">{registration.name}</p>
                                                </div>
                                            </div>

                                            <div className="flex items-start gap-3">
                                                <div className="mt-1 p-2 bg-white rounded-lg border border-gray-100 shadow-sm">
                                                    <Mail className="h-4 w-4 text-gray-400" />
                                                </div>
                                                <div>
                                                    <span className="text-xs font-bold text-gray-400 uppercase tracking-wider">Email Address</span>
                                                    <p className="text-sm font-semibold text-gray-900">{registration.email}</p>
                                                </div>
                                            </div>

                                            <div className="flex items-start gap-3">
                                                <div className="mt-1 p-2 bg-white rounded-lg border border-gray-100 shadow-sm">
                                                    <Phone className="h-4 w-4 text-gray-400" />
                                                </div>
                                                <div>
                                                    <span className="text-xs font-bold text-gray-400 uppercase tracking-wider">Phone Number</span>
                                                    <p className="text-sm font-semibold text-gray-900">{registration.phone}</p>
                                                </div>
                                            </div>

                                            <div className="flex items-start gap-3">
                                                <div className="mt-1 p-2 bg-white rounded-lg border border-gray-100 shadow-sm">
                                                    <Globe className="h-4 w-4 text-gray-400" />
                                                </div>
                                                <div>
                                                    <span className="text-xs font-bold text-gray-400 uppercase tracking-wider">Enrollment Type</span>
                                                    <p className="text-sm font-semibold text-gray-900 capitalize">{registration.enrollment_type || "Online"}</p>
                                                </div>
                                            </div>

                                            {registration.address && (
                                                <div className="sm:col-span-2 flex items-start gap-3">
                                                    <div className="mt-1 p-2 bg-white rounded-lg border border-gray-100 shadow-sm">
                                                        <MapPin className="h-4 w-4 text-gray-400" />
                                                    </div>
                                                    <div>
                                                        <span className="text-xs font-bold text-gray-400 uppercase tracking-wider">Physical Address</span>
                                                        <p className="text-sm font-semibold text-gray-900 whitespace-pre-wrap">{registration.address}</p>
                                                    </div>
                                                </div>
                                            )}
                                        </div>
                                    </div>

                                    {/* Course Details */}
                                    <div className="mb-8">
                                        <h2 className="mb-4 border-b-2 border-gray-200 pb-2 text-lg font-bold text-gray-900">
                                            Course Details
                                        </h2>
                                        <div className="overflow-x-auto">
                                            <table className="w-full">
                                                <thead>
                                                    <tr className="border-b-2 border-gray-200 bg-gray-50">
                                                        <th className="px-4 py-3 text-left text-sm font-semibold text-gray-900">Course</th>
                                                        {registration.course_variation && (
                                                            <th className="px-4 py-3 text-left text-sm font-semibold text-gray-900">Variation</th>
                                                        )}
                                                        <th className="px-4 py-3 text-right text-sm font-semibold text-gray-900">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr className="border-b border-gray-100">
                                                        <td className="px-4 py-4">
                                                            <div className="font-semibold text-gray-900">{course?.title || "Unknown Course"}</div>
                                                            {course?.duration && (
                                                                <div className="mt-1 text-sm text-gray-500">Duration: {course.duration}</div>
                                                            )}
                                                        </td>
                                                        {registration.course_variation && (
                                                            <td className="px-4 py-4">
                                                                <div className="font-medium text-gray-900">{registration.course_variation.name}</div>
                                                                {registration.course_variation.duration && (
                                                                    <div className="mt-1 text-sm text-gray-500">{registration.course_variation.duration}</div>
                                                                )}
                                                            </td>
                                                        )}
                                                        <td className="px-4 py-4 text-right font-semibold text-gray-900">
                                                            {isFreeCourse ? (
                                                                <span className="text-green-600">Free</span>
                                                            ) : (
                                                                formatPrice(totalPrice)
                                                            )}
                                                        </td>
                                                    </tr>
                                                    {isPaidCourse && (
                                                        <tr className="bg-primary-50">
                                                            <td colSpan={registration.course_variation ? 2 : 1} className="px-4 py-4 text-lg font-bold text-gray-900">
                                                                Total Amount
                                                            </td>
                                                            <td className="px-4 py-4 text-right text-lg font-bold text-primary-600">
                                                                {formatPrice(totalPrice)}
                                                            </td>
                                                        </tr>
                                                    )}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {/* Payment Information */}
                                    {isPaidCourse && registration.payment_gateway && (
                                        <div className="mb-8 rounded-lg border-l-4 border-primary-500 bg-primary-50 p-4">
                                            <h3 className="mb-3 text-sm font-semibold text-gray-900">Payment Information</h3>
                                            <div className="space-y-2 text-sm">
                                                <div>
                                                    <span className="font-medium text-gray-700">Payment Method:</span>
                                                    <span className="ml-2 text-gray-900">{registration.payment_gateway.name}</span>
                                                </div>
                                                {registration.payment_gateway.account_number && (
                                                    <div>
                                                        <span className="font-medium text-gray-700">Account:</span>
                                                        <span className="ml-2 font-mono text-gray-900">{registration.payment_gateway.account_number}</span>
                                                    </div>
                                                )}
                                                {registration.transaction_id && (
                                                    <div>
                                                        <span className="font-medium text-gray-700">Transaction ID:</span>
                                                        <span className="ml-2 font-mono text-gray-900">{registration.transaction_id}</span>
                                                    </div>
                                                )}
                                                {registration.payment_status && (
                                                    <div>
                                                        <span className="font-medium text-gray-700">Payment Status:</span>
                                                        <span className={`ml-2 rounded-full px-2 py-1 text-xs font-semibold ${
                                                            registration.payment_status === 'verified' 
                                                                ? 'bg-green-100 text-green-800' 
                                                                : registration.payment_status === 'rejected'
                                                                ? 'bg-red-100 text-red-800'
                                                                : 'bg-yellow-100 text-yellow-800'
                                                        }`}>
                                                            {registration.payment_status}
                                                        </span>
                                                    </div>
                                                )}
                                            </div>
                                        </div>
                                    )}

                                    {/* Success Message */}
                                    <div className={`mb-6 rounded-lg border-l-4 p-4 ${
                                        isFreeCourse 
                                            ? 'border-green-500 bg-green-50' 
                                            : registration.payment_status === 'verified'
                                            ? 'border-green-500 bg-green-50'
                                            : 'border-blue-500 bg-blue-50'
                                    }`}>
                                        <div className="flex items-start gap-3">
                                            <CheckCircle2 className={`h-6 w-6 flex-shrink-0 ${
                                                isFreeCourse || registration.payment_status === 'verified'
                                                    ? 'text-green-600' 
                                                    : 'text-blue-600'
                                            }`} />
                                            <div>
                                                <h3 className={`font-semibold ${
                                                    isFreeCourse || registration.payment_status === 'verified'
                                                        ? 'text-green-900' 
                                                        : 'text-blue-900'
                                                }`}>
                                                    {isFreeCourse 
                                                        ? 'Enrollment Completed Successfully!' 
                                                        : registration.payment_status === 'verified'
                                                        ? 'Payment Verified - Enrollment Confirmed!'
                                                        : 'Registration Submitted Successfully!'}
                                                </h3>
                                                <p className={`mt-1 text-sm ${
                                                    isFreeCourse || registration.payment_status === 'verified'
                                                        ? 'text-green-700' 
                                                        : 'text-blue-700'
                                                }`}>
                                                    {isFreeCourse 
                                                        ? 'You have been successfully enrolled in this course. Check your email for course access details.'
                                                        : registration.payment_status === 'verified'
                                                        ? 'Your payment has been verified and your enrollment is confirmed. Check your email for course access details.'
                                                        : 'Your registration has been submitted. We will verify your payment and contact you soon. An invoice has been sent to your email address.'}
                                                </p>
                                                {isNewUser && (
                                                    <p className={`mt-2 text-sm font-medium ${
                                                        isFreeCourse || registration.payment_status === 'verified'
                                                            ? 'text-green-800' 
                                                            : 'text-blue-800'
                                                    }`}>
                                                        ✓ An account has been created for you. Check your email for login credentials.
                                                    </p>
                                                )}
                                            </div>
                                        </div>
                                    </div>

                                    {/* Footer */}
                                    <div className="border-t border-gray-200 pt-6 text-center text-sm text-gray-500">
                                        <p>This is a computer-generated invoice. No signature required.</p>
                                        <p className="mt-2">
                                            Generated on {new Date().toLocaleString("en-US", {
                                                year: "numeric",
                                                month: "long",
                                                day: "numeric",
                                                hour: "numeric",
                                                minute: "numeric",
                                            })}
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

