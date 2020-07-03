<?php 

Kirki::add_section( 'homepage', array(
    'title'          => esc_html__( 'Jobs Home Page Options', 'workscout'  ),
    'description'    => esc_html__( 'Options for Page with Job Search', 'workscout'  ),
    'panel'          => 'homesearch_panel', // Not typically needed.
    'priority'       => 21,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

	
	Kirki::add_field( 'workscout', array(
	    'type'        => 'text',
	    'settings'     => 'pp_jobs_home_title',
	    'label'       => esc_html__( 'Search banner Title', 'workscout' ),
	    'description' => __( 'Text above search form ', 'workscout' ),
	    'section'     => 'homepage',
	    'default'     => esc_html__('Find Job','workscout') ,
	    'priority'    => 10,
	) );	

	Kirki::add_field( 'workscout', array(
	    'type'        => 'text',
	    'settings'     => 'pp_jobs_home_subtitle',
	    'label'       => esc_html__( 'Search banner Subtitle', 'workscout' ),
	    'description' => __( 'Subtitle above search form ', 'workscout' ),
	    'section'     => 'homepage',
	    'default'     => esc_html__('Hire experts or be hired in','workscout') ,
	    'priority'    => 10,
	) );	

	Kirki::add_field( 'workscout', array(
		    'type'        => 'radio',
		    'settings'     => 'pp_jobs_home_typed_status',
		    'label'       => esc_html__( 'Enable Typed words effect', 'workscout' ),
		    'section'     => 'homepage',
		    'default'     => 'enable',
			'priority'    => 1,
			'choices'     => array(
				'enable'  => esc_attr__( 'Enable', 'workscout' ),
				'disable' => esc_attr__( 'Disable', 'workscout' ),
			),
			
		) );			

	Kirki::add_field( 'workscout', array(
		    'type'        => 'text',
		    'settings'     => 'pp_jobs_home_typed_text',
		    'label'       => esc_html__( 'Text to display in "typed" Banner Subtitle', 'workscout' ),
		    'description' => esc_html__( 'Separate with coma', 'workscout' ),
		    'section'     => 'homepage',
		    'default'     => esc_html__('healthcare, automotive, sales & marketing, accounting & finance','workscout') ,
		    'priority'    => 1,
		    'active_callback'  => array(
	            array(
	                'setting'  => 'pp_jobs_home_typed_status',
	                'operator' => '==',
	                'value'    => 'enable',
	            ),
	        
	        )

		) );	


	Kirki::add_field( 'workscout', array(
	    'type'        => 'multicheck',
	    'settings'    => 'pp_job_search_elements',
	    'label'       => esc_html__( 'Jobs Search Form elements to display', 'workscout' ),
	    'description' => esc_html__( 'Set which elements you want to display on Search Banner', 'workscout' ),
	    'section'     => 'homepage',
	    'default'     => array('keywords','location'),
	    'priority'    => 10,
	    'choices'     => array(
	    	'keywords' 		=> esc_html__( 'Keyword input', 'workscout' ),
	    	'location' 		=> esc_html__( 'Location/Region input', 'workscout' ),
	    	'category' 		=> esc_html__( 'Category dropdown', 'workscout' ),
	    ),
	) );


	Kirki::add_field( 'workscout', array(
		'type'        => 'slider',
		'settings'    => 'pp_jobs_home_height',
		'label'       => esc_html__( 'Height of the search banner', 'workscout' ),
		'description' => esc_html__( 'Height is set by adjusting top and bottom padding', 'workscout' ),
		'section'     => 'homepage',
		'default'     => '190',
		'choices'     => array(
			'min'  => '30',
			'max'  => '1000',
			'step' => '1',
		),
		'priority'    => 11,
		'output' => array(
			array(
				'element'  => '#banner.with-transparent-header .search-container.sc-jobs',
				'property' => 'padding-top',
				'units'    => 'px',
			),
			array(
				'element'  => '#banner.with-transparent-header .search-container.sc-jobs',
				'property' => 'padding-bottom',
				'units'    => 'px',
			),
			array(
				'element'  => '#banner.jobs-search-banner .search-container.sc-jobs',
				'property' => 'padding-top',
				'units'    => 'px',
			),
			array(
				'element'  => '#banner.jobs-search-banner .search-container.sc-jobs',
				'property' => 'padding-bottom',
				'units'    => 'px',
			),
			array(
				'element'  => '.intro-banner',
				'property' => 'padding-top',
				'units'    => 'px',
			),
			array(
				'element'  => '.intro-banner',
				'property' => 'padding-bottom',
				'units'    => 'px',
			),
		),
	) );


	Kirki::add_field( 'workscout', array(
	    'type'        => 'image',
	    'settings'     => 'pp_jobs_search_bg',
	    'label'       => esc_html__( 'Background for search banner on homepage', 'workscout' ),
	    'description' => esc_html__( 'Set image for search banner, should be 1920px wide', 'workscout' ),
	    'section'     => 'homepage',
	    'default'     => '',
	    'priority'    => 12,
	) );

	Kirki::add_field( 'workscout', array(
		'type'        => 'color',
		'settings'    => 'pp_jobs_search_color',
		'label'       => __( 'Search banner overlay color', 'workscout' ),
		'section'     => 'homepage',
		'default'     => 'rgba(42, 46, 50, 0.7)',
		'priority'    => 12,
		'choices'     => array(
			'alpha' => true,
		),
		'output' => array(
			array(
				'element'  => '#banner.with-transparent-header.jobs-search-banner:before',
				'property' => 'background-color',
			),
			array(
				'element'  => '#banner.jobs-search-banner:before',
				'property' => 'background-color',
			),array(
				'element'  => '.intro-banner.dark-overlay:before',
				'property' => 'background-color',
			),
		),
	) );

// removed for v2
	// Kirki::add_field( 'workscout', array(
	//     'type'        => 'switch',
	//     'settings'    => 'pp_transparent_header',
	//     'label'       => esc_html__( 'Transparent header', 'workscout' ),
	//     'section'     => 'homepage',
	//     'description' => esc_html__( 'Enabling transparent header works only on \'Page with Jobs Search\'', 'workscout' ),
	//     'default'     => false,
	//     'priority'    => 13,
	
	// ) );

	

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'    => 'pp_home_job_advanced',
	    'label'       => esc_html__( 'Show "Advanced Search" link', 'workscout' ),
	    'section'     => 'homepage',
	    'description' => esc_html__( 'Disable to hide text below search form', 'workscout' ),
	    'default'     => true,
	    'priority'    => 14,
	
	) );	

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'    => 'pp_home_job_counter',
	    'label'       => esc_html__( 'Show job counter', 'workscout' ),
	    'section'     => 'homepage',
	    'description' => esc_html__( 'Disable to hide jobs counter (works on old home page template)', 'workscout' ),
	    'default'     => true,
	    'priority'    => 14,
	
	) );

	// Kirki::add_field( 'workscout', array(
	//     'type'        => 'dropdown-pages',
	//     'settings'    => 'pp_categories_page',
	//     'label'       => esc_html__( 'Choose "Browse Categories Page"', 'workscout' ),
	//     'section'     => 'homepage',
	//     'description' => esc_html__( 'This page needs to use template named "Job Categories Page Template"', 'workscout' ),
	//     'priority'    => 15,
	// ) );

 ?>