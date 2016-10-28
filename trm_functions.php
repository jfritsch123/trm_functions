<?php

/**
 * Treemotion Functions
 *
 * @link              http.//treemotion.at
 * @since             1.0.0
 * @package           Trm_functions
 *
 * @wordpress-plugin
 * Plugin Name:       trm_functions
 * Plugin URI:        http.//treemotion.at
 * Version:           1.0.0
 * Author:            jf
 * Author URI:        http.//treemotion.at
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       trm_functions
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define ('PLUGIN_DIR_PATH',plugin_dir_path(__FILE__ ));
define ('PLUGIN_DIR_URL',plugin_dir_url(__FILE__ ));

/**
 * The core plugin settings file
 * admin-specific hooks, and public-facing site hooks.
 */
require PLUGIN_DIR_PATH . 'settings.php';

