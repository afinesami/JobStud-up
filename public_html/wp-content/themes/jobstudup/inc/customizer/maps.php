<?php 
Kirki::add_section( 'maps', array(
    'title'          => esc_html__( 'Maps Options', 'workscout'  ),
    'description'    => esc_html__( 'Maps related options', 'workscout'  ),
    'panel'          => '', // Not typically needed.
    'priority'       => 24,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );


	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'     => 'pp_enable_jobs_map',
	    'label'       => esc_html__( 'Enable map on Jobs page', 'workscout' ),
	    'section'     => 'maps',
	    'default'     => 0,
	    'priority'    => 10,
	) );


	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'     => 'pp_enable_all_jobs_map',
	    'label'       => esc_html__( 'Use all jobs map', 'workscout' ),
	    'description' => __( 'If enabled map will show ALL your jobs instead of the jobs currently filteres/searched for. ', 'workscout' ),
	    'section'     => 'maps',
	    'default'     => 0,
	    'priority'    => 10,
	    'active_callback'  => array(
			array(
				'setting'  => 'pp_enable_jobs_map',
				'operator' => '==',
				'value'    => 1,
			),
		)
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'     => 'pp_enable_resumes_map',
	    'label'       => esc_html__( 'Enable map on Resumes page', 'workscout' ),
	    'section'     => 'maps',
	    'default'     => 0,
	    'priority'    => 10,
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'     => 'pp_enable_all_resumes_map',
	    'label'       => esc_html__( 'Use all resumes map', 'workscout' ),
	    'description' => __( 'If enabled map will show ALL your resumes instead of the resumes currently filteres/searched for. ', 'workscout' ),
	    'section'     => 'maps',
	    'default'     => 0,
	    'priority'    => 10,
	    'active_callback'  => array(
			array(
				'setting'  => 'pp_enable_resumes_map',
				'operator' => '==',
				'value'    => 1,
			),
		)
	) );

	

	Kirki::add_field( 'workscout', array(
		'type'        => 'dimension',
		'settings'    => 'pp_map_height',
		'label'       => __( 'Map height', 'workscout' ),
		'section'     => 'maps',
		'default'     => '400px',
		'priority'    => 10,
	) );


	Kirki::add_field( 'workscout', array(
	    'type'        => 'color',
	    'settings'     => 'pp_maps_marker_color',
	    'label'       => esc_html__( 'Marker color', 'workscout' ),
	    'section'     => 'maps',
	    'default'     => '#808080',
	    'priority'    => 10,
	) );	

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'     => 'pp_maps_marker_color_job_type',
	    'label'       => esc_html__( 'Use Job Type color for markers color', 'workscout' ),
	    'section'     => 'maps',
	    'default'     => 0,
	    'priority'    => 10,
	) );	

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'     => 'pp_maps_clusters',
	    'label'       => esc_html__( 'Group nearby markes in clusters', 'workscout' ),
	    'section'     => 'maps',
	    'default'     => 1,
	    'priority'    => 10,
	) );		
	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'     => 'pp_maps_autofit',
	    'label'       => esc_html__( 'Autofit all job markers on map', 'workscout' ),
	    'section'     => 'maps',
	    'default'     => 1,
	    'priority'    => 10,
	) );
	Kirki::add_field( 'workscout', array(
	    'type'        => 'select',
	    'settings'     => 'pp_maps_default_zoom',
	    'label'       => esc_html__( 'Default zoom level', 'workscout' ),
	    'section'     => 'maps',
	    'default'     => '10',
	    'choices'     => array(
			'1' 	=> '1',
			'2' 	=> '2',
			'3' 	=> '3',
			'4' 	=> '4',
			'5' 	=> '5',
			'6' 	=> '6',
			'7' 	=> '7',
			'8' 	=> '8',
			'9' 	=> '9',
			'10' 	=> '10',
			'11' 	=> '11',
			'12' 	=> '12',
			'13' 	=> '13',
			'14' 	=> '14',
			'15' 	=> '15',
			'16' 	=> '16',
			'17' 	=> '17',
			'18' 	=> '18',
			'' 	=> 'null',
	    ),
	    'priority'    => 10,
	    'active_callback'  => array(
			array(
				'setting'  => 'pp_maps_autofit',
				'operator' => '!=',
				'value'    => 1,
			),
		)
	) );

	
	
	Kirki::add_field( 'workscout', array(
	    'type'        => 'select',
	    'settings'     => 'pp_maps_type',
	    'label'       => esc_html__( 'Map type', 'workscout' ),
	    'section'     => 'maps',
	    'default'     => 'ROADMAP',
	    'choices'     => array(
			'ROADMAP' 	=> 'ROADMAP',
			'HYBRID' 	=> 'HYBRID',
			'SATELLITE' => 'SATELLITE',
			'TERRAIN' 	=> 'TERRAIN',
	    ),
	    'priority'    => 10,
	) );	

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'     => 'pp_maps_scroll_zoom',
	    'label'       => esc_html__( 'Set zoom with scrollwheel', 'workscout' ),
	     'description' => __( 'Disabled by default as it might create problems witch scrolling page', 'workscout' ),
	    'section'     => 'maps',
	    'default'     => '0',
	    'priority'    => 10,
	) );
 ?>