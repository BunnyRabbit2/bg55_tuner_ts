const tailwindcss = require('tailwindcss');
const postcssExtend = require('postcss-extend');
const postcssImport = require('postcss-import');

module.exports = {
    plugins: [
        postcssImport,
        postcssExtend,
        'postcss-preset-env',
        tailwindcss        
    ],
};