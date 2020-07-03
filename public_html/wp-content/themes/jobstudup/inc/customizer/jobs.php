<?php 


Kirki::add_panel( 'jobs_panel', array(
    'priority'    => 21,
    'title'       => __( 'Jobs Options', 'sphene' ),
    'description' => __( 'Job related options', 'sphene' ),
) );

require get_template_directory() . '/inc/customizer/jobs_home.php';



Kirki::add_section( 'jobs_list', array(
    'title'          => esc_html__( 'Jobs Lists Options', 'workscout'  ),
    'description'    => esc_html__( 'Job search list related options', 'workscout'  ),
    'panel'          => 'jobs_panel', // Not typically needed.
    'priority'       => 22,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

Kirki::add_field( 'workscout', array(
	    'type'        => 'select',
	    'settings'    => 'jobs_list_layout',
	    'label'       => esc_html__( 'Jobs Page layout', 'workscout' ),
	    'section'     => 'jobs_list',
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
	    'settings'    => 'pp_taxonomies_description',
	    'label'       => esc_html__( 'Show taxonomies description on archives', 'workscout' ),
	    'section'     => 'jobs_list',
	    'description' => esc_html__( 'Set to ON to show category title and description', 'workscout' ),
	    'default'     => false,
	    'priority'    => 10,
	
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'    => 'pp_jobs_search_in_sb',
	    'label'       => esc_html__( 'Move keyword search to the sidebar on Jobs list', 'workscout' ),
	    'section'     => 'jobs_list',
	    'description' => esc_html__( 'Disable to use jobs search input obove the job list', 'workscout' ),
	    'default'     => false,
	    'priority'    => 10,
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'    => 'pp_disable_rss',
	    'label'       => esc_html__( 'Disable RSS button', 'workscout' ),
	    'section'     => 'jobs_list',
	    'description' => esc_html__( 'Set to ON to hide it', 'workscout' ),
	    'default'     => false,
	    'priority'    => 10,
	
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'    => 'pp_disable_jobs_counter',
	    'label'       => esc_html__( 'Jobs counter on Browse Jobs page', 'workscout' ),
	    'section'     => 'jobs_list',
	    'description' => esc_html__( 'Set to OFF to show default titlebar', 'workscout' ),
	    'default'     => true,
	    'priority'    => 10,
	
	) );	

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'     => 'pp_jobs_old_layout',
	    'label'       => esc_html__( 'Enable old jobs list layout', 'workscout' ),
	    'description' => esc_html__( 'Layout before the 1.5v update', 'workscout' ), 
	    'section'     => 'jobs_list',
	    'default'     => false,
	    'priority'    => 10,
	
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'     => 'pp_job_tags_below_title',
	    'label'       => esc_html__( 'Show job types below title', 'workscout' ),
	    'description' => esc_html__( 'Instead of the right side floated types', 'workscout' ), 
	    'section'     => 'jobs_list',
	    'default'     => false,
	    'priority'    => 10,
	
	) );
	
	
	Kirki::add_field( 'workscout', array(
	    'type'        => 'upload',
	    'settings'     => 'pp_jobs_header_upload',
	    'label'       => esc_html__( 'Jobs header image', 'workscout' ),
	    'description' => esc_html__( 'Used on Job archive page. Set image for header, should be 1920px wide', 'workscout' ),
	    'section'     => 'jobs_list',
	    'default'     => '',
	    'priority'    => 10,
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'    => 'pp_jobs_transparent_header',
	    'label'       => esc_html__( 'Transparent header on Jobs page', 'workscout' ),
	    'section'     => 'jobs_list',
	    'description' => esc_html__( 'Enabling transparent on browse jobs page', 'workscout' ),
	    'default'     => false,
	    'priority'    => 10,
	
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'    => 'pp_disable_jobs_titlebar',
	    'label'       => esc_html__( 'Hide titlebar on Jobs page', 'workscout' ),
	    'section'     => 'jobs_list',
	    'description' => esc_html__( 'Set to ON to hide titlebar on browse jobs page', 'workscout' ),
	    'default'     => false,
	    'priority'    => 10,
	
	) );	

	Kirki::add_field( 'workscout', array(
	    'type'        => 'select',
	    'settings'    => 'pp_call_to_action_jobs',
	    'label'       => esc_html__( 'Call to action button in header', 'workscout' ),
	    'section'     => 'jobs_list',
	    'description' => '',
	    'default'     => 'jobs',
	    'priority'    => 10,
	    'choices'     => array(
	        'job'		=> __( 'Post a Job! It\'s Free!', 'workscout' ),
	        'resume'	=> __( 'Post a Resume! It\'s Free!', 'workscout' ),
	        'nothing' 	=> esc_html__( 'Show nothing', 'workscout' ),
	    ),
	) );


	Kirki::add_field( 'workscout', array(
	    'type'        => 'upload',
	    'settings'     => 'pp_jobs_default_image_upload',
	    'label'       => esc_html__( 'Default company logo', 'workscout' ),
	    'description' => esc_html__( 'Used on jobs lists', 'workscout' ),
	    'section'     => 'jobs_list',
	    'default'     => '',
	    'priority'    => 10,
	) );

	Kirki::add_field( 'workscout', array(
		    'type'        => 'switch',
		    'settings'     => 'pp_jobs_hide_default_image_upload',
		    'label'       => esc_html__( 'Hide company logo if not set by user', 'workscout' ),
		    'description' => esc_html__( 'Used on jobs lists', 'workscout' ),
		    'section'     => 'jobs_list',
		    'default'     => '',
		    'priority'    => 10,
		) );


	Kirki::add_field( 'workscout', array(
	    'type'        => 'multicheck',
	    'settings'     => 'pp_meta_job_list',
	    'label'       => esc_html__( 'Job meta informations on jobs list', 'workscout' ),
	    'description' => esc_html__( 'Set which elements you want to display', 'workscout' ),
	    'section'     => 'jobs_list',
	    'default'     => array('company','location','rate','salary'),
	    'priority'    => 10,
	    'choices'     => array(
	        'company' 	=> esc_html__( 'Company', 'workscout' ),
	        'location' 	=> esc_html__( 'Location', 'workscout' ),
	        'rate' 		=> esc_html__( 'Rate', 'workscout' ),
	        'salary' 	=> esc_html__( 'Salary', 'workscout' ),
	        'date' 		=> esc_html__( 'Date created', 'workscout' ),
	        'deadline' 	=> esc_html__( 'Deadline', 'workscout' ),
	        'expires' 	=> esc_html__( 'Expires', 'workscout' ),
	    ),
	) );

		Kirki::add_field( 'workscout', array(
		    'type'        => 'switch',
		    'settings'     => 'pp_jobs_hide_content_on_list',
		    'label'       => esc_html__( 'Hide job listing excerpt on the jobs list', 'workscout' ),
		    'description' => esc_html__( 'Used on jobs lists', 'workscout' ),
		    'section'     => 'jobs_list',
		    'default'     => '',
		    'priority'    => 10,
		) );


	Kirki::add_field( 'workscout', array(
	    'type'        => 'select',
	    'settings'    => 'pp_jobs_orderby',
	    'label'       => esc_html__( 'Jobs Archive orderby', 'workscout' ),
	    'section'     => 'jobs_list',
	    'description' => '',
	    'default'     => 'title',
	    'priority'    => 10,
	    'choices'     => array(
	    	'featured' => 'Featured',
	    	'title'  => 'Order by title.',
			'ID'  => 'Order by post id. ',
	    	'name'  => 'Order by post name (post slug).',
			'date'  => 'Order by date.',
			'modified'  => 'Order by last modified date.',
			'rand'  => 'Random order.',
	
	    ),
	) );
	Kirki::add_field( 'workscout', array(
	    'type'        => 'select',
	    'settings'    => 'pp_jobs_order',
	    'label'       => esc_html__( 'Jobs Archive order', 'workscout' ),
	    'section'     => 'jobs_list',
	    'description' => '',
	    'default'     => 'DESC',
	    'priority'    => 10,
	    'choices'     => array(
	    	'ASC' => 'ascending order from lowest to highest values (1, 2, 3; a, b, c).',
			'DESC' => 'descending order from highest to lowest values (3, 2, 1; c, b, a).',
	    ),
	) );
	Kirki::add_field( 'workscout', array(
		'type'        => 'number',
		'settings'    => 'pp_jobs_per_page',
		'label'       => esc_attr__( 'Jobs Archive number of listings', 'workscout' ),
		'section'     => 'jobs_list',
		'default'     => 10,
		'choices'     => array(
			'min'  => 1,
			'max'  => 50,
			'step' => 1,
		),
	) );

	Kirki::add_field( 'workscout', array(
		'type'        => 'select',
		'settings'    => 'pp_job_list_logo_position',
		'label'       => __( 'Logo position on jobs list', 'workscout' ),
		'section'     => 'jobs_list',
		'description' => esc_html__( 'If you don\'t like cropped out logos, move them to the right!', 'workscout' ),
		'priority'    => 10,
		'default'	  => 'left',
		'choices'     => array(
			'left' 	=> esc_html__( 'Left', 'workscout' ),
	        'right' => esc_html__( 'Right', 'workscout' ),
	    ),
	) );

