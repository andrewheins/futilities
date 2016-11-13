<?php 
  
  Futilities::register_futility_hook(
    'clean_head',
    'Removes garbage from &lt;head&gt;',
    'wp_loaded',
    function(){
      remove_action('wp_head', 'rsd_link');
      remove_action('wp_head', 'wlwmanifest_link');
      remove_action('wp_head', 'wp_generator');
      remove_action('wp_head', 'start_post_rel_link');
      remove_action('wp_head', 'index_rel_link');
      remove_action('wp_head', 'adjacent_posts_rel_link');
    },
    "Removes a bunch of stuff you don't need from &lt;head&gt;"
  );