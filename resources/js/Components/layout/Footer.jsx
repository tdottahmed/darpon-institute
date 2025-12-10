import Container from "../ui/Container";
import { Link } from "@inertiajs/react";

export default function Footer() {
    const currentYear = new Date().getFullYear();

    const footerLinks = {
        product: [
            { name: "Features", href: "#features" },
            { name: "Pricing", href: "#pricing" },
            { name: "Courses", href: "#courses" },
        ],
        company: [
            { name: "About", href: "#about" },
            { name: "Blog", href: "#blog" },
            { name: "Careers", href: "#careers" },
        ],
        support: [
            { name: "Help Center", href: "#help" },
            { name: "Contact", href: "#contact" },
            { name: "Privacy", href: "#privacy" },
        ],
    };

    return (
        <footer className="bg-gray-900 text-gray-300 py-12 sm:py-16">
            <Container>
                <div className="grid grid-cols-2 md:grid-cols-4 gap-8 mb-8">
                    {/* Logo and Description */}
                    <div className="col-span-2 md:col-span-1">
                        <h3 className="text-2xl font-bold text-white mb-4">
                            {import.meta.env.VITE_APP_NAME || "Darpon"}
                        </h3>
                        <p className="text-sm text-gray-400">
                            Master English from anywhere with our interactive
                            learning platform.
                        </p>
                    </div>

                    {/* Product Links */}
                    <div>
                        <h4 className="text-white font-semibold mb-4">
                            Product
                        </h4>
                        <ul className="space-y-2">
                            {footerLinks.product.map((link) => (
                                <li key={link.name}>
                                    <Link
                                        href={link.href}
                                        className="text-sm hover:text-primary-400 transition-colors"
                                    >
                                        {link.name}
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </div>

                    {/* Company Links */}
                    <div>
                        <h4 className="text-white font-semibold mb-4">
                            Company
                        </h4>
                        <ul className="space-y-2">
                            {footerLinks.company.map((link) => (
                                <li key={link.name}>
                                    <Link
                                        href={link.href}
                                        className="text-sm hover:text-primary-400 transition-colors"
                                    >
                                        {link.name}
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </div>

                    {/* Support Links */}
                    <div>
                        <h4 className="text-white font-semibold mb-4">
                            Support
                        </h4>
                        <ul className="space-y-2">
                            {footerLinks.support.map((link) => (
                                <li key={link.name}>
                                    <Link
                                        href={link.href}
                                        className="text-sm hover:text-primary-400 transition-colors"
                                    >
                                        {link.name}
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </div>
                </div>

                {/* Copyright */}
                <div className="border-t border-gray-800 pt-8 text-center text-sm text-gray-400">
                    <p>
                        © {currentYear}{" "}
                        {import.meta.env.VITE_APP_NAME || "Darpon"}. All rights
                        reserved.
                    </p>
                </div>
            </Container>
        </footer>
    );
}
