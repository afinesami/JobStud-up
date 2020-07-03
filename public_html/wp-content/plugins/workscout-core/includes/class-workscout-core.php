<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WorkScout_Core {

	/**
	 * The single instance of WorkScout_Core.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * Settings class object
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = null;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_version;

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
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct ( $file = '', $version = '1.0.2' ) {
		$this->_version = $version;
		
		$this->_token = 'workscout_core';

		// Load plugin environment variables
		$this->file = $file;
		$this->dir = dirname( $this->file );
		$this->assets_dir = trailingslashit( $this->dir ) . 'assets';
		$this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) );

		$this->script_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		register_activation_hook( $this->file, array( $this, 'install' ) );


		define( 'WORKSCOUT_CORE_ASSETS_DIR', trailingslashit( $this->dir ) . 'assets' );
		define( 'WORKSCOUT_CORE_ASSETS_URL', esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) ) );
		

		//include( 'class-workscout-core-admin.php' );
		include( 'class-workscout-core-fields.php' );
		include( 'class-workscout-core-registration.php' );
		include( 'class-workscout-core-search.php' );
		include( 'class-workscout-core-shortcodes.php' );
		include( 'class-workscout-core-wpjm-settings.php' );
		include( 'class-workscout-core-wpjm.php' );
		include( 'class-workscout-core-activities-log.php' );
		include( 'class-workscout-core-emails.php' );
		include( 'class-workscout-core-messages.php' );
		//include( 'class-workscout-core-editor.php' );
	
		// Load frontend JS & CSS
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 10 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10 );

		// Load admin JS & CSS
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 10, 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles' ), 10, 1 );

		add_filter('cron_schedules',array( $this, 'workscout_cron_schedules'));
		 
		 $this->fields 			= new WorkScout_Core_Fields();
		 $this->registration 	= new WorkScout_Core_Registration();
		 $this->search 			= new WorkScout_Core_Search();
		 $this->shortcodes 		= new WorkScout_Core_Shortcodes();
		 $this->wpjm_settings 	= new WorkScout_Core_WPJM_Settings();
		 $this->wpjm 			= new WorkScout_Core_WPJM();
		 $this->emails 			= WorkScout_Core_Emails::instance();
		 $this->activities 		= new Workscout_Core_Activities_Log();
		 $this->messages 		= new Workscout_Core_Messages();
		 
		
		
		// Handle localisation
		$this->load_plugin_textdomain();
		add_action( 'init', array( $this, 'load_localisation' ), 0 );
		add_action( 'init', array( $this, 'image_size' ) );
		
		
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );
		add_action( 'after_setup_theme', array( $this, 'include_template_functions' ), 11 );
		
		
		add_action( 'admin_notices', array( $this, 'google_api_notice' ));

			// Schedule cron jobs
		self::maybe_schedule_cron_jobs();

	} // End __construct ()
	  
	/**
	 * Widgets init
	 */
	public function widgets_init() {
		//include( 'class-workscout-core-widgets.php' );
	}


	public function include_template_functions() {
		include( WORKSCOUT_PLUGIN_DIR.'/workscout-core-template-functions.php' );
	}

	/**
	 * Load frontend CSS.
	 * @access  public
	 * @since   1.0.0
	 * @return void
	 */
	public function enqueue_styles () {
		//wp_register_style( $this->_token . '-frontend', esc_url( $this->assets_url ) . 'css/frontend.css', array(), $this->_version );
		//wp_enqueue_style( $this->_token . '-frontend' );
		wp_enqueue_style( 'select2' );
		

	} // End enqueue_styles ()



	/**
	 * Load frontend Javascript.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function enqueue_scripts () {
		
		// wp_register_script(	'dropzone', esc_url( $this->assets_url ) . 'js/dropzone.js', array( 'jquery' ), $this->_version, true );
		
		wp_register_script( $this->_token . '-leaflet-markercluster', esc_url( $this->assets_url ) . 'js/leaflet.markercluster.js', array( 'jquery' ), $this->_version );
		wp_register_script( $this->_token . '-leaflet-geocoder', esc_url( $this->assets_url ) . 'js/control.geocoder.js', array( 'jquery' ), $this->_version );
		wp_register_script( $this->_token . '-leaflet-search', esc_url( $this->assets_url ) . 'js/leaflet-search.src.js', array( 'jquery' ), $this->_version );
		wp_register_script( $this->_token . '-leaflet-bing-layer', esc_url( $this->assets_url ) . 'js/leaflet-bing-layer.min.js', array( 'jquery' ), $this->_version );
		wp_register_script( $this->_token . '-leaflet-google-maps', esc_url( $this->assets_url ) . 'js/leaflet-googlemutant.js', array( 'jquery' ), $this->_version );
		wp_register_script( $this->_token . '-leaflet-tilelayer-here', esc_url( $this->assets_url ) . 'js/leaflet-tilelayer-here.js', array( 'jquery' ), $this->_version );
		wp_register_script( $this->_token . '-leaflet-gesture-handling', esc_url( $this->assets_url ) . 'js/leaflet-gesture-handling.min.js', array( 'jquery' ), $this->_version );
		wp_register_script( $this->_token . '-leaflet', esc_url( $this->assets_url ) . 'js/workscout.leaflet.js', array( 'jquery' ), $this->_version );
		wp_register_script( $this->_token . '-recaptchav3', esc_url( $this->assets_url ) . 'js/recaptchav3.js', array( 'jquery' ), $this->_version );

		wp_register_script( $this->_token . '-contact-leaflet', esc_url( $this->assets_url ) . 'js/workscout.contact.leaflet.js', array( 'jquery' ), $this->_version );

		wp_register_script( $this->_token . '-google-autocomplete', esc_url( $this->assets_url ) . 'js/workscout.google.autocomplete.js', array( 'jquery' ), $this->_version );

		wp_register_script( $this->_token . '-map', esc_url( $this->assets_url ) . 'js/workscout.map.min.js', array( 'jquery' ), $this->_version );
		

		wp_register_script( $this->_token . '-frontend', esc_url( $this->assets_url ) . 'js/frontend.js', array( 'jquery' ), $this->_version );
		
		wp_register_script(	'markerclusterer', esc_url( $this->assets_url )  . '/js/markerclusterer.min.js', array( 'jquery' ), $this->_version );
		wp_register_script( 'infobox-min', esc_url( $this->assets_url )  . '/js/infobox.min.js', array( 'jquery' ), $this->_version  );
		wp_register_script( 'jquery-geocomplete-min',esc_url( $this->assets_url )  . '/js/jquery.geocomplete.min.js', array( 'jquery','maps' ), $this->_version  );

		wp_register_script( 'workscout-map', esc_url( $this->assets_url )  . '/js/workscout.map.min.js', array( 'jquery','markerclusterer' ), $this->_version  );
		
		wp_register_script( 'workscout-single-map', esc_url( $this->assets_url )  . '/js/workscout.single.map.min.js', array( 'jquery','markerclusterer' ), $this->_version  );

		$map_provider = get_option( 'workscout_map_provider');
		$maps_api_key = get_option( 'workscout_maps_api' );

		if(class_exists('Kirki')) :
			$map 		=  Kirki::get_option( 'workscout', 'pp_enable_jobs_map', 0 ); 
			$map_resume =  Kirki::get_option( 'workscout', 'pp_enable_resumes_map', 0 ); 
			$map_resume =  Kirki::get_option( 'workscout', 'pp_enable_resumes_map', 0 ); 
			$geocode 	=  Kirki::get_option( 'workscout','pp_maps_geocode', 0);
			$max_zoom 	=  Kirki::get_option( 'workscout','pp_maps_max_zoom', 0);
		endif;
		
		if($map_provider != "none"):

			wp_enqueue_script( 'leaflet.js', esc_url( $this->assets_url ) . 'js/leaflet.js');
			
			$map_provider = get_option('workscout_map_provider');
			if( $map_provider == 'bing'){
				wp_enqueue_script('polyfill','https://cdn.polyfill.io/v2/polyfill.min.js?features=Promise');
				wp_enqueue_script($this->_token . '-leaflet-bing-layer');
				
			}
			if( $map_provider == 'here' ){
				wp_enqueue_script($this->_token . '-leaflet-tilelayer-here');
			}
			if( $map_provider == 'google' ){
				wp_enqueue_script( 'google-maps', 'https://maps.google.com/maps/api/js?key='.$maps_api_key.'&libraries=places' );
			}
			wp_enqueue_script($this->_token . '-leaflet-google-maps');
			wp_enqueue_script( $this->_token . '-leaflet-geocoder' );
			wp_enqueue_script( $this->_token . '-leaflet-markercluster' );
			wp_enqueue_script( $this->_token . '-leaflet-gesture-handling' );
			wp_enqueue_script( $this->_token . '-leaflet' );

			if(get_option('workscout_map_address_provider') == 'google'){
				wp_enqueue_script( 'google-maps', 'https://maps.google.com/maps/api/js?key='.$maps_api_key.'&libraries=places' );
				wp_enqueue_script( $this->_token . '-google-autocomplete' );	
			}
			if ( is_page_template( 'template-contact.php' ) ) {

				wp_enqueue_script( $this->_token . '-contact-leaflet' );
				$map_points = Kirki::get_option( 'workscout','pp_new_contact_map', array());
				
				wp_localize_script(  $this->_token . '-contact-leaflet' , 'wscontactmap',
				    array(
				        'markers'	=> json_encode($map_points)
				        )
				    );
				
			}
			if(class_exists('Kirki')) :
				wp_localize_script(  $this->_token . '-leaflet' , 'wsmap',
				    array(
				        'marker_color'	=> Kirki::get_option( 'workscout','pp_maps_marker_color', '#888'),
				    	'use_clusters'	=> (bool) Kirki::get_option( 'workscout','pp_maps_clusters', 1) == 1 ? true : false,
				    	'autofit'		=> Kirki::get_option( 'workscout','pp_maps_autofit', 1) == 1 ? true : false,
				    	'default_zoom'	=> Kirki::get_option( 'workscout','pp_maps_default_zoom', '10'),
				    	'map_type'		=> Kirki::get_option( 'workscout','pp_maps_type', 'ROADMAP'),
				    	'scroll_zoom'	=> Kirki::get_option( 'workscout','pp_maps_scroll_zoom', 1) == 1 ? true : false,
				    	/*'max_zoom'		=> empty($max_zoom) ? null : $max_zoom,*/
				    	'geocode'			=> !empty(get_option( 'workscout_maps_api_server')) ? true : false,
				    	'address_provider'	=> get_option('workscout_map_address_provider','osm'),
				    	'centerPoint'		=> !empty(get_option('workscout_map_center_point')) ? get_option('workscout_map_center_point') : '-34.397,150.644',
				    	'country'			=> get_option( 'workscout_maps_limit_country'),
				    	"maps_autolocate" 	=> get_option('workscout_map_autolocate'),
				        )
				    );
			endif;
		else:
			wp_localize_script(  $this->_token . '-frontend' , 'wsmap',
				    array(
				    	'address_provider'	=> 'off',
				        )
				    );
		endif;

		// }	

		wp_enqueue_script( 'select2' );
		
		$recaptcha_status = get_option('workscout_recaptcha');
		$recaptcha_version = get_option('workscout_recaptcha_version');
		$recaptcha_sitekey3 = get_option('workscout_recaptcha_sitekey3');
		if(is_user_logged_in()){
			$recaptcha_status = false;
		}
		if(!empty($recaptcha_status) && $recaptcha_version == 'v3' && !empty($recaptcha_sitekey3)){
			wp_enqueue_script( 'google-recaptcha', 'https://www.google.com/recaptcha/api.js?render='.trim($recaptcha_sitekey3));	
			wp_enqueue_script( $this->_token . '-recaptchav3' );
		}
		if(!empty($recaptcha_status) && $recaptcha_version == 'v2'){
			wp_enqueue_script( 'google-recaptcha', 'https://www.google.com/recaptcha/api.js' );
		}
		

		// $_price_min =  $this->get_min_all_listing_price('');
		// $_price_max =  $this->get_max_all_listing_price('');


		$ajax_url = admin_url( 'admin-ajax.php', 'relative' );
		// $currency = get_option( 'workscout_currency' );
		// $currency_symbol = WorkScout_Core_Listing::get_currency_symbol($currency); 
		
		$localize_array = array(
				'ajax_url'                	=> $ajax_url,
				'is_rtl'                  	=> is_rtl() ? 1 : 0,
				'lang'                    	=> defined( 'ICL_LANGUAGE_CODE' ) ? ICL_LANGUAGE_CODE : '', // WPML workaround until this is standardized
				'loadingmessage' 			=> esc_html__('Sending user info, please wait...','workscout_core'),
				'submitCenterPoint'		    => get_option( 'workscout_submit_center_point','52.2296756,21.012228700000037' ),
				'centerPoint'		      	=> get_option( 'workscout_map_center_point','52.2296756,21.012228700000037' ),
				'country'		      		=> get_option( 'workscout_maps_limit_country' ),
				'upload'					=> admin_url( 'admin-ajax.php?action=handle_dropped_media' ),
  				'delete'					=> admin_url( 'admin-ajax.php?action=handle_delete_media' ),
  				'color'						=> get_option('pp_main_color','#274abb' ), 
  				"autologin" 				=> get_option('workscout_autologin'),
		        "map_provider" 				=> get_option('workscout_map_provider','osm'),
		        "mapbox_access_token" 		=> get_option('workscout_mapbox_access_token'),
		        "mapbox_retina" 			=> get_option('workscout_mapbox_retina'),
		        "bing_maps_key" 			=> get_option('workscout_bing_maps_key'),
		        "thunderforest_api_key" 	=> get_option('workscout_thunderforest_api_key'),
		        "here_app_id" 				=> get_option('workscout_here_app_id'),
		        "here_app_code" 			=> get_option('workscout_here_app_code'),
		        "category_title" 			=> esc_html__('Category Title','workscout_core'),
	            "radius_state" 				=> get_option('workscout_radius_state'),
	            "radius_default" 			=> get_option('workscout_maps_default_radius'),
	            "recaptcha_status" 			=> $recaptcha_status,
	            "recaptcha_version" 		=> $recaptcha_version,
	            "recaptcha_sitekey3" 		=> trim($recaptcha_sitekey3)


			);
		
		wp_enqueue_script(   $this->_token . '-frontend');		
		
		wp_localize_script(  $this->_token . '-frontend', 'workscout_core', $localize_array);

		wp_enqueue_script( 'jquery-ui-core' );
		
		wp_enqueue_script( 'jquery-ui-autocomplete' );

		wp_enqueue_script( 'jquery-ui-sortable' );
		
		//wp_enqueue_script( $this->_token . '-frontend' );
		
		
	} // End enqueue_scripts ()

	/**
	 * Load admin CSS.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function admin_enqueue_styles ( $hook = '' ) {
		wp_register_style( $this->_token . '-admin', esc_url( $this->assets_url ) . 'css/admin.css', array(), $this->_version );
		wp_enqueue_style( $this->_token . '-admin' );
	} // End admin_enqueue_styles ()

	/**
	 * Load admin Javascript.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function admin_enqueue_scripts ( $hook = '' ) {
		
		wp_register_script( $this->_token . '-settings', esc_url( $this->assets_url ) . 'js/settings.js', array( 'jquery' ), $this->_version );
		wp_enqueue_script( $this->_token . '-settings' );
		wp_register_script( $this->_token . '-admin', esc_url( $this->assets_url ) . 'js/admin' . $this->script_suffix . '.js', array( 'jquery' ), $this->_version );
		wp_enqueue_script( $this->_token . '-admin' );
		

		$map_provider = get_option( 'workscout_map_provider');
		$maps_api_key = get_option( 'workscout_maps_api' );
		if($map_provider == 'google') {
			if($maps_api_key) {
				wp_enqueue_script( 'google-maps', 'https://maps.google.com/maps/api/js?key='.$maps_api_key.'&libraries=places' );	
				wp_register_script( $this->_token . '-admin-maps', esc_url( $this->assets_url ) . 'js/admin.maps' . $this->script_suffix . '.js', array( 'jquery' ), $this->_version );
				wp_enqueue_script( $this->_token . '-admin-maps' );
			
			}
		} else {
			wp_enqueue_script( 'leaflet.js', esc_url( $this->assets_url ) . 'js/leaflet.js');
			wp_enqueue_script( 'leaflet-geocoder',esc_url( $this->assets_url ) . 'js/control.geocoder.js');
			wp_register_script( $this->_token . '-admin-leaflet', esc_url( $this->assets_url ) . 'js/admin.leaflet' . $this->script_suffix . '.js', array( 'jquery' ), $this->_version );
			wp_enqueue_script( $this->_token . '-admin-leaflet' );
			
		}
		wp_enqueue_script('jquery-ui-datepicker');
		if(function_exists('workscout_date_time_wp_format')) {
			$convertedData = workscout_date_time_wp_format();
	        // add converented format date to javascript
	        wp_localize_script(  $this->_token . '-admin', 'wordpress_date_format', $convertedData );
        }
	} // End admin_enqueue_scripts ()

	/**
	 * Load plugin localisation
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_localisation () {
		load_plugin_textdomain( 'workscout_core', false, dirname( plugin_basename( $this->file ) ) . '/languages/' );

	} // End load_localisation ()

	
	public static function maybe_schedule_cron_jobs() {
	
		if ( ! wp_next_scheduled( 'workscout_core_check_for_new_messages' ) ) {
			
			wp_schedule_event( time(), '30min', 'workscout_core_check_for_new_messages' );
		}
	}
	
	function workscout_cron_schedules($schedules){
	    if(!isset($schedules["5min"])){
	        $schedules["5min"] = array(
	            'interval' => 5*60,
	            'display' => __('Once every 5 minutes'));
	    }
	    if(!isset($schedules["30min"])){
	        $schedules["30min"] = array(
	            'interval' => 30*60,
	            'display' => __('Once every 30 minutes'));
	    }
	    return $schedules;
	}
	/**
	 * Adds image sizes
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function image_size () {
		add_image_size('workscout-gallery', 1200, 0, true);
		add_image_size('workscout-listing-grid', 520, 397, true);
		add_image_size('workscout_core-avatar', 590, 590, true);
		add_image_size('workscout_core-preview', 200, 200, true);

	} // End load_localisation ()

	public function register_sidebar () {

		register_sidebar( array(
			'name'          => esc_html__( 'Single listing sidebar', 'workscout_core' ),
			'id'            => 'sidebar-listing',
			'description'   => esc_html__( 'Add widgets here.', 'workscout_core' ),
			'before_widget' => '<div id="%1$s" class="listing-widget widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title margin-bottom-35">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Listings sidebar', 'workscout_core' ),
			'id'            => 'sidebar-listings',
			'description'   => esc_html__( 'Add widgets here.', 'workscout_core' ),
			'before_widget' => '<div id="%1$s" class="listing-widget widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title margin-bottom-35">',
			'after_title'   => '</h3>',
		) );		



	} // End load_localisation ()


	
		function google_api_notice() {
		
		$map_provider = get_option( 'workscout_map_provider');
		$maps_api_key = get_option( 'workscout_maps_api' );
		if($map_provider == 'google') {

			if(empty($maps_api_key)) {
			    ?>
			    <div class="error notice">
					<p><?php echo esc_html_e('Please configure Google Maps API key to use all WorkScout features.') ?> <a href="http://www.docs.purethemes.net/workscout/knowledge-base/getting-google-maps-api-key/"><?php esc_html_e('Check here how to do it.','workscout_core') ?></a></p>
			    	
			        
			    </div>
			    <?php
			}
		}
		$wpjm_api_key = get_option('job_manager_google_maps_api_key');
		if(empty($wpjm_api_key)) {
		?>
		<div class="error notice">
					<p><?php echo esc_html_e('Please add unrestricted Google Maps API key to Job Listings Settings to geocode jobs - that is required to show them on maps and search by locations.') ?> <a href="https://wpjobmanager.com/document/geolocation-with-googles-maps-api/"><?php esc_html_e('Check here how to do it.','workscout_core') ?></a></p>
			    	
			        
			    </div>
		<?php
		}

	}
	/**
	 * Load plugin textdomain
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_plugin_textdomain () {
	    $domain = 'workscout_core';

	    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	    load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
	    load_plugin_textdomain( $domain, false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_plugin_textdomain ()

	/**
	 * Main WorkScout_Core Instance
	 *
	 * Ensures only one instance of WorkScout_Core is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see WorkScout_Core()
	 * @return Main WorkScout_Core instance
	 */
	public static function instance ( $file = '', $version = '1.2.1' ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $file, $version );
		}
		return self::$_instance;
	} // End instance ()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?','workscout_core' ), $this->_version );
	} // End __clone ()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?','workscout_core' ), $this->_version );
	} // End __wakeup ()

	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install () {
		$this->_log_version_number();
		//$this->init_user_roles();
	} // End install ()

	/**
	 * Log the plugin version number.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number () {
		update_option( $this->_token . '_version', $this->_version );
	} // End _log_version_number ()



	function init_user_roles(){
		global $wp_roles;

		if ( class_exists( 'WP_Roles' ) && ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}
 
		if ( is_object( $wp_roles ) ) {
				remove_role( 'owner' );
				add_role( 'owner', __( 'Owner', 'workscout_core' ), array(
					'read'                 => true,
					'upload_files'         => true,
					'edit_listing'         => true,
					'edit_posts'         => true,
					'read_listing'         => true,
					'delete_listing'       => true,
					'edit_listings'        => true,
					'delete_listings'      => true,
					'edit_listings'        => true,
					'assign_listing_terms' => true,
					
			) );

			$capabilities = array(
				'core' => array(
					'manage_listings'
				),
				'listing' => array(
					"edit_listing",
					"read_listing",
					"delete_listing",
					"edit_listings",
					"edit_others_listings",
					"publish_listings",
					"read_private_listings",
					"delete_listings",
					"delete_private_listings",
					"delete_published_listings",
					"delete_others_listings",
					"edit_private_listings",
					"edit_published_listings",
					"manage_listing_terms",
					"edit_listing_terms",
					"delete_listing_terms",
					"assign_listing_terms"
				));

				add_role( 'guest', __( 'Guest', 'workscout_core' ), array(
						'read'  => true,
				) );

			foreach ( $capabilities as $cap_group ) {
				foreach ( $cap_group as $cap ) {
					$wp_roles->add_cap( 'administrator', $cap );
				}
			}
		}

	}
	
}