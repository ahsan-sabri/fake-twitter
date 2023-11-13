const mix = require('laravel-mix');

mix.js('resources/frontend/js/main.js', 'public/js')
    .sass('resources/frontend/sass/app.scss', 'public/css');
    // .setVue2(); // Specify that you are using Vue 2

if (mix.inProduction()) {
    mix.version();
}
