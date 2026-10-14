import "../css/app.css";
import "./bootstrap";
import { Toaster } from "react-hot-toast";

import { createInertiaApp, router } from "@inertiajs/react";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { createRoot } from "react-dom/client";
import { trackPageView } from "./Utils/metaPixel";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

// The pixel snippet tracks the initial PageView; track client-side navigations here.
let isInitialNavigation = true;
router.on("navigate", () => {
    if (isInitialNavigation) {
        isInitialNavigation = false;
        return;
    }
    trackPageView();
});

createInertiaApp({
    title: (title) => {
        if (!title) {
            return appName;
        }
        if (title.includes(appName)) {
            return title;
        }
        return `${title} - ${appName}`;
    },
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.jsx`,
            import.meta.glob("./Pages/**/*.jsx"),
        ),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(
            <>
                <Toaster position="top-right" />
                <App {...props} />
            </>,
        );
    },
    progress: {
        color: "#4B5563",
    },
});
