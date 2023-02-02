<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and starts the plugin.
 *
 * @wordpress-plugin
 * Plugin Name:       WP Clear
 * Plugin URI:        http://example.com/wpclear/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            WP Clear
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://example.com/wpclear/
 * Text Domain:       wpclear
 * Domain Path:       /languages
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Plugin version and other constants.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 */
define( 'WPCLEAR_VERSION', '1.0.0' );
define( 'WPCLEAR_URL', plugin_dir_url( __FILE__ ) );
define( 'WPCLEAR_PATH', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-activator.php
 */
function activate_wpclear() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/config/class-activator.php';
	Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-deactivator.php
 */
function deactivate_wpclear() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/config/class-deactivator.php';
	Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpclear' );

register_deactivation_hook( __FILE__, 'deactivate_wpclear' );

/**
 * General functions for your plugin.
 */
require plugin_dir_path( __FILE__ ) . 'includes/functions.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpclear.php';

/**
 * Begins execution of the plugin.
 * 
 * @since 1.0.0
 */
new WP_Clear();
