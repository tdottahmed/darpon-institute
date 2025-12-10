export default function Card({
    variant = "default",
    padding = "md",
    radius = "lg",
    shadow = "md",
    className = "",
    children,
    ...props
}) {
    const baseClasses = "bg-white dark:bg-gray-800";

    const variants = {
        default: "border border-gray-200 dark:border-gray-700",
        elevated: "shadow-lg",
        outlined: "border-2 border-gray-300 dark:border-gray-600",
        floating: "shadow-xl transform hover:scale-105 transition-transform",
    };

    const paddings = {
        sm: "p-4",
        md: "p-6",
        lg: "p-8",
    };

    const radiuses = {
        sm: "rounded-sm",
        md: "rounded-md",
        lg: "rounded-lg",
        xl: "rounded-xl",
        "2xl": "rounded-2xl",
        full: "rounded-full",
    };

    const shadows = {
        sm: "shadow-sm",
        md: "shadow-md",
        lg: "shadow-lg",
        xl: "shadow-xl",
        "2xl": "shadow-2xl",
        none: "shadow-none",
    };

    const classes = `${baseClasses} ${variants[variant]} ${paddings[padding]} ${radiuses[radius]} ${shadows[shadow]} ${className}`;

    return (
        <div className={classes} {...props}>
            {children}
        </div>
    );
}
