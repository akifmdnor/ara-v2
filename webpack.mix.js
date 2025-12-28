const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js")
    .vue()
    .postCss("resources/css/app.css", "public/css", [require("tailwindcss")])
    .postCss("resources/css/old-homepage.css", "public/css")
    .js("resources/js/date-time-picker.js", "public/js")
    .js("resources/js/status-utils.js", "public/js")
    .js("resources/js/bootstrap.js", "public/js")
    .copyDirectory("resources/images", "public/images")
    .version();
