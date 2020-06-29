const path = require('path');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
module.exports = {
    publicPath: process.env.NODE_ENV === 'production' ? '/application/views/' : '/',
    outputDir: './views',
}