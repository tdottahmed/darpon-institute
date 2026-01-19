import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import TeacherCard from "../cards/TeacherCard";

import { usePage } from "@inertiajs/react";

export default function TeamSection({ teachers = [] }) {
    if (!teachers || teachers.length === 0) return null;

    const { frontend_content } = usePage().props;
    const content = frontend_content?.team || {};

    return (
        <section className="bg-white py-20 dark:bg-gray-900 sm:py-28">
            <Container>
                <SectionHeader
                    badge={content.header_badge || "Our Team"}
                    title={content.header_title || "Meet Our Expert Instructors"}
                    subtitle={
                        content.header_subtitle ||
                        "Learn from the best educators dedicated to your success"
                    }
                    alignment="center"
                    className="mb-16"
                />

                <div className="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    {teachers.map((teacher) => (
                        <TeacherCard key={teacher.id} teacher={teacher} />
                    ))}
                </div>
            </Container>
        </section>
    );
}
