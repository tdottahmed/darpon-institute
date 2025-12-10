import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import Card from "../ui/Card";
import { testimonials } from "../../data/testimonials";

export default function TestimonialsSection() {
    return (
        <section className="py-16 sm:py-24 bg-gray-50 dark:bg-gray-800">
            <Container>
                <SectionHeader
                    badge="Testimonials"
                    title="What Our Students Say"
                    subtitle="Real feedback from real learners"
                    alignment="center"
                    className="mb-12"
                />

                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {testimonials.map((testimonial) => (
                        <Card
                            key={testimonial.id}
                            variant="elevated"
                            padding="lg"
                            className="flex flex-col"
                        >
                            <div className="text-4xl text-primary-600 dark:text-primary-400 mb-4">
                                "
                            </div>
                            <p className="text-gray-700 dark:text-gray-300 mb-6 flex-grow">
                                {testimonial.review}
                            </p>
                            <div className="flex items-center gap-4">
                                <div className="text-4xl">
                                    {testimonial.avatar}
                                </div>
                                <div>
                                    <p className="font-semibold text-gray-900 dark:text-white">
                                        {testimonial.name}
                                    </p>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">
                                        {testimonial.role}
                                    </p>
                                </div>
                            </div>
                            <div className="flex gap-1 mt-4">
                                {[...Array(testimonial.rating)].map((_, i) => (
                                    <span key={i} className="text-yellow-400">
                                        ⭐
                                    </span>
                                ))}
                            </div>
                        </Card>
                    ))}
                </div>
            </Container>
        </section>
    );
}
