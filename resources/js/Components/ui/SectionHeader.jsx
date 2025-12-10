import Badge from "./Badge";

export default function SectionHeader({
    badge,
    title,
    subtitle,
    alignment = "center",
    className = "",
    ...props
}) {
    const alignments = {
        left: "text-left",
        center: "text-center",
        right: "text-right",
    };

    const classes = `${alignments[alignment]} ${className}`;

    return (
        <div className={classes} {...props}>
            {badge && (
                <div className="mb-4">
                    <Badge>{badge}</Badge>
                </div>
            )}
            {title && (
                <h2 className="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl lg:text-5xl mb-4">
                    {title}
                </h2>
            )}
            {subtitle && (
                <p className="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    {subtitle}
                </p>
            )}
        </div>
    );
}
