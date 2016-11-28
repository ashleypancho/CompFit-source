var path = require( 'path' );
var webpack = require( 'webpack' );
var location = process.env.ASSETS_HOST;
var webpackDevConfig = {
    overrides: {
        devtool: 'eval',
        debug: true,
        entry: {
            app: [
                'webpack/hot/dev-server',
                'webpack-dev-server/client?http://localhost:8080/',
                './src/app/index.js'
            ]
        }
    },

    loaders: [
        {
            test: /\.js$/,
            loaders: [ 'ng-annotate', 'babel' ],
            include: path.join( __dirname, 'src', 'app' ),
            exclude: path.join( __dirname, 'node_modules' )
        }
    ],

    plugins: [
        new webpack.DefinePlugin( {
            'process.env': {
                NODE_ENV: JSON.stringify( 'development' )
            }
        } ),
        new webpack.HotModuleReplacementPlugin()
    ]
};

module.exports = require( './webpack.config' )( webpackDevConfig );
