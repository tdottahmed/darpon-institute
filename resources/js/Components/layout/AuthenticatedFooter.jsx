export default function AuthenticatedFooter() {
    const currentYear = new Date().getFullYear();

    return (
        <footer className="border-t border-gray-200 bg-white py-4 dark:border-gray-700 dark:bg-gray-800">
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div className="flex flex-col items-center justify-between space-y-2 sm:flex-row sm:space-y-0">
                    <p className="text-sm text-gray-600 dark:text-gray-400">
                        © {currentYear}{" "}
                        {import.meta.env.VITE_APP_NAME || "Darpon"}. All rights
                        reserved.
                    </p>
                    <div className="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                        <a
                            href="#"
                            className="hover:text-primary-600 dark:hover:text-primary-400"
                        >
                            Privacy
                        </a>
                        <a
                            href="#"
                            className="hover:text-primary-600 dark:hover:text-primary-400"
                        >
                            Terms
                        </a>
                        <a
                            href="#"
                            className="hover:text-primary-600 dark:hover:text-primary-400"
                        >
                            Help
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    );
}
