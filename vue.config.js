const BundleTracker = require("webpack-bundle-tracker");
const path = require('path');

// const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

const pages = {
  'login': './resources/ts/login.ts',
  'me': './resources/ts/me.ts',
  // 'home': {
  //     entry: './src/home.ts',
  //     chunks: ['chunk-vendors']
  // },
  // 'me': {
  //     entry: './resources/ts/me.ts',
  //     chunks: ['chunk-vendors']
  // },
}

module.exports = {
  pages: pages,
  publicPath: '/vue',
  outputDir: './public/vue',
  filenameHashing: false,
  css: {
    extract: true
  },
  transpileDependencies: [
    "vuetify"
  ],
  configureWebpack: {
    plugins: [
        new BundleTracker({ filename: 'webpack-stats.json' }),
        // new BundleAnalyzerPlugin(),
    ],
  },
  chainWebpack: config => {
      config.plugins.delete('html');
      config.plugins.delete('preload');
      config.plugins.delete('prefetch');
      config.resolve
            .alias
            .set('@', path.resolve(__dirname, 'resources/ts'));
      
      const options = module.exports
      const pages = options.pages
      const pageKeys = Object.keys(pages)
  
      // Long-term caching
      const IS_VENDOR = /[\\/]node_modules[\\/]/
  
      config.optimization
        .splitChunks({
          cacheGroups: {
            vendors: {
              name: 'chunk-vendors',
              priority: -10,
              chunks: 'initial',
              minChunks: 2,
              test: IS_VENDOR,
              enforce: true,
            },
            ...pageKeys.map(key => ({
              name: `chunk-${key}-vendors`,
              priority: -11,
              chunks: chunk => chunk.name === key,
              test: IS_VENDOR,
              enforce: true,
            })),
            common: {
              name: 'chunk-common',
              priority: -20,
              chunks: 'initial',
              minChunks: 2,
              reuseExistingChunk: true,
              enforce: true,
            },
          },
        })
  }
}