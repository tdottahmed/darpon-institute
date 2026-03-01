/**
 * Formats a number as BDT (Bangladeshi Taka)
 *
 * @param {number|string|null} amount
 * @param {boolean} showDecimals Whether to show decimal places (default: true)
 * @returns {string}
 */
export const formatPrice = (amount, showDecimals = true) => {
    if (amount === null || amount === undefined || amount === "") {
        return "Tk.0" + (showDecimals ? ".00" : "");
    }

    const value = parseFloat(amount) || 0;

    if (showDecimals) {
        // Format with 2 decimal places: ৳1,234.56
        return (
            "Tk." +
            value.toLocaleString("en-BD", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            })
        );
    } else {
        // Format without decimals: ৳1,235
        return (
            "Tk." +
            value.toLocaleString("en-BD", {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            })
        );
    }
};
