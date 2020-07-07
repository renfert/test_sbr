const path = require('path');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
module.exports = {
    configureWebpack: {
        output: {
            filename: '[name].js',
            chunkFilename:'js/[id].[chunkhash].js',
        },
        optimization: {
            runtimeChunk: 'single',
            splitChunks: {
                chunks: 'all',
                maxInitialRequests: Infinity,
                minSize: 0,
                cacheGroups: {
                    vendor: {
                        test: /[\\/]node_modules[\\/]/,
                        name(module) {
                            const packageName = module.context.match(/[\\/]node_modules[\\/](.*?)([\\/]|$)/)[1];
                            return `npm.${packageName.replace('@', '')}`;
                        },
                    },
                },
            },
        },
    },
    pluginOptions: {
        webpackBundleAnalyzer: {
          openAnalyzer: true
        }
    },
    publicPath: process.env.NODE_ENV === 'production' ? '/application/views/' : '/',
    outputDir: './views',
}