Kirki::add_section( 'jobs', array(
    'title'          => esc_html__( 'Single Job Options', 'workscout'  ),
    'description'    => esc_html__( 'Job options', 'workscout'  ),
    'panel'          => 'jobs_panel', // Not typically needed.
    'priority'       => 22,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

	

	Kirki::add_field( 'workscout', array(
	    'type'        => 'radio-image',
	    'settings'     => 'pp_job_layout',
	    'label'       => esc_html__( 'Single Job layout', 'workscout' ),
	    'description' => esc_html__( 'Choose the sidebar side for single job', 'workscout' ),
	    'section'     => 'jobs',
	    'default'     => 'right-sidebar',
	    'priority'    => 10,
	    'choices'     => array(
	        'left-sidebar' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/left-sidebar.png',
	        'right-sidebar' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/right-sidebar.png',
	    ),
	) );


	Kirki::add_field( 'workscout', array(
	    'type'        => 'multicheck',
	    'settings'    => 'pp_job_overview',
	    'label'       => esc_html__( 'Job Overview elements to display', 'workscout' ),
	    'description' => esc_html__( 'Set which elements you want to display on single job post', 'workscout' ),
	    'section'     => 'jobs',
	    'default'     => array('date_posted','expiration_date','application_deadline','location','job_title','hours','rate','salary'),
	    'priority'    => 10,
	    'choices'     => array(
	    	'date_posted' 			=> esc_html__( 'Date Posted', 'workscout' ),
	    	'expiration_date' 		=> esc_html__( 'Expiration Date', 'workscout' ),
	    	'application_deadline' 	=> esc_html__( 'Application Deadline', 'workscout' ),
	    	'location' 				=> esc_html__( 'Location', 'workscout' ),
	    	'job_title' 			=> esc_html__( 'Job Title', 'workscout' ),
	    	'hours' 				=> esc_html__( 'Hours', 'workscout' ),
	    	'rate' 					=> esc_html__( 'Rate', 'workscout' ),
	    	'salary' 				=> esc_html__( 'Salary', 'workscout' ),
	    ),
	) );


	Kirki::add_field( 'workscout', array(
	    'type'        => 'multicheck',
	    'settings'     => 'pp_job_share',
	    'label'       => esc_html__( 'Share buttons on single job', 'workscout' ),
	    'description' => esc_html__( 'Set which share buttons you want to display on single job post', 'workscout' ),
	    'section'     => 'jobs',
	    'default'     => array(),
	    'priority'    => 10,
	    'choices'     => array(
	        'facebook' 	=> esc_html__( 'Facebook', 'workscout' ),
	        'twitter' 		=> esc_html__( 'Twitter', 'workscout' ),
	        'google-plus' 		=> esc_html__( 'Google Plus', 'workscout' ),
	        'pinterest' 		=> esc_html__( 'Pinterest', 'workscout' ),
	        'linkedin' 		=> esc_html__( 'LinkedIn', 'workscout' ),
	    ),
	) );



	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'     => 'pp_enable_related_jobs',
	    'label'       => esc_html__( 'Enable related Jobs on Single Job', 'workscout' ),
	    'section'     => 'jobs',
	    'default'     => 0,
	    'priority'    => 10,
	) );	

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'     => 'pp_enable_single_jobs_map',
	    'label'       => esc_html__( 'Enable map on Single Job', 'workscout' ),
	    'section'     => 'jobs',
	    'default'     => 0,
	    'priority'    => 12,
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'select',
	    'settings'     => 'pp_maps_single_zoom',
	    'label'       => esc_html__( 'Default Map zoom level', 'workscout' ),
	    'section'     => 'jobs',
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
	    ),
	    'priority'    => 13,
	   
	) );

 ?>