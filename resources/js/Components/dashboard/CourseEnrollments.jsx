import { useState } from "react";
import Card from "@/Components/ui/Card";
import { Link } from "@inertiajs/react";
import { formatPrice } from "@/Utils/currency";
import { Eye, FileText } from "lucide-react";
import CourseEnrollmentInvoiceDialog from "@/Components/CourseEnrollmentInvoiceDialog";

export default function CourseEnrollments({ courseRegistrations }) {
    const [selectedRegistration, setSelectedRegistration] = useState(null);
    const [isInvoiceOpen, setIsInvoiceOpen] = useState(false);

    const handleViewInvoice = (registration) => {
        setSelectedRegistration(registration);
        setIsInvoiceOpen(true);
    };

    function formatDate(dateString) {
        if (!dateString) return "N/A";
        const date = new Date(dateString);
        return date.toLocaleDateString("en-US", {
            year: "numeric",
            month: "short",
            day: "numeric",
        });
    }

    function getStatusColor(status) {
        const colors = {
            pending:
                "bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400",
            confirmed:
                "bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400",
            completed:
                "bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400",
            cancelled:
                "bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400",
        };
        return (
            colors[status] ||
            "bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400"
        );
    }

    function getEnrollmentTypeColor(type) {
        const colors = {
            online:
                "bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400",
            offline:
                "bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400",
        };
        return (
            colors[type] ||
            "bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400"
        );
    }

    return (
        <Card variant="elevated" padding="lg" className="lg:col-span-2">
            <div className="flex items-center justify-between mb-6">
                <h3 className="text-xl font-bold text-gray-900 dark:text-white">
                    Course Enrollments
                </h3>
            </div>
            <div className="space-y-4">
                {courseRegistrations && courseRegistrations.length > 0 ? (
                    courseRegistrations.map((registration) => {
                        const courseImage = registration.course?.thumbnail
                            ? registration.course.thumbnail.startsWith("http")
                                ? registration.course.thumbnail
                                : `/storage/${registration.course.thumbnail}`
                            : null;

                        return (
                            <div
                                key={registration.id}
                                className="flex items-start gap-4 p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all duration-200"
                            >
                                {courseImage ? (
                                    <img
                                        src={courseImage}
                                        alt={
                                            registration.course?.title ||
                                            "Course"
                                        }
                                        className="h-20 w-16 object-cover rounded-lg flex-shrink-0"
                                    />
                                ) : (
                                    <div className="h-20 w-16 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg
                                            className="h-8 w-8 text-gray-400"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                strokeWidth={2}
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                            />
                                        </svg>
                                    </div>
                                )}
                                <div className="flex-1 min-w-0">
                                    <div className="flex items-start justify-between gap-4">
                                        <div className="flex-1">
                                            <h4 className="font-semibold text-gray-900 dark:text-white mb-1">
                                                {registration.course?.title ||
                                                    "Unknown Course"}
                                            </h4>
                                            {registration.courseVariation && (
                                                <p className="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                                    {
                                                        registration
                                                            .courseVariation
                                                            ?.name
                                                    }
                                                </p>
                                            )}
                                            <div className="flex items-center gap-2 mb-2">
                                                <span
                                                    className={`inline-flex rounded-full px-2 py-1 text-xs font-semibold ${getEnrollmentTypeColor(
                                                        registration.enrollment_type
                                                    )}`}
                                                >
                                                    {registration.enrollment_type
                                                        ?.charAt(0)
                                                        .toUpperCase() +
                                                        registration.enrollment_type.slice(
                                                            1
                                                        )}
                                                </span>
                                                {registration.is_installment_payment && (
                                                    <span className="text-xs text-gray-500 dark:text-gray-400">
                                                        • Installment Payment
                                                    </span>
                                                )}
                                            </div>
                                            <div className="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                                <span>
                                                    Enrollment #
                                                    {registration.id}
                                                </span>
                                                <span>•</span>
                                                <span>
                                                    {formatDate(
                                                        registration.created_at
                                                    )}
                                                </span>
                                            </div>
                                        </div>
                                        <div className="text-right">
                                            <span
                                                className={`inline-flex rounded-full px-3 py-1 text-xs font-semibold mb-2 ${getStatusColor(
                                                    registration.status
                                                )}`}
                                            >
                                                {registration.status
                                                    ?.charAt(0)
                                                    .toUpperCase() +
                                                    registration.status.slice(1)}
                                            </span>
                                        </div>
                                    </div>

                                    {/* Action Buttons */}
                                    <div className="mt-4 flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700/50">
                                        <button
                                            onClick={() =>
                                                handleViewInvoice(registration)
                                            }
                                            className="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                                        >
                                            <Eye className="h-3.5 w-3.5" />
                                            Details
                                        </button>
                                        <button
                                            onClick={() =>
                                                handleViewInvoice(registration)
                                            }
                                            className="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 border border-primary-100 dark:border-primary-900/30 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-900/30 transition-colors"
                                        >
                                            <FileText className="h-3.5 w-3.5" />
                                            Invoice
                                        </button>
                                    </div>
                                </div>
                            </div>
                        );
                    })
                ) : (
                    <div className="text-center py-12">
                        <div className="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                            <svg
                                className="h-8 w-8 text-gray-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                />
                            </svg>
                        </div>
                        <p className="text-gray-500 dark:text-gray-400 mb-2">
                            No course enrollments yet
                        </p>
                        <Link
                            href={route("courses.index")}
                            className="text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400"
                        >
                            Browse Courses →
                        </Link>
                    </div>
                )}
            </div>

            {/* Invoice Modal */}
            {selectedRegistration && (
                <CourseEnrollmentInvoiceDialog
                    isOpen={isInvoiceOpen}
                    onClose={() => setIsInvoiceOpen(false)}
                    registration={selectedRegistration}
                    course={selectedRegistration.course}
                    totalPrice={selectedRegistration.total_amount}
                />
            )}
        </Card>
    );
}

