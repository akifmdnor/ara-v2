const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js")
    .vue()
    .postCss("resources/css/app.css", "public/css", [require("tailwindcss")])
    .postCss("resources/css/old-homepage.css", "public/css")
    .copyDirectory("resources/images", "public/images")
    .version();
