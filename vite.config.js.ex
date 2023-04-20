import { defineConfig, loadEnv } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import fs from 'fs';
// import path from 'path';

let host = 'blognt.local';

export default ({ mode }) => {
    process.env = { ...process.env, ...loadEnv(mode, process.cwd()) };

    // import.meta.env.VITE_NAME available here with: process.env.VITE_NAME
    // import.meta.env.VITE_PORT available here with: process.env.VITE_PORT

    return defineConfig({
        server: {
            hmr: { host },
            host,
            https: {
                key: fs.readFileSync(process.env.VITE_DEV_SERVER_KEY),
                cert: fs.readFileSync(process.env.VITE_DEV_SERVER_CERT),
            },
        },
        plugins: [
            laravel({
                input: [
                    'resources/assets/js/frontend/app.js',
                    'resources/assets/js/backend/admin/main.js',
                    'resources/assets/js/backend/admin/common.js',
                    'resources/assets/js/backend/admin/onwer.js',
                    'resources/assets/js/backend/admin/posts.js',
                    'resources/assets/scss/admin/main.scss',
                    'resources/assets/scss/main.scss',
                ],
                refresh: [...refreshPaths, 'app/Http/Livewire/**'],
            }),
            vue(),
            {
                name: 'blade',
                handleHotUpdate({ file, server }) {
                    if (file.endsWith('.blade.php')) {
                        server.ws.send({
                            type: 'full-reload',
                            path: '*',
                        });
                    }
                },
            },
        ],
        resolve: {
            alias: {
                '~': '/resources/assets/css',
                '@': '/resources/assets/js',
            },
        },
    });
};
