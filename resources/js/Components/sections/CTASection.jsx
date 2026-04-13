import Container from "../ui/Container";
import PrimaryButton from "../ui/PrimaryButton";
import SecondaryButton from "../ui/SecondaryButton";
import { usePage } from "@inertiajs/react";

export default function CTASection({ translations }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.cta || {};
    const t = translations?.common || {};

    return (
        <section className="relative py-20 sm:py-20 overflow-hidden bg-gradient-to-br from-primary-600 via-primary-700 to-secondary-600 dark:from-primary-800 dark:via-primary-900 dark:to-secondary-800">
            {/* Background Pattern */}
            <div className="absolute inset-0 opacity-10">
                <div
                    className="absolute inset-0"
                    style={{
                        backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`,
                    }}
                ></div>
            </div>

            {/* Decorative Elements */}
            <div className="absolute top-0 left-0 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
            <div className="absolute bottom-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>

            <Container className="relative z-10">
                <div className="text-center space-y-8 max-w-4xl mx-auto">
                    <h2 className="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight">
                        {content.title ||
                            "Ready to Start Your English Journey?"}
                    </h2>
                    <p className="text-xl sm:text-2xl text-white/90 leading-relaxed max-w-2xl mx-auto">
                        {content.subtitle ||
                            "Join thousands of students already learning with us. Get started today and transform your English skills!"}
                    </p>
                    <div className="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                        <PrimaryButton
                            href={route("courses.index")}
                        >
                            {content.btn_primary ||
                                t.register ||
                                "Get Started Free"}
                        </PrimaryButton>
                        <SecondaryButton
                            href={route("login")}
                            showIcon={true}
                        >
                            {content.btn_outline || t.login || "Log In"}
                        </SecondaryButton>
                    </div>
                </div>
            </Container>
        </section>
    );
}
