import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import Badge from "../ui/Badge";
import { usePage } from "@inertiajs/react";

export default function InstructorSection() {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.instructor || {};

    // Parse skills array from string or use default
    const skillsString = content.skills || "English Teaching, Language Instruction, Curriculum Development";
    const skills = skillsString.split(",").map((skill) => skill.trim());

    // Parse experience from string or use default
    const experience = content.experience || "10+ Years";

    return (
        <section className="py-20 sm:py-28 bg-gray-50 dark:bg-gray-800/50">
            <Container>
                {/* Section Header */}
                <SectionHeader
                    badge={content.header_badge || "Meet Your Instructor"}
                    title={content.header_title || "About the Instructor"}
                    subtitle={
                        content.header_subtitle ||
                        "Learn from an experienced and passionate English language expert"
                    }
                    alignment="center"
                    className="mb-16"
                />

                {/* Main Content - Image on Right, Details on Left */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    {/* Left Side - Details */}
                    <div className="space-y-8 order-2 lg:order-1">
                        {/* Name and Title */}
                        <div>
                            <h3 className="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-3">
                                {content.name || "Instructor Name"}
                            </h3>
                            <p className="text-xl text-primary-600 dark:text-primary-400 font-semibold">
                                {content.title || "Lead English Instructor"}
                            </p>
                        </div>

                        {/* Description */}
                        <div className="prose prose-lg dark:prose-invert max-w-none">
                            <p className="text-gray-700 dark:text-gray-300 leading-relaxed text-lg">
                                {content.description ||
                                    "With years of dedicated experience in English language education, I'm passionate about helping students achieve fluency and confidence in their English communication skills."}
                            </p>
                        </div>

                        {/* Experience */}
                        {experience && (
                            <div className="flex items-center gap-4 p-4 bg-white dark:bg-gray-700 rounded-xl shadow-sm border border-gray-200 dark:border-gray-600">
                                <div className="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                                    <svg
                                        className="w-6 h-6 text-primary-600 dark:text-primary-400"
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
                                </div>
                                <div>
                                    <p className="text-sm text-gray-500 dark:text-gray-400 font-medium">
                                        Experience
                                    </p>
                                    <p className="text-2xl font-bold text-gray-900 dark:text-white">
                                        {experience}
                                    </p>
                                </div>
                            </div>
                        )}

                        {/* Skills */}
                        {skills && skills.length > 0 && (
                            <div>
                                <h4 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    {content.skills_label || "Areas of Expertise"}
                                </h4>
                                <div className="flex flex-wrap gap-2">
                                    {skills.map((skill, index) => (
                                        <Badge
                                            key={index}
                                            variant="primary"
                                            className="text-sm px-4 py-2 bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-400 border-primary-200 dark:border-primary-800"
                                        >
                                            {skill}
                                        </Badge>
                                    ))}
                                </div>
                            </div>
                        )}

                        {/* Additional Info / Achievement */}
                        {content.achievement && (
                            <div className="p-6 bg-gradient-to-br from-primary-50 to-secondary-50 dark:from-primary-900/20 dark:to-secondary-900/20 rounded-xl border border-primary-200 dark:border-primary-800">
                                <p className="text-gray-800 dark:text-gray-200 leading-relaxed">
                                    <span className="font-semibold text-primary-700 dark:text-primary-400">
                                        {content.achievement_label || "Notable Achievement:"}
                                    </span>{" "}
                                    {content.achievement}
                                </p>
                            </div>
                        )}
                    </div>

                    {/* Right Side - Image */}
                    <div className="order-1 lg:order-2">
                        <div className="relative">
                            {/* Decorative Background */}
                            <div className="absolute -inset-4 bg-gradient-to-br from-primary-200 via-secondary-200 to-primary-300 dark:from-primary-800 dark:via-secondary-800 dark:to-primary-900 rounded-2xl transform rotate-3 opacity-20"></div>
                            
                            {/* Image Container */}
                            <div className="relative rounded-2xl overflow-hidden shadow-2xl">
                                <img
                                    src={
                                        content.image ||
                                        "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=800&auto=format&fit=crop"
                                    }
                                    alt={content.name || "Instructor"}
                                    className="w-full h-auto object-cover aspect-[3/4]"
                                    loading="lazy"
                                />
                                {/* Overlay Gradient */}
                                <div className="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
                            </div>

                            {/* Floating Badge */}
                            <div className="absolute -bottom-6 -left-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 border border-gray-200 dark:border-gray-700">
                                <div className="text-center">
                                    <p className="text-3xl font-bold text-primary-600 dark:text-primary-400">
                                        {content.students_count || "5K+"}
                                    </p>
                                    <p className="text-sm text-gray-600 dark:text-gray-400 font-medium">
                                        {content.students_label || "Students Taught"}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Container>
        </section>
    );
}

