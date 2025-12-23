import parse from "html-react-parser";

export default function CourseMainContent({ course }) {
    return (
        <div className="prose prose-lg dark:prose-invert max-w-none prose-headings:font-bold prose-headings:text-gray-900 dark:prose-headings:text-white prose-p:text-gray-600 dark:prose-p:text-gray-300 prose-img:rounded-xl">
            {course.long_description ? (
                parse(course.long_description)
            ) : (
                <div className="p-8 bg-gray-50 dark:bg-gray-800 rounded-2xl text-center text-gray-500 dark:text-gray-400 italic">
                    No detailed description available for this course.
                </div>
            )}
        </div>
    );
}
