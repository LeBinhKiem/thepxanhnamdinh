const path = require('path');
let mix = require(__dirname + '/node_modules/laravel-mix/src/index');
let webpack = require('webpack');

//copy
mix.copyDirectory('resources/plugins','public/plugins');

mix.options({
    processCssUrls: false
})

new webpack.LoaderOptionsPlugin({
    test: /\.s[ac]ss$/,
    options: {
        includePaths: [
            path.resolve(__dirname, './public/')
        ]
    }
});
