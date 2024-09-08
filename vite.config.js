import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0', // This allows Vite to be accessible from any network interface
        port: 5173,      // Ensure this port matches the one you're exposing in Docker
        hmr: {
            host: 'localhost', // or use 'host.docker.internal' if accessing from the Docker container
        },
    },
});
