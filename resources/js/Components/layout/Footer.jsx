import Container from "../ui/Container";
import { Link, usePage } from "@inertiajs/react";

export default function Footer() {
    const { frontend_content, settings } = usePage().props;
    const content = frontend_content?.footer || {};
    const currentYear = new Date().getFullYear();

    const exploreLinks = [
        {
            name: content.link_courses || "All Courses",
            href: route("courses.index"),
        },
        {
            name: content.link_books || "Books Store",
            href: route("books.index"),
        },
        { name: content.link_about || "About Us", href: route("about") },
        { name: content.link_contact || "Contact", href: route("contact") },
        { name: "Success Stories", href: route("home") + "#testimonials" },
    ];

    const supportLinks = [
        { name: "Privacy Policy", href: "#privacypolicy" },
        { name: "Terms of Service", href: "#terms" },
        { name: "Refund Policy", href: "#" },
    ];

    const socialLinks = [
        {
            name: "Facebook",
            icon: (props) => (
                <svg fill="currentColor" viewBox="0 0 24 24" {...props}>
                    <path
                        fillRule="evenodd"
                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                        clipRule="evenodd"
                    />
                </svg>
            ),
            href: settings?.social_facebook || "#",
        },
        {
            name: "Instagram",
            icon: (props) => (
                <svg fill="currentColor" viewBox="0 0 24 24" {...props}>
                    <path
                        fillRule="evenodd"
                        d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772 4.902 4.902 0 011.772-1.153c.636-.247 1.363-.416 2.427-.465C9.673 2.013 10.03 2 12.48 2h-.165zm-2.366 1.258c-2.269 0-2.551.01-3.44.05-.888.041-1.492.186-1.921.353-.519.202-.9.467-1.206.773-.306.307-.571.688-.773 1.206-.167.43-.312 1.033-.353 1.921-.04.89-.05 1.171-.05 3.441a16.635 16.635 0 00.05 3.44c.041.89.186 1.493.353 1.922.202.518.467.9.773 1.206.307.306.688.571 1.206.773.43.167 1.033.312 1.921.353.89.04 1.171.05 3.441.05 2.27 0 2.551-.01 3.44-.05.888-.041 1.492-.186 1.921-.353.519-.202.9-.467 1.206-.773.307-.306.571-.688.773-1.206.167-.43.312-1.033.353-1.921.04-.89.05-1.171.05-3.441 0-2.269-.01-2.551-.05-3.44-.041-.888-.186-1.492-.353-1.921-.202-.519-.467-.9-.773-1.206-.307-.306-.688-.571-1.206-.773-.43-.167-1.033-.312-1.921-.353-.889-.04-1.171-.05-3.441-.05z"
                        clipRule="evenodd"
                    />
                </svg>
            ),
            href: settings?.social_instagram || "#",
        },
        {
            name: "Twitter",
            icon: (props) => (
                <svg fill="currentColor" viewBox="0 0 24 24" {...props}>
                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                </svg>
            ),
            href: settings?.social_twitter || "#",
        },
        {
            name: "YouTube",
            icon: (props) => (
                <svg fill="currentColor" viewBox="0 0 24 24" {...props}>
                    <path
                        fillRule="evenodd"
                        d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 01-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 01-1.768-1.768C2 15.255 2 12 2 12s0-3.255.418-4.814a2.507 2.507 0 011.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418zM15.194 12 10 15V9l5.194 3z"
                        clipRule="evenodd"
                    />
                </svg>
            ),
            href: settings?.social_youtube || "#",
        },
    ].filter((link) => link.href !== "#");

    return (
        <footer className="relative overflow-hidden bg-[var(--header-footer-bg-light)] dark:bg-[var(--header-footer-bg-dark)] border-t border-gray-200 dark:border-gray-800 transition-colors duration-300">
            <Container className="relative z-10">
                {/* 3 columns */}
                <div className="pt-16 pb-12 grid grid-cols-2 md:grid-cols-3 gap-12 lg:gap-16 text-center md:text-left">
                    {/* Column 1: Brand */}
                    <div className="col-span-2 md:col-span-1 space-y-5 flex flex-col items-center md:items-start">
                        <Link href="/" className="inline-block">
                            <img
                                src={settings?.logo_light || "/darponbdv.png"}
                                alt="Darpon Logo"
                                className="h-14 w-auto dark:hidden max-w-[180px]"
                            />
                            {settings?.logo_dark ? (
                                <img
                                    src={settings.logo_dark}
                                    alt="Darpon Logo"
                                    className="h-14 w-auto hidden dark:block max-w-[180px]"
                                />
                            ) : (
                                <img
                                    src={
                                        settings?.logo_light || "/darponbdv.png"
                                    }
                                    alt="Darpon Logo"
                                    className="h-14 w-auto hidden dark:block max-w-[180px] invert opacity-90"
                                />
                            )}
                        </Link>
                        <p className="text-gray-600 dark:text-gray-300 text-sm leading-relaxed max-w-xs">
                            {content.description ||
                                "Empowering students with accessible, high-quality English education. Join Darpon and start your learning journey today."}
                        </p>
                        {socialLinks.length > 0 && (
                            <div className="flex items-center gap-3 pt-2">
                                {socialLinks.map((item) => (
                                    <a
                                        key={item.name}
                                        href={item.href}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="flex items-center justify-center w-10 h-10 rounded-xl bg-gray-200/80 dark:bg-white/5 text-gray-600 dark:text-gray-400 hover:bg-primary-100 hover:text-primary-700 dark:hover:bg-primary-500/20 dark:hover:text-white transition-all duration-300"
                                        aria-label={item.name}
                                    >
                                        <item.icon
                                            className="h-5 w-5"
                                            aria-hidden="true"
                                        />
                                    </a>
                                ))}
                            </div>
                        )}
                    </div>

                    {/* Column 2: Explore */}
                    <div>
                        <h3 className="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-widest mb-6 md:text-left text-center">
                            {content.col_1_title || "Explore"}
                        </h3>
                        <ul className="space-y-3.5 md:text-left text-center">
                            {exploreLinks.map((link) => (
                                <li key={link.name}>
                                    <Link
                                        href={link.href}
                                        className="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition-colors duration-200"
                                    >
                                        {link.name}
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </div>

                    {/* Column 3: Support / Legal */}
                    <div>
                        <h3 className="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-widest mb-6 md:text-left text-center">
                            {content.col_3_title || "Support"}
                        </h3>
                        <ul className="space-y-3.5 md:text-left text-center">
                            {supportLinks.map((link) => (
                                <li key={link.name}>
                                    <Link
                                        href={link.href}
                                        className="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition-colors duration-200"
                                    >
                                        {link.name}
                                    </Link>
                                </li>
                            ))}
                            {settings?.rss_feed_url && (
                                <li>
                                    <a
                                        href={settings.rss_feed_url}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition-colors duration-200"
                                    >
                                        RSS Feed
                                    </a>
                                </li>
                            )}
                        </ul>
                    </div>
                </div>

                {/* Bottom bar */}
                <div className="border-t border-gray-200 dark:border-gray-800 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p className="text-gray-500 dark:text-gray-400 text-sm text-center sm:text-left">
                        &copy; {currentYear}{" "}
                        {import.meta.env.VITE_APP_NAME || "Darpon"}.{" "}
                        {content.copyright || "All rights reserved."}
                    </p>
                    <div className="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                        <span className="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" />
                        System Operational
                    </div>
                </div>

                {/* Developer credit */}
                <div className="border-t border-gray-200 dark:border-gray-800 py-4 text-center">
                    <p className="text-gray-500 dark:text-gray-400 text-xs">
                        Developed by{" "}
                        <a
                            href="https://nixsoftware.net/"
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white font-medium transition-colors"
                        >
                            nix software
                        </a>
                    </p>
                </div>
            </Container>
        </footer>
    );
}
