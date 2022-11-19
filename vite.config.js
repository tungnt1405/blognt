import { defineConfig } from "vite";
import laravel, { refreshPaths } from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/scss/main.css",
                "resources/js/app.js",
                "resources/js/admin/js/main.js",
            ],
            refresh: [...refreshPaths, "app/Http/Livewire/**"],
        }),
        vue(),
    ],
});
