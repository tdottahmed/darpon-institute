import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.jsx"],
            refresh: true,
        }),
        react(),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    // Separate vendor libraries into their own chunks
                    'react-vendor': ['react', 'react-dom'],
                    'inertia-vendor': ['@inertiajs/react'],
                    'lucide-icons': ['lucide-react'],
                    'ui-vendor': ['@headlessui/react'],
                },
            },
        },
        chunkSizeWarningLimit: 1000, // Increase limit to 1MB (optional, but helps reduce warnings)
    },
});
