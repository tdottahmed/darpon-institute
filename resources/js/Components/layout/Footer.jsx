import Container from "../ui/Container";
import { Link, usePage } from "@inertiajs/react";
import FloatingWidgets from "../ui/FloatingWidgets";

export default function Footer() {
    const { frontend_content, settings, custom_pages } = usePage().props;
    const content = frontend_content?.footer || {};
    const currentYear = new Date().getFullYear();

    const quickLinks = [
        { name: content.link_about || "About Us", href: route("about") },
        { name: content.link_books || "Books", href: route("books.index") },
        {
            name: content.link_courses || "Courses",
            href: route("courses.index"),
        },
        { name: content.link_contact || "Contact Us", href: route("contact") },
        { name: "Success Stories", href: route("home") + "#testimonials" },
        { name: "Blog", href: route("video_blogs.index") },
        { name: "Gallery", href: route("galleries.index") },
    ];

    const supportLinks = (custom_pages || []).map((page) => ({
        name: page.title,
        href: route("page.show", page.slug),
    }));

    const socialLinks = [
        {
            name: "Facebook",
            color: "#1877F2",
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
            color: "#E1306C",
            icon: (props) => (
                <svg viewBox="0 0 24 24" fill="none" {...props}>
                    <rect
                        x="2"
                        y="2"
                        width="20"
                        height="20"
                        rx="5"
                        stroke="currentColor"
                        strokeWidth="2"
                    />
                    <circle
                        cx="12"
                        cy="12"
                        r="4"
                        stroke="currentColor"
                        strokeWidth="2"
                    />
                    <circle cx="17" cy="7" r="1" fill="currentColor" />
                </svg>
            ),
            href: settings?.social_instagram || "#",
        },
        {
            name: "X",
            color: "currentColor",
            icon: (props) => (
                <svg fill="currentColor" viewBox="0 0 24 24" {...props}>
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                </svg>
            ),
            href: settings?.social_twitter || "#",
        },
        {
            name: "YouTube",
            color: "#FF0000",
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
        <footer className="relative overflow-hidden bg-[var(--header-footer-bg-light)] dark:bg-[var(--header-footer-bg-dark)] text-[var(--header-footer-text-light)] dark:text-[var(--header-footer-text-dark)] border-t border-gray-200 dark:border-gray-800 transition-colors duration-300">
            <Container className="relative z-10">
                {/* 4 columns */}
                <div className="pt-12 pb-10 grid grid-cols-2 md:grid-cols-4 gap-10 md:gap-8">
                    {/* Column 1: Brand */}
                    <div className="col-span-2 md:col-span-1 space-y-4 flex flex-col items-start">
                        <Link href="/" className="inline-block">
                            <img
                                src={settings?.logo_light || "/darponbdv.png"}
                                alt="Darpon Logo"
                                className="h-12 w-auto dark:hidden max-w-[160px]"
                            />
                            {settings?.logo_dark ? (
                                <img
                                    src={settings.logo_dark}
                                    alt="Darpon Logo"
                                    className="h-12 w-auto hidden dark:block max-w-[160px]"
                                />
                            ) : (
                                <img
                                    src={
                                        settings?.logo_light || "/darponbdv.png"
                                    }
                                    alt="Darpon Logo"
                                    className="h-12 w-auto hidden dark:block max-w-[160px] invert opacity-90"
                                />
                            )}
                        </Link>
                        <p
                            className="opacity-75 text-sm leading-relaxed max-w-[240px] mt-2"
                            dangerouslySetInnerHTML={{
                                __html:
                                    content.description ||
                                    "Empowering English learners worldwide with expert guidance, engaging courses, and a supportive community.",
                            }}
                        ></p>
                        {socialLinks.length > 0 && (
                            <div className="flex items-center gap-2.5 pt-1">
                                {socialLinks.map((item) => (
                                    <a
                                        key={item.name}
                                        href={item.href}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="flex items-center justify-center w-9 h-9 rounded-xl bg-gray-200/80 dark:bg-white/5 transition-all duration-300 hover:scale-110"
                                        style={{ color: item.color }}
                                        aria-label={item.name}
                                    >
                                        <item.icon
                                            className="h-4 w-4"
                                            aria-hidden="true"
                                        />
                                    </a>
                                ))}
                            </div>
                        )}
                    </div>

                    {/* Column 2: Quick Links */}
                    <div>
                        <h3 className="text-xs font-bold uppercase tracking-widest mb-5">
                            {content.col_1_title || "Quick Links"}
                        </h3>
                        <ul className="space-y-3">
                            {quickLinks.map((link) => (
                                <li key={link.name}>
                                    <Link
                                        href={link.href}
                                        className="text-sm opacity-75 hover:opacity-100 transition-opacity duration-200"
                                    >
                                        {link.name}
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </div>

                    {/* Column 3: Legal / Custom Pages */}
                    {supportLinks.length > 0 && (
                        <div>
                            <h3 className="text-xs font-bold uppercase tracking-widest mb-5">
                                {content.col_3_title || "Legal"}
                            </h3>
                            <ul className="space-y-3">
                                {supportLinks.map((link) => (
                                    <li key={link.name}>
                                        <Link
                                            href={link.href}
                                            className="text-sm opacity-75 hover:opacity-100 transition-opacity duration-200"
                                        >
                                            {link.name}
                                        </Link>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}

                    {/* Column 4: Contact Info */}
                    <div
                        className={`col-span-2 md:col-span-1 ${supportLinks.length === 0 ? "md:col-start-4" : ""}`}
                    >
                        <h3 className="text-xs font-bold uppercase tracking-widest mb-5">
                            {content.col_4_title || "Contact"}
                        </h3>
                        <ul className="space-y-3.5 text-sm opacity-75">
                            {settings?.company_address && (
                                <li className="flex gap-2.5 items-start">
                                    <svg
                                        className="w-4 h-4 flex-shrink-0 mt-0.5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                        />
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>
                                    <span style={{ whiteSpace: "pre-line" }}>
                                        {settings.company_address}
                                    </span>
                                </li>
                            )}
                            {settings?.company_phone && (
                                <li className="flex gap-2.5 items-center">
                                    <svg
                                        className="w-4 h-4 flex-shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                        />
                                    </svg>
                                    <a
                                        href={`tel:${settings.company_phone}`}
                                        className="hover:opacity-100 transition-opacity"
                                    >
                                        {settings.company_phone}
                                    </a>
                                </li>
                            )}
                            {settings?.company_email && (
                                <li className="flex gap-2.5 items-center">
                                    <svg
                                        className="w-4 h-4 flex-shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                        />
                                    </svg>
                                    <a
                                        href={`mailto:${settings.company_email}`}
                                        className="hover:opacity-100 transition-opacity break-all"
                                    >
                                        {settings.company_email}
                                    </a>
                                </li>
                            )}
                            {!settings?.company_address &&
                                !settings?.company_phone &&
                                !settings?.company_email && (
                                    <li className="opacity-60">
                                        Update info in Admin settings.
                                    </li>
                                )}
                        </ul>
                    </div>
                </div>

                {/* Bottom bar */}
                <div className="border-t border-gray-200 dark:border-gray-800 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p className="opacity-70 text-sm text-center sm:text-left">
                        &copy; {currentYear}{" "}
                        {import.meta.env.VITE_APP_NAME || "Darpon"}.{" "}
                        {content.copyright || "All rights reserved."}
                    </p>
                    <p className="opacity-70 text-xs">
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

            <FloatingWidgets />
        </footer>
    );
}
