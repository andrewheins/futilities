<?php

class FutilitiesSettings
{

  
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Futilities', 
            'Futilities Settings', 
            'manage_options', 
            'futilities-settings', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'futilities_settings' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Futilities</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'futilities_settings' );   
                do_settings_sections( 'futilities-settings' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
      
      $futilities = Futilities::get_instance();
      
      register_setting(
          'futilities_settings', // Option group
          'futilities_settings', // Option name
          array( $this, 'sanitize' ) // Sanitize
      );

      add_settings_section(
          'setting_section_id', // ID
          'Hooks', // Title
          array( $this, 'print_section_info' ), // Callback
          'futilities-settings' // Page
      );  

      
      $futilities_list = $futilities->get_futilities();
    

      foreach( $futilities_list['hooks']['action'] as $hook ) {
        add_settings_field(
          $hook->ID, // ID
          $hook->title, // Title 
          $hook->field, // Callback
          'futilities-settings', // Page
          'setting_section_id', // Section
          array(
            'id' => $hook->ID,
            'type' => $hook->type,
            'description' => empty( $hook->description ) ? $hook->title : $hook->description,
          )         
        );
      }

    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        return $input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print "Select which hooks you'd like to include:";
    }

}

if( is_admin() )
    $my_settings_page = new FutilitiesSettings();