import Container from "../ui/Container";
import Badge from "../ui/Badge";
import Button from "../ui/Button";
import Card from "../ui/Card";

export default function DataSection() {
    const stats = [
        { label: "Active Students", value: "50K+", icon: "👥" },
        { label: "Courses Available", value: "200+", icon: "📚" },
        { label: "Success Rate", value: "95%", icon: "🎯" },
    ];

    return (
        <section className="py-16 sm:py-24 bg-white dark:bg-gray-900">
            <Container>
                <div className="grid lg:grid-cols-2 gap-12 items-center">
                    {/* Content Column */}
                    <div className="space-y-6 order-2 lg:order-2">
                        <Badge variant="secondary">Our Impact</Badge>
                        <h2 className="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white">
                            Proven Results, Real Data
                        </h2>
                        <p className="text-lg text-gray-600 dark:text-gray-300">
                            Join thousands of successful students who have
                            transformed their English skills with our platform.
                        </p>

                        {/* Stats Grid */}
                        <div className="grid grid-cols-3 gap-4 pt-4">
                            {stats.map((stat, index) => (
                                <Card
                                    key={index}
                                    variant="default"
                                    padding="md"
                                    className="text-center"
                                >
                                    <div className="text-3xl mb-2">
                                        {stat.icon}
                                    </div>
                                    <p className="text-2xl font-bold text-primary-600 dark:text-primary-400">
                                        {stat.value}
                                    </p>
                                    <p className="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        {stat.label}
                                    </p>
                                </Card>
                            ))}
                        </div>

                        <div className="flex flex-col sm:flex-row gap-4 pt-4">
                            <Button
                                href={route("register")}
                                variant="primary"
                                size="lg"
                            >
                                Join Now
                            </Button>
                            <Button variant="outline" size="lg">
                                View Statistics
                            </Button>
                        </div>
                    </div>

                    {/* Image Column */}
                    <div className="relative order-1 lg:order-1">
                        <div className="relative">
                            <div className="w-full h-80 bg-gradient-to-br from-secondary-400 to-accent-400 rounded-2xl shadow-xl flex items-center justify-center">
                                <span className="text-9xl">📊</span>
                            </div>

                            {/* Floating Elements */}
                            <Card
                                variant="floating"
                                className="absolute -top-6 -left-6 max-w-xs"
                            >
                                <div className="flex items-center gap-3">
                                    <div className="text-3xl">🏆</div>
                                    <div>
                                        <p className="text-lg font-bold text-gray-900 dark:text-white">
                                            Top Rated
                                        </p>
                                        <p className="text-xs text-gray-600 dark:text-gray-400">
                                            Platform of the Year
                                        </p>
                                    </div>
                                </div>
                            </Card>
                        </div>
                    </div>
                </div>
            </Container>
        </section>
    );
}
