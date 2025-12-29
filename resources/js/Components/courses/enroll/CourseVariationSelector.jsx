import { Settings } from "lucide-react";
import InputError from "@/Components/InputError";
import { formatPrice } from "@/Utils/currency";
import { CheckCircle2 } from "lucide-react";

export default function CourseVariationSelector({
    variations,
    selectedVariationId,
    setSelectedVariationId,
    errors,
}) {
    if (variations.length === 0) return null;

    return (
        <div className="space-y-4 border-b border-gray-200 dark:border-gray-700 pb-6">
            <h3 className="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <Settings className="w-5 h-5 text-primary-600" />
                Select Course Duration
            </h3>
            <div className="grid gap-3">
                {variations.map((variation) => {
                    const varHasDiscount = variation.discount > 0;
                    const varDiscountType =
                        variation.discount_type || "percentage";
                    let varDiscountedPrice = Number(variation.price) || 0;
                    let varOriginalPrice = Number(variation.price) || 0;

                    if (varHasDiscount && variation.price) {
                        varOriginalPrice = Number(variation.price);
                        if (varDiscountType === "flat") {
                            varDiscountedPrice = Math.max(
                                0,
                                Number(variation.price) -
                                    Number(variation.discount)
                            );
                        } else {
                            varDiscountedPrice =
                                Number(variation.price) -
                                (Number(variation.price) *
                                    Number(variation.discount)) /
                                    100;
                        }
                    }

                    const isSelected = selectedVariationId === variation.id;

                    return (
                        <label
                            key={variation.id}
                            className={`relative flex cursor-pointer rounded-lg border-2 p-4 transition-all ${
                                isSelected
                                    ? "border-primary-500 bg-primary-50 dark:bg-primary-900/20"
                                    : "border-gray-200 bg-white hover:border-gray-300 dark:border-gray-700 dark:bg-gray-800"
                            }`}
                        >
                            <input
                                type="radio"
                                name="course_variation_id"
                                value={variation.id}
                                checked={isSelected}
                                onChange={() =>
                                    setSelectedVariationId(variation.id)
                                }
                                className="sr-only"
                            />
                            <div className="flex-1">
                                <div className="flex items-center justify-between">
                                    <div>
                                        <span className="text-sm font-semibold text-gray-900 dark:text-white">
                                            {variation.name}
                                        </span>
                                        {variation.duration && (
                                            <p className="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                {variation.duration}
                                            </p>
                                        )}
                                    </div>
                                    <div className="text-right">
                                        <span className="text-lg font-bold text-primary-600 dark:text-primary-400">
                                            {formatPrice(varDiscountedPrice)}
                                        </span>
                                        {varHasDiscount && (
                                            <p className="text-xs text-gray-400 line-through">
                                                {formatPrice(varOriginalPrice)}
                                            </p>
                                        )}
                                    </div>
                                </div>
                            </div>
                            {isSelected && (
                                <CheckCircle2 className="h-5 w-5 text-primary-600 dark:text-primary-400 ml-2" />
                            )}
                        </label>
                    );
                })}
            </div>
            <InputError
                message={errors.course_variation_id}
                className="mt-2"
            />
        </div>
    );
}

