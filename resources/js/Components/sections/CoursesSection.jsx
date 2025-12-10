import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import CourseCard from "../courses/CourseCard";
import Button from "../ui/Button";

export default function CoursesSection({ courses = [] }) {
    const displayedCourses = courses.slice(0, 6);

    return (
        <section className="py-16 sm:py-24 bg-white dark:bg-gray-900">
            <Container>
                {/* Section Header */}
                <SectionHeader
                    title="Featured Courses"
                    subtitle="Discover our most popular English learning courses designed to help you achieve fluency"
                    className="mb-12"
                />

                {/* Courses Grid */}
                {displayedCourses.length > 0 ? (
                    <>
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                            {displayedCourses.map((course) => (
                                <CourseCard key={course.id} course={course} />
                            ))}
                        </div>

                        {/* View More Button */}
                        <div className="text-center">
                            <Button href="/courses" variant="outline" size="lg">
                                View All Courses
                            </Button>
                        </div>
                    </>
                ) : (
                    <div className="text-center py-12">
                        <div className="text-6xl mb-4">📚</div>
                        <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                            No courses available yet
                        </h3>
                        <p className="text-gray-600 dark:text-gray-400">
                            Check back soon for exciting new courses!
                        </p>
                    </div>
                )}
            </Container>
        </section>
    );
}
