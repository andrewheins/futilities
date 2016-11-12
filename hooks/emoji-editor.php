<?php 
  
  Futilities::register_futility_hook(
    'remove_emoji_editor',
    'Remove Emoji Support from Content Editor',
    'init',
    function() {
    	add_filter( 'tiny_mce_plugins', function( $plugins ) {
      	if ( ! is_array( $plugins ) ) {
      		return array();
      	}
        return array_diff( $plugins, array( 'wpemoji' ) );
      } );
    },
    "Remove emoji support from WordPress Content Editor"
  );