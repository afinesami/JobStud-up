<?php 

// ----------- HEADER OPTIONS ----------

Kirki::add_section( 'header', array(
    'title'          => esc_html__( 'Header Options', 'workscout'  ),
    'description'    => esc_html__( 'Header related options', 'workscout'  ),
    'panel'          => '', // Not typically needed.
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );





	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'     => 'pp_old_header',
	    'label'       => esc_html__( 'Enable old header', 'workscout' ),
	    'description' => esc_html__( 'Header before the version 2 was released', 'workscout' ), 
	    'section'     => 'header',
	    'default'     => false,
	    'priority'    => 10,
	
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'select',
	    'settings'    => 'pp_header_style',
	    'label'       => esc_html__( 'Header style', 'workscout' ),
	    'section'     => 'header',
	    'description' => '',
	    'default'     => 'default',
	    'priority'    => 11,
	    'choices'     => array(
	        'default'		=> esc_html__( 'Default', 'workscout' ),
	        'alternative' 	=> esc_html__( 'Alternative', 'workscout' ),
	        'full-width' 	=> esc_html__( 'Full-width', 'workscout' ),
	    ),
	    'active_callback'  => array(
            array(
                'setting'  => 'pp_old_header',
                'operator' => '==',
                'value'    => true,
            ),
	    )
	) );
	
	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'    => 'pp_minicart_in_header',
	    'label'       => esc_html__( 'Mini shop cart in header', 'workscout' ),
	    'section'     => 'header',
	    'description' => esc_html__( 'Enable/disable mini shop cart in header', 'workscout' ),
	    'default'     => false,
	    'priority'    => 10,
	    'active_callback'  => array(
            array(
                'setting'  => 'pp_old_header',
                'operator' => '==',
                'value'    => true,
            ),
	    )
	
	) );	

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'    => 'pp_sticky_header',
	    'label'       => esc_html__( 'Sticky header', 'workscout' ),
	    'section'     => 'header',
	    'description' => esc_html__( 'Enable/disable sticky header', 'workscout' ),
	    'default'     => false,
	    'priority'    => 12,
	
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'    => 'pp_fullwidth_header',
	    'label'       => esc_html__( 'Make header full-width', 'workscout' ),
	    'section'     => 'header',
	    'description' => esc_html__( 'Enable/disable full width header', 'workscout' ),
	   	'default'     => false,
	    'priority'    => 10,
	    'active_callback'  => array(
            array(
                'setting'  => 'pp_old_header',
                'operator' => '!=',
                'value'    => true,
            ),
	    )
	) );	

	Kirki::add_field( 'workscout', array(
		'type'        => 'slider',
		'settings'    => 'pp_alt_menu_width',
		'label'       => esc_html__( 'Alternative header breakpoint', 'workscout' ),
		'description' => esc_html__( 'If your screen width will be smaller than this value, the menu will always switch to alternatvie', 'workscout' ),
		'section'     => 'header',
		'default'     => '1290',
		'choices'     => array(
			'min'  => '768',
			'max'  => '1600',
			'step' => '1',
		),
		'priority'    => 15,
		'active_callback'  => array(
            array(
                'setting'  => 'pp_old_header',
                'operator' => '==',
                'value'    => true,
            ),
	    )
	) );


	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'    => 'pp_login_form_status',
	    'label'       => esc_html__( 'Login/Sign Up buttons in header', 'workscout' ),
	    'section'     => 'header',
	    'description' => esc_html__( 'Enable/disable Login/Sing Up buttons in header', 'workscout' ),
	   	'default'     => true,
	    'priority'    => 10,
	) );	

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'    => 'pp_user_page_status',
	    'label'       => esc_html__( 'User Page button in header', 'workscout' ),
	    'section'     => 'header',
	    'description' => esc_html__( 'Enable/disable link to User Page in header', 'workscout' ),
	   	'default'     => true,
	    'priority'    => 10,
	    'active_callback'  => array(
            array(
                'setting'  => 'pp_old_header',
                'operator' => '==',
                'value'    => true,
            ),
	    )
	) );	

	Kirki::add_field( 'workscout', array(
		'type'        => 'slider',
		'settings'    => 'new_header_height',
		'label'       => esc_html__( 'Set header height', 'workscout' ),
		'description' => esc_html__( 'Only for screen width higher then 1366px', 'workscout' ),
		'section'     => 'header',
		'default'     => '82',
		'choices'     => array(
			'min'  => '50',
			'max'  => '300',
			'step' => '1',
		),
		'priority'    => 11,
		'output' => array(
			array(
				'element'  => '.new-header #header-container,.new-header #header',
				'property' => 'height',
				'units'    => 'px',
				'media_query' => '@media (min-width: 1366px)'
			),
			array(
				'element'  => '#wrapper.new-header',
				'property' => 'padding-top',
				'units'    => 'px',
				'media_query' => '@media (min-width: 1366px)'
			),
			
		),
	) );

 ?>