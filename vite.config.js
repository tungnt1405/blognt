import { defineConfig } from "vite";
import laravel, { refreshPaths } from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/scss/main.scss",
                "resources/scss/admin/main.css",
                "resources/js/app.js",
                "resources/js/admin/**",
            ],
            refresh: [...refreshPaths, "app/Http/Livewire/**"],
        }),
        vue(),
    ],
});
