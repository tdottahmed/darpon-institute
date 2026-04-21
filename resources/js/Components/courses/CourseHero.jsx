import Badge from "@/Components/ui/Badge";
import parse from "html-react-parser";

export default function CourseHero({ course, tags }) {
    return (
        <div className="mb-8">
            <h1 className="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-6 leading-tight">
                {course.title}
            </h1>

            {/* Short Description */}
            {course.short_description && (
                <div className="text-sm sm:text-base lg:text-lg text-gray-600 dark:text-gray-300 leading-relaxed max-w-3xl">
                    {typeof course.short_description === "string" &&
                    course.short_description.includes("<")
                        ? parse(course.short_description)
                        : course.short_description}
                </div>
            )}

            {/* Meta Bar */}
            {/* <div className="flex items-center gap-6 mt-6 pt-6 border-t border-gray-100 dark:border-gray-800"> */}
                {/* <div className="flex items-center gap-2">
                    <div className="p-2 rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
                        <svg
                            className="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                    </div>
                    <div>
                        <p className="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">
                            Duration
                        </p>
                        <p className="text-sm font-semibold text-gray-900 dark:text-white">
                            {course.duration || "Self-paced"}
                        </p>
                    </div>
                </div> */}

                {/* <div className="flex items-center gap-2">
                    <div className="p-2 rounded-full bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400">
                        <svg
                            className="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M13 10V3L4 14h7v7l9-11h-7z"
                            />
                        </svg>
                    </div>
                    <div>
                        <p className="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">
                            Level
                        </p>
                        <p className="text-sm font-semibold text-gray-900 dark:text-white">
                            Beginner Friendly
                        </p>
                    </div>
                </div> */}
            {/* </div> */}
        </div>
    );
}
