<?php


add_action( 'cmb2_admin_init', 'workscout_register_metabox_testimonial' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function workscout_register_metabox_testimonial() {
	$prefix = 'workscout_';
	$workscout_testimonials_mb = new_cmb2_box( array(
		'id'            => $prefix . 'testimonial_cmb2',
		'title'         => esc_html__('Testimonials info','workscout'),
		'object_types'  => array( 'testimonial', ), // Post type
		'priority'   => 'high',
	));

	$workscout_testimonials_mb->add_field( array(
		'name' => esc_html__('Author of testimonial','workscout'),
		'id'   => 'pp_author',
		'type' => 'text_medium',
	));	

	$workscout_testimonials_mb->add_field( array(
		'name' => esc_html__('Link to author\'s website (optional)','workscout'),
		'id'   => 'pp_link',
		'type' => 'text_medium',
	));	

	$workscout_testimonials_mb->add_field( array(
		'name' => esc_html__('Enter their position in their specific company.','workscout'),
		'id'   => 'pp_position',
		'type' => 'text_medium',
	));	

}	


add_action( 'cmb2_admin_init', 'workscout_register_metabox_job_listing' );
function workscout_register_metabox_job_listing() {
	
	
	/* get the registered sidebars */
    global $wp_registered_sidebars;

    $sidebars = array();
    foreach( $wp_registered_sidebars as $id=>$sidebar ) {
      $sidebars[ $id ] = $sidebar[ 'name' ];
    }

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	// $workscout_location_mb = new_cmb2_box( array(
	// 	'id'            => 'pp_job_locations_cmb2',
	// 	'title'         => esc_html__('Location settings','workscout'),
	// 	'object_types'  => array( 'job_listing' ), // Post type
	// 	'priority'   	=> 'high',
	// ) );

	// $workscout_location_mb->add_field( array(
	// 	'name'    => esc_html__('Latitude','workscout'),
	// 	'id'      => 'geolocation_lat',
	// 	'type'    => 'text',
	// ) );
	// $workscout_location_mb->add_field( array(
	// 	'name'    => esc_html__('Longitude','workscout'),
	// 	'id'      => 'geolocation_long',
	// 	'type'    => 'text',
	// ) );


}



add_action( 'cmb2_admin_init', 'workscout_register_metabox_header' );
function workscout_register_metabox_header() {

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$workscout_location_mb = new_cmb2_box( array(
		'id'            => 'pp_job_settings_cmb2',
		'title'         => esc_html__('Background image for header','workscout'),
		'object_types'  => array( 'job_listing','page','post' ),
		'priority'   	=> 'high',
	) );

	$workscout_location_mb->add_field( array(
		'name'       => esc_html__('Make header transparent ','workscout'),
        'desc'        => esc_html__('Works only if the "header background" image is added','workscout'),
		'id'      => 'pp_transparent_header',
		'type'    => 'checkbox',
	) );
	$workscout_location_mb->add_field( array(
		'name'    => esc_html__( 'Header background ', 'findeo' ),
		'desc'    => esc_html__( 'Set image for header, should be 1920px wide.', 'findeo' ),
		'id'      =>'pp_job_header_bg',
		'type'    => 'file',
		// Optional:

	) );


}



add_action( 'cmb2_admin_init', 'workscout_register_metabox_slider' );
function workscout_register_metabox_slider() {
	
  $revos = array();
  global $wpdb;
  // Table name
  $table_name = $wpdb->prefix . "revslider_sliders";
  // Get sliders
  if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
    $sliders = $wpdb->get_results( "SELECT alias, title FROM $table_name" );
  } else {
    $sliders = '';
  }

  // Iterate over the sliders
  if($sliders) {
    foreach($sliders as $key => $item) {
      $revos[$item->alias] = $item->title;
    }
  } else {
    $revos[] =  esc_html__('No Sliders Found','workscout');
  }


  $workscout_slider_mb = new_cmb2_box( array(
		'id'            => 'pp_metabox_slider_cmb2',
		'title'         =>  esc_html__('Slider settings','workscout'),
		'desc'      => esc_html__('Enable option below to dispay Revolution Slider on this page (the page template "Revolution Page" is now deprecated).','workscout'),
		'object_types'  => array( 'page' ),
		'priority'   	=> 'high',
	) );


  $workscout_slider_mb->add_field( array(
		'name'    => 	__( 'Display Revolution Slider on this page', 'workscout' ),
		'id'      =>	'pp_page_slider_status',
		'type'    => 	'checkbox',
		// Optional:

	) );

  $workscout_slider_mb->add_field( array(
		'name'    => 	esc_html__('Revolution Slider','workscout'),
		'id'      =>	'pp_page_layer',
		'type'    => 'select',
		
		'options' => $revos,

	) );

}




