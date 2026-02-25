import { usePage } from "@inertiajs/react";

export default function HeroSection({ translations }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.hero || {};

    return (
        <section className="relative  overflow-hidden">
            {/* Full Width Background Image */}
            <div className="absolute inset-0 z-0 select-none overflow-hidden ">
                <img
                    src={
                        content.bg_image ||
                        "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1920&auto=format&fit=crop"
                    }
                    alt="Background"
                    className="w-full h-full object-cover object-center scale-105 md:scale-100 transition-transform duration-700 ease-out"
                    loading="eager"
                />
                {/* Enhanced Overlay with Gradient - Optimized for top-left text */}
                <div className="absolute inset-0 bg-gradient-to-br from-gray-900/50 via-gray-900/40 to-gray-900/30"></div>
                <div className="absolute inset-0 bg-gradient-to-r from-gray-900/50 via-gray-900/30 to-transparent"></div>
                {/* Accent Gradient Overlay */}
                <div className="absolute inset-0 bg-gradient-to-br from-primary-600/25 via-primary-600/10 to-transparent"></div>
                {/* Subtle overlay for depth */}
                <div className="absolute top-0 left-0 w-1/2 h-full bg-gradient-to-r from-gray-900/30 to-transparent"></div>
            </div>

            {/* Content Container - Top Left Positioned */}
            <div className="relative z-10 flex items-center min-h-[45vh] sm:min-h-[50vh] md:min-h-[65vh] lg:min-h-[75vh] xl:min-h-[80vh]">
                <div className="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="max-w-4xl mx-auto">
                        {/* Main Heading - Clean Typography */}
                        {(content.title_line_1 || content.title_line_2) && (
                            <div className="animate-fade-in-up pt-[25px]" style={{ animationDelay: '0.2s' }}>
                                <h1 class="text-4xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-7xl xxl:text-8xl font-black text-white leading-[1.08] tracking-[-0.02em] sm:tracking-[-0.03em] md:tracking-[-0.04em] text-center pt-2">
                                    {content.title_line_1 && (
                                        <span 
                                            className="block mb-2 sm:mb-3 md:mb-4 lg:mb-5"
                                            style={{
                                                textShadow: '0 2px 10px rgba(0, 0, 0, 0.7), 0 1px 3px rgba(0, 0, 0, 0.5)'
                                            }}
                                        >
                                            {content.title_line_1}
                                        </span>
                                    )}
                                    {content.title_line_2 && (
                                        <span 
                                            className="block"
                                            style={{
                                                textShadow: '0 2px 10px rgba(0, 0, 0, 0.7), 0 1px 3px rgba(0, 0, 0, 0.5)'
                                            }}
                                        >
                                            {content.title_line_2}
                                        </span>
                                    )}
                                </h1>
                            </div>
                        )}
                    </div>
                </div>
            </div>

            {/* Enhanced Scroll Indicator - Positioned at bottom center */}
            <div className="absolute bottom-4 sm:bottom-6 md:bottom-8 lg:bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce z-10">
                <div className="w-5 h-9 sm:w-6 sm:h-10 md:w-7 md:h-12 border-2 border-white/70 rounded-full flex justify-center backdrop-blur-md bg-white/15 shadow-xl hover:bg-white/20 transition-all duration-300 cursor-pointer">
                    <div className="w-1.5 h-2 sm:w-1.5 sm:h-3 md:w-2 md:h-4 bg-gradient-to-b from-primary-400 to-primary-500 rounded-full mt-2 sm:mt-2.5 md:mt-3 animate-pulse"></div>
                </div>
            </div>
        </section>
    );
}
