<?php

/**
 * @link              http://tweetneat.com
 * @since             1.0.0
 * @package           WPMVC
 *
 * @wordpress-plugin
 * Plugin Name:       WPMVC
 * Plugin URI:        http://jakesmakes.com/wpmvc
 * Description:       This is WPMVC.
 * Version:           1.0.0
 * Author:            WPMVC
 * Plugin URI:        http://jakesmakes.com/wpmvc
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpmvc
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


include 'include/helpers.php';
include 'classes/Encrypt.php';
include 'classes/Response.php';
include 'classes/Request.php';
include 'classes/Validate.php';
include 'rest-api/rest-api.php';


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */

function update_permalinks() {
    
	global $wp_rewrite;
	
	$wp_rewrite->set_permalink_structure('/%postname%/');
	
	$wp_rewrite->flush_rules();
		
}

function activate_plugin_name() {

	update_permalinks();

}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_plugin_name() {

}

register_activation_hook( __FILE__, 'activate_plugin_name' );

register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

function run_plugin_name() {

	new Rest_API;

}

add_action( 'init', 'run_plugin_name' );