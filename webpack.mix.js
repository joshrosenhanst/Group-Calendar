const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.sass', 'public/css');

/* Page modules */
mix.js('resources/js/pages/groups/view.js', 'public/js/pages/groups')
   .js('resources/js/pages/groups/events.js', 'public/js/pages/groups')
   .js('resources/js/pages/groups/members.js', 'public/js/pages/groups')
   .js('resources/js/pages/events/new.js', 'public/js/pages/events')
   .js('resources/js/pages/events/edit.js', 'public/js/pages/events')
   .js('resources/js/pages/events/view.js', 'public/js/pages/events')
;

if (mix.inProduction()) {
   mix.version();
}else{
   mix.sourceMaps();
   mix.webpackConfig({
      devtool: "inline-source-map"
   });
}