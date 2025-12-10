import Container from "../ui/Container";
import Button from "../ui/Button";

export default function CTASection({ translations }) {
    const t = translations?.common || {};

    return (
        <section className="py-16 sm:py-24 bg-gradient-to-br from-primary-600 via-secondary-600 to-accent-600 dark:from-primary-700 dark:via-secondary-700 dark:to-accent-700 relative overflow-hidden">
            {/* Background Pattern */}
            <div className="absolute inset-0 opacity-10">
                <div
                    className="absolute inset-0"
                    style={{
                        backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`,
                    }}
                ></div>
            </div>

            <Container className="relative z-10">
                <div className="text-center space-y-6 max-w-3xl mx-auto">
                    <h2 className="text-3xl sm:text-4xl lg:text-5xl font-bold text-white">
                        Ready to Start Your English Journey?
                    </h2>
                    <p className="text-lg sm:text-xl text-white/90">
                        Join thousands of students already learning with us. Get
                        started today and transform your English skills!
                    </p>
                    <div className="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                        <Button
                            href={route("register")}
                            variant="outline"
                            size="lg"
                            className="bg-white text-primary-600 hover:bg-gray-100 border-white dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700"
                        >
                            {t.register || "Get Started Free"}
                        </Button>
                        <Button
                            href={route("login")}
                            variant="outline"
                            size="lg"
                            className="border-2 border-white text-white hover:bg-white/10 dark:border-gray-300 dark:text-gray-300"
                        >
                            {t.login || "Log In"}
                        </Button>
                    </div>
                </div>
            </Container>
        </section>
    );
}
