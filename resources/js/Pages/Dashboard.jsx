import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, usePage, router } from "@inertiajs/react";
import { useEffect } from "react";
import WelcomeSection from "@/Components/dashboard/WelcomeSection";
import PurchaseHistory from "@/Components/dashboard/PurchaseHistory";
import CourseEnrollments from "@/Components/dashboard/CourseEnrollments";
import QuickActions from "@/Components/dashboard/QuickActions";
import ContactInformation from "@/Components/dashboard/ContactInformation";
import ProfileSettings from "@/Components/dashboard/ProfileSettings";

export default function Dashboard({ bookOrders, courseRegistrations }) {
    const { translations, auth } = usePage().props;
    const t = translations?.common || {};
    const user = auth?.user;

    // Get active section from URL params
    const urlParams = new URLSearchParams(window.location.search);
    const activeSection = urlParams.get("section") || "overview";

    const renderContent = () => {
        switch (activeSection) {
            case "books":
                return (
                    <div className="space-y-6">
                        <WelcomeSection user={user} />
                        <PurchaseHistory bookOrders={bookOrders} />
                    </div>
                );
            case "courses":
                return (
                    <div className="space-y-6">
                        <WelcomeSection user={user} />
                        <CourseEnrollments
                            courseRegistrations={courseRegistrations}
                        />
                    </div>
                );
            case "profile":
                return (
                    <div className="space-y-6">
                        <WelcomeSection user={user} />
                        <div className="grid grid-cols-1 gap-6 lg:grid-cols-2">
                            <ContactInformation user={user} />
                            <ProfileSettings />
                        </div>
                    </div>
                );
            case "overview":
            default:
                return (
                    <div className="space-y-6">
                        <WelcomeSection user={user} />
                        <div className="grid grid-cols-1 gap-6 lg:grid-cols-3">
                            <PurchaseHistory bookOrders={bookOrders} />
                            <QuickActions />
                        </div>
                        <div className="grid grid-cols-1 gap-6 lg:grid-cols-2">
                            <ContactInformation user={user} />
                            <ProfileSettings />
                        </div>
                    </div>
                );
        }
    };

    return (
        <AuthenticatedLayout>
            <Head title={t.dashboard || "Dashboard"} />

            <div className="space-y-6">{renderContent()}</div>
        </AuthenticatedLayout>
    );
}