add_action( 'cmb2_admin_init', 'workscout_register_metabox_post_layout' );
function workscout_register_metabox_post_layout() {
	/* get the registered sidebars */
    global $wp_registered_sidebars;

    $sidebars = array();
    foreach( $wp_registered_sidebars as $id=>$sidebar ) {
      $sidebars[ $id ] = $sidebar[ 'name' ];
    }

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$workscout_posts_mb = new_cmb2_box( array(
		'id'            => 'pp_metabox_layout_cmb2',
		'title'     	=>    esc_html__('Layout','workscout'),
    	'desc'      	=> esc_html__('You can choose a sidebar from the list below. Sidebars can be created in the Theme Options and configured in the Appearance -> Widgets.','workscout'),
		'object_types'  => array('post' ),
		'priority'   	=> 'high',
	) );

	$workscout_posts_mb->add_field( array(
		'name'       => esc_html__('Layout ','workscout'),
        'desc'        => esc_html__('Works only if the "header background" image is added','workscout'),
		'id'      => 'pp_sidebar_layout',
		'type'    => 'radio_inline',
		'options' => array(
			'left-sidebar' => __( 'Left sidebar', 'workscout' ),
			'right-sidebar'   => __( 'Right sidebar', 'workscout' ),
		),
		'default' => 'left-sidebar',
	) );
	$workscout_posts_mb->add_field( array(
		'name'    => esc_html__( 'Select sidebar', 'workscout' ),
		'id'      => 'pp_sidebar_set',
		'options' => $sidebars,
		'type'    => 'select',
		// Optional:

	) );

	$workscout_pages_mb = new_cmb2_box( array(
		'id'            => 'pp_metabox_page_layout_cmb2',
		'title'     	=>    esc_html__('Layout','workscout'),
    	'desc'      	=> esc_html__('You can choose a sidebar from the list below. Sidebars can be created in the Theme Options and configured in the Appearance -> Widgets.','workscout'),
		'object_types'  => array('page' ),
		'priority'   	=> 'high',
	) );

	$workscout_pages_mb->add_field( array(
		'name'       => esc_html__('Titlebar ','workscout'),
        'desc'        => esc_html__('Titlebar status','workscout'),
		'id'      => 'pp_page_titlebar',
		'type'    => 'radio_inline',
		'options' => array(
			'on' => __( 'On', 'workscout' ),
			'off' => __( 'Off', 'workscout' ),
			
		),
		'default' => 'on',
	) );

	$workscout_pages_mb->add_field( array(
		'name'       => esc_html__('Layout ','workscout'),
        'desc'        => esc_html__('Works only if the "header background" image is added','workscout'),
		'id'      => 'pp_sidebar_layout',
		'type'    => 'radio_inline',
		'options' => array(
			'left-sidebar' => __( 'Left sidebar', 'workscout' ),
			'full-width' => __( 'Full Width', 'workscout' ),
			'right-sidebar'   => __( 'Right sidebar', 'workscout' ),
		),
		'default' => 'left-sidebar',
	) );
	$workscout_pages_mb->add_field( array(
		'name'    => esc_html__( 'Select sidebar', 'workscout' ),
		'id'      => 'pp_sidebar_set',
		'options' => $sidebars,
		'type'    => 'select',
		// Optional:

	) );

}


add_action( 'cmb2_admin_init', 'workscout_register_page_jobs' );
function workscout_register_page_jobs() {

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$workscout_jobs_mb = new_cmb2_box( array(
		'id'            => 'pp_metabox_job_settings_cmb2',
		'title'         => esc_html__('Background image for header','workscout'),
		'object_types'  => array( 'job_listing','page','post' ),
		'priority'   	=> 'high',
	) );

	$workscout_jobs_mb->add_field( array(
		'name'       => esc_html__('Location/resume filter ','workscout'),
        'desc'        => esc_html__('set to OFF to hide it from filters','workscout'),
		'id'      => 'pp_jobs_filters_locreg_widget',
		'type'    => 'radio_inline',
		'options' => array(
			'on' => __( 'On', 'workscout' ),
			'off' => __( 'Off', 'workscout' ),
			
		),
		'default' => 'on',
	) );
	$workscout_jobs_mb->add_field( array(
		'name'       => esc_html__('Job types filter','workscout'),
        'desc'        => esc_html__('set to OFF to hide it from filters','workscout'),
		'id'      => 'pp_jobs_filters_types_widget',
		'type'    => 'radio_inline',
		'options' => array(
			'on' => __( 'On', 'workscout' ),
			'off' => __( 'Off', 'workscout' ),
		),
		'default' => 'on',
	) );
	$workscout_jobs_mb->add_field( array(
		'name'       => esc_html__('Job categories filter','workscout'),
        'desc'        => esc_html__('set to OFF to hide it from filters','workscout'),
		'id'      => 'pp_jobs_filters_categories_widget',
		'type'    => 'radio_inline',
		'options' => array(
			'on' => __( 'On', 'workscout' ),
			'off' => __( 'Off', 'workscout' ),
		),
		'default' => 'on',
	) );
	$workscout_jobs_mb->add_field( array(
		'name'       => esc_html__('Salary filter','workscout'),
        'desc'        => esc_html__('set to OFF to hide it from filters','workscout'),
		'id'      => 'pp_jobs_filters_salary_widget',
		'type'    => 'radio_inline',
		'options' => array(
			'on' => __( 'On', 'workscout' ),
			'off' => __( 'Off', 'workscout' ),
		),
		'default' => 'on',
	) );
	$workscout_jobs_mb->add_field( array(
		'name'       => esc_html__('Rate filter','workscout'),
        'desc'        => esc_html__('set to OFF to hide it from filters','workscout'),
		'id'      => 'pp_jobs_filters_rate_widget',
		'type'    => 'radio_inline',
		'options' => array(
			'on' => __( 'On', 'workscout' ),
			'off' => __( 'Off', 'workscout' ),
		),
		'default' => 'on',
	) );	
	$workscout_jobs_mb->add_field( array(
		'name'       => esc_html__('Job tags  filter','workscout'),
        'desc'        => esc_html__('set to OFF to hide it from filters','workscout'),
		'id'      => 'pp_jobs_filters_tags_widget',
		'type'    => 'radio_inline',
		'options' => array(
			'on' => __( 'On', 'workscout' ),
			'off' => __( 'Off', 'workscout' ),
		),
		'default' => 'on',
	) );


}


?>