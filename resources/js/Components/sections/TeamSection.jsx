import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import TeacherCard from "../cards/TeacherCard";

export default function TeamSection({ teachers = [] }) {
    if (!teachers || teachers.length === 0) return null;

    return (
        <section className="bg-white py-20 dark:bg-gray-900 sm:py-28">
            <Container>
                <SectionHeader
                    badge="Our Team"
                    title="Meet Our Expert Instructors"
                    subtitle="Learn from the best educators dedicated to your success"
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
