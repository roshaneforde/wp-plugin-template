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

// Create a dist directory if it does not exist.
const fs = require( 'fs' );

const public_dir = 'dist';

const archiver = require( 'archiver' );

if ( ! fs.existsSync( public_dir ) && 'production' === process.env.NODE_ENV ) {
    fs.mkdirSync( public_dir );
}

// Require laravel mix.
let mix = require( 'laravel-mix' );

// Compile dev assets and copy fiiles.
mix
    .sass( 'assets/scss/wpclear.scss', 'assets/min/wpclear.min.css' )
    .sass( 'assets/scss/wpclear-admin.scss', 'assets/min/wpclear-admin.min.css' )
    .js( 'assets/js/wpclear.js', 'assets/min/wpclear.min.js' )
    .js( 'assets/js/wpclear-admin.js', 'assets/min/wpclear-admin.min.js' )
    .disableNotifications()
    .options( { manifest: false } );

// Copy theme or plugin files to dist directory.
if ( 'production' === process.env.NODE_ENV ) {
    mix
        .copyDirectory( 'assets/img', `${public_dir}/wpclear/assets/img` )
        .copyDirectory( 'assets/min', `${public_dir}/wpclear/assets/min` )
        .copyDirectory( 'includes', `${public_dir}/wpclear/includes` )
        .copyDirectory( 'languages', `${public_dir}/wpclear/languages` )
        .copyDirectory( 'templates', `${public_dir}/wpclear/templates` )
        .copy(
            [
                'index.php',
                'LICENSE.txt',
                'readme.txt',
                'wpclear.php',
                'uninstall.php',
            ],
            `${public_dir}/wpclear`
        )
        .then( () => {
            // create a folder to stream archive data to.
            let output = fs.createWriteStream( `${public_dir}/wpclear-${process.env.npm_package_version}.zip` );
            let archive = archiver( 'zip', {
                zlib: { level: 9 } // Sets the compression level.
            } );

            // pipe archive data to the file
            archive.pipe( output );

            // append files and putting its contents at the root of archive
            archive.directory( `${public_dir}/wpclear/`, 'wpclear' );

            // finalize the archive 
            archive.finalize();
        } );
}
