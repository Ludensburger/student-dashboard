// filepath: /C:/xampp/htdocs/student-dashboard/webpack.config.js
const path = require('path');

module.exports = {
    entry: './src/css/init.scss',
    output: {
        filename: 'bundle.js',
        path: path.resolve(__dirname, 'dist'),
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [
                    'style-loader', // Injects styles into DOM
                    'css-loader',   // Turns CSS into CommonJS
                    'sass-loader'   // Compiles Sass to CSS
                ],
            },
        ],
    },
    mode: 'development',
};