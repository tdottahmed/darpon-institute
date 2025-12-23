import { Link } from "@inertiajs/react";
import CourseCard from "@/Components/courses/CourseCard";

export default function RelatedCourses({ relatedCourses }) {
    if (!relatedCourses || relatedCourses.length === 0) return null;

    return (
        <div className="mt-24 border-t border-gray-200 dark:border-gray-800 pt-16">
            <div className="flex items-center justify-between mb-8">
                <h2 className="text-2xl font-bold text-gray-900 dark:text-white">
                    More Courses You Might Like
                </h2>
                <Link
                    href="/courses"
                    className="text-primary-600 hover:text-primary-700 dark:text-primary-400 font-medium hover:underline"
                >
                    View All
                </Link>
            </div>
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                {relatedCourses.map((relatedCourse) => (
                    <div key={relatedCourse.id} className="h-full">
                        <CourseCard course={relatedCourse} />
                    </div>
                ))}
            </div>
        </div>
    );
}
