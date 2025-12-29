export default function BackgroundDecorations() {
    return (
        <>
            <div className="absolute top-0 left-0 w-full h-96 bg-gradient-to-br from-primary-50 via-secondary-50 to-primary-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 -z-10"></div>
            <div className="absolute -top-10 right-0 w-96 h-96 bg-primary-200/20 rounded-full blur-3xl dark:bg-primary-900/10 -z-10"></div>
            <div className="absolute bottom-0 left-0 w-96 h-96 bg-secondary-200/20 rounded-full blur-3xl dark:bg-secondary-900/10 -z-10"></div>
        </>
    );
}

