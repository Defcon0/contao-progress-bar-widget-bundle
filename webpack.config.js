var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('src/Resources/public/')
    .addEntry('contao-progress-bar-widget-bundle-be', './src/Resources/assets/js/contao-progress-bar-widget-bundle-be.js')
    .setPublicPath('/bundles/heimrichhannotprogressbarwidget/')
    .setManifestKeyPrefix('bundles/heimrichhannotprogressbarwidget')
    .enableSassLoader()
    .disableSingleRuntimeChunk()
    .addExternals({
        '@hundh/contao-utils-bundle': 'utilsBundle'
    })
    .enableSourceMaps(!Encore.isProduction())
;

module.exports = Encore.getWebpackConfig();
