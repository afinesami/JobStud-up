<?php 



Kirki::add_section( 'contact_map', array(
    'title'          => esc_html__( 'Contact Page Map', 'workscout'  ),
    'description'    => esc_html__( 'Contact Page Map related options', 'workscout'  ),
    'panel'          => '', // Not typically needed.
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );


	Kirki::add_field( 'workscout', array(
		    'type'        => 'slider',
		    'settings'    => 'pp_contact_zoom',
		    'label'       => esc_html__( 'Zoom level for map', 'workscout' ),
		    'section'     => 'contact_map',
		    'description' => '',
		    'default'     => 13,
		    'priority'    => 11,
		    'choices'     => [
				'min'  => 1,
				'max'  => 19,
				'step' => 1,
			],
		) );


	// Kirki::add_field( 'workscout', array(
	// 	    'type'        => 'select',
	// 	    'settings'    => 'pp_contact_maptype',
	// 	    'label'       => esc_html__( 'Map type', 'workscout' ),
	// 	    'section'     => 'contact_map',
	// 	    'description' => '',
	// 	    'default'     => 'default',
	// 	    'priority'    => 11,
	// 	    'choices'     => array(
	// 	        'ROADMAP'		=> esc_html__( 'ROADMAP', 'workscout' ),
	// 	        'SATELLITE' 	=> esc_html__( 'SATELLITE', 'workscout' ),
	// 	        'HYBRID' 		=> esc_html__( 'HYBRID', 'workscout' ),
	// 	        'TERRAIN' 		=> esc_html__( 'TERRAIN', 'workscout' ),
	// 	    ),
	// 	) );

		Kirki::add_field( 'workscout', array(
			'type'        => 'repeater',
			'label'       => esc_html__( 'Markers on map', 'kirki' ),
			'section'     => 'contact_map',
			'priority'    => 10,
			'row_label' => array(
				'type'  => 'text',
				'value' => esc_html__( 'Marker', 'kirki' ),
			),
			'button_label' => esc_html__('"Add new" button label (optional) ', 'kirki' ),
			'settings'     => 'pp_new_contact_map',
			
			'fields' => array(
				'address' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Address of marker on map', 'kirki' ),
					//'description' => esc_html__( 'This will be the label for your link', 'kirki' ),
					'default'     => '',
				),
				'latitude' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Latitude (required)', 'kirki' ),
					//'description' => esc_html__( 'This will be the label for your link', 'kirki' ),
					'default'     => '',
				),
				'longitude' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Longitude (required)', 'kirki' ),
					//'description' => esc_html__( 'This will be the label for your link', 'kirki' ),
					'default'     => '',
				),
				'content'  => array(
					'type'        => 'text',
					'label'       => esc_html__( 'HTML content of marker', 'kirki' ),
					//'description' => esc_html__( 'This will be the link URL', 'kirki' ),
					'default'     => '',
				),
			)
		) );
?>