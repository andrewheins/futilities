<?php
  
  namespace Futilities;
  
  class Routing extends FutilityClass {
    
    // Properly route to 404. Must be used before get_header() in Template to prevent issues.
    public static function send_404() {
      global $wp_query;
      $wp_query->set_404();
      status_header(404);
      require( get_404_template() );
      exit();
    }
    
  }
  