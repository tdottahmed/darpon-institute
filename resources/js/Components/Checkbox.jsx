export default function Checkbox({ className = "", ...props }) {
    return (
        <input
            {...props}
            type="checkbox"
            className={
                "rounded border-gray-300 text-primary-600 shadow-sm transition-colors focus:ring-primary-500 dark:border-gray-600 dark:text-primary-400 dark:focus:ring-primary-400 " +
                className
            }
        />
    );
}
