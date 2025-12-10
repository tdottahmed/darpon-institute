/**
 * Toast Notification Helper
 * Usage: window.showToast('success', 'User created successfully!');
 */
window.showToast = function(type, message, duration = 5000) {
    const toastContainer = document.querySelector('[x-data*="toasts"]');
    if (!toastContainer) {
        console.warn('Toast container not found');
        return;
    }

    const toastId = Date.now();
    const toast = {
        id: toastId,
        type: type,
        message: message
    };

    // Get Alpine.js component data
    const alpineData = Alpine.$data(toastContainer);
    if (alpineData && alpineData.toasts) {
        alpineData.toasts.push(toast);
        
        // Auto remove after duration
        setTimeout(() => {
            alpineData.removeToast(toastId);
        }, duration);
    }
};

// Make it available globally
if (typeof window !== 'undefined') {
    window.toast = {
        success: (message, duration) => window.showToast('success', message, duration),
        error: (message, duration) => window.showToast('error', message, duration),
        warning: (message, duration) => window.showToast('warning', message, duration),
        info: (message, duration) => window.showToast('info', message, duration),
    };
}

