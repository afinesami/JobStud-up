<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WorkScout_Core_Admin {

    /**
     * The single instance of WordPress_Plugin_Template_Settings.
     * @var     object
     * @access  private
     * @since   1.0.0
     */
    private static $_instance = null;

    /**
     * The main plugin object.
     * @var     object
     * @access  public
     * @since   1.0.0
     */
    public $parent = null;


    /**
     * The token.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $_token;

    /**
     * The main plugin file.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $file;

    /**
     * The main plugin directory.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $dir;

    /**
     * The plugin assets directory.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $assets_dir;

    /**
     * The plugin assets URL.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $assets_url;

    /**
     * Suffix for Javascripts.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $script_suffix;

    /**
     * Prefix for plugin settings.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $base = '';

    /**
     * Available settings for plugin.
     * @var     array
     * @access  public
     * @since   1.0.0
     */
    public $settings = array();

    public function __construct ( $parent ) {

        $this->parent = $parent;
        $this->_token = 'workscout';

        
        $this->dir = dirname( $this->file );
        $this->assets_dir = trailingslashit( $this->dir ) . 'assets';
        $this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) );

        $this->script_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';



        $this->base = 'workscout_';

        // Initialise settings
        add_action( 'init', array( $this, 'init_settings' ), 11 );

        // Register plugin settings
        add_action( 'admin_init' , array( $this, 'register_settings' ) );

        // Add settings page to menu
        add_action( 'admin_menu' , array( $this, 'add_menu_item' ) );

        add_action( 'save_post', array( $this, 'save_meta_boxes' ), 10, 1 );

        // Add settings link to plugins page
        //add_filter( 'plugin_action_links_' . plugin_basename( 'workscout_core' ) , array( $this, 'add_settings_link' ) );
        //add_action( 'current_screen', array( $this, 'conditional_includes' ) );
    }

    /**
     * Initialise settings
     * @return void
     */
    public function init_settings () {
        $this->settings = $this->settings_fields();

    }


    /**
     * Include admin files conditionally.
     */
    public function conditional_includes() {
        $screen = get_current_screen();
        if ( ! $screen ) {
            return;
        }
        switch ( $screen->id ) {
            case 'options-permalink':
                include 'class-workscout-core-permalinks.php';
                break;
        }
    }


    /**
     * Add settings page to admin menu
     * @return void
     */
    public function add_menu_item () {
        $page = add_menu_page( __( 'WorkScout Core ', 'workscout_core' ) , __( 'WorkScout Core', 'workscout_core' ) , 'manage_options' , $this->_token . '_settings' ,  array( $this, 'settings_page' ) );
        add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );

