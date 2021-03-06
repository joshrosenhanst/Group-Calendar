const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.sass', 'public/css')
   .sass('resources/sass/event_flyer.sass', 'public/css')
   .sass('resources/sass/landing.sass', 'public/css')
   .sass('resources/sass/noscript_styles.sass', 'public/css');

/* Page modules */
mix.js('resources/js/pages/groups/view.js', 'public/js/pages/groups')
   .js('resources/js/pages/groups/events.js', 'public/js/pages/groups')
   .js('resources/js/pages/groups/members.js', 'public/js/pages/groups')
   .js('resources/js/pages/groups/edit.js', 'public/js/pages/groups')
   .js('resources/js/pages/groups/new.js', 'public/js/pages/groups')
   .js('resources/js/pages/events/index.js', 'public/js/pages/events')
   .js('resources/js/pages/events/new.js', 'public/js/pages/events')
   .js('resources/js/pages/events/edit.js', 'public/js/pages/events')
   .js('resources/js/pages/events/view.js', 'public/js/pages/events')
   .js('resources/js/pages/profile/edit.js', 'public/js/pages/profile')
;

if (mix.inProduction()) {
   mix.version();
}else{
   mix.sourceMaps();
   mix.webpackConfig({
      devtool: "inline-source-map"
   });
}