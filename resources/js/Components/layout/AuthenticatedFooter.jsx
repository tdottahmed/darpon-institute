export default function AuthenticatedFooter() {
    const currentYear = new Date().getFullYear();

    return (
        <footer className="border-t border-gray-200 bg-white py-4 dark:border-gray-700 dark:bg-gray-800">
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div className="flex flex-col items-center justify-center space-y-2">
                    <p className="text-sm text-gray-600 dark:text-gray-400">
                        © {currentYear}{" "}
                        {import.meta.env.VITE_APP_NAME || "Darpon"}. All rights
                        reserved.
                    </p>
                </div>
            </div>
        </footer>
    );
}
