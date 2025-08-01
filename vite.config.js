import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  server: {
    host: '0.0.0.0', // expose to LAN/public IP
    port: 5173,
    strictPort: true,
    cors: true,
    hmr: {
      protocol: 'ws', // or 'wss' if you're using HTTPS in dev
      host: 'bluecafe.malaygawra.com',
      port: 5173,
    },
  },
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
});
