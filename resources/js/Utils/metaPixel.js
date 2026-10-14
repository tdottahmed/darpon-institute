/**
 * Thin wrapper around the Meta Pixel `fbq` loaded by the facebook-pixel Blade component.
 * Safe to call when the pixel is disabled or blocked.
 *
 * @param {string} event Standard event name (e.g. "Purchase", "Lead")
 * @param {object} params Event parameters (value, currency, content_name, ...)
 * @param {string|null} eventId Unique ID used by Meta to deduplicate events
 */
export const trackPixel = (event, params = {}, eventId = null) => {
    if (typeof window === "undefined" || typeof window.fbq !== "function") {
        return;
    }

    if (eventId) {
        window.fbq("track", event, params, { eventID: String(eventId) });
    } else {
        window.fbq("track", event, params);
    }
};

export const trackPageView = () => {
    if (typeof window === "undefined" || typeof window.fbq !== "function") {
        return;
    }

    window.fbq("track", "PageView");
};
