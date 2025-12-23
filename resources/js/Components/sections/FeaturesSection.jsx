import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import Card from "../ui/Card";
import { features } from "../../data/features";
import { usePage } from "@inertiajs/react";

export default function FeaturesSection() {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.features || {};

    const colorClasses = {
        primary:
            "bg-primary-100 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400",
        secondary:
            "bg-secondary-100 text-secondary-600 dark:bg-secondary-900/30 dark:text-secondary-400",
        accent: "bg-accent-100 text-accent-600 dark:bg-accent-900/30 dark:text-accent-400",
    };

    return (
        <section className="py-20 sm:py-28 bg-white dark:bg-gray-900">
            <Container>
                <SectionHeader
                    badge={content.header_badge || "Features"}
                    title={content.header_title || "Why Choose Our Platform"}
                    subtitle={
                        content.header_subtitle ||
                        "Everything you need to master English in one place"
                    }
                    alignment="center"
                    className="mb-16"
                />

                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    {features.map((feature, index) => (
                        <Card
                            key={feature.id}
                            variant="floating"
                            padding="lg"
                            hover={true}
                            radius="xl"
                            className="text-center border border-gray-100 dark:border-gray-700"
                        >
                            <div
                                className={`w-20 h-20 ${
                                    colorClasses[feature.color]
                                } rounded-2xl flex items-center justify-center text-4xl mx-auto mb-6 transition-transform duration-300 group-hover:scale-110`}
                            >
                                {feature.icon}
                            </div>
                            <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-3">
                                {content[`feature_${index + 1}_title`] ||
                                    feature.title}
                            </h3>
                            <p className="text-gray-600 dark:text-gray-400 leading-relaxed">
                                {content[`feature_${index + 1}_description`] ||
                                    feature.description}
                            </p>
                        </Card>
                    ))}
                </div>
            </Container>
        </section>
    );
}
