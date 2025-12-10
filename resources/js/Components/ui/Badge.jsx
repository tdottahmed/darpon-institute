export default function Badge({
    variant = "primary",
    icon,
    className = "",
    children,
    ...props
}) {
    const baseClasses =
        "inline-flex items-center px-3 py-1 rounded-full text-xs font-medium";

    const variants = {
        primary:
            "bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-300",
        secondary:
            "bg-secondary-100 text-secondary-700 dark:bg-secondary-900/30 dark:text-secondary-300",
        success:
            "bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300",
        warning:
            "bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300",
        info: "bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300",
    };

    const classes = `${baseClasses} ${variants[variant]} ${className}`;

    return (
        <span className={classes} {...props}>
            {icon && <span className="mr-1">{icon}</span>}
            {children}
        </span>
    );
}
