import ApplicationLogo from "@/Components/ApplicationLogo";
import { Check } from "lucide-react";

export default function CourseInfoSidebar({ course, thumbnailUrl }) {
    const benefits = [
        "Unlimited access to all course materials",
        "Expert instruction and support",
        "Certificate of completion",
        "Community access and networking",
        "Lifetime updates and new content",
    ];

    return (
        <div className="lg:col-span-2 order-1 lg:order-2 space-y-6">
            <div className="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700 sticky top-24">
                <div className="aspect-video w-full rounded-xl overflow-hidden mb-6 relative group">
                    {thumbnailUrl ? (
                        <img
                            src={thumbnailUrl}
                            alt={course.title}
                            className="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                        />
                    ) : (
                        <div className="flex h-full items-center justify-center bg-gradient-to-br from-primary-100 to-secondary-100 dark:from-primary-900/40 dark:to-secondary-900/40">
                            <ApplicationLogo className="h-16 w-16 opacity-30" />
                        </div>
                    )}
                    <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div className="absolute bottom-4 left-4 text-white">
                        <p className="text-sm font-medium opacity-90">
                            Course Preview
                        </p>
                        <h3 className="text-xl font-bold">{course.title}</h3>
                    </div>
                </div>

                <h4 className="font-bold text-gray-900 dark:text-white mb-4 text-lg">
                    What you'll get:
                </h4>
                <ul className="space-y-3">
                    {benefits.map((item, i) => (
                        <li
                            key={i}
                            className="flex items-start gap-3 text-gray-600 dark:text-gray-300"
                        >
                            <div className="mt-1 h-5 w-5 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center flex-shrink-0 text-green-600 dark:text-green-400">
                                <Check className="w-3 h-3" strokeWidth={3} />
                            </div>
                            <span className="text-sm leading-relaxed">
                                {item}
                            </span>
                        </li>
                    ))}
                </ul>
            </div>

            {/* Trust Indicators */}
            <div className="bg-primary-50 dark:bg-primary-900/10 rounded-xl p-6 border border-primary-100 dark:border-primary-800/20">
                <div className="flex gap-1 text-yellow-500 mb-3">
                    {[1, 2, 3, 4, 5].map((i) => (
                        <span key={i} className="text-lg">
                            ★
                        </span>
                    ))}
                </div>
                <p className="text-sm text-gray-700 dark:text-gray-300 italic mb-4">
                    "This course changed the way I learn. Highly recommended
                    for anyone looking to improve quickly."
                </p>
                <div className="flex items-center gap-3">
                    <div className="h-10 w-10 rounded-full bg-primary-200 dark:bg-primary-800 flex items-center justify-center text-sm font-bold text-primary-700 dark:text-primary-300">
                        SJ
                    </div>
                    <div>
                        <p className="text-sm font-bold text-gray-900 dark:text-white">
                            Sarah Johnson
                        </p>
                        <p className="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Student
                        </p>
                    </div>
                </div>
            </div>
        </div>
    );
}

