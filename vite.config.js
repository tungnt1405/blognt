import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/assets/scss/admin/main.scss',
                'resources/assets/scss/main.scss',
                'resources/assets/js/frontend/app.js',
                'resources/assets/js/backend/admin/main.js',
                'resources/assets/js/backend/admin/common.js',
                'resources/assets/js/backend/admin/onwer.js',
                'resources/assets/js/backend/admin/posts.js',
            ],
            refresh: [...refreshPaths, 'app/Http/Livewire/**'],
        }),
        vue(),
    ],
    resolve: {
        alias: {
            '~': '/resources/assets/css',
            '@': '/resources/assets/js',
        },
    },
});
