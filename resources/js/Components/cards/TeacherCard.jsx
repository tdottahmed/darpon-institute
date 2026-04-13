import { Link } from "@inertiajs/react";

export default function TeacherCard({ teacher }) {
    return (
        <div className="group relative flex h-full flex-col overflow-hidden rounded-2xl bg-white shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
            {/* Image Container */}
            <div className="relative aspect-square overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-900 dark:to-gray-800">
                {teacher.image_path ? (
                    <Link href={route("instructors.show", teacher.id)} className="block w-full h-full">
                        <img
                            src={`/storage/${teacher.image_path}`}
                            alt={teacher.name}
                            className="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                            loading="lazy"
                        />
                    </Link>
                ) : (
                    <Link href={route("instructors.show", teacher.id)} className="flex h-full w-full items-center justify-center text-gray-400 transition-colors duration-300 group-hover:bg-gray-200 dark:group-hover:bg-gray-700">
                        <svg
                            className="h-24 w-24 opacity-50"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </Link>
                )}

                {/* Overlay Gradient */}
                <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-60 transition-opacity duration-300 group-hover:opacity-80" />

                {/* Social Icons / Quick Actions Overlay (Placeholder for future) */}
                <div className="absolute bottom-0 left-0 right-0 translate-y-full p-4 transition-transform duration-300 group-hover:translate-y-0">
                   {/* We can add social links here in the future */}
                </div>
            </div>

            {/* Content Card - Overlapping or Below */}
            <div className="relative flex flex-1 flex-col p-6 text-center">
                 {/* Decorative Line */}
                <div className="mx-auto mb-4 h-1 w-12 rounded-full bg-primary-500" />
                
                {/* Name */}
                <Link href={route("instructors.show", teacher.id)} className="inline-block">
                    <h3 className="mb-1 text-xl font-bold text-gray-900 dark:text-white transition-colors duration-200 group-hover:text-primary-600 dark:group-hover:text-primary-400">
                        {teacher.name}
                    </h3>
                </Link>

                {/* Designation */}
                <p className="mb-2 text-sm font-semibold uppercase tracking-wide text-primary-600 dark:text-primary-400">
                    {teacher.designation}
                </p>

                {/* Department */}
                <p className="text-sm text-gray-500 dark:text-gray-400">
                    Department of {teacher.department}
                </p>
                
                 {/* Hover effect bottom bar */}
                <div className="absolute inset-x-0 bottom-0 h-1 scale-x-0 bg-gradient-to-r from-primary-500 to-secondary-500 transition-transform duration-300 group-hover:scale-x-100" />
            </div>
        </div>
    );
}
