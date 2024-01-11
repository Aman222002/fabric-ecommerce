<<<<<<< HEAD
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
=======
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
>>>>>>> bc51b2b6e2c8892c42905cabbfb7268f8012f6f7

export default defineConfig({
    plugins: [
        laravel({
<<<<<<< HEAD
            input: ["resources/sass/app.scss", "resources/js/app.js"],
=======
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
>>>>>>> bc51b2b6e2c8892c42905cabbfb7268f8012f6f7
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
<<<<<<< HEAD
            vue: "vue/dist/vue.esm-bundler.js",
=======
            vue: 'vue/dist/vue.esm-bundler.js',
>>>>>>> bc51b2b6e2c8892c42905cabbfb7268f8012f6f7
        },
    },
});
