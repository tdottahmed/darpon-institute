import { CreditCard } from "lucide-react";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import { CheckCircle2 } from "lucide-react";

export default function PaymentGatewaySection({
    data,
    setData,
    errors,
    paymentGateways,
    totalPrice,
}) {
    if (totalPrice === 0 || paymentGateways.length === 0) return null;

    return (
        <div className="space-y-6 border-t border-gray-200 dark:border-gray-700 pt-6">
            <h3 className="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <CreditCard className="w-5 h-5 text-primary-600" />
                Payment Information
            </h3>

            {/* Payment Gateway Selection */}
            <div>
                <InputLabel
                    htmlFor="payment_gateway_id"
                    value="Select Payment Method *"
                    className="text-base font-semibold mb-2"
                />
                <div className="grid gap-3 sm:grid-cols-2">
                    {paymentGateways.map((gateway) => (
                        <label
                            key={gateway.id}
                            className={`relative flex cursor-pointer rounded-lg border-2 p-4 transition-all ${
                                data.payment_gateway_id == gateway.id
                                    ? "border-primary-500 bg-primary-50 dark:bg-primary-900/20"
                                    : "border-gray-200 bg-white hover:border-gray-300 dark:border-gray-700 dark:bg-gray-800"
                            }`}
                        >
                            <input
                                type="radio"
                                name="payment_gateway_id"
                                value={gateway.id}
                                checked={data.payment_gateway_id == gateway.id}
                                onChange={(e) =>
                                    setData("payment_gateway_id", e.target.value)
                                }
                                className="sr-only"
                            />
                            <div className="flex-1">
                                <div className="flex items-center justify-between">
                                    <span className="text-sm font-semibold text-gray-900 dark:text-white">
                                        {gateway.name}
                                    </span>
                                    {data.payment_gateway_id == gateway.id && (
                                        <CheckCircle2 className="h-5 w-5 text-primary-600 dark:text-primary-400" />
                                    )}
                                </div>
                                {gateway.account_number && (
                                    <p className="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        {gateway.account_number}
                                    </p>
                                )}
                                {gateway.instructions && (
                                    <p className="mt-2 text-xs text-gray-600 dark:text-gray-300">
                                        {gateway.instructions}
                                    </p>
                                )}
                            </div>
                        </label>
                    ))}
                </div>
                <InputError
                    message={errors.payment_gateway_id}
                    className="mt-2"
                />
            </div>

            {/* Transaction ID */}
            {data.payment_gateway_id && (
                <>
                    <div>
                        <InputLabel
                            htmlFor="transaction_id"
                            value="Transaction ID *"
                            className="text-base font-semibold mb-2"
                        />
                        <TextInput
                            id="transaction_id"
                            type="text"
                            className="mt-2 block w-full py-3 px-4 bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                            value={data.transaction_id}
                            onChange={(e) =>
                                setData("transaction_id", e.target.value)
                            }
                            required
                            placeholder="Enter your transaction ID"
                        />
                        <InputError
                            message={errors.transaction_id}
                            className="mt-2"
                        />
                    </div>

                    {/* Payment Screenshot */}
                    <div>
                        <InputLabel
                            htmlFor="payment_screenshot"
                            value="Payment Screenshot (Optional)"
                            className="text-base font-semibold mb-2"
                        />
                        <div className="mt-2">
                            <input
                                id="payment_screenshot"
                                type="file"
                                accept="image/*"
                                onChange={(e) =>
                                    setData(
                                        "payment_screenshot",
                                        e.target.files[0]
                                    )
                                }
                                className="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-300"
                            />
                            {data.payment_screenshot && (
                                <p className="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    Selected: {data.payment_screenshot.name}
                                </p>
                            )}
                        </div>
                        <InputError
                            message={errors.payment_screenshot}
                            className="mt-2"
                        />
                    </div>
                </>
            )}
        </div>
    );
}

