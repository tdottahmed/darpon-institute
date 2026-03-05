import { useEffect, useState } from "react";

/**
 * Parse stat value string (e.g. "10K+", "500+", "4.9", "98%") into numeric value and suffix for display.
 */
function parseStatValue(raw) {
    if (raw == null || raw === "") return { target: 0, suffix: "", isDecimal: false };
    const str = String(raw).trim();
    const upper = str.toUpperCase();
    let target = 0;
    let suffix = "";
    let isDecimal = false;

    if (upper.includes("K")) {
        const numMatch = str.match(/[\d.,]+/);
        const num = numMatch ? parseFloat(numMatch[0].replace(/,/g, ".")) : 0;
        target = num * 1000;
        suffix = str.replace(/[\d.,\s]/g, "") || "+"; // "K+", "K", etc.
    } else {
        const numMatch = str.match(/[\d.,]+/);
        const num = numMatch ? parseFloat(numMatch[0].replace(/,/g, ".")) : 0;
        target = num;
        suffix = str.replace(/[\d.,\s]/g, "") || ""; // "%", "+", ""
        isDecimal = num % 1 !== 0 || str.includes(".");
    }
    return { target, suffix, isDecimal };
}

/**
 * Format a numeric value for display (e.g. 10000 -> "10K+", 98 -> "98%")
 */
function formatDisplay(current, rawValue, suffix, isDecimal) {
    const { target } = parseStatValue(rawValue);
    if (target >= 1000 && String(rawValue || "").toUpperCase().includes("K")) {
        const k = current / 1000;
        return (k >= 10 ? Math.round(k) : k.toFixed(1)) + suffix;
    }
    if (isDecimal || (target > 0 && target < 10 && String(rawValue || "").includes("."))) {
        return current.toFixed(1) + suffix;
    }
    return Math.round(current) + suffix;
}

/**
 * Animate from 0 to target when isActive. Returns formatted display string.
 */
export function useCountUp(rawValue, isActive, duration = 1800) {
    const { target, suffix, isDecimal } = parseStatValue(rawValue);
    const [current, setCurrent] = useState(0);

    useEffect(() => {
        if (!isActive) {
            setCurrent(target);
            return;
        }
        if (target === 0) return;
        const start = performance.now();
        const step = (now) => {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            setCurrent(eased * target);
            if (progress < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    }, [target, isActive, duration]);

    return formatDisplay(current, rawValue, suffix, isDecimal);
}
