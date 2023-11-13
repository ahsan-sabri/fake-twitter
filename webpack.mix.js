const mix = require('laravel-mix')

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            '@': __dirname + '/resources/frontend',
            '@components': __dirname + '/resources/frontend/components',
        }
    }
})

mix.js('resources/frontend/main.js', 'public/js')

if (mix.inProduction()) {
    mix.version();
}
