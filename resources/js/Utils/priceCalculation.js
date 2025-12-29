/**
 * Calculate the discounted price based on discount type
 * @param {number} price - Original price
 * @param {number} discount - Discount amount
 * @param {string} discountType - 'flat' or 'percentage'
 * @returns {object} - { totalPrice, originalPrice }
 */
export function calculatePrice(priceSource) {
    const price = Number(priceSource.price) || 0;
    const discount = Number(priceSource.discount) || 0;
    const discountType = priceSource.discount_type || "percentage";
    const hasDiscount = discount > 0;

    let totalPrice = price;
    let originalPrice = price;

    if (hasDiscount && price) {
        originalPrice = price;
        if (discountType === "flat") {
            totalPrice = Math.max(0, price - discount);
        } else {
            totalPrice = price - (price * discount) / 100;
        }
    }

    return { totalPrice, originalPrice };
}

