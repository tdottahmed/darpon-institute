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
                    <Badge
                        variant="primary"
                        className="text-xs font-semibold uppercase tracking-wide px-3 py-1"
                    >
                        {badge}
                    </Badge>
                </div>
            )}
            {title && (
                <h2 className="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">
                    {title}
                </h2>
            )}
            {subtitle && (
                <p className="text-lg sm:text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    {subtitle}
                </p>
            )}
        </div>
    );
}
