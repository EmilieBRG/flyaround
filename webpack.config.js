const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/web')
    .addEntry('style', './assets/scss/main.scss')
    .addEntry('app', './assets/js/app.js')
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSassLoader();

module.exports = Encore.getWebpackConfig();