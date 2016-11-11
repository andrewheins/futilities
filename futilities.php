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

global $futilities;

$futilities = array(
  'hooks' => array(
    'action' => array(),
    'filter' => array(),
  ),
  'utilities' => array(),
);

// Our registration functions. These is what you use to register a futility.
function register_futility_hook( 
  $id, // unique id
  $hook_title, // 10 word description of what the hook does.
  $hook_bound_to, // what action/filter are you binding to
  $callback, // The function that actually does the thing
  $description = '',
  $type = 'action'
) {
  
  global $futilities;
  
  $futilities['hooks'][$type][] = (object) array(
    'ID' => $id,
    'title' => $hook_title,
    'type' => $type,
    'binding' => $hook_bound_to,
    'callback' => $callback,
    'field' => function( $args ) {
      
      $options = get_option( 'futilities_settings' );
      
      if( empty( $options ) ) {
        $state = false;
      } else {
        $state = $options["hook_{$args['type']}_{$args['id']}"];
      }
      
      $field = "<label for='futilities_settings[hook_{$args['type']}_{$args['id']}]'><input type='checkbox'";
      if( $state ) {
        $field .= " checked ";
      }
      $field .= "name='futilities_settings[hook_{$args['type']}_{$args['id']}]'> {$args['description']}</label>";
      
      echo $field;
    },
    'description' => $description,
  ); 
}

function register_futility_class( 
  $id, // unique id
  $class_title, // 10 word description of what the hook does.
  $hook_bound_to, // what action/filter are you binding to
  $callback, // The function that actually does the thing
  $description = '',
  $type = 'action'
) {
  
  global $futilities;
  
  $futilities['hooks'][$type][] = (object) array(
    'ID' => $id,
    'title' => $hook_title,
    'binding' => $hook_bound_to,
    'callback' => $callback,
    'field' => function( $args ) {
      
      $options = get_option( 'futilities_settings' );
      
      if( empty( $options ) ) {
        $state = false;
      } else {
        $state = $options["hook_{$args['type']}_{$args['id']}"];
      }
      
      $field = "<label for='futilities_settings[hook_{$args['type']}_{$args['id']}]'><input type='checkbox'";
      if( $state ) {
        $field .= " checked ";
      }
      $field .= "name='futilities_settings[hook_{$args['type']}_{$args['id']}]'> {$args['description']}</label>";
      
      echo $field;
    },
    'description' => $description,
  ); 
}

$subdirectories = array(
  'utilities',
  'hooks',
);

// This loads every file, making them available to the settings page.
foreach( $subdirectories as $dir ) {
  foreach(glob(__DIR__ .'/' . $dir . '/*.php') as $file) {
      require_once( $file );
  }
}

// Get the currently enabled options
$options = get_option( 'futilities_settings' );

// Load up each futility that you've enabled
foreach( $futilities['hooks']['action'] as $hook ) {
  
  if( $options && $options["hook_{$hook->type}_{$hook->ID}"] ) {
    add_action(
      $hook->binding,
      $hook->callback
    );  
  }
  
}

// Initialize the settings page
require_once( 'settings.php' );