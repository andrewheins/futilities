<?php 
  
  Futilities::register_futility_hook(
    'remove_feeds',
    'Removes Feeds from &lt;head&gt;',
    'wp_loaded',
    function(){
      remove_action( 'wp_head', 'feed_links', 2 );
      remove_action( 'wp_head', 'feed_links_extra', 3 );
    },
    "Removes basic and comment feeds from WordPress Header"
  );