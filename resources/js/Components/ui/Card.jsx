export default function Card({
    variant = "default",
    padding = "md",
    radius = "lg",
    shadow = "md",
    hover = false,
    className = "",
    children,
    ...props
}) {
    const baseClasses = "bg-white dark:bg-gray-800 transition-all duration-300";

    const variants = {
        default: "border border-gray-200 dark:border-gray-700",
        elevated: "shadow-lg border border-gray-100 dark:border-gray-700",
        outlined: "border-2 border-gray-300 dark:border-gray-600",
        floating: "shadow-xl",
        gradient:
            "bg-gradient-to-br from-primary-50 to-secondary-50 dark:from-gray-800 dark:to-gray-900 border border-primary-100 dark:border-primary-900/30",
    };

    const paddings = {
        none: "",
        sm: "p-4",
        md: "p-6",
        lg: "p-8",
        xl: "p-10",
    };

    const radiuses = {
        none: "rounded-none",
        sm: "rounded-sm",
        md: "rounded-md",
        lg: "rounded-lg",
        xl: "rounded-xl",
        "2xl": "rounded-2xl",
        "3xl": "rounded-3xl",
        full: "rounded-full",
    };

    const shadows = {
        none: "shadow-none",
        sm: "shadow-sm",
        md: "shadow-md",
        lg: "shadow-lg",
        xl: "shadow-xl",
        "2xl": "shadow-2xl",
    };

    const hoverClasses = hover
        ? "hover:-translate-y-1 hover:shadow-xl hover:border-primary-200 dark:hover:border-primary-700"
        : "";

    const classes = `${baseClasses} ${variants[variant]} ${paddings[padding]} ${radiuses[radius]} ${shadows[shadow]} ${hoverClasses} ${className}`;

    return (
        <div className={classes} {...props}>
            {children}
        </div>
    );
}
