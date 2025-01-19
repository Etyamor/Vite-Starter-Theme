import path from 'path';
import { ViteImageOptimizer } from 'vite-plugin-image-optimizer';
import { defineConfig } from 'vite';

const ROOT = path.resolve('../../../');
const BASE = __dirname.replace(ROOT, '');

export default defineConfig({
    base: process.env.NODE_ENV === 'production' ? `${BASE}/dist/` : BASE,
    build: {
        manifest: true,
        assetsDir: '.',
        outDir: 'dist',
        emptyOutDir: true,
        sourcemap: false,
        assetsInlineLimit: 0,
        minify: true,
        rollupOptions: {
            input: [
                'resources/scripts/scripts.js',
                'resources/styles/styles.css',
            ],
            output: {
                entryFileNames: '[hash].js',
                assetFileNames: (assetInfo) => {
                    if (/\.(png|jpe?g|gif|svg|webp|avif)$/i.test(assetInfo.name)) {
                        return 'images/[hash][extname]';
                    }
                    if (/\.(woff2?|ttf|eot|otf)$/i.test(assetInfo.name)) {
                        return 'fonts/[hash][extname]';
                    }
                    if (/\.(css)$/i.test(assetInfo.name)) {
                        return '[hash][extname]';
                    }
                    return 'others/[hash][extname]';
                },
            },
        },
    },
    plugins: [
        ViteImageOptimizer(),
    ],
});