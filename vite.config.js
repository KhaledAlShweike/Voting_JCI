import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';
import laravel from 'laravel-vite-plugin';  // Ensure you're using `import`

export default defineConfig({
  plugins: [
    vue(),
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
      ],
    }),
  ],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './resources/js'),
    },
  },
  build: {
    outDir: 'public/build',
  },
});
