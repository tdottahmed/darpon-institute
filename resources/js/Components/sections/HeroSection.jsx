import { usePage, Link } from "@inertiajs/react";

export default function HeroSection({ translations }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.hero || {};

    return (
        <section className="relative overflow-hidden bg-white dark:bg-gray-950 min-h-[75vh] md:min-h-[85vh] flex items-center py-20 sm:py-20">
            {/* Background Decorations */}
            <div className="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-primary-500/10 rounded-full blur-[80px] md:blur-[120px]"></div>
            <div className="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-[250px] md:w-[500px] h-[250px] md:h-[500px] bg-secondary-500/10 rounded-full blur-[70px] md:blur-[100px]"></div>

            <div className="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                    {/* Left Column: Content */}
                    <div className="space-y-8 text-center lg:text-left order-2 lg:order-1">
                        <div className="space-y-6">
                            <h1 className="text-4xl sm:text-5xl md:text-6xl xl:text-7xl font-extrabold text-gray-900 dark:text-white leading-[1.15] tracking-tight animate-fade-in-up" style={{ animationDelay: '0.1s' }}>
                                {content.title_line_1 || "Master Your Future"}
                                <span className="block text-transparent bg-clip-text bg-gradient-to-r from-primary-600 via-primary-500 to-secondary-500 mt-2">
                                    {content.title_line_2 || "with Darpon Institute"}
                                </span>
                            </h1>
                            <p className="text-lg md:text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto lg:mx-0 animate-fade-in-up leading-relaxed" style={{ animationDelay: '0.2s' }}>
                                {content.description || "Unlock your potential with our expert-led courses and comprehensive learning materials. Join thousands of successful students today and transform your skills."}
                            </p>
                        </div>

                        <div className="flex flex-col sm:flex-row items-center justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-5 animate-fade-in-up" style={{ animationDelay: '0.3s' }}>
                            {content.button_1_text && (
                                <Link
                                    href={content.button_1_link || "/courses"}
                                    className="w-full sm:w-auto px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white rounded-2xl font-bold text-lg shadow-xl shadow-primary-500/25 transition-all duration-300 hover:-translate-y-1 active:scale-95 flex items-center justify-center group"
                                >
                                    {content.button_1_text}
                                    <svg className="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </Link>
                            )}
                            {content.button_2_text && (
                                <Link
                                    href={content.button_2_link || "/books"}
                                    className="w-full sm:w-auto px-8 py-4 bg-white dark:bg-gray-900 text-gray-900 dark:text-white border-2 border-gray-100 dark:border-gray-800 hover:border-primary-500 dark:hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-400 rounded-2xl font-bold text-lg transition-all duration-300 hover:-translate-y-1 active:scale-95 flex items-center justify-center shadow-lg shadow-gray-200/50 dark:shadow-none"
                                >
                                    {content.button_2_text}
                                </Link>
                            )}
                        </div>

                        {/* Stats Badges */}
                        {/* <div className="pt-10 flex flex-wrap justify-center lg:justify-start gap-10 animate-fade-in-up" style={{ animationDelay: '0.4s' }}>
                            {(content.stat_1_value || content.stat_1_label) && (
                                <div className="flex flex-col">
                                    <span className="text-3xl font-black text-gray-900 dark:text-white">{content.stat_1_value || "10K+"}</span>
                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-400">{content.stat_1_label || "Students"}</span>
                                </div>
                            )}
                            <div className="hidden sm:block w-px h-12 bg-gray-200 dark:bg-gray-800 mt-1"></div>
                            {(content.stat_2_value || content.stat_2_label) && (
                                <div className="flex flex-col">
                                    <span className="text-3xl font-black text-gray-900 dark:text-white">{content.stat_2_value || "500+"}</span>
                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-400">{content.stat_2_label || "Courses"}</span>
                                </div>
                            )}
                            <div className="hidden sm:block w-px h-12 bg-gray-200 dark:bg-gray-800 mt-1"></div>
                            {(content.stat_3_value || content.stat_3_label) && (
                                <div className="flex flex-col">
                                    <span className="text-3xl font-black text-gray-900 dark:text-white">{content.stat_3_value || "4.9"}</span>
                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-400">{content.stat_3_label || "User Rating"}</span>
                                </div>
                            )}
                        </div> */}
                    </div>

                    {/* Right Column: High Quality Image */}
                    <div className="relative animate-fade-in order-1 lg:order-2" style={{ animationDelay: '0.4s' }}>
                        {/* Interactive Image Frame */}
                        <div className="absolute -inset-4 bg-gradient-to-tr from-primary-500/20 to-secondary-500/20 rounded-[3rem] blur-2xl rotate-3 animate-pulse"></div>
                        <div className="relative rounded-[2.5rem] overflow-hidden border-[12px] border-white dark:border-gray-900 shadow-[0_32px_64px_-12px_rgba(0,0,0,0.14)] dark:shadow-[0_32px_64px_-12px_rgba(0,0,0,0.5)] group">
                            <img
                                src={content.hero_image || "https://images.unsplash.com/photo-1523240715627-5d0b501f2185?q=80&w=1470&auto=format&fit=crop"}
                                alt="Darpon Institute"
                                className="w-full h-full object-cover aspect-[4/3] sm:aspect-square lg:aspect-[4/5] xl:aspect-square scale-100 group-hover:scale-110 transition-transform duration-1000 ease-out"
                            />
                            <div className="absolute inset-0 bg-gradient-to-t from-gray-900/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        </div>

                        {/* Floating Elements */}
                        <div className="absolute -top-6 -right-6 md:-right-10 bg-white dark:bg-gray-900 p-5 rounded-3xl shadow-2xl border border-gray-50 dark:border-gray-800 animate-float">
                            <div className="flex items-center space-x-4">
                                <div className="p-3 bg-primary-100 dark:bg-primary-900/40 rounded-2xl">
                                    <svg className="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div className="pr-2">
                                    <p className="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Resources</p>
                                    <p className="text-base font-black text-gray-900 dark:text-white">1,000+ Items</p>
                                </div>
                            </div>
                        </div>

                        <div className="absolute -bottom-10 -left-6 md:-left-12 bg-white dark:bg-gray-900 p-5 rounded-3xl shadow-2xl border border-gray-50 dark:border-gray-800 animate-float" style={{ animationDelay: '1.5s' }}>
                            <div className="flex items-center space-x-4">
                                <div className="p-3 bg-green-100 dark:bg-green-900/40 rounded-2xl">
                                    <svg className="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div className="pr-2">
                                    <p className="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Success Rate</p>
                                    <p className="text-base font-black text-gray-900 dark:text-white">99% Quality</p>
                                </div>
                            </div>
                        </div>

                        {/* Decoration dots */}
                        <div className="absolute -z-10 bottom-20 -right-16 w-32 h-32 bg-secondary-200/30 rounded-full blur-2xl"></div>
                    </div>

                </div>
            </div>

            {/* Scroll Indicator */}
            <div className="absolute bottom-6 left-1/2 -translate-x-1/2 hidden xl:block animate-bounce">
                <div className="w-7 h-11 border-2 border-gray-200 dark:border-gray-800 rounded-full flex justify-center p-1.5 backdrop-blur-sm bg-white/10 dark:bg-black/10">
                    <div className="w-1.5 h-2.5 bg-primary-600 dark:bg-primary-400 rounded-full"></div>
                </div>
            </div>
        </section>
    );
}
