import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/admin/main.scss',
                'resources/scss/main.scss',
                'resources/css/app.css',
                'resources/js/frontend/app.js',
                'resources/js/backend/admin/main.js',
                'resources/js/backend/admin/common.js',
                'resources/js/backend/admin/onwer.js',
                'resources/js/backend/admin/posts.js',
            ],
            refresh: [...refreshPaths, 'app/Http/Livewire/**'],
        }),
        vue(),
    ],
    resolve: {
        alias: {
            // "~bootstrap": path.resolve(__dirname, "node_modules/bootstrap"),
            '~': '/resources/css',
            '@': '/resources/js',
        },
    },
});
