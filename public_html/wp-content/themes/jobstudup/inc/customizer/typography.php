<?php

/*section typography*/ 
Kirki::add_section( 'typography', array(
    'title'          => esc_html__( 'Typography', 'workscout'  ),
    'description'    => esc_html__( 'Fonts options', 'workscout'  ),
    'panel'          => '', // Not typically needed.
    'priority'       => 60,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

	Kirki::add_field( 'workscout', array(
		'type'        => 'typography',
		'settings'    => 'pp_body_font',
		'label'       => esc_attr__( 'Body font', 'workscout' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'Montserrat, Arial, sans-serif; text-transform: none;',
			'variant'        => 'regular',
			'font-size'      => '14px',
			'line-height'    => '27px',
			'letter-spacing' => '0',
			'subsets'        => array( 'latin-ext' ),
			'color'          => '#666',
			
			'text-align'     => 'left'
		),
		'priority'    => 10,
		'output'      => array(
			array(
				'element' => 'body',
			),
		),
	) );	

	Kirki::add_field( 'workscout', array(
		'type'        => 'typography',
		'settings'    => 'pp_logo_font',
		'label'       => esc_attr__( 'Text logo font', 'workscout' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'Varela Round',
			'variant'        => 'regular',
			'color'          => '#666',
			'text-transform' => 'none',
			'font-size'      => '24px',
			'line-height'    => '27px',
			'text-align'     => 'left',
			'subsets'        => array( 'latin-ext' ),
			
		),
		'priority'    => 10,
		'output'      => array(
			array(
				'element' => '#logo h1 a,#logo h2 a',
			),
		),
	) );

	Kirki::add_field( 'workscout', array(
		'type'        => 'typography',
		'settings'    => 'pp_headers_font',
		'label'       => esc_attr__( 'h1..h6 font', 'workscout' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'Montserrat',
			'variant'        => 'regular',
			'subsets'        => array( 'latin-ext' ),
			
		),
		'priority'    => 10,
		'output'      => array(
			array(
				'element' => 'h1,h2,h3,h4,h5,h6',
			),
		),
	) );

	// Kirki::add_field( 'workscout', array(
	// 	'type'        => 'typography',
	// 	'settings'    => 'pp_menu_font',
	// 	'label'       => esc_attr__( 'Menu font', 'workscout' ),
	// 	'section'     => 'typography',
	// 	'default'     => array(
	// 		'font-family'    => 'Montserrat',
	// 		'variant'        => '600',
	// 		'font-size'      => '13px',
	// 		'line-height'    => '19px',
	// 		'subsets'        => array( 'latin-ext' ),

	// 		'text-transform' => 'none',
	// 		'text-align'     => 'left'
			
	// 	),
	// 	'priority'    => 10,
	// 	'output'      => array(
	// 		array(
	// 			'element' => '#navigation > ul > li > a',
	// 		),
	// 	),
	// ) );

	?>