import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Card from "@/Components/ui/Card";
import { Head, Link, usePage } from "@inertiajs/react";
import { formatPrice } from "@/Utils/currency";

export default function Dashboard({ bookOrders }) {
    const { translations, auth } = usePage().props;
    const t = translations?.common || {};
    const user = auth?.user;

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
            processing:
                "bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400",
            shipped:
                "bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400",
            delivered:
                "bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400",
            cancelled:
                "bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400",
        };
        return (
            colors[status] ||
            "bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400"
        );
    }

    return (
        <AuthenticatedLayout>
            <Head title={t.dashboard || "Dashboard"} />

            <div className="space-y-6">
                {/* Welcome Section */}
                <div className="bg-gradient-to-r from-primary-600 via-secondary-600 to-accent-600 dark:from-primary-700 dark:via-secondary-700 dark:to-accent-700 rounded-2xl p-8 text-white">
                    <div className="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <h1 className="text-3xl sm:text-4xl font-bold mb-2">
                                Welcome back,{" "}
                                {user?.name?.split(" ")[0] || "User"}! 👋
                            </h1>
                            <p className="text-white/90 text-lg">
                                Manage your purchases and profile settings
                            </p>
                        </div>
                    </div>
                </div>

                {/* Main Content Grid */}
                <div className="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    {/* Purchase History */}
                    <Card
                        variant="elevated"
                        padding="lg"
                        className="lg:col-span-2"
                    >
                        <div className="flex items-center justify-between mb-6">
                            <h3 className="text-xl font-bold text-gray-900 dark:text-white">
                                Purchase History
                            </h3>
                        </div>
                        <div className="space-y-4">
                            {bookOrders && bookOrders.length > 0 ? (
                                bookOrders.map((order) => {
                                    const bookImage = order.book?.cover_image
                                        ? order.book.cover_image.startsWith(
                                              "http"
                                          )
                                            ? order.book.cover_image
                                            : `/storage/${order.book.cover_image}`
                                        : null;

                                    return (
                                        <div
                                            key={order.id}
                                            className="flex items-start gap-4 p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all duration-200"
                                        >
                                            {bookImage ? (
                                                <img
                                                    src={bookImage}
                                                    alt={
                                                        order.book?.title ||
                                                        "Book"
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
                                                            {order.book
                                                                ?.title ||
                                                                "Unknown Book"}
                                                        </h4>
                                                        <p className="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                                            Quantity:{" "}
                                                            {order.quantity} ×{" "}
                                                            {formatPrice(
                                                                order.total_amount /
                                                                    order.quantity
                                                            )}
                                                        </p>
                                                        <div className="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                                            <span>
                                                                Order #
                                                                {order.id}
                                                            </span>
                                                            <span>•</span>
                                                            <span>
                                                                {formatDate(
                                                                    order.created_at
                                                                )}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div className="text-right">
                                                        <p className="font-bold text-lg text-gray-900 dark:text-white mb-2">
                                                            {formatPrice(
                                                                order.total_amount
                                                            )}
                                                        </p>
                                                        <span
                                                            className={`inline-flex rounded-full px-3 py-1 text-xs font-semibold ${getStatusColor(
                                                                order.status
                                                            )}`}
                                                        >
                                                            {order.status
                                                                .charAt(0)
                                                                .toUpperCase() +
                                                                order.status.slice(
                                                                    1
                                                                )}
                                                        </span>
                                                    </div>
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
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                                            />
                                        </svg>
                                    </div>
                                    <p className="text-gray-500 dark:text-gray-400 mb-2">
                                        No purchase history yet
                                    </p>
                                    <Link
                                        href={route("books.index")}
                                        className="text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400"
                                    >
                                        Browse Books →
                                    </Link>
                                </div>
                            )}
                        </div>
                    </Card>

                    {/* Quick Actions */}
                    <Card variant="elevated" padding="lg">
                        <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-6">
                            Quick Actions
                        </h3>
                        <div className="space-y-3">
                            <Link
                                href={route("books.index")}
                                className="flex items-center justify-between rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 hover:border-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all duration-200 group"
                            >
                                <div className="flex items-center gap-3">
                                    <div className="h-10 w-10 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center group-hover:bg-primary-200 dark:group-hover:bg-primary-900/50 transition-colors">
                                        <svg
                                            className="h-5 w-5 text-primary-600 dark:text-primary-400"
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
                                    <span className="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                        Browse Books
                                    </span>
                                </div>
                                <svg
                                    className="h-5 w-5 text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </Link>
                            <Link
                                href={route("profile.edit")}
                                className="flex items-center justify-between rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 hover:border-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all duration-200 group"
                            >
                                <div className="flex items-center gap-3">
                                    <div className="h-10 w-10 rounded-lg bg-accent-100 dark:bg-accent-900/30 flex items-center justify-center group-hover:bg-accent-200 dark:group-hover:bg-accent-900/50 transition-colors">
                                        <svg
                                            className="h-5 w-5 text-accent-600 dark:text-accent-400"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                strokeWidth={2}
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                            />
                                        </svg>
                                    </div>
                                    <span className="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                        Profile Settings
                                    </span>
                                </div>
                                <svg
                                    className="h-5 w-5 text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </Link>
                            <Link
                                href={route("contact")}
                                className="flex items-center justify-between rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 hover:border-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all duration-200 group"
                            >
                                <div className="flex items-center gap-3">
                                    <div className="h-10 w-10 rounded-lg bg-secondary-100 dark:bg-secondary-900/30 flex items-center justify-center group-hover:bg-secondary-200 dark:group-hover:bg-secondary-900/50 transition-colors">
                                        <svg
                                            className="h-5 w-5 text-secondary-600 dark:text-secondary-400"
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
                                    <span className="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                        Contact Us
                                    </span>
                                </div>
                                <svg
                                    className="h-5 w-5 text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </Link>
                        </div>
                    </Card>
                </div>

                {/* Contact Information & Profile */}
                <div className="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    {/* Contact Information */}
                    <Card variant="elevated" padding="lg">
                        <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-6">
                            Contact Information
                        </h3>
                        <div className="space-y-4">
                            <div className="flex items-start gap-4">
                                <div className="flex-shrink-0">
                                    <div className="h-10 w-10 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                                        <svg
                                            className="h-5 w-5 text-primary-600 dark:text-primary-400"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                strokeWidth={2}
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                            />
                                        </svg>
                                    </div>
                                </div>
                                <div className="flex-1">
                                    <p className="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Full Name
                                    </p>
                                    <p className="text-base font-semibold text-gray-900 dark:text-white">
                                        {user?.name || "N/A"}
                                    </p>
                                </div>
                            </div>
                            <div className="flex items-start gap-4">
                                <div className="flex-shrink-0">
                                    <div className="h-10 w-10 rounded-lg bg-secondary-100 dark:bg-secondary-900/30 flex items-center justify-center">
                                        <svg
                                            className="h-5 w-5 text-secondary-600 dark:text-secondary-400"
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
                                </div>
                                <div className="flex-1">
                                    <p className="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Email Address
                                    </p>
                                    <p className="text-base font-semibold text-gray-900 dark:text-white">
                                        {user?.email || "N/A"}
                                    </p>
                                </div>
                            </div>
                            <div className="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <Link
                                    href={route("contact")}
                                    className="inline-flex items-center gap-2 text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300"
                                >
                                    <span>Update contact information</span>
                                    <svg
                                        className="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M9 5l7 7-7 7"
                                        />
                                    </svg>
                                </Link>
                            </div>
                        </div>
                    </Card>

                    {/* Profile Settings */}
                    <Card variant="elevated" padding="lg">
                        <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-6">
                            Profile Settings
                        </h3>
                        <div className="space-y-4">
                            <div className="flex items-center justify-between p-4 rounded-xl bg-gray-50 dark:bg-gray-800">
                                <div className="flex items-center gap-3">
                                    <svg
                                        className="h-5 w-5 text-gray-500 dark:text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        />
                                    </svg>
                                    <span className="text-sm font-medium text-gray-900 dark:text-white">
                                        Personal Information
                                    </span>
                                </div>
                                <Link
                                    href={route("profile.edit")}
                                    className="text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400"
                                >
                                    Edit →
                                </Link>
                            </div>
                            <div className="flex items-center justify-between p-4 rounded-xl bg-gray-50 dark:bg-gray-800">
                                <div className="flex items-center gap-3">
                                    <svg
                                        className="h-5 w-5 text-gray-500 dark:text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                        />
                                    </svg>
                                    <span className="text-sm font-medium text-gray-900 dark:text-white">
                                        Password & Security
                                    </span>
                                </div>
                                <Link
                                    href={route("profile.edit")}
                                    className="text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400"
                                >
                                    Edit →
                                </Link>
                            </div>
                        </div>
                    </Card>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
