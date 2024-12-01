/*
 *--------------------------------------------------------------------------
 * Mix Asset Management
 *--------------------------------------------------------------------------
 *
 * Mix provides a clean, fluent API for defining some Webpack build steps
 * for Laravel applications. Instead of Laravel, we are using it for WordPress
 * theme and plugin development. By default, we are compiling the Sass file for
 * the theme or plugin as well as bundling up all the JS files.
 *
 */

const fs = require( 'fs' );
const archiver = require( 'archiver' );

const plugin_name = 'wp-plugin-template';
const plugin_prefix = 'wpt';

// Create directories if they don't exist.
if ( ! fs.existsSync( 'assets/min' ) ) {
    fs.mkdirSync( 'assets/min' );
}

if ( ! fs.existsSync( 'dist' ) && 'production' === process.env.NODE_ENV ) {
    fs.mkdirSync( 'dist' );
}

// Require laravel mix.
let mix = require( 'laravel-mix' );

// Compile dev assets and copy fiiles.
mix
    .sass( 'assets/scss/frontend.scss', `assets/min/${plugin_prefix}-frontend.min.css` )
    .sass( 'assets/scss/admin.scss', `assets/min/${plugin_prefix}-admin.min.css` )
    .js( 'assets/js/frontend.js', `assets/min/${plugin_prefix}-frontend.min.js` )
    .js( 'assets/js/admin.js', `assets/min/${plugin_prefix}-admin.min.js` )
    .js( 'assets/js/blocks.js', `assets/min/${plugin_prefix}-blocks.min.js` )
    .disableNotifications()
    .options( { manifest: false } );

// Copy theme or plugin files to dist directory.
if ( 'production' === process.env.NODE_ENV ) {
    mix
        .copyDirectory( 'assets/img', `dist/${plugin_name}/assets/img` )
        .copyDirectory( 'assets/min', `dist/${plugin_name}/assets/min` )
        .copyDirectory( 'includes', `dist/${plugin_name}/includes` )
        .copyDirectory( 'languages', `dist/${plugin_name}/languages` )
        .copy(
            [
                'index.php',
                'LICENSE.txt',
                'readme.txt',
                `${plugin_name}.php`,
                'uninstall.php',
            ],
            `dist/${plugin_name}`
        )
        .then( () => {
            // create a folder to stream archive data to.
            let output = fs.createWriteStream( `dist/${plugin_name}-${process.env.npm_package_version}.zip` );
            let archive = archiver( 'zip', {
                zlib: { level: 9 } // Sets the compression level.
            } );

            // pipe archive data to the file
            archive.pipe( output );

            // append files and putting its contents at the root of archive
            archive.directory( `dist/${plugin_name}/`, `${plugin_name}` );

            // finalize the archive 
            archive.finalize();
        } );
}