// submit_listing
// browse_listing
// Registration
// Pages
// Emails\
   
        add_submenu_page($this->_token . '_settings', 'Map Settings', 'Map Settings', 'manage_options', 'workscout_settings&tab=maps',  array( $this, 'settings_page' ) ); 
        
        
        add_submenu_page($this->_token . '_settings', 'Registration', 'Registration', 'manage_options', 'workscout_settings&tab=registration',  array( $this, 'settings_page' ) );   
        
        add_submenu_page($this->_token . '_settings', 'Pages', 'Pages', 'manage_options', 'workscout_settings&tab=pages',  array( $this, 'settings_page' ) ); 
        
        add_submenu_page($this->_token . '_settings', 'Emails', 'Emails', 'manage_options', 'workscout_settings&tab=emails',  array( $this, 'settings_page' ) ); 
    }

    /**
     * Load settings JS & CSS
     * @return void
     */
    public function settings_assets () {

        // We're including the farbtastic script & styles here because they're needed for the colour picker
        // If you're not including a colour picker field then you can leave these calls out as well as the farbtastic dependency for the wpt-admin-js script below
        wp_enqueue_style( 'farbtastic' );
        wp_enqueue_script( 'farbtastic' );

        // We're including the WP media scripts here because they're needed for the image upload field
        // If you're not including an image upload then you can leave this function call out
        wp_enqueue_media();

        wp_register_script( $this->_token . '-settings-js', WORKSCOUT_CORE_ASSETS_URL . 'js/settings.js', array( 'farbtastic', 'jquery' ), '1.0.0' );
      //  wp_enqueue_script( $this->_token . '-settings-js',array('jquery','jquery-ui-draggable', 'jquery-ui-sortable') );
        

    }


    /**
     * Build settings fields
     * @return array Fields to be displayed on settings page
     */
    private function settings_fields () {

        $settings['general'] = array(
            'title'                 => __( 'General', 'workscout_core' ),
            'description'           => __( 'General WorkScout settings.', 'workscout_core' ),
            'fields'                => array(
               
               //Comments on pages option on off
                array(
                    'label'      => __('Currency', 'workscout_core'),
                    'description'      => __('Choose a currency used.', 'workscout_core'),
                    'id'        => 'currency', //each field id must be unique
                    'type'      => 'select',
                    'options'   => array(
                            'none' => esc_html__( 'Disable Currency Symbol', 'workscout_core' ),
                            'USD' => esc_html__( 'US Dollars', 'workscout_core' ),
                            'AED' => esc_html__( 'United Arab Emirates Dirham', 'workscout_core' ),
                            'ARS' => esc_html__( 'Argentine Peso', 'workscout_core' ),
                            'AUD' => esc_html__( 'Australian Dollars', 'workscout_core' ),
                            'BDT' => esc_html__( 'Bangladeshi Taka', 'workscout_core' ),
                            'BHD' => esc_html__( 'Bahraini Dinar', 'workscout_core' ),
                            'BRL' => esc_html__( 'Brazilian Real', 'workscout_core' ),
                            'BGN' => esc_html__( 'Bulgarian Lev', 'workscout_core' ),
                            'CAD' => esc_html__( 'Canadian Dollars', 'workscout_core' ),
                            'CLP' => esc_html__( 'Chilean Peso', 'workscout_core' ),
                            'CNY' => esc_html__( 'Chinese Yuan', 'workscout_core' ),
                            'COP' => esc_html__( 'Colombian Peso', 'workscout_core' ),
                            'CZK' => esc_html__( 'Czech Koruna', 'workscout_core' ),
                            'DKK' => esc_html__( 'Danish Krone', 'workscout_core' ),
                            'DOP' => esc_html__( 'Dominican Peso', 'workscout_core' ),
                            'MAD' => esc_html__( 'Moroccan Dirham', 'workscout_core' ),
                            'EUR' => esc_html__( 'Euros', 'workscout_core' ),
                            'GHS' => esc_html__( 'Ghanaian Cedi', 'workscout_core' ),
                            'HKD' => esc_html__( 'Hong Kong Dollar', 'workscout_core' ),
                            'HRK' => esc_html__( 'Croatia kuna', 'workscout_core' ),
                            'HUF' => esc_html__( 'Hungarian Forint', 'workscout_core' ),
                            'ISK' => esc_html__( 'Icelandic krona', 'workscout_core' ),
                            'IDR' => esc_html__( 'Indonesia Rupiah', 'workscout_core' ),
                            'INR' => esc_html__( 'Indian Rupee', 'workscout_core' ),
                            'NPR' => esc_html__( 'Nepali Rupee', 'workscout_core' ),
                            'ILS' => esc_html__( 'Israeli Shekel', 'workscout_core' ),
                            'JPY' => esc_html__( 'Japanese Yen', 'workscout_core' ),
                            'JOD' => esc_html__( 'Jordanian Dinar', 'workscout_core' ),
                            'KZT' => esc_html__( 'Kazakhstani tenge', 'workscout_core' ),
                            'KIP' => esc_html__( 'Lao Kip', 'workscout_core' ),
                            'KRW' => esc_html__( 'South Korean Won', 'workscout_core' ),
                            'LKR' => esc_html__( 'Sri Lankan Rupee', 'workscout_core' ),
                            'MYR' => esc_html__( 'Malaysian Ringgits', 'workscout_core' ),
                            'MXN' => esc_html__( 'Mexican Peso', 'workscout_core' ),
                            'NGN' => esc_html__( 'Nigerian Naira', 'workscout_core' ),
                            'NOK' => esc_html__( 'Norwegian Krone', 'workscout_core' ),
                            'NZD' => esc_html__( 'New Zealand Dollar', 'workscout_core' ),
                            'PYG' => esc_html__( 'Paraguayan Guaraní', 'workscout_core' ),
                            'PHP' => esc_html__( 'Philippine Pesos', 'workscout_core' ),
                            'PLN' => esc_html__( 'Polish Zloty', 'workscout_core' ),
                            'GBP' => esc_html__( 'Pounds Sterling', 'workscout_core' ),
                            'RON' => esc_html__( 'Romanian Leu', 'workscout_core' ),
                            'RUB' => esc_html__( 'Russian Ruble', 'workscout_core' ),
                            'SGD' => esc_html__( 'Singapore Dollar', 'workscout_core' ),
                            'ZAR' => esc_html__( 'South African rand', 'workscout_core' ),
                            'SEK' => esc_html__( 'Swedish Krona', 'workscout_core' ),
                            'CHF' => esc_html__( 'Swiss Franc', 'workscout_core' ),
                            'TWD' => esc_html__( 'Taiwan New Dollars', 'workscout_core' ),
                            'THB' => esc_html__( 'Thai Baht', 'workscout_core' ),
                            'TRY' => esc_html__( 'Turkish Lira', 'workscout_core' ),
                            'UAH' => esc_html__( 'Ukrainian Hryvnia', 'workscout_core' ),
                            'USD' => esc_html__( 'US Dollars', 'workscout_core' ),
                            'VND' => esc_html__( 'Vietnamese Dong', 'workscout_core' ),
                            'EGP' => esc_html__( 'Egyptian Pound', 'workscout_core' ),
                            'ZMK' => esc_html__( 'Zambian Kwacha', 'workscout_core' )
                        ),
                    'default'       => 'USD'
                ),      
                array(
                    'label'      => __('Currency position', 'workscout_core'),
                    'description'      => __('Set currency symbol before or after', 'workscout_core'),
                    'id'        => 'currency_postion',
                    'type'      => 'radio',
                    'options'   => array( 
                            'after' => 'After', 
                            'before' => 'Before' 
                        ),
                    'default'   => 'after'
                ), 

                array(
                    'label'      => __('Use WorkScout Private Messages to contact job owner', 'workscout_core'),
                    'description'      => __('Will add "send message" button to job listings', 'workscout_core'),
                    'id'        => 'private_messages_job',
                    'type'      => 'checkbox',
                    'default'   => 'on'
                ),
                array(
                    'label'      => __('Use WorkScout Private Messages to contact candidates', 'workscout_core'),
                    'description'      => __('Will add "send message" button to resumes', 'workscout_core'),
                    'id'        => 'private_messages_resumes',
                    'type'      => 'checkbox',
                    'default'   => 'on'
                ),
               

               
                // array(
                //     'label'      => __('Region in listing permalinks', 'workscout_core'),
                //     'description'      => __('By enabling this option the links to properties will <br> be prepended  with regions (e.g /listing/las-vegas/arlo-apartment/).<br> After enabling this go to Settings-> Permalinks and click \' Save Changes \' ', 'workscout_core'),
                //     'id'        => 'region_in_links',
                //     'type'      => 'checkbox',
                // ), 

                // array(
                //     'label'      => __('Hide owner contact information from not logged in users', 'workscout_core'),
                //     'description'      => __('By enabling this option phone and emails fields will be visible only for logged in users', 'workscout_core'),
                //     'id'        => 'user_contact_details_visibility',
                //     'type'      => 'checkbox',
                // ),  

               
            )
        ); 
    if(class_exists('Kirki')) : 
        $settings['maps'] = array(
            'title'                 => __( 'Map Settings', 'workscout_core' ),
            'description'           => __( 'Settings for map usage.', 'workscout_core' ),
            'fields'                => array(
                
                array(
                    'label'         => __( 'Automatically locate users on page load', 'listeo_core' ),
                    'description'   => __( 'You need to be on HTTPS, this uses html5 geolocation feature https://www.w3schools.com/html/html5_geolocation.asp', 'workscout_core' ),
                    'id'            => 'map_autolocate', //field id must be unique
                    'type'          => 'checkbox',
                    'default'          => 'off',
                ),

                array(
                    'label' => __( 'Restrict search results to one country (works only with Google Maps)', 'workscout_core' ),
                    'description' => __( 'Put symbol of country you want to restrict your results to (eg. uk for United Kingdon). Leave empty to search whole world.', 'workscout_core' ),
                    'id'   => 'maps_limit_country', //field id must be unique
                    'type' => 'text',
                    'default' =>  Kirki::get_option( 'workscout','pp_maps_limit_country', '')
                ),
                array(
                    'label' => __( 'Listings map center point', 'workscout_core' ),
                    'description' => __( 'Write latitude and longitude separated by come, for example -34.397,150.644', 'workscout_core' ),
                    'id'   => 'map_center_point', //field id must be unique
                    'type' => 'text',
                    'default' => Kirki::get_option( 'workscout','pp_map_center','52.2296756,21.012228700000037'),    
                ),

                array(
                    'label'      => __('Maps Provider', 'workscout_core'),
                    'description'      => __('Choose which service you want to use for maps', 'workscout_core'),
                    'id'        => 'map_provider',
                    'type'      => 'radio',
                    'options'   => array( 
                            'osm' => esc_html__( 'OpenStreetMap', 'workscout_core' ),
                            'google' => __( 'Google Maps <a href="http://www.docs.purethemes.net/workscout/knowledge-base/getting-google-maps-api-key/">(requires API key)</a>', 'workscout_core' ),
                            'mapbox' => __( 'MapBox <a href="https://account.mapbox.com/access-tokens/create">(requires API key)</a>', 'workscout_core' ),
                            'bing' => __( 'Bing <a href="https://www.microsoft.com/en-us/maps/choose-your-bing-maps-api">(requires API key)</a>', 'workscout_core' ),
                            'thunderforest' => __( 'ThunderForest <a href="https://manage.thunderforest.com/">(requires API key)</a>', 'workscout_core' ),
                            'here' => __( 'HERE <a href="https://developer.here.com/lp/mapAPIs?create=Freemium-Basic&keepState=true&step=account">(requires API key)</a>', 'workscout_core' ),
                            // 'esri' => esc_html__( 'ESRI (requires registration)', 'workscout_core' ),
                            'none' => esc_html__( 'None - this will dequeue all map related scripts', 'workscout_core' ),  
                        ),
                    'default'   => 'osm'
                ),

                array(
                    'label'      => __('Address suggestion provider', 'workscout_core'),
                    'description'      => __('Choose which service you want to use for adress autocomplete', 'workscout_core'),
                    'id'        => 'map_address_provider',
                    'type'      => 'radio',
                    'options'   => array( 
                            'osm' => esc_html__( 'OpenStreetMap', 'workscout_core' ),
                            'google' => __( 'Google Maps <a href="http://www.docs.purethemes.net/workscout/knowledge-base/getting-google-maps-api-key/">(requires API key and Maps Provider set to Google Maps)</a>', 'workscout_core' ),
                            'off' => esc_html__( 'Disable address suggestion', 'workscout_core' ),
                        ),
                    'default'   => 'osm'
                ),

                //geocoding providers
                
                array(
                    'label' => __( 'Google Maps API key', 'workscout_core' ),
                    'description' => __( 'Generate API key for google maps functionality (can be domain restricted).', 'workscout_core' ),
                    'id'   => 'maps_api', //field id must be unique
                    'type' => 'text',
                    'placeholder'   => __( 'Google Maps API key', 'workscout_core' ),
                    'default' => Kirki::get_option( 'workscout','pp_maps_browser_api', '')
                ),

                array(
                    'label' => __( 'MapBox Access Token', 'workscout_core' ),
                    'description' => __( 'Generate Access Token for MapBox', 'workscout_core' ),
                    'id'   => 'mapbox_access_token', //field id must be unique
                    'type' => 'text',
                    'placeholder'   => __( 'MapBox Access Token key', 'workscout_core' )
                ),
                array(
                    'label' => __( 'MapBox Retina Tiles', 'workscout_core' ),
                    'description' => __( 'Enable to use Retina Tiles. Might affect map loading speed.', 'workscout_core' ),
                    'id'   => 'mapbox_retina', //field id must be unique
                    'type' => 'checkbox',
                    
                ),
                array(
                    'label' => __( 'Bing Maps Key', 'workscout_core' ),
                    'description' => __( 'API key for Bing Maps', 'workscout_core' ),
                    'id'   => 'bing_maps_key', //field id must be unique
                    'type' => 'text',
                    'placeholder'   => __( 'Bing Maps API Key', 'workscout_core' )
                ),
                array(
                    'label' => __( 'ThunderForest API Key', 'workscout_core' ),
                    'description' => __( 'API key for ThunderForest', 'workscout_core' ),
                    'id'   => 'thunderforest_api_key', //field id must be unique
                    'type' => 'text',
                    'placeholder'   => __( 'ThunderForest API Key', 'workscout_core' )
                ), 
                array(
                    'label' => __( 'HERE App ID', 'workscout_core' ),
                    'description' => __( 'HERE App ID', 'workscout_core' ),
                    'id'   => 'here_app_id', //field id must be unique
                    'type' => 'text',
                    'placeholder'   => __( 'HERE Maps API Key', 'workscout_core' )
                ), 
                array(
                    'label' => __( 'HERE App Code', 'workscout_core' ),
                    'description' => __( 'App code key for HERE Maps', 'workscout_core' ),
                    'id'   => 'here_app_code', //field id must be unique
                    'type' => 'text',
                    'placeholder'   => __( 'HERE App Code', 'workscout_core' )
                ),

                array(
                    'label' =>  '',
                    'description' =>  __('Radius search settings', 'workscout_core'),
                    'type' => 'title',
                    'id'   => 'header_radius',
                    'description' => 'Radius search settings<br><span style="font-size:13px">To use the Search by Radius feature, you need to create Google Maps API key for geocoding</span>',
                ), 
                array(
                    'label' => __( 'Google Maps API key for server side geocoding', 'workscout_core' ),
                    'description' => __( 'Generate API key for geocoding search functionality (without any domain/key restriction).', 'workscout_core' ),
                    'id'   => 'maps_api_server', //field id must be unique
                    'type' => 'text',
                    'placeholder'   => __( 'Google Maps API key', 'workscout_core' )
                ),

                array(
                    'label'      => __('Radius slider default state', 'workscout_core'),
                    'description'      => __('Choose radius search slider', 'workscout_core'),
                    'id'        => 'radius_state',
                    'type'      => 'select',
                    'options'   => array( 
                            'disabled' => esc_html__( 'Disabled by default', 'workscout_core' ),
                            'enabled' => esc_html__( 'Enabled by default', 'workscout_core' ),
                        ),
                    'default'   => 'km'
                ),  
                array(
                    'label'      => __('Radius search unit', 'workscout_core'),
                    'description'      => __('Choose a unit', 'workscout_core'),
                    'id'        => 'radius_unit',
                    'type'      => 'select',
                    'options'   => array( 
                            'km' => esc_html__( 'km', 'workscout_core' ),
                            'miles' => esc_html__( 'miles', 'workscout_core' ),
                        ),
                    'default'   => 'km'
                ), 
                 array(
                    'label' => __( 'Default radius search value', 'workscout_core' ),
                    'description' => __( 'Set default radius for search, leave empty to disable default radius search.', 'workscout_core' ),
                    'id'   => 'maps_default_radius', //field id must be unique
                    'type' => 'text',
                    'default'   => 50
                ),



            )
        );
        
       endif;
        $settings['registration'] = array(
            'title'                 => __( 'Registration', 'workscout_core' ),
            'description'           => __( 'Settings for users registration and login.', 'workscout_core' ),
            'fields'                => array(
                array(
                    'id'            => 'front_end_login',
                    'label'         => __( 'Enable Forced Front End Login', 'workscout_core' ),
                    'description'   => __( 'Enabling this option will redirect all wp-login request to frontend form. Be aware that on some servers or some configuration, especially with security plugins, this might cause a redirect loop, so always test this setting on different browser, while being still logged in Dashboard to have option to disable that if things go wrong.', 'workscout_core' ),
                    'type'          => 'checkbox',
                ),
                array(
                    'id'            => 'popup_login',
                    'label'         => __( 'Login/Registration Form Type', 'workscout_core' ),
                    'description'   => __( '.', 'workscout_core' ),
                    'type'          => 'select',
                    'options'       => array( 
                            'ajax'       => __('Ajax form in a popup', 'workscout_core' ),
                            'page'   => __('Separate page', 'workscout_core' ),  
                    ),
                    'default'       => 'ajax'
                ),
                array(
                    'id'            => 'privacy_policy',
                    'label'         => __( 'Enable Privacy Policy link in registration form', 'workscout_core' ),
                    'description'   => __( '.', 'workscout_core' ),
                    'type'          => 'checkbox',
                ),
                 array(
                    'id'            => 'autologin',
                    'label'         => __( 'Automatically login user after successful registration', 'workscout_core' ),
                    'description'   => __( '.', 'workscout_core' ),
                    'type'          => 'checkbox',
                ),
                array(
                    'id'            => 'recaptcha',
                    'label'         => __( 'Enable reCAPTCHA on registration form', 'workscout_core' ),
                    'description'   => __( 'Check this checkbox to add reCAPTCHA to form. You need to provide API keys for that.', 'workscout_core' ),
                    'type'          => 'checkbox',
                ),
                  array(
                    'id'            => 'recaptcha_version',
                    'label'         => __( 'Recaptcha version', 'workscout_core' ),
                    'description'   => __( '.', 'workscout_core' ),
                    'type'          => 'select',
                    'options'       => array( 
                            'v2'       => __('V2 checkbox', 'workscout_core' ),
                            'v3'   => __('V3', 'workscout_core' ),  
                    ),
                    'default'       => 'v2'
                ),
                array(
                    'id'            => 'recaptcha_sitekey',
                    'label'         => __( 'reCAPTCHA v2 Site Key', 'workscout_core' ),
                    'description'   => __( 'Get the sitekey from https://www.google.com/recaptcha/admin#list - use reCaptcha v2', 'workscout_core' ),
                    'type'          => 'text',
                ),
                array(
                    'id'            => 'recaptcha_secretkey',
                    'label'         => __( 'reCAPTCHA v2 Secret Key', 'workscout_core' ),
                    'description'   => __( 'Get the sitekey from https://www.google.com/recaptcha/admin#list - use reCaptcha v2', 'workscout_core' ),
                    'type'          => 'text',
                ),  
                array(
                    'id'            => 'recaptcha_sitekey3',
                    'label'         => __( 'reCAPTCHA v3 Site Key', 'workscout_core' ),
                    'description'   => __( 'Get the sitekey from https://www.google.com/recaptcha/admin#list - use reCaptcha v3', 'workscout_core' ),
                    'type'          => 'text',
                ),
                array(
                    'id'            => 'recaptcha_secretkey3',
                    'label'         => __( 'reCAPTCHA v3 Secret Key', 'workscout_core' ),
                    'description'   => __( 'Get the sitekey from https://www.google.com/recaptcha/admin#list - use reCaptcha v3', 'workscout_core' ),
                    'type'          => 'text',
                ),
                array(
                    'id'            => 'registration_hide_role',
                    'label'         => __( 'Hide Role field in Registration Form', 'workscout_core' ),
                    'description'   => __( 'If hidden, set default role in Settings -> General -> New User Default Role', 'workscout_core' ),
                    'type'          => 'checkbox',
                ),
                array(
                    'id'            => 'registration_hide_username',
                    'label'         => __( 'Hide Username field in Registration Form', 'workscout_core' ),
                    'description'   => __( 'Username will be generated from email address (part before @)', 'workscout_core' ),
                    'type'          => 'checkbox',
                ),
               
                array(
                    'id'            => 'display_first_last_name',
                    'label'         => __( 'Display First and Last name fields in registration form', 'workscout_core' ),
                    'description'   => __( 'Adds optional input fields for first and last name', 'workscout_core' ),
                    'type'          => 'checkbox',
                ),
                array(
                    'id'            => 'display_password_field',
                    'label'         => __('Add Password pickup field to registration form', 'workscout_core'),
                    'description'   => __('Enable to add password field, when disabled it will be randomly generated and sent via email', 'workscout_core'),
                    'type'          => 'checkbox',
                )
            )
        );

       $settings['pages'] = array(
            'title'                 => __( 'Pages', 'workscout_core' ),
            'description'           => __( 'Set all pages required in WorkScout.', 'workscout_core' ),
            'fields'                => array(
                array(
                    'id'            => 'dashboard_page',
                    'options'       => workscout_core_get_pages_options(),
                    'label'         => __( 'Dashboard Page' , 'workscout_core' ),
                    'description'   => __( 'Main Dashboard page for user', 'workscout_core' ),
                    'type'          => 'select',
                ),
                array(
                    'id'            => 'messages_page',
                    'options'       => workscout_core_get_pages_options(),
                    'label'         => __( 'Messages Page' , 'workscout_core' ),
                    'description'   => __( 'Main page for user messages', 'workscout_core' ),
                    'type'          => 'select',
                ),
                array(
                    'id'            => 'past_applications',
                    'options'       => workscout_core_get_pages_options(),
                    'label'         => __( 'Past Applications Page' , 'workscout_core' ),
                    'description'   => __( 'Page to show previous applications (requires Applications add-on)', 'workscout_core' ),
                    'type'          => 'select',
                ),
                        
                array(
                    'id'            => 'profile_page',
                    'options'       => workscout_core_get_pages_options(),
                    'label'         => __( 'My Profile Page' , 'workscout_core' ),
                    'description'   => __( 'Displays user profile page', 'workscout_core' ),
                    'type'          => 'select',
                ),
                    
                array(
                    'label'          => __('Lost Password Page', 'workscout_core'),
                    'description'          => __('Select page that holds [workscout_lost_password] shortcode', 'workscout_core'),
                    'id'            =>  'lost_password_page',
                    'type'          => 'select',
                    'options'       => workscout_core_get_pages_options(),
                ),                
                array(
                    'label'          => __('Reset Password Page', 'workscout_core'),
                    'description'          => __('Select page that holds [workscout_reset_password] shortcode', 'workscout_core'),
                    'id'            =>  'reset_password_page',
                    'type'          => 'select',
                    'options'       => workscout_core_get_pages_options(),
                ), 
                array(
                    'label'          => __('Browse Job Categories Page', 'workscout_core'),
                    'description'          => __('Select page that shows list of job categories', 'workscout_core'),
                    'id'            =>  'categories_page',
                    'type'          => 'select',
                    'options'       => workscout_core_get_pages_options(),
                ), 
                array(
                    'label'          => __('Browse Resume Categories Page', 'workscout_core'),
                    'description'          => __('Select page that shows list of resume categories', 'workscout_core'),
                    'id'            =>  'resume_categories_page',
                    'type'          => 'select',
                    'options'       => workscout_core_get_pages_options(),
                ),
               
                array(
                    'id'            => 'orders_page',
                    'label'         => __( 'WooCommerce Orders Page' , 'workscout_core' ),
                    'description'   => __( 'Displays orders page in dashboard menu', 'workscout_core' ),
                    'type'          => 'checkbox',
                ), 
                array(
                    'id'            => 'subscription_page',                    
                    'label'         => __( 'WooCommerce Subscription Page' , 'workscout_core' ),
                    'description'   => __( 'Displays subscription page in dashboard menu (requires WooCommerce Subscription plugin)', 'workscout_core' ),
                    'type'          => 'checkbox',
                ),

        //         array(
        //             'id'            => 'colour_picker',
        //             'label'         => __( 'Pick a colour', 'workscout_core' ),
        //             'description'   => __( 'This uses WordPress\' built-in colour picker - the option is stored as the colour\'s hex code.', 'workscout_core' ),
        //             'type'          => 'color',
        //             'default'       => '#21759B'
        //         ),
                // array(
                //     'id'            => 'an_image',
                //     'label'         => __( 'An Image' , 'workscout_core' ),
                //     'description'   => __( 'This will upload an image to your media library and store the attachment ID in the option field. Once you have uploaded an imge the thumbnail will display above these buttons.', 'workscout_core' ),
                //     'type'          => 'image',
                //     'default'       => '',
                //     'placeholder'   => ''
                // ),
        //         array(
        //             'id'            => 'multi_select_box',
        //             'label'         => __( 'A Multi-Select Box', 'workscout_core' ),
        //             'description'   => __( 'A standard multi-select box - the saved data is stored as an array.', 'workscout_core' ),
        //             'type'          => 'select_multi',
        //             'options'       => array( 'linux' => 'Linux', 'mac' => 'Mac', 'windows' => 'Windows' ),
        //             'default'       => array( 'linux' )
        //         )
            )
        );
        // $settings['search'] = array(
        //     'title'         => __( 'Search Forms', 'workscout_core' ),
        //     'description'   => __( 'Search Forms settings.', 'workscout_core' ),
        //     'fields'        => array(
        //         array(
        //             'label'  => __('Home Search Form elements', 'workscout_core'),
        //             'description'  => __('Choose elements to show on front page search form.', 'workscout_core'),
        //             'id'    => 'home_search',
        //              'options'   => array( 

        //                     'keyword' => esc_html__( 'Search by keyword', 'workscout_core' ),
        //                     'location' => esc_html__( 'Search by location', 'workscout_core' ),
        //                     'categories' => esc_html__( 'Search by categories', 'workscout_core' ),
        //                     'job_types' => esc_html__( 'Search by job types', 'workscout_core' ),
        //                     'region'=> esc_html__( 'Region', 'workscout_core' ),
                            
        //                 ),              
        //             'type'  => 'drag_list',
        //         ),
        //         array(
        //             'label'  => __('Sidebar Search Form elements', 'workscout_core'),
        //             'description'  => __('Choose elements to show on sidebar search form.', 'workscout_core'),
        //             'id'    => 'sidebar_search',
        //              'options'   => array( 

        //                     'keyword' => esc_html__( 'Search by keyword', 'workscout_core' ),
        //                     'location' => esc_html__( 'Search by location', 'workscout_core' ),
        //                     'categories' => esc_html__( 'Search by categories', 'workscout_core' ),
        //                     'job_types' => esc_html__( 'Search by job types', 'workscout_core' ),
        //                     'salary'  => esc_html__( 'Search by salary filter', 'workscout_core' ),
        //                     'rate' => esc_html__( 'Search by rate', 'workscout_core' ),
        //                     'region'=> esc_html__( 'Region', 'workscout_core' ),
                           
        //                 ),              
        //             'type'  => 'drag_list',
        //         ),
        //     ),
        

            
        // );
        $settings['emails'] = array(
            'title'                 => __( 'Emails', 'workscout_core' ),
            'description'           => __( 'Email settings.', 'workscout_core' ),
            'fields'                => array(
        
                array(
                    'label'  => __('"From name" in email', 'workscout_core'),
                    'description'  => __('The name from who the email is received, by default it is your site name.', 'workscout_core'),
                    'id'    => 'emails_name',
                    'default' =>  get_bloginfo( 'name' ),                
                    'type'  => 'text',
                ),

                array(
                    'label'  => __('"From" email ', 'workscout_core'),
                    'description'  => __('This will act as the "from" and "reply-to" address. This emails should match your domain address', 'workscout_core'),
                    'id'    => 'emails_from_email',
                    'default' =>  get_bloginfo( 'admin_email' ),               
                    'type'  => 'text',
                ),
                
                array(
                    'label' =>  '',
                    'description' =>  __('Registration/Welcome email for new users', 'workscout_core'),
                    'type' => 'title',
                    'id'   => 'header_welcome',
                    'description' => '<br>'.__('Available tags are:').'{user_mail},{user_name},{site_name},{password},{login}',
                ), 
                array(
                    'label'      => __('Welcome  Email Subject', 'workscout_core'),
                    'default'      => __('Welcome to {site_name}', 'workscout_core'),
                    'id'        => 'listing_welcome_email_subject',
                    'type'      => 'text',
                ),
                 array(
                    'label'      => __('Published notification Email Content', 'workscout_core'),
                    'default'      => trim(preg_replace('/\t+/', '', "Hi {user_name},<br>
Welcome to our website.<br>
<ul>
<li>Username: {login}</li>
<li>Password: {password}</li>
</ul>
<br>
Thank you.
<br>")),
                    'id'        => 'listing_welcome_email_content',
                    'type'      => 'editor',
                ),   

 /*New message in conversation*/
                array(
                    'label' =>  '',
                    'description' =>  __('Email notification about new conversation', 'workscout_core'),
                    'type' => 'title',
                    'id'   => 'header_new_converstation'
                ), 
                array(
                    'label'      => __('Enable new conversation notification email', 'workscout_core'),
                    'description'      => __('Check this checkbox to enable sending emails to user when there was new conversation started', 'workscout_core'),
                    'id'        => 'new_conversation_notification',
                    'type'      => 'checkbox',
                ), 
                array(
                    'label'      => __('New conversation notification email subject', 'workscout_core'),
                    'default'      => __('You got new conversation', 'workscout_core'),
                    'id'        => 'new_conversation_notification_email_subject',
                    'description' => '<br>'.__('Available tags are:').'{user_mail},{user_name},{sender},{conversation_url},{site_name},{site_url}',
                    'type'      => 'text',
                ),
                 array(
                    'label'      => __('New conversation notification email content', 'workscout_core'),
                    'default'      => trim(preg_replace('/\t+/', '', "Hi {user_name},<br>
                    There's a new conversation waiting for your on {site_name}.<br>
                    <br>
                    Thank you
                    <br>")),
                    'id'        => 'new_conversation_notification_email_content',
                    'type'      => 'editor',
                ),  

                /*New message in conversation*/
                array(
                    'label' =>  '',
                    'description' =>  __('Email notification about new message', 'workscout_core'),
                    'type' => 'title',
                    'id'   => 'header_new_message'
                ), 
                array(
                    'label'      => __('Enable new message notification email', 'workscout_core'),
                    'description'      => __('Check this checkbox to enable sending emails to user when there was new message send', 'workscout_core'),
                    'id'        => 'new_message_notification',
                    'type'      => 'checkbox',
                ), 
                array(
                    'label'      => __('New message notification email subject', 'workscout_core'),
                    'default'      => __('You got new message', 'workscout_core'),
                    'id'        => 'new_message_notification_email_subject',
                    'description' => '<br>'.__('Available tags are:').'{user_mail},{user_name},{listing_name},{listing_url},{sender},{conversation_url},{site_name},{site_url}',
                    'type'      => 'text',
                ),
                 array(
                    'label'      => __('New message notification email content', 'workscout_core'),
                    'default'      => trim(preg_replace('/\t+/', '', "Hi {user_name},<br>
                    There's a new message waiting for your on {site_name}.<br>
                    <br>
                    Thank you
                    <br>")),
                    'id'        => 'new_message_notification_email_content',
                    'type'      => 'editor',
                ),  
               
              


            ),
        );

        $settings = apply_filters( $this->_token . '_settings_fields', $settings );

        return $settings;
    }

    /**
     * Register plugin settings
     * @return void
     */
    public function register_settings () {
        if ( is_array( $this->settings ) ) {

            // Check posted/selected tab
            $current_section = '';
            if ( isset( $_POST['tab'] ) && $_POST['tab'] ) {
                $current_section = $_POST['tab'];
            } else {
                if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
                    $current_section = $_GET['tab'];
                }
            }

            foreach ( $this->settings as $section => $data ) {

                if ( $current_section && $current_section != $section ) continue;

                // Add section to page
                add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), $this->_token . '_settings' );

                foreach ( $data['fields'] as $field ) {

                    // Validation callback for field
                    $validation = '';
                    if ( isset( $field['callback'] ) ) {
                        $validation = $field['callback'];
                    }

                    // Register field
                    $option_name = $this->base . $field['id'];

                    register_setting( $this->_token . '_settings', $option_name, $validation );

                    // Add field to page

                    add_settings_field( $field['id'], $field['label'], array($this, 'display_field'), $this->_token . '_settings', $section, array( 'field' => $field, 'class' => 'workscout_map_settings '.$field['id'],  'prefix' => $this->base ) );
                }

                if ( ! $current_section ) break;
            }
        }
    }

    public function settings_section ( $section ) {
        $html = '<p> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
        echo $html;
    }

    /**
     * Load settings page content
     * @return void
     */
    public function settings_page () {

        // Build page HTML
        $html = '<div class="wrap" id="' . $this->_token . '_settings">' . "\n";
            $html .= '<h2>' . __( 'Plugin Settings' , 'workscout_core' ) . '</h2>' . "\n";

            $tab = '';
            if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
                $tab .= $_GET['tab'];
            }

            // Show page tabs
            if ( is_array( $this->settings ) && 1 < count( $this->settings ) ) {

                $html .= '<h2 class="nav-tab-wrapper">' . "\n";

                $c = 0;
                foreach ( $this->settings as $section => $data ) {

                    // Set tab class
                    $class = 'nav-tab';
                    if ( ! isset( $_GET['tab'] ) ) {
                        if ( 0 == $c ) {
                            $class .= ' nav-tab-active';
                        }
                    } else {
                        if ( isset( $_GET['tab'] ) && $section == $_GET['tab'] ) {
                            $class .= ' nav-tab-active';
                        }
                    }

                    // Set tab link
                    $tab_link = add_query_arg( array( 'tab' => $section ) );
                    if ( isset( $_GET['settings-updated'] ) ) {
                        $tab_link = remove_query_arg( 'settings-updated', $tab_link );
                    }

                    // Output tab
                    $html .= '<a href="' . $tab_link . '" class="' . esc_attr( $class ) . '">' . esc_html( $data['title'] ) . '</a>' . "\n";

                    ++$c;
                }

                $html .= '</h2>' . "\n";
            }

            $html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";

                // Get settings fields
                ob_start();
                settings_fields( $this->_token . '_settings' );
                do_settings_sections( $this->_token . '_settings' );
                $html .= ob_get_clean();

                $html .= '<p class="submit">' . "\n";
                    $html .= '<input type="hidden" name="tab" value="' . esc_attr( $tab ) . '" />' . "\n";
                    $html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( __( 'Save Settings' , 'workscout_core' ) ) . '" />' . "\n";
                $html .= '</p>' . "\n";
            $html .= '</form>' . "\n";
        $html .= '</div>' . "\n";

        echo $html;
    }

    /**
     * Generate HTML for displaying fields
     * @param  array   $field Field data
     * @param  boolean $echo  Whether to echo the field HTML or return it
     * @return void
     */
    public function display_field ( $data = array(), $post = false, $echo = true ) {

        // Get field info
        if ( isset( $data['field'] ) ) {
            $field = $data['field'];
        } else {
            $field = $data;
        }

        // Check for prefix on option name
        $option_name = '';
        if ( isset( $data['prefix'] ) ) {
            $option_name = $data['prefix'];
        }

        // Get saved data
        $data = '';
        if ( $post ) {

            // Get saved field data
            $option_name .= $field['id'];
            $option = get_post_meta( $post->ID, $field['id'], true );

            // Get data to display in field
            if ( isset( $option ) ) {
                $data = $option;
            }

        } else {

            // Get saved option
            $option_name .= $field['id'];
            $option = get_option( $option_name );

            // Get data to display in field
            if ( isset( $option ) ) {
                $data = $option;
            }

        }

        // Show default data if no option saved and default is supplied
        if ( $data === false && isset( $field['default'] ) ) {
            $data = $field['default'];
        } elseif ( $data === false ) {
            $data = '';
        }

        $html = '';

        switch( $field['type'] ) {

            case 'text':
            case 'url':
            case 'email':
                $html .= '<input id="' . esc_attr( $field['id'] ) . '" type="text" class="regular-text" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( (isset($field['placeholder'])) ? $field['placeholder'] : '' ) . '" value="' . esc_attr( $data ) . '" />' . "\n";
            break;

            case 'password':
            case 'number':
            case 'hidden':
                $min = '';
                if ( isset( $field['min'] ) ) {
                    $min = ' min="' . esc_attr( $field['min'] ) . '"';
                }

                $max = '';
                if ( isset( $field['max'] ) ) {
                    $max = ' max="' . esc_attr( $field['max'] ) . '"';
                }
                $html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . esc_attr( $field['type'] ) . '" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value="' . esc_attr( $data ) . '"' . $min . '' . $max . '/>' . "\n";
            break;

            case 'text_secret':
                $html .= '<input id="' . esc_attr( $field['id'] ) . '" type="text" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value="" />' . "\n";
            break;

            case 'textarea':
                $html .= '<textarea id="' . esc_attr( $field['id'] ) . '" rows="5" cols="50" name="' . esc_attr( $option_name ) . '">' . $data . '</textarea><br/>'. "\n";
            break;

            case 'checkbox':
                $checked = '';
                if ( $data && 'on' == $data ) {
                    $checked = 'checked="checked"';
                }
                $html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . esc_attr( $field['type'] ) . '" name="' . esc_attr( $option_name ) . '" ' . $checked . '/>' . "\n";
            break;

            case 'checkbox_multi':
                foreach ( $field['options'] as $k => $v ) {
                    $checked = false;
                    if ( in_array( $k, (array) $data ) ) {
                        $checked = true;
                    }
                    $html .= '<p><label for="' . esc_attr( $field['id'] . '_' . $k ) . '" class="checkbox_multi"><input type="checkbox" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '[]" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label></p> ';
                }
            break;

            case 'radio':
                foreach ( $field['options'] as $k => $v ) {
                    $checked = false;
                    if ( $k == $data ) {
                        $checked = true;
                    }
                    $html .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '"><input type="radio" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label><br> ';
                }
            break;

            case 'select':
                $html .= '<select name="' . esc_attr( $option_name ) . '" id="' . esc_attr( $field['id'] ) . '">';
                foreach ( $field['options'] as $k => $v ) {
                    $selected = false;
                    if ( $k == $data ) {
                        $selected = true;
                    }
                    $html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '">' . $v . '</option>';
                }
                $html .= '</select> ';
            break;

            case 'select_multi':
                $html .= '<select name="' . esc_attr( $option_name ) . '[]" id="' . esc_attr( $field['id'] ) . '" multiple="multiple">';
                foreach ( $field['options'] as $k => $v ) {
                    $selected = false;
                    if ( in_array( $k, (array) $data ) ) {
                        $selected = true;
                    }
                    $html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '">' . $v . '</option>';
                }
                $html .= '</select> ';
            break;

            case 'image':
                $image_thumb = '';
                if ( $data ) {
                    $image_thumb = wp_get_attachment_thumb_url( $data );
                }
                $html .= '<img id="' . $option_name . '_preview" class="image_preview" src="' . $image_thumb . '" /><br/>' . "\n";
                $html .= '<input id="' . $option_name . '_button" type="button" data-uploader_title="' . __( 'Upload an image' , 'workscout_core' ) . '" data-uploader_button_text="' . __( 'Use image' , 'workscout_core' ) . '" class="image_upload_button button" value="'. __( 'Upload new image' , 'workscout_core' ) . '" />' . "\n";
                $html .= '<input id="' . $option_name . '_delete" type="button" class="image_delete_button button" value="'. __( 'Remove image' , 'workscout_core' ) . '" />' . "\n";
                $html .= '<input id="' . $option_name . '" class="image_data_field" type="hidden" name="' . $option_name . '" value="' . $data . '"/><br/>' . "\n";
            break;

            case 'color':
                ?><div class="color-picker" style="position:relative;">
                    <input type="text" name="<?php esc_attr_e( $option_name ); ?>" class="color" value="<?php esc_attr_e( $data ); ?>" />
                    <div style="position:absolute;background:#FFF;z-index:99;border-radius:100%;" class="colorpicker"></div>
                </div>
                <?php
            break;

            case 'drag_list':  ?>
                <div>
                  
                    <ul class="workscout_drag_list">
                        <?php 
                  
                        foreach ( $field['options'] as $k => $v ) { ?>
                        <?php if(array_key_exists($k,(array)$data)){  ?>
                              <li>
                            
                            <input <?php if(array_key_exists($k,(array)$data)){
                                echo 'checked="checked"';
                            } ?> type="checkbox" id="<?php echo $option_name .'-'. $k; ?>" name="<?php esc_attr_e( $option_name ); ?>[<?php echo $k ?>]">
                            <label for="<?php echo $option_name .'-'. $k; ?>"><?php echo $v; ?></label>
                            <span class="handle dashicons dashicons-editor-justify ui-sortable-handle"></span>

                        </li>

                        <?php }
                        } ?>
                    </ul>
                </div>
            <?php
            break;
            
            case 'editor':
                wp_editor($data, $option_name, array(
                    'textarea_name' => $option_name,
                    'editor_height' => 150
                ) );
            break;

        }

        switch( $field['type'] ) {

            case 'checkbox_multi':
            case 'radio':
            case 'select_multi':
                $html .= '<br/><span class="description">' . $field['description'] . '</span>';
            break;
            case 'title':
                $html .= '<br/><h3 class="description '.$field['id'].' ">' . $field['description'] . '</h3>';
            break;

            default:
                if ( ! $post ) {
                    $html .= '<label for="' . esc_attr( $field['id'] ) . '">' . "\n";
                }
                if(isset($field['description']) && !empty($field['description'] )) {
                    $html .= '<span class="description">' . $field['description'] . '</span>' . "\n";    
                }
                

                if ( ! $post ) {
                    $html .= '</label>' . "\n";
                }
            break;
        }

        if ( ! $echo ) {
            return $html;
        }

        echo $html;

    }

    /**
     * Validate form field
     * @param  string $data Submitted value
     * @param  string $type Type of field to validate
     * @return string       Validated value
     */
    public function validate_field ( $data = '', $type = 'text' ) {

        switch( $type ) {
            case 'text': $data = esc_attr( $data ); break;
            case 'url': $data = esc_url( $data ); break;
            case 'email': $data = is_email( $data ); break;
        }

        return $data;
    }

    /**
     * Add meta box to the dashboard
     * @param string $id            Unique ID for metabox
     * @param string $title         Display title of metabox
     * @param array  $post_types    Post types to which this metabox applies
     * @param string $context       Context in which to display this metabox ('advanced' or 'side')
     * @param string $priority      Priority of this metabox ('default', 'low' or 'high')
     * @param array  $callback_args Any axtra arguments that will be passed to the display function for this metabox
     * @return void
     */
    public function add_meta_box ( $id = '', $title = '', $post_types = array(), $context = 'advanced', $priority = 'default', $callback_args = null ) {

        // Get post type(s)
        if ( ! is_array( $post_types ) ) {
            $post_types = array( $post_types );
        }

        // Generate each metabox
        foreach ( $post_types as $post_type ) {
            add_meta_box( $id, $title, array( $this, 'meta_box_content' ), $post_type, $context, $priority, $callback_args );
        }
    }

    /**
     * Display metabox content
     * @param  object $post Post object
     * @param  array  $args Arguments unique to this metabox
     * @return void
     */
    public function meta_box_content ( $post, $args ) {

        $fields = apply_filters( $post->post_type . '_custom_fields', array(), $post->post_type );

        if ( ! is_array( $fields ) || 0 == count( $fields ) ) return;

        echo '<div class="custom-field-panel">' . "\n";

        foreach ( $fields as $field ) {

            if ( ! isset( $field['metabox'] ) ) continue;

            if ( ! is_array( $field['metabox'] ) ) {
                $field['metabox'] = array( $field['metabox'] );
            }

            if ( in_array( $args['id'], $field['metabox'] ) ) {
                $this->display_meta_box_field( $field, $post );
            }

        }

        echo '</div>' . "\n";

    }

    /**
     * Dispay field in metabox
     * @param  array  $field Field data
     * @param  object $post  Post object
     * @return void
     */
    public function display_meta_box_field ( $field = array(), $post ) {

        if ( ! is_array( $field ) || 0 == count( $field ) ) return;

        $field = '<p class="form-field"><label for="' . $field['id'] . '">' . $field['label'] . '</label>' . $this->display_field( $field, $post, false ) . '</p>' . "\n";

        echo $field;
    }

    /**
     * Save metabox fields
     * @param  integer $post_id Post ID
     * @return void
     */
    public function save_meta_boxes ( $post_id = 0 ) {

        if ( ! $post_id ) return;

        $post_type = get_post_type( $post_id );

        $fields = apply_filters( $post_type . '_custom_fields', array(), $post_type );

        if ( ! is_array( $fields ) || 0 == count( $fields ) ) return;

        foreach ( $fields as $field ) {
            if ( isset( $_REQUEST[ $field['id'] ] ) ) {
                update_post_meta( $post_id, $field['id'], $this->validate_field( $_REQUEST[ $field['id'] ], $field['type'] ) );
            } else {
                update_post_meta( $post_id, $field['id'], '' );
            }
        }
    }

    /**
     * Main WordPress_Plugin_Template_Settings Instance
     *
     * Ensures only one instance of WordPress_Plugin_Template_Settings is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @see WordPress_Plugin_Template()
     * @return Main WordPress_Plugin_Template_Settings instance
     */
    public static function instance ( $parent ) {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self( $parent );
        }
        return self::$_instance;
    } // End instance()

    /**
     * Cloning is forbidden.
     *
     * @since 1.0.0
     */
    public function __clone () {
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
    } // End __clone()

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 1.0.0
     */
    public function __wakeup () {
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
    } // End __wakeup()

}

$settings = new WorkScout_Core_Admin( __FILE__ );