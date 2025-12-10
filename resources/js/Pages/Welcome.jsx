import { Head, Link, usePage } from "@inertiajs/react";
import DarkModeToggle from "@/Components/DarkModeToggle";
import LanguageSwitcher from "@/Components/LanguageSwitcher";

export default function Welcome() {
    const { auth, translations } = usePage().props;
    const t = translations?.common || {};

    return (
        <>
            <Head title={t.welcome || "Welcome"} />
            <div className="min-h-screen bg-gradient-to-br from-primary-50 via-secondary-50 to-accent-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
                {/* Header */}
                <header className="absolute top-0 left-0 right-0 z-10">
                    <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div className="flex h-16 items-center justify-between">
                            <div className="flex items-center">
                                <h1 className="text-2xl font-bold text-primary-600 dark:text-primary-400">
                                    {import.meta.env.VITE_APP_NAME || "Darpon"}
                                </h1>
                            </div>
                            <div className="flex items-center space-x-4">
                                <LanguageSwitcher />
                                <DarkModeToggle />
                                {auth?.user ? (
                                    <Link
                                        href={route("dashboard")}
                                        className="rounded-md bg-primary-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600"
                                    >
                                        {t.dashboard || "Dashboard"}
                                    </Link>
                                ) : (
                                    <>
                                        <Link
                                            href={route("login")}
                                            className="rounded-md px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400"
                                        >
                                            {t.login || "Log in"}
                                        </Link>
                                        <Link
                                            href={route("register")}
                                            className="rounded-md bg-primary-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600"
                                        >
                                            {t.register || "Register"}
                                        </Link>
                                    </>
                                )}
                            </div>
                        </div>
                    </div>
                </header>

                {/* Hero Section */}
                <main className="flex min-h-screen items-center justify-center px-4 pt-16">
                    <div className="mx-auto max-w-4xl text-center">
                        <h2 className="text-5xl font-bold text-gray-900 dark:text-white sm:text-6xl lg:text-7xl">
                            <span className="bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent dark:from-primary-400 dark:to-secondary-400">
                                {t.welcome || "Welcome"}
                            </span>
                        </h2>
                        <p className="mt-6 text-lg text-gray-600 dark:text-gray-300 sm:text-xl">
                            {auth?.user
                                ? `${t.welcome || "Welcome"} back, ${
                                      auth.user.name
                                  }!`
                                : "Get started with your journey today."}
                        </p>
                        {!auth?.user && (
                            <div className="mt-10 flex items-center justify-center gap-4">
                                <Link
                                    href={route("register")}
                                    className="rounded-lg bg-primary-600 px-8 py-3 text-base font-semibold text-white shadow-lg transition-all hover:bg-primary-700 hover:shadow-xl dark:bg-primary-500 dark:hover:bg-primary-600"
                                >
                                    {t.register || "Get Started"}
                                </Link>
                                <Link
                                    href={route("login")}
                                    className="rounded-lg border-2 border-primary-600 px-8 py-3 text-base font-semibold text-primary-600 transition-all hover:bg-primary-50 dark:border-primary-400 dark:text-primary-400 dark:hover:bg-gray-800"
                                >
                                    {t.login || "Log in"}
                                </Link>
                            </div>
                        )}
                    </div>
                </main>
            </div>
        </>
    );
}
