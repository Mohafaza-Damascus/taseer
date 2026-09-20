import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { glob } from 'glob';
import path from 'node:path';

// جمع كل ملفات CSS تلقائياً من resources/css
const cssFiles = glob.sync('resources/css/**/*.css', {
    ignore: ['resources/css/app.css'], // app.css يُضاف يدوياً كأول عنصر
});

// جمع كل ملفات JS تلقائياً من resources/js (اختياري)
const jsFiles = glob.sync('resources/js/**/*.js', {
    ignore: ['resources/js/app.js'],
});

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', // الأساسي أولاً (Tailwind + fonts + base)
                ...cssFiles,             // باقي ملفات CSS
                'resources/js/app.js',   // الأساسي JS أولاً
                ...jsFiles,              // باقي ملفات JS
            ],
            refresh: [
                'resources/views/**',        // إعادة تحميل عند تعديل Blade
                'resources/css/**',          // إعادة تحميل عند تعديل CSS
                'resources/js/**',           // إعادة تحميل عند تعديل JS
                'routes/**',                 // إعادة تحميل عند تعديل Routes
            ],
        }),
    ],
    resolve: {
        alias: {
            '@css': path.resolve(__dirname, 'resources/css'),
            '@js': path.resolve(__dirname, 'resources/js'),
            '@fonts': path.resolve(__dirname, 'resources/fonts'),
            '@images': path.resolve(__dirname, 'resources/images'),
        },
    },
    build: {
        // لضمان ترتيب الـ CSS في الملف النهائي
        cssCodeSplit: false,
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    // تنظيم ملفات البناء في مجلدات
                    if (/\.(woff2?|ttf|otf|eot)$/i.test(assetInfo.name)) {
                        return 'assets/fonts/[name]-[hash][extname]';
                    }
                    if (/\.(png|jpe?g|gif|svg|webp|avif)$/i.test(assetInfo.name)) {
                        return 'assets/images/[name]-[hash][extname]';
                    }
                    if (/\.css$/i.test(assetInfo.name)) {
                        return 'assets/css/[name]-[hash][extname]';
                    }
                    return 'assets/[name]-[hash][extname]';
                },
                chunkFileNames: 'assets/js/[name]-[hash].js',
                entryFileNames: 'assets/js/[name]-[hash].js',
            },
        },
    },
});
