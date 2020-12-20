const BundleTracker = require("webpack-bundle-tracker"); // eslint-disable-line
const CompressionPlugin = require('compression-webpack-plugin'); // eslint-disable-line
const path = require('path'); // eslint-disable-line

const pages = {
    login: {
        title: '😀',
        entry: './resources/ts/login.ts',
        chunks: [ 'chunk-vendors', 'chunk-common', 'chunk-login-vendors', 'chunk-vuetify', 'login']
    },
    admin: {
        title: '😀',
        entry: './resources/ts/admin.ts',
        chunks: [ 'chunk-vendors', 'chunk-common', 'chunk-admin-vendors','chunk-vuetify', 'admin']
    },
    maintenance: {
        title: '😀',
        entry: './resources/ts/maintenance.ts',
        chunks: [ 'chunk-vendors', 'chunk-common', 'chunk-maintenance-vendors','chunk-vuetify', 'maintenance']
    },
    user: {
        title: '😀',
        entry: './resources/ts/user.ts',
        chunks: [ 'chunk-vendors', 'chunk-common', 'chunk-user-vendors','chunk-vuetify', 'user']
    },
};

module.exports = {
    pages: pages,
    publicPath: '/vue',
    outputDir: './public/vue',
    css: {
        extract: { ignoreOrder: true }
    },
    transpileDependencies: [
        'vuetify'
    ],
    configureWebpack: {
        plugins: [
            new BundleTracker({ filename: 'webpack-stats.json' }),
            new CompressionPlugin(),
        // new (require('webpack-bundle-analyzer').BundleAnalyzerPlugin)({ analyzerMode: 'static' }),
        ],
    },
    pwa: {
        workboxPluginMode: 'InjectManifest',
        workboxOptions: {
            swSrc: 'resources/ts/register-service-worker.ts',
            swDest: 'service-worker.js',
        },
        manifestOptions: {
            start_url: '/',
        },
    },
    chainWebpack: config => {
        config.module
            .rule('eslint')
            .use('eslint-loader')
            .options({
                fix: process.env.NODE_ENV !== 'production',
            });

        const options = module.exports;
        const pages = options.pages;
        const pageKeys = Object.keys(pages);

        config.resolve
            .alias
            .set('@', path.resolve(__dirname, 'resources/ts'))
            .set('@style', path.resolve(__dirname, 'resources/styles'))
            .set('@module', path.resolve(__dirname, 'node_modules'));

        config.performance
            .maxEntrypointSize(1000000)
            .maxAssetSize(1000000);

        // Long-term caching
        const IS_VENDOR = /[\\/]node_modules[\\/]/;
        const IS_VUETIFY = /[\\/]node_modules[\\/]vuetify/;

        config.optimization.splitChunks({
            cacheGroups: {
                vuetify: {
                    name: 'chunk-vuetify',
                    priority: -1,
                    chunks: 'all',
                    test: IS_VUETIFY,
                    enforce: true
                },
                ...pageKeys.map((key) => ({
                    name: `chunk-${key}-vendors`,
                    priority: -11,
                    chunks: (chunk) => chunk.name === key,
                    test: IS_VENDOR,
                    enforce: true
                })),
                common: {
                    name: 'chunk-common',
                    priority: -20,
                    chunks: 'initial',
                    minChunks: 2,
                    reuseExistingChunk: true,
                    enforce: true
                }
            }
        });
    }
};