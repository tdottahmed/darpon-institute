import { usePage, Link } from "@inertiajs/react";

export default function HeroSection({ translations }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.hero || {};

    return (
        <section className="relative overflow-hidden bg-gradient-to-br from-[#f8fdf2] via-[#fbf7f0] to-[#f0f6fc] min-h-[85vh] flex items-center py-16 md:py-24">
            
            {/* Top Left Red Crosses */}
            <div className="absolute top-24 left-10 md:left-24 grid grid-cols-2 gap-3 opacity-60">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" className="text-red-400">
                    <path d="M12 2V22M2 12H22" stroke="currentColor" strokeWidth="4" strokeLinecap="round"/>
                </svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" className="text-red-400">
                    <path d="M12 2V22M2 12H22" stroke="currentColor" strokeWidth="4" strokeLinecap="round"/>
                </svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" className="text-red-400">
                    <path d="M12 2V22M2 12H22" stroke="currentColor" strokeWidth="4" strokeLinecap="round"/>
                </svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" className="text-red-400">
                    <path d="M12 2V22M2 12H22" stroke="currentColor" strokeWidth="4" strokeLinecap="round"/>
                </svg>
            </div>

            {/* Right Middle Green Dots */}
            <div className="absolute right-10 top-[40%] hidden lg:grid grid-cols-3 gap-2 opacity-60">
                {[...Array(15)].map((_, i) => (
                    <div key={i} className="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                ))}
            </div>

            <div className="container mx-auto px-4 sm:px-6 lg:px-16 relative z-10 w-full max-w-7xl mt-4">
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">

                    {/* Left Column: Content */}
                    <div className="space-y-6 text-center lg:text-left z-10 pt-8 lg:pt-0">
                        <h1 className="text-[2.5rem] sm:text-5xl md:text-6xl lg:text-[4.2rem] font-bold text-[#0a1e14] leading-[1.1] tracking-tight">
                            {content.title_line_1 || "Best"} <span className="inline-block bg-[#FFC510] text-[#0a1e14] px-4 py-1 pb-1.5 rounded-xl ml-1">
                                {content.highlight_text || "Online"}
                            </span>
                            <br />
                            {content.title_line_2 || "Platform to Learn"}
                            <br />
                            {content.title_line_3 || "Everything"}
                        </h1>
                        <p className="text-[15px] sm:text-[17px] text-gray-500 max-w-[500px] mx-auto lg:mx-0 leading-relaxed pt-3">
                            {content.description || "Discover interactive courses, track progress in real-time, and unlock certifications. Our AI-powered platform adapts to your learning style for maximum knowledge retention."}
                        </p>

                        <div className="pt-6 flex justify-center lg:justify-start">
                            <Link
                                href={content.button_1_link || "/courses"}
                                className="group flex items-center space-x-3 bg-[#5A45FF] hover:bg-[#4a34e0] text-white rounded-full pr-1.5 pl-7 py-1.5 transition-all duration-300 shadow-[0_8px_20px_rgba(90,69,255,0.25)]"
                            >
                                <span className="font-semibold text-sm sm:text-[15px] py-2.5">{content.button_1_text || "Find Courses"}</span>
                                <div className="bg-white rounded-full p-2 flex items-center justify-center group-hover:bg-gray-100 transition-colors">
                                    <svg className="w-4 h-4 text-[#5A45FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </Link>
                        </div>
                    </div>

                    {/* Right Column: Image */}
                    <div className="relative w-full max-w-[500px] mx-auto mt-12 lg:mt-0 flex justify-center">
                        {/* Background Container for positioning */}
                        <div className="relative w-full aspect-square flex items-center justify-center">
                            
                            {/* Background Circle */}
                            <div className="absolute inset-8 bg-white rounded-full translate-x-4 shadow-[0_20px_50px_rgba(0,0,0,0.06)] -z-10"></div>
                            
                            {/* Image */}
                            <img
                                src={content.hero_image || "https://res.cloudinary.com/dztksqwip/image/upload/v1727787355/student-reading-book-PNG_vsw91r.png"}
                                alt="Student"
                                className="w-[85%] relative z-10 drop-shadow-2xl object-cover"
                                style={{ transform: 'scale(1.1) translateY(-10px)' }}
                            />

                            {/* Bottom Left Green Dots */}
                            <div className="absolute bottom-16 -left-6 grid grid-cols-3 gap-2 opacity-60">
                                {[...Array(15)].map((_, i) => (
                                    <div key={i} className="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                                ))}
                            </div>

                            {/* Top Right Circle */}
                            <div className="absolute top-12 -right-4 w-10 h-10 border border-gray-200 rounded-full flex items-center justify-center opacity-80">
                                <div className="w-1 h-1 bg-blue-500 rounded-full"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}
