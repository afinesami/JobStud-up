<?php
class Workscout_Forms_And_Fields_Editor {


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
     * The version number.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $_version;

	/**
     * Initiate our hooks
     * @since 0.1.0
     */
	public function __construct($file = '', $version = '1.0.0') {
        $this->_version = $version;
        add_action( 'admin_menu', array( $this, 'add_options_page' ) ); //create tab pages
        add_action('admin_enqueue_scripts', array( $this, 'enqueue_scripts_and_styles' ) ); 

        // Load plugin environment variables
        
        include( 'class-workscout-forms-builder.php' );
        //include( 'includes/class-workscout-fields-builder.php' );
        //include( 'includes/class-workscout-reviews-criteria.php' );
        //include( 'includes/class-workscout-user-fields-builder.php' );
        //include( 'includes/class-workscout-submit-builder.php' );
        //include( 'includes/class-workscout-import-export.php' );


        //$this->forms  = Workscout_Forms_Editor::instance();
        // $this->fields  = Workscout_Fields_Editor::instance();
        // $this->submit  = Workscout_Submit_Editor::instance();
        //$this->users  = Workscout_User_Fields_Editor::instance();
        //$this->import_export  = Workscout_Forms_Import_Export::instance();
        // $this->reviews_criteria  = Workscout_Reviews_Criteria::instance();
        
        add_action( 'admin_init', array( $this,'workscout_process_settings_export' ));
        add_action( 'admin_init', array( $this,'workscout_process_settings_import' ));
        
    }


    public function enqueue_scripts_and_styles($hook){

    if ( !in_array( $hook, array('workscout-editor_page_workscout-submit-builder','workscout-editor_page_workscout-forms-builder','workscout-editor_page_workscout-fields-builder','workscout-editor_page_workscout-reviews-criteria') ) ){
        return;
    }

        wp_enqueue_script('workscout-fafe-script', esc_url( $this->assets_url ) . 'js/admin.js', array('jquery','jquery-ui-droppable','jquery-ui-draggable', 'jquery-ui-sortable', 'jquery-ui-dialog','jquery-ui-resizable'));
        
        wp_register_style( 'workscout-fafe-styles', esc_url( $this->assets_url ) . 'css/admin.css', array(), $this->_version );
        
        wp_enqueue_style( 'workscout-fafe-styles' );
        wp_enqueue_style( 'wp-jquery-ui-dialog' );
    }

      /**
     * Add menu options page
     * @since 0.1.0
     */
    public function add_options_page() {        
        
            //add_menu_page('Workscout Forms', 'Workscout Editor', 'manage_options', 'workscout_settings',array( $this, 'output' ));
               
            add_submenu_page( 'workscout_settings', 'Search Forms Editor', 'Search Form Editor', 'manage_options', 'workscout_search', array( $this, 'output' ));
    }

    public function output(){ 
        ?>
        <?php
    }

   
    /**
         * Process a settings export that generates a .json file of the shop settings
         */
        function workscout_process_settings_export() {

            if( empty( $_POST['workscout_action'] ) || 'export_settings' != $_POST['workscout_action'] )
                return;

            if( ! wp_verify_nonce( $_POST['workscout_export_nonce'], 'workscout_export_nonce' ) )
                return;

            if( ! current_user_can( 'manage_options' ) )
                return;

            $settings = array();
            $settings['property_types']         = get_option('workscout_property_types_fields');
            $settings['property_rental']        = get_option('workscout_rental_periods_fields');
            $settings['property_offer_types']   = get_option('workscout_offer_types_fields');

            $settings['submit']                 = get_option('workscout_submit_form_fields');
            
            $settings['price_tab']              = get_option('workscout_price_tab_fields');
            $settings['main_details_tab']       = get_option('workscout_main_details_tab_fields');
            $settings['details_tab']            = get_option('workscout_details_tab_fields');
            $settings['location_tab']           = get_option('workscout_locations_tab_fields');

            $settings['sidebar_search']         = get_option('workscout_sidebar_search_form_fields');
            $settings['full_width_search']      = get_option('workscout_full_width_search_form_fields');
            $settings['half_map_search']        = get_option('workscout_search_on_half_map_form_fields');
            $settings['home_page_search']       = get_option('workscout_search_on_home_page_form_fields');
            $settings['home_page_alt_search']   = get_option('workscout_search_on_home_page_alt_form_fields');

            ignore_user_abort( true );

            nocache_headers();
            header( 'Content-Type: application/json; charset=utf-8' );
            header( 'Content-Disposition: attachment; filename=workscout-settings-export-' . date( 'm-d-Y' ) . '.json' );
            header( "Expires: 0" );

            echo json_encode( $settings );
            exit;
        }

        /**
     * Process a settings import from a json file
     */
    function workscout_process_settings_import() {

        if( empty( $_POST['workscout_action'] ) || 'import_settings' != $_POST['workscout_action'] )
            return;

        if( ! wp_verify_nonce( $_POST['workscout_import_nonce'], 'workscout_import_nonce' ) )
            return;

        if( ! current_user_can( 'manage_options' ) )
            return;

        $extension = end( explode( '.', $_FILES['import_file']['name'] ) );

        if( $extension != 'json' ) {
            wp_die( __( 'Please upload a valid .json file' ) );
        }

        $import_file = $_FILES['import_file']['tmp_name'];

        if( empty( $import_file ) ) {
            wp_die( __( 'Please upload a file to import' ) );
        }

        // Retrieve the settings from the file and convert the json object to an array.
        $settings = json_decode( file_get_contents( $import_file ), true );

        update_option('workscout_property_types_fields'   ,$settings['property_types']);
        update_option('workscout_rental_periods_fields'   ,$settings['property_rental']);
        update_option('workscout_offer_types_fields'      ,$settings['property_offer_types']);

        update_option('workscout_submit_form_fields'      ,$settings['submit']);

        update_option('workscout_price_tab_fields'        ,$settings['price_tab']);
        update_option('workscout_main_details_tab_fields' ,$settings['main_details_tab']);
        update_option('workscout_details_tab_fields'      ,$settings['details_tab']);
        update_option('workscout_locations_tab_fields'    ,$settings['location_tab']);

        update_option('workscout_sidebar_search_form_fields',$settings['sidebar_search']);
        update_option('workscout_full_width_search_form_fields',$settings['full_width_search']);
        update_option('workscout_search_on_half_map_form_fields',$settings['half_map_search']);
        update_option('workscout_search_on_home_page_form_fields',$settings['home_page_search']);
        update_option('workscout_search_on_home_page_alt_form_fields',$settings['home_page_alt_search']);

       
        wp_safe_redirect( admin_url( 'admin.php?page=workscout-fields-and-form&import=success' ) ); exit;

    }

 
}

$Workscout_Form_Editor = new Workscout_Forms_And_Fields_Editor();