import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';

/**
 * @type {import('vite').UserConfig}
 *
 * Configuración profesional para Vite, optimizada para el proyecto ISTPET.
 * Proporciona un entorno de desarrollo eficiente y un empaquetado de producción optimizado.
 */
export default defineConfig({
    /*
     |--------------------------------------------------------------------------
     | Configuración de plugins
     |--------------------------------------------------------------------------
     */
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/tailwind.css',
                'resources/js/istpet-animations.js',
            ],
            refresh: true,
        }),
    ],

    /*
     |--------------------------------------------------------------------------
     | Opciones de construcción (build)
     |--------------------------------------------------------------------------
     */
    build: {
        cssCodeSplit: true,
        rollupOptions: {
            output: {
                entryFileNames: `assets/js/[name]-[hash].js`,
                chunkFileNames: `assets/js/[name]-[hash].js`,
                assetFileNames: (assetInfo) => {
                    const extType = assetInfo.name.split('.').at(1);
                    if (/png|jpe?g|svg|gif|tiff|bmp|ico/i.test(extType)) {
                        return `assets/img/[name]-[hash][extname]`;
                    }
                    if (/css/i.test(extType)) {
                        return `assets/css/[name]-[hash][extname]`;
                    }
                    return `assets/[name]-[hash][extname]`;
                },
            },
        },
        minify: 'esbuild',
        sourcemap: false,
    },
});
