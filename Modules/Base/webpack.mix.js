let mix = require(__dirname + '/../../node_modules/laravel-mix/src/index');
let path = require("path");
let directory_bundle = path.normalize('public/vendor/base/');
mix.setPublicPath(directory_bundle);

let build_scss = [
    {
        from: '/Resources/assets/sass/base.scss',
        to: 'css/base.css'
    },
    {
        from: '/Resources/assets/sass/vote.scss',
        to: 'css/vote.css'
    },

];


let build_js = [
    {
        from: '/Resources/assets/js/base.js',
        to: 'js/base.js'
    },
    {
        from: '/Resources/assets/js/vote.js',
        to: 'js/vote.js'
    },
    {
        from: '/Resources/assets/js/pages/user/user_detail.js',
        to: 'js/user_detail.js'
    },
    {
        from: '/Resources/assets/js/pages/user/user_change_password.js',
        to: 'js/user_change_password.js'
    },
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
            plugins_public: path.resolve(__dirname + '/../../public/plugins'),
        }
    }
});

if (mix.inProduction()) {
    mix.version();
}
