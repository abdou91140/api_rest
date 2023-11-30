const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enablePostCssLoader()
    .enableSassLoader()
    .enableReactPreset() // Enable React if you are using it
//   .configureBabel((config) => {
  //    config.plugins.push('@babel/a-babel-plugin');
    //})
    .addEntry('app', './assets/app.js') // Adjust the path accordingly
    .autoProvidejQuery();

module.exports = Encore.getWebpackConfig();
