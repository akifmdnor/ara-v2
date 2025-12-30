module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                manrope: ["Manrope", "sans-serif"],
            },
            fontSize: {
                base: ["14px", { lineHeight: "1.25", fontWeight: "400" }],
            },
        },
    },
    plugins: [],
};
