import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        // Enable asset compression and optimization
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true, // Remove console.log in production
                drop_debugger: true,
            },
        },
        rollupOptions: {
            output: {
                // Split chunks for better caching
                manualChunks: undefined, // Disable manual chunks for now
            },
        },
        // Enable gzip compression
        reportCompressedSize: true,
        // Optimize chunk size
        chunkSizeWarningLimit: 1000,
    },
    server: {
        // Optimize development server
        hmr: {
            overlay: false,
        },
    },
});