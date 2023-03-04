import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
export default defineConfig({
    plugins: [
        laravel({
            input: ['~~/admin/main.scss', '~/main.css', '@/frontend/app.js', '@/backend/admin/**'],
            refresh: [...refreshPaths, 'app/Http/Livewire/**'],
        }),
        vue(),
    ],
    resolve: {
        alias: {
            '~': '/resources/css',
            '~~': '/resources/scss',
            '@': '/resources/js',
        },
    },
});
