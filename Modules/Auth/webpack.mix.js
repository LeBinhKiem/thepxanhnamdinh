let mix = require(__dirname + '/../../node_modules/laravel-mix/src/index');
let path = require("path");
let directory_bundle = path.normalize('public/vendor/auth/');
mix.setPublicPath(directory_bundle);

let build_scss = [
    {
        from: '/Resources/assets/sass/auth.scss',
        to: 'css/auth.css'
    },
];


let build_js = [

];

build_scss.map((index) => {
    let from = __dirname + index.from;
    let to = index.to;
    mix.sass(from, to).minify(directory_bundle + to);
});


build_js.map((index) => {
    let from = __dirname + index.from;
    let to = index.to;
    if (Array.isArray(index.from)) {
        from = [];
        index.from.forEach(file => {
            from.push(__dirname + file);
        });
    }
    mix.js(from, to)
});


mix.webpackConfig({
    resolve: {
        alias: {
            plugins_public: path.resolve(__dirname+'/../../public/plugins'),
        }
    }
});

if (mix.inProduction()) {
    mix.version();
}
