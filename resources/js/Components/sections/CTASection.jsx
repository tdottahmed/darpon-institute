import { useEffect, useMemo, useState } from "react";
import Badge from "../ui/Badge";
import Container from "../ui/Container";
import PrimaryButton from "../ui/PrimaryButton";
import SecondaryButton from "../ui/SecondaryButton";
import { usePage } from "@inertiajs/react";

const SUBTITLE_WORD_LIMITS = { sm: 20, md: 40, full: Infinity };

function getWordLimit(width) {
    if (width < 640) return SUBTITLE_WORD_LIMITS.sm;
    if (width < 1024) return SUBTITLE_WORD_LIMITS.md;
    return SUBTITLE_WORD_LIMITS.full;
}

export default function CTASection({ translations }) {
    const { frontend_content } = usePage().props;
    const content = frontend_content?.cta || {};
    const t = translations?.common || {};

    const [viewportWidth, setViewportWidth] = useState(() =>
        typeof window !== "undefined" ? window.innerWidth : 1024,
    );
    const [isExpanded, setIsExpanded] = useState(false);

    useEffect(() => {
        const onResize = () => setViewportWidth(window.innerWidth);
        window.addEventListener("resize", onResize);
        return () => window.removeEventListener("resize", onResize);
    }, []);

    const rawSubtitle =
        content.subtitle ||
        "Join thousands of students already learning with us. Get started today and transform your English skills!";

    const { truncated, isTruncated } = useMemo(() => {
        const limit = getWordLimit(viewportWidth);
        const words = rawSubtitle.split(/\s+/).filter(Boolean);
        if (words.length <= limit) return { truncated: rawSubtitle, isTruncated: false };
        return { truncated: words.slice(0, limit).join(" "), isTruncated: true };
    }, [rawSubtitle, viewportWidth]);

    return (
        <section className="relative py-16 sm:py-20 overflow-hidden bg-gradient-to-br from-primary-600 via-primary-700 to-secondary-600 dark:from-primary-800 dark:via-primary-900 dark:to-secondary-800">
            {/* Background Pattern */}
            <div className="absolute inset-0 opacity-10">
                <div
                    className="absolute inset-0"
                    style={{
                        backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`,
                        backgroundRepeat: "repeat",
                        backgroundSize: "60px 60px",
                    }}
                />
            </div>

            {/* Decorative blobs */}
            <div className="absolute top-0 left-0 w-72 h-72 bg-white/5 rounded-full blur-3xl" />
            <div className="absolute bottom-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl" />

            <Container className="relative z-10">
                <div className="mb-4 text-center">
                    <Badge
                        variant="secondary"
                        className="text-xs font-semibold uppercase tracking-wide px-3 py-1"
                    >
                        {content.badge || "Call To Action"}
                    </Badge>
                </div>

                <div className="text-center space-y-6 sm:space-y-8 max-w-4xl mx-auto">
                    <h2 className="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight text-balance">
                        {content.title || "Ready to Start Your English Journey?"}
                    </h2>

                    <p className="text-base sm:text-lg lg:text-xl text-white/90 leading-relaxed">
                        {isTruncated && !isExpanded ? (
                            <>
                                {truncated}{"… "}
                                <button
                                    type="button"
                                    onClick={() => setIsExpanded(true)}
                                    className="inline font-semibold underline underline-offset-2 text-white hover:text-white/80 transition-colors"
                                >
                                    Read more
                                </button>
                            </>
                        ) : (
                            <>
                                {rawSubtitle}
                                {isTruncated && (
                                    <button
                                        type="button"
                                        onClick={() => setIsExpanded(false)}
                                        className="ml-1 inline font-semibold underline underline-offset-2 text-white hover:text-white/80 transition-colors"
                                    >
                                        Show less
                                    </button>
                                )}
                            </>
                        )}
                    </p>

                    <div className="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center pt-2">
                        <PrimaryButton href={route("courses.index")}>
                            {content.btn_primary || t.register || "Get Started Free"}
                        </PrimaryButton>
                        <SecondaryButton href={route("login")} showIcon={true}>
                            {content.btn_outline || t.login || "Log In"}
                        </SecondaryButton>
                    </div>
                </div>
            </Container>
        </section>
    );
}
