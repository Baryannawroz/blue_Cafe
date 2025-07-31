import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  server: {
    host: '0.0.0.0', // expose to network
        port:51743,
    strictPort: true,
    cors: true,
    hmr: {
      host: 'bluecafe.malaygawra.com',
    },
  },
  plugins: [
    laravel({
               input: ['resources/assets/js/app.js'],

      refresh: true,
    }),
  ],
