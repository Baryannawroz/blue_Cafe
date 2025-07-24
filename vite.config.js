import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: true,
        port: 5173,
        cors: {
            origin: 'https://bluecafe.malaygawra.com',
            credentials: true,
        }
    },
    plugins: [
        laravel({
            input: ['resources/assets/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
});
