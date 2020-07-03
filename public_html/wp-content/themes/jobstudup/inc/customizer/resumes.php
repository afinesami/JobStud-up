<?php 


Kirki::add_panel( 'resumes_panel', array(
    'priority'    => 21,
    'title'       => __( 'Resumes Options', 'sphene' ),
    'description' => __( 'Resumes related options', 'sphene' ),
) );

require get_template_directory() . '/inc/customizer/resume_home.php';


Kirki::add_section( 'resumes', array(
    'title'          => esc_html__( 'Resumes Options', 'workscout'  ),
    'description'    => esc_html__( 'Resume related options', 'workscout'  ),
    //'panel'          => 'resumes_panel', // Not typically needed.
    'priority'       => 23,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );



Kirki::add_field( 'workscout', array(
	    'type'        => 'select',
	    'settings'    => 'resumes_list_layout',
	    'label'       => esc_html__( 'Resumes Page layout', 'workscout' ),
	    'section'     => 'resumes',
	    'description' => '',
	    'default'     => 'jobs',
	    'priority'    => 10,
	    'choices'     => array(
	        'standard'	=> __( 'Classic', 'workscout' ),
	        'split'		=> __( 'Split page with map on right', 'workscout' ),
	        
	    ),
	) );

Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'    => 'pp_resumes_taxonomies_description',
	    'label'       => esc_html__( 'Show taxonomies description on archives', 'workscout' ),
	    'section'     => 'resumes',
	    'description' => esc_html__( 'Set to ON to show category title and description', 'workscout' ),
	    'default'     => false,
	    'priority'    => 10,
	
	) );
	Kirki::add_field( 'workscout', array(
	    'type'        => 'upload',
	    'settings'     => 'pp_resumes_header_upload',
	    'label'       => esc_html__( 'Resumes header image', 'workscout' ),
	    'description' => esc_html__( 'Used on Resumes archive page. Set image for header, should be 1920px wide', 'workscout' ),
	    'section'     => 'resumes',
	    'default'     => '',
	    'priority'    => 10,
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'select',
	    'settings'    => 'pp_call_to_action_resumes',
	    'label'       => esc_html__( 'Call to action button in header', 'workscout' ),
	    'section'     => 'resumes',
	    'description' => '',
	    'default'     => 'resume',
	    'priority'    => 10,
	    'choices'     => array(
	        'job'		=> __( 'Post a Job! It\'s Free!', 'workscout' ),
	        'resume'	=> __( 'Post a Resume! It\'s Free!', 'workscout' ),
	        'nothing' 	=> esc_html__( 'Show nothing', 'workscout' ),
	    ),
	) );


	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'     => 'pp_resume_old_layout',
	    'label'       => esc_html__( 'Enable old resume list layout', 'workscout' ),
	    'description' => esc_html__( 'Layout before the 1.5v update', 'workscout' ),
	    'section'     => 'resumes',
	    'default'     => 0,
	    'priority'    => 10,
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'     => 'pp_resume_rounded_photos',
	    'label'       => esc_html__( 'Rounded resumes photos', 'workscout' ),
	    'description' => esc_html__( 'Turn it off for rectangular photos', 'workscout' ),
	    'section'     => 'resumes',
	    'default'     => 0,
	    'priority'    => 10,
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'select',
	    'settings'    => 'pp_resumes_order',
	    'label'       => esc_html__( 'Resume Archive order', 'workscout' ),
	    'section'     => 'resumes',
	    'description' => '',
	    'default'     => 'DESC',
	    'priority'    => 10,
	    'choices'     => array(
	    	'ASC' => 'ascending order from lowest to highest values (1, 2, 3; a, b, c).',
			'DESC' => 'descending order from highest to lowest values (3, 2, 1; c, b, a).',
	    ),
	) );
	Kirki::add_field( 'workscout', array(
	    'type'        => 'select',
	    'settings'    => 'pp_resumes_orderby',
	    'label'       => esc_html__( 'Resume Archive orderby', 'workscout' ),
	    'section'     => 'resumes',
	    'description' => '',
	    'default'     => 'title',
	    'priority'    => 10,
	    'choices'     => array(
	    	'featured'  => 'Featured.',
	    	'none'  => 'No order.',
			'ID'  => 'Order by post id. ',
			'author'  => 'Order by author.',
			'title'  => 'Order by title.',
			'name'  => 'Order by post name (post slug).',
			'date'  => 'Order by date.',
			'modified'  => 'Order by last modified date.',
			'rand'  => 'Random order.',
	    ),
	) );

	Kirki::add_field( 'workscout', array(
		'type'        => 'number',
		'settings'    => 'pp_resumes_per_page',
		'label'       => esc_attr__( 'Resume Archive number of listings', 'workscout' ),
		'section'     => 'resumes',
		'default'     => 10,
		'choices'     => array(
			'min'  => 1,
			'max'  => 50,
			'step' => 1,
		),
	) );	

	Kirki::add_field( 'workscout', array(
		'type'        => 'switch',
		'settings'    => 'pp_resumes_styled_list',
		'label'       => esc_attr__( 'Square list bullets', 'workscout' ),
		'section'     => 'resumes',
		'description' => 'Automatically make all lists in resume description use squere color bullet points',
		'default'     => false,
		
	) );

	?>