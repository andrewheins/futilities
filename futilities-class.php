<?php 
  
class Futilities {

  protected $version = '1.0.0';
  protected $plugin_slug = 'futilities';
  protected static $instance = null;
  protected $plugin_screen_hook_suffix = utilities;
  public $futilities;
  

  private function __construct() {
    
    $this->futilities = array(
      'hooks' => array(
        'action' => array(),
        'filter' => array(),
      ),
      'utilities' => array(),
    );
    
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
    foreach( $this->futilities['hooks']['action'] as $hook ) {
      
      if( $options && $options["hook_{$hook->type}_{$hook->ID}"] ) {
        add_action(
          $hook->binding,
          $hook->callback
        );  
      }
      
    }
    
  }
  
  // Our registration functions. These is what you use to register a futility.
  public function register_futility_hook( 
      $id, // unique id
      $hook_title, // 10 word description of what the hook does.
      $hook_bound_to, // what action/filter are you binding to
      $callback, // The function that actually does the thing
      $description = '',
      $type = 'action'
    ) {
      
      $this->futilities['hooks'][$type][] = (object) array(
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
    
    public function register_futility_class( 
      $id, // unique id
      $class_title, // 10 word description of what the hook does.
      $hook_bound_to, // what action/filter are you binding to
      $callback, // The function that actually does the thing
      $description = '',
      $type = 'action'
    ) {
      
      $this->futilities['hooks'][$type][] = (object) array(
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

  public static function get_instance() {

    // If the single instance hasn't been set, set it now.
    if ( null == self::$instance ) {
      self::$instance = new self;
    }

    return self::$instance;
  }
  
}