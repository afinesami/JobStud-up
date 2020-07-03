<?php 

Kirki::add_section( 'layout', array(
    'title'          => esc_html__( 'Layout Options', 'workscout'  ),
    'description'    => esc_html__( 'Layout and header options', 'workscout'  ),
    'panel'          => '', // Not typically needed.
    'priority'       => 29,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'select',
	    'settings'    => 'pp_body_style',
	    'label'       => esc_html__( 'Layout style', 'workscout' ),
	    'section'     => 'layout',
	    'description' => '',
	    'default'     => 'fullwidth',
	    'priority'    => 10,
	    'choices'     => array(
	        'boxed'		=> esc_html__( 'Boxed', 'workscout' ),
	        'fullwidth' => esc_html__( 'Full-width', 'workscout' ),
	    ),
	) ); 
	Kirki::add_field( 'workscout', array(
	    'type'        => 'select',
	    'settings'    => 'pp_pagecomments',
	    'label'       => esc_html__( 'Comments on pages', 'workscout' ),
	    'section'     => 'layout',
	    'description' => '',
	    'default'     => 'fullwidth',
	    'priority'    => 10,
	    'choices'     => array(
	        'on'		=> esc_html__( 'On', 'workscout' ),
	        'off' => esc_html__( 'Off', 'workscout' ),
	    ),
	) ); 


	Kirki::add_field( 'workscout', array(
		  'type'        => 'repeater',
		  'label'       => esc_attr__( 'Sidebar generator', 'workscout' ),
		  'section'     => 'layout',
		  'priority'    => 10,
		  'settings'    => 'incr_sidebars',

		  'fields' => array(
		      'sidebar_name' => array(
		          'type'        => 'text',
		          'label'       => esc_attr__( 'Sidebar name', 'workscout' ),
		          'description' => esc_attr__( 'This will be name of sidebar', 'workscout' ),
		          'default'     => 'Sidebar name',
		      ),
		      'id' => array(
		          'type'        => 'text',
		          'label'       => esc_attr__( 'Sidebar ID', 'workscout' ),
		          'description' => esc_attr__( 'Replace x with a number', 'workscout' ),
		          'default'     => 'sidebar_id_x',
		
		      ),
		  )
		) );?>