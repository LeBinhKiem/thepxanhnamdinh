let mix = require(__dirname + '/node_modules/laravel-mix/src/index');

if (process.env.module) {
    let nameModule = process.env.npm_config_name;
    return require(`${__dirname}/Modules/${nameModule}/webpack.mix.js`);
}
