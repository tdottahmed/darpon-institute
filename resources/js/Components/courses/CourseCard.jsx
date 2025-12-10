import { Link } from "@inertiajs/react";
import Card from "../ui/Card";
import Badge from "../ui/Badge";
import Button from "../ui/Button";

export default function CourseCard({ course }) {
    const thumbnailUrl = course.thumbnail
        ? course.thumbnail.startsWith("http")
            ? course.thumbnail
            : `/storage/${course.thumbnail}`
        : null;

    const tags = Array.isArray(course.tags) ? course.tags : [];

    return (
        <Card
            variant="elevated"
            className="group overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
        >
            {/* Thumbnail */}
            <div className="relative h-48 w-full overflow-hidden bg-gradient-to-br from-primary-400 to-secondary-400">
                {thumbnailUrl ? (
                    <img
                        src={thumbnailUrl}
                        alt={course.title}
                        className="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110"
                    />
                ) : (
                    <div className="flex h-full items-center justify-center">
                        <span className="text-6xl">📚</span>
                    </div>
                )}
                {/* Overlay on hover */}
                <div className="absolute inset-0 bg-black/0 transition-all duration-300 group-hover:bg-black/20"></div>
            </div>

            {/* Content */}
            <div className="p-6">
                {/* Tags */}
                {tags.length > 0 && (
                    <div className="mb-3 flex flex-wrap gap-2">
                        {tags.slice(0, 3).map((tag, index) => (
                            <Badge
                                key={index}
                                variant="primary"
                                className="text-xs"
                            >
                                {tag}
                            </Badge>
                        ))}
                    </div>
                )}

                {/* Title */}
                <h3 className="mb-2 text-xl font-bold text-gray-900 dark:text-white line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                    {course.title}
                </h3>

                {/* Short Description */}
                {course.short_description && (
                    <p className="mb-4 text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                        {course.short_description
                            ? course.short_description
                                  .replace(/<[^>]*>/g, "")
                                  .substring(0, 100) +
                              (course.short_description.replace(/<[^>]*>/g, "")
                                  .length > 100
                                  ? "..."
                                  : "")
                            : ""}
                    </p>
                )}

                {/* Meta Info */}
                <div className="mb-4 flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                    {course.duration && (
                        <div className="flex items-center gap-1">
                            <svg
                                className="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            <span>{course.duration}</span>
                        </div>
                    )}
                </div>

                {/* CTA Button */}
                <Button
                    href={route("courses.show", course.slug)}
                    variant="primary"
                    size="sm"
                    className="w-full"
                >
                    View Course
                </Button>
            </div>
        </Card>
    );
}
