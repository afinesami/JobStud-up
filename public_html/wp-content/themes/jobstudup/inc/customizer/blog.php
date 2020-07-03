<?php 
Kirki::add_section( 'blog', array(
    'title'          => esc_html__( 'Blog Options', 'workscout'  ),
    'description'    => esc_html__( 'Blog related options', 'workscout'  ),
    'panel'          => '', // Not typically needed.
    'priority'       => 26,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'radio-image',
	    'settings'     => 'pp_blog_layout',
	    'label'       => esc_html__( 'Blog layout', 'workscout' ),
	    'description' => esc_html__( 'Choose the sidebar side for blog', 'workscout' ),
	    'section'     => 'blog',
	    'default'     => 'left-sidebar',
	    'priority'    => 10,
	    'choices'     => array(
	        'left-sidebar' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/left-sidebar.png',
	        'right-sidebar' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/right-sidebar.png',
	    ),
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'upload',
	    'settings'     => 'pp_blog_header_upload',
	    'label'       => esc_html__( 'Blog header image', 'workscout' ),
	    'description' => esc_html__( 'Set image for header, should be 1920px wide', 'workscout' ),
	    'section'     => 'blog',
	    'default'     => '',
	    'priority'    => 10,
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'multicheck',
	    'settings'     => 'pp_meta_single',
	    'label'       => esc_html__( 'Post meta informations on single post', 'workscout' ),
	    'description' => esc_html__( 'Set which elements of posts meta data you want to display', 'workscout' ),
	    'section'     => 'blog',
	    'default'     => array('author'),
	    'priority'    => 10,
	    'choices'     => array(
	        'author' 	=> esc_html__( 'Author', 'workscout' ),
	        'date' 		=> esc_html__( 'Date', 'workscout' ),
	        'tags' 		=> esc_html__( 'Tags', 'workscout' ),
	        'cat' 		=> esc_html__( 'Categories', 'workscout' ),
	    ),
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'multicheck',
	    'settings'     => 'pp_blog_meta',
	    'label'       => esc_html__( 'Post meta informations on blog post', 'workscout' ),
	    'description' => esc_html__( 'Set which elements of posts meta data you want to display on blog and archive pages', 'workscout' ),
	    'section'     => 'blog',
	    'default'     => array('author'),
	    'priority'    => 10,
	    'choices'     => array(
	        'author' 	=> esc_html__( 'Author', 'workscout' ),
	        'date' 		=> esc_html__( 'Date', 'workscout' ),
	        'tags' 		=> esc_html__( 'Tags', 'workscout' ),
	        'cat' 		=> esc_html__( 'Categories', 'workscout' ),
	        'com' 		=> esc_html__( 'Comments', 'workscout' ),
	    ),
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'text',
	    'settings'    => 'pp_blog_title',
	    'label'       => esc_html__( 'Blog title', 'workscout' ),
	    'default'     => esc_html__( 'Blog', 'workscout' ),
	    'section'     => 'blog',
	    'priority'    => 10,
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'text',
	    'settings'    => 'pp_blog_subtitle',
	    'label'       => esc_html__( 'Blog subtitle', 'workscout' ),
	    'default'     => esc_html__( 'Keep up to date with the latest news', 'workscout' ),
	    'section'     => 'blog',
	    'priority'    => 10,
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'multicheck',
	    'settings'     => 'pp_post_share',
	    'label'       => esc_html__( 'Share buttons on single post', 'workscout' ),
	    'description' => esc_html__( 'Set which share buttons you want to display on single post', 'workscout' ),
	    'section'     => 'blog',
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

?>