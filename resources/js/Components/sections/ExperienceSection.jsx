import Container from "../ui/Container";
import Badge from "../ui/Badge";
import Button from "../ui/Button";
import Card from "../ui/Card";

export default function ExperienceSection() {
    return (
        <section className="py-16 sm:py-24 bg-gray-50 dark:bg-gray-800">
            <Container>
                <div className="grid lg:grid-cols-2 gap-12 items-center">
                    {/* Image Column */}
                    <div className="relative order-2 lg:order-1">
                        <div className="relative">
                            <div className="w-full h-80 bg-gradient-to-br from-primary-400 to-secondary-400 rounded-2xl shadow-xl flex items-center justify-center">
                                <span className="text-9xl">🎓</span>
                            </div>

                            {/* Floating Card */}
                            <Card
                                variant="floating"
                                className="absolute -bottom-6 -right-6 max-w-xs"
                            >
                                <div className="flex items-center gap-4">
                                    <div className="text-4xl">⭐</div>
                                    <div>
                                        <p className="text-2xl font-bold text-gray-900 dark:text-white">
                                            10K+
                                        </p>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">
                                            Happy Students
                                        </p>
                                    </div>
                                </div>
                            </Card>
                        </div>
                    </div>

                    {/* Content Column */}
                    <div className="space-y-6 order-1 lg:order-2">
                        <Badge variant="primary">Unique Experience</Badge>
                        <h2 className="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white">
                            Learn English Your Way
                        </h2>
                        <p className="text-lg text-gray-600 dark:text-gray-300">
                            Experience a revolutionary approach to language
                            learning with personalized study plans, interactive
                            content, and real-time progress tracking.
                        </p>
                        <div className="space-y-4">
                            <div className="flex items-start gap-3">
                                <span className="text-primary-600 dark:text-primary-400 text-xl">
                                    ✓
                                </span>
                                <div>
                                    <h4 className="font-semibold text-gray-900 dark:text-white">
                                        Personalized Learning Path
                                    </h4>
                                    <p className="text-gray-600 dark:text-gray-400">
                                        Customized courses based on your goals
                                    </p>
                                </div>
                            </div>
                            <div className="flex items-start gap-3">
                                <span className="text-primary-600 dark:text-primary-400 text-xl">
                                    ✓
                                </span>
                                <div>
                                    <h4 className="font-semibold text-gray-900 dark:text-white">
                                        Interactive Content
                                    </h4>
                                    <p className="text-gray-600 dark:text-gray-400">
                                        Engaging lessons with multimedia support
                                    </p>
                                </div>
                            </div>
                            <div className="flex items-start gap-3">
                                <span className="text-primary-600 dark:text-primary-400 text-xl">
                                    ✓
                                </span>
                                <div>
                                    <h4 className="font-semibold text-gray-900 dark:text-white">
                                        Progress Tracking
                                    </h4>
                                    <p className="text-gray-600 dark:text-gray-400">
                                        Monitor your improvement in real-time
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div className="flex flex-col sm:flex-row gap-4 pt-4">
                            <Button
                                href={route("register")}
                                variant="primary"
                                size="lg"
                            >
                                Start Learning
                            </Button>
                            <Button variant="outline" size="lg">
                                Learn More
                            </Button>
                        </div>
                    </div>
                </div>
            </Container>
        </section>
    );
}
