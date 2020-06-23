const BundleTracker = require("webpack-bundle-tracker");
const CompressionPlugin = require('compression-webpack-plugin');
const path = require('path');

// const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

const pages = {
  login: {
    entry: './resources/ts/login.ts',
    chunks: [ 'chunk-vendors', 'chunk-common', 'chunk-login-vendors', 'vuetify', 'login']
  },
  me: {
    entry: './resources/ts/me.ts',
    chunks: [ 'chunk-vendors', 'chunk-common', 'chunk-me-vendors','vuetify', 'me']
  },
  home: {
    entry: './resources/ts/home.ts',
    chunks: [ 'chunk-vendors', 'chunk-common', 'chunk-home-vendors','vuetify', 'home']
  },
}

module.exports = {
  pages: pages,
  publicPath: '/vue',
  outputDir: './public/vue',
  filenameHashing: false,
  css: {
    extract: { ignoreOrder: true }
  },
  transpileDependencies: [
    "vuetify"
  ],
  configureWebpack: {
    plugins: [
        new BundleTracker({ filename: 'webpack-stats.json' }),
        new CompressionPlugin(),
        // new BundleAnalyzerPlugin({ analyzerMode: 'static' }),
    ],
  },
  chainWebpack: config => {
      config.plugins.delete('pwa')
      config.plugins.delete('copy')
      config.plugins.delete('html');
      config.plugins.delete('preload');
      config.plugins.delete('prefetch');      

      const options = module.exports;
      const pages = options.pages;
      const pageKeys = Object.keys(pages);

      pageKeys.forEach((key) => {        
        config.plugins.delete('html-' + key);
        config.plugins.delete('preload-' + key);
        config.plugins.delete('prefetch-' + key);
      });

      config.resolve
            .alias
            .set('@', path.resolve(__dirname, 'resources/ts'))
            .set('@module', path.resolve(__dirname, 'node_modules'));
      
      config.performance
            .maxEntrypointSize(1000000)
            .maxAssetSize(1000000)

      // Long-term caching
      const IS_VENDOR = /[\\/]node_modules[\\/]/
      const IS_VUETIFY = /[\\/]node_modules[\\/]vuetify/

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
      })
  }
}