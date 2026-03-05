import { usePage, Link } from "@inertiajs/react";

export default function HeroSection({ translations }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.hero || {};

    return (
        <section className="relative overflow-hidden bg-gradient-to-br from-[#f8fdf2] via-[#fbf7f0] to-[#f0f6fc] dark:from-gray-950 dark:via-gray-900 dark:to-gray-950 min-h-[85vh] flex items-center py-16 md:py-24">
            
            {/* Top Left Red Crosses */}
            <div className="absolute top-24 left-10 md:left-24 grid grid-cols-2 gap-3 opacity-60 dark:opacity-40">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" className="text-red-400 dark:text-red-500">
                    <path d="M12 2V22M2 12H22" stroke="currentColor" strokeWidth="4" strokeLinecap="round"/>
                </svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" className="text-red-400 dark:text-red-500">
                    <path d="M12 2V22M2 12H22" stroke="currentColor" strokeWidth="4" strokeLinecap="round"/>
                </svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" className="text-red-400 dark:text-red-500">
                    <path d="M12 2V22M2 12H22" stroke="currentColor" strokeWidth="4" strokeLinecap="round"/>
                </svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" className="text-red-400 dark:text-red-500">
                    <path d="M12 2V22M2 12H22" stroke="currentColor" strokeWidth="4" strokeLinecap="round"/>
                </svg>
            </div>

            {/* Right Middle Green Dots */}
            <div className="absolute right-10 top-[40%] hidden lg:grid grid-cols-3 gap-2 opacity-60 dark:opacity-40">
                {[...Array(15)].map((_, i) => (
                    <div key={i} className="w-1.5 h-1.5 rounded-full bg-green-500 dark:bg-green-600"></div>
                ))}
            </div>

            <div className="container mx-auto px-4 sm:px-6 lg:px-16 relative z-10 w-full max-w-7xl mt-4">
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">

                    {/* Left Column: Content */}
                    <div className="space-y-6 text-center lg:text-left z-10 pt-8 lg:pt-0">
                        <h1 className="text-[2.5rem] sm:text-5xl md:text-6xl lg:text-[4.2rem] font-bold text-[#0a1e14] dark:text-white leading-[1.1] tracking-tight whitespace-pre-line">
                            {content.title_line_1 || "Best Online Platform\nto Learn Everything"}
                            {content.title_line_2 && (
                                <span className="inline-block bg-[#FFC510] dark:bg-yellow-500 text-[#0a1e14] dark:text-gray-900 px-4 py-1 pb-1.5 rounded-xl mt-3 ml-0 lg:ml-2">
                                    {content.title_line_2}
                                </span>
                            )}
                        </h1>
                        <p className="text-[15px] sm:text-[17px] text-gray-500 dark:text-gray-400 max-w-[500px] mx-auto lg:mx-0 leading-relaxed pt-3">
                            {content.description || "Discover interactive courses, track progress in real-time, and unlock certifications. Our AI-powered platform adapts to your learning style for maximum knowledge retention."}
                        </p>

                        <div className="pt-2 pb-6 flex flex-col sm:flex-row justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-4">
                            <Link
                                href={content.button_1_link || "/courses"}
                                className="group flex items-center justify-between sm:justify-start space-x-3 bg-[#5A45FF] hover:bg-[#4a34e0] dark:bg-indigo-600 dark:hover:bg-indigo-500 text-white rounded-full pr-1.5 pl-7 py-1.5 transition-all duration-300 shadow-[0_8px_20px_rgba(90,69,255,0.25)] dark:shadow-none"
                            >
                                <span className="font-semibold text-sm sm:text-[15px] py-2.5">{content.button_1_text || "Find Courses"}</span>
                                <div className="bg-white dark:bg-gray-800 rounded-full p-2 flex items-center justify-center group-hover:bg-gray-100 dark:group-hover:bg-gray-700 transition-colors">
                                    <svg className="w-4 h-4 text-[#5A45FF] dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </Link>

                            <Link
                                href={content.button_2_link || "/books"}
                                className="group flex items-center justify-between sm:justify-start space-x-3 bg-[#FFC510] hover:bg-[#eab308] dark:bg-yellow-500 dark:hover:bg-yellow-600 text-[#0a1e14] dark:text-gray-900 rounded-full pr-1.5 pl-7 py-1.5 transition-all duration-300 shadow-[0_8px_20px_rgba(255,197,16,0.25)] dark:shadow-none"
                            >
                                <span className="font-semibold text-sm sm:text-[15px] py-2.5">{content.button_2_text || "Find Books"}</span>
                                <div className="bg-white dark:bg-gray-800 rounded-full p-2 flex items-center justify-center group-hover:bg-gray-100 dark:group-hover:bg-gray-700 transition-colors">
                                    <svg className="w-4 h-4 text-[#0a1e14] dark:text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </Link>
                        </div>

                        {/* Stats Badges */}
                        <div className="pt-6 flex flex-wrap justify-center lg:justify-start gap-8 lg:gap-12 border-t border-gray-200 dark:border-gray-800">
                            {(content.stat_1_value || content.stat_1_label) && (
                                <div className="flex flex-col mt-4">
                                    <span className="text-2xl font-black text-gray-900 dark:text-white">{content.stat_1_value}</span>
                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-400">{content.stat_1_label}</span>
                                </div>
                            )}
                            {(content.stat_2_value || content.stat_2_label) && (
                                <div className="flex flex-col mt-4">
                                    <span className="text-2xl font-black text-gray-900 dark:text-white">{content.stat_2_value}</span>
                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-400">{content.stat_2_label }</span>
                                </div>
                            )}
                            {(content.stat_3_value || content.stat_3_label) && (
                                <div className="flex flex-col mt-4">
                                    <span className="text-2xl font-black text-gray-900 dark:text-white">{content.stat_3_value}</span>
                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-400">{content.stat_3_label || "Ratings"}</span>
                                </div>
                            )}
                            {(content.stat_4_value || content.stat_4_label) && (
                                <div className="flex flex-col mt-4">
                                    <span className="text-2xl font-black text-gray-900 dark:text-white">{content.stat_4_value}</span>
                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-400">{content.stat_4_label}</span>
                                </div>
                            )}
                        </div>
                    </div>

                    {/* Right Column: Image */}
                    <div className="relative w-full max-w-[500px] mx-auto mt-12 lg:mt-0 flex justify-center">
                        {/* Background Container for positioning */}
                        <div className="relative w-full aspect-square flex items-center justify-center">
                            
                            {/* Background Circle */}
                            <div className="absolute inset-8 bg-white dark:bg-gray-800/50 rounded-full translate-x-4 shadow-[0_20px_50px_rgba(0,0,0,0.06)] dark:shadow-none -z-10"></div>
                            
                            {/* Image */}
                            <img
                                src={content.bg_image || content.hero_image || "https://res.cloudinary.com/dztksqwip/image/upload/v1727787355/student-reading-book-PNG_vsw91r.png"}
                                alt="Hero Image"
                                className="w-[85%] relative z-10 drop-shadow-2xl dark:drop-shadow-[0_25px_25px_rgba(0,0,0,0.6)] object-cover rounded-3xl"
                                style={{ transform: 'scale(1.1) translateY(-10px)' }}
                            />

                            {/* Bottom Left Green Dots */}
                            <div className="absolute bottom-16 -left-6 grid grid-cols-3 gap-2 opacity-60 dark:opacity-40">
                                {[...Array(15)].map((_, i) => (
                                    <div key={i} className="w-1.5 h-1.5 rounded-full bg-green-500 dark:bg-green-600"></div>
                                ))}
                            </div>

                            {/* Top Right Circle */}
                            <div className="absolute top-12 -right-4 w-10 h-10 border border-gray-200 dark:border-gray-700/50 rounded-full flex items-center justify-center opacity-80">
                                <div className="w-1 h-1 bg-blue-500 dark:bg-blue-600 rounded-full"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}
