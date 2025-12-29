export default function WelcomeSection({ user }) {
    return (
        <div className="bg-gradient-to-r from-primary-600 via-secondary-600 to-accent-600 dark:from-primary-700 dark:via-secondary-700 dark:to-accent-700 rounded-2xl p-8 text-white">
            <div className="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 className="text-3xl sm:text-4xl font-bold mb-2">
                        Welcome back,{" "}
                        {user?.name?.split(" ")[0] || "User"}! 👋
                    </h1>
                    <p className="text-white/90 text-lg">
                        Manage your purchases and profile settings
                    </p>
                </div>
            </div>
        </div>
    );
}

