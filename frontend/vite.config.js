import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
    ],
    build: {
        outDir: '../backend/public/assets',
        emptyOutDir: true,
    },
    server: {
        port: 5173,
        proxy: {
            '/api': {
                target: 'http://localhost:8000',
                changeOrigin: true,
            },
            '/storage': {
                target: 'http://localhost:8000',
                changeOrigin: true,
            },
        },
    },
});
