var path = require( 'path' );
var gulp = require( 'gulp' );
var gutil = require( 'gulp-util' );
var webpack = require( 'webpack' );
// var webpackStream = require( 'webpack-stream');
// var reload = require('gulp-hot-reload');
var gulpWebpack = require( 'gulp-webpack' );
var WebpackDevServer = require( 'webpack-dev-server' );
var stylus = require( 'gulp-stylus' );
var clean = require( 'gulp-clean' );
var runSequence = require( 'run-sequence' );

function handleError( task ) {
    return function ( err ) {
        this.emit( 'end' );
        gutil.log( 'Error handler for', task, err.toString() );
    };
}

gulp.task('default', ['webpack-dev-server','stylus:compile']);

// const buildDone = (err, stats) => {
//   if(err) throw new gutil.PluginError("webpack", err);
//   gutil.log('[webpack]', stats.toString({
//     colors: true,
//     chunkModules: false,
//     assets: false,
//     version: false,
//     hash: false
//   }))
// }
//
// var serverConfig = require('./webpack.server.config.js');
//
// var spawn = require('child_process').spawn
// var node;


// gulp.task('default', function() {
//     return gulp.src('src/app/index.js')
//         .pipe(webpackStream( require('./webpack.config.js') ))
//         .pipe(gulp.dest('dist/'));
// });

// path.join( __dirname, 'build' )
// The development server (the recommended option for development)
// gulp.task( 'default', [ 'webpack-dev-server', 'stylus:compile' ] );

/**
 * $ gulp server
 * description: launch the server. If there's a server already running, kill it.
 */
// gulp.task('server', function() {
//   if (node) node.kill()
//   node = spawn('node', ['src/app/index.js'], {stdio: 'inherit'})
//   node.on('close', function (code) {
//     if (code === 8) {
//       gulp.log('Error detected, waiting for changes...');
//     }
//   });
// })

/**
 * $ gulp
 * description: start the development environment
 */
// gulp.task('default', function() {
//   gulp.run('server')
//   gulp.run('stylus:compile')
//   gulp.run('webpack-dev-server')
//
//   gulp.watch(['./src/app/index.js','./src/app/routes.js', './src/app/controllers/**/*.*', './src/app/directives/**/*.*', './app/services/**/*.*'], function() {
//     gulp.run('server')
//   })
//
//   // Need to watch for sass changes too? Just add another watch call!
//   // no more messing around with grunt-concurrent or the like. Gulp is
//   // async by default.
// })

// clean up if an error goes unhandled.
// process.on('exit', function() {
//     if (node) node.kill()
// })


// gulp.task('default', function() {
//   gulp.run('build-backend')
//   gulp.run('watch')
//   gulp.run('stylus:compile')
//   gulp.run('webpack-dev-server')
//
//   // gulp.watch(['./src/app/index.js','./src/app/routes.js', './src/app/controllers/**/*.*', './src/app/directives/**/*.*', './app/services/**/*.*'], function() {
//   //   gulp.run('server')
//   // })
//
//   gutil.log('watch')
//
//   // Need to watch for sass changes too? Just add another watch call!
//   // no more messing around with grunt-concurrent or the like. Gulp is
//   // async by default.
// });







gulp.task( 'webpack-dev-server', function ( callback ) {
    var config = Object.create( require( './webpack.dev.js' ) );
    config.entry.app.unshift("webpack-dev-server/client?http://localhost:8080/", "webpack/hot/dev-server");
    // Start a webpack-dev-server
    new WebpackDevServer( webpack( config ), {
        contentBase: "http://localhost:8080/",
        publicPath: config.output.publicPath,
        hot: true,
        historyApiFallback: true,
        stats: {
            colors: true
        }
    } ).listen( 8080, '0.0.0.0', function ( err ) {
            if ( err ) {
                throw new gutil.PluginError( 'webpack-dev-server', err );
            }
            gutil.log( '[webpack-dev-server]', 'http://localhost:8080' );
            callback();
        } );

    //setup stylus watcher
    // gulp.watch( [ 'src/assets/stylus/*.styl', 'src/assets/stylus/**/*.styl', 'src/app/controllers/**/style' ], [ 'stylus:compile' ] );
} );

gulp.task( 'stylus:compile', function () {
    return gulp.src( './src/assets/stylus/main.styl' )
        .pipe( stylus().on( 'error', handleError( 'stylus:compile' ) ) )
        .pipe( gulp.dest( 'build/' ) );
} );

gulp.task( 'clean:build', function () {
    return gulp.src( 'build/*', { read: false } )
        .pipe( clean() );
} );

gulp.task( 'build:cp:index', function () {
    return gulp.src( [
        './src/assets/favicon.png'
    ] )
        .pipe( gulp.dest( 'build/' ) );
} );

gulp.task( 'build:webpack', function () {
    return gulp.src( 'src/app/index.js' )
        .pipe( gulpWebpack( require( './webpack.prod.js' ), webpack ) )
        .pipe( gulp.dest( 'build/' ) );
} );

// gulp.task('build-backend', () => {
//   gulp
//     .src('./src/index.js')
//     .pipe(webpackStream(serverConfig, webpack, buildDone))
//     .pipe(reload({
//       port: 8080,
//       react: false,
//       config: path.join(__dirname, 'webpack.config.js')
//     }))
// });
//
// gulp.task('watch', function () {
//   gulp.watch('src/**/*.js', ['build-backend'])
// });




gulp.task( 'build', function ( cb ) {
    runSequence(
        'clean:build',
        [ 'stylus:compile', 'build:cp:index' ],
        'build:webpack',
        cb
    );
} );
