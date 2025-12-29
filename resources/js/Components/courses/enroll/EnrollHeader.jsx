import { CheckCircle2 } from "lucide-react";

export default function EnrollHeader({ course, auth }) {
    return (
        <div className="text-center max-w-2xl mx-auto mb-12">
            <div className="inline-flex items-center gap-2 px-4 py-2 bg-primary-100 dark:bg-primary-900/30 rounded-full mb-4">
                <CheckCircle2 className="w-5 h-5 text-primary-600 dark:text-primary-400" />
                <span className="text-sm font-semibold text-primary-700 dark:text-primary-300">
                    Course Enrollment
                </span>
            </div>
            <h1 className="text-3xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4 tracking-tight">
                Complete Your Registration
            </h1>
            <p className="text-lg text-gray-600 dark:text-gray-300">
                You are enrolling in{" "}
                <span className="text-primary-600 dark:text-primary-400 font-semibold">
                    {course.title}
                </span>
                .
                {!auth?.user && (
                    <span className="block mt-2 text-base">
                        {" "}
                        We'll create an account for you and send login
                        credentials to your email.
                    </span>
                )}
            </p>
        </div>
    );
}

