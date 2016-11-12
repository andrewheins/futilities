<?php
/**
 * Futilities
 *
 * @package	  futilities
 * @author	  Andrew Heins <andrew@andrewheins.ca>
 *
 * @futilities
 * Plugin Name: Futilities
 * Description: Various plug-and-play utilities to make WordPress a little easier to work with.
 * Version:		1.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( plugin_dir_path( __FILE__ ) . 'futilities-class.php' );

Futilities::get_instance();

// Initialize the settings page
require_once( 'settings.php' );