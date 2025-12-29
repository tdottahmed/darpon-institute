import { CheckCircle2 } from "lucide-react";
import { formatPrice } from "@/Utils/currency";

export default function PriceSummary({ totalPrice, selectedVariation }) {
    if (totalPrice === 0 && !selectedVariation) return null;

    return (
        <div className="bg-gradient-to-r from-primary-50 to-secondary-50 dark:from-primary-900/20 dark:to-secondary-900/20 rounded-xl p-6 border-2 border-primary-200 dark:border-primary-800 shadow-lg">
            <div className="flex items-center justify-between mb-2">
                <span className="text-lg font-bold text-gray-900 dark:text-white">
                    Total Amount:
                </span>
                <span className="text-3xl font-extrabold text-primary-600 dark:text-primary-400">
                    {formatPrice(totalPrice)}
                </span>
            </div>
            {selectedVariation && (
                <p className="text-sm text-gray-600 dark:text-gray-400 mt-2 flex items-center gap-2">
                    <CheckCircle2 className="w-4 h-4" />
                    {selectedVariation.name}
                    {selectedVariation.duration &&
                        ` • ${selectedVariation.duration}`}
                </p>
            )}
            {totalPrice === 0 && (
                <p className="text-sm font-semibold text-green-600 dark:text-green-400 mt-2">
                    ✓ This course is free!
                </p>
            )}
        </div>
    );
}

