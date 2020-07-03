<?php 
Kirki::add_section( 'workscout_shop', array(
    'title'          => esc_html__( 'WorkScout Woo Settings', 'workscout'  ),
    'description'    => esc_html__( 'Theme related settings', 'workscout'  ),
    'panel'          => 'woocommerce', // Not typically needed.
    'priority'       => 22,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
	Kirki::add_field( 'workscout', array(
	    'type'        => 'radio-image',
	    'settings'     => 'pp_shop_layout',
	    'label'       => esc_html__( 'Shop layout', 'workscout' ),
	    'description' => esc_html__( 'Choose the sidebar side for shop', 'workscout' ),
	    'section'     => 'workscout_shop',
	    'default'     => 'full-width',
	    'priority'    => 10,
	    'choices'     => array(
	        'left-sidebar' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/left-sidebar.png',
	        'right-sidebar' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/right-sidebar.png',
	        'full-width' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/full-width.png',
	    ),
	) );
	

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'    => 'pp_shop_ordering',
	    'label'       => esc_html__( 'Show/hide results count and order select on shop page', 'workscout' ),
	    'section'     => 'workscout_shop',
	    'description' => esc_html__( 'With this setting set to On, results count and order select on shop page will be displayed', 'workscout' ),
	    'default'     => true,
	    'priority'    => 10,
	) );


	Kirki::add_field( 'workscout', array(
	    'settings'    => 'pp_hide_woo_nav',
	    'label'       => esc_html__( 'MyAccount navigation control ', 'workscout' ),
	    'section'     => 'workscout_shop',
	    'description' => esc_html__( 'Check the checkbox to hide that element in the WooCommerce My Account menu', 'workscout' ),
	    'default'     => true,
	    'priority'    => 10,
	    'type'        => 'multicheck',
	    'choices'     => array(
		        'dashboard' 		=> esc_html__( 'Dashboard', 'workscout' ),
		        'orders' 			=> esc_html__( 'Orders', 'workscout' ),
		        'downloads' 		=> esc_html__( 'Downloads', 'workscout' ),
		        'addresses' 		=> esc_html__( 'Addresses', 'workscout' ),
		        'account_details' 	=> esc_html__( 'Account details', 'workscout' ),
		        'logout' 			=> esc_html__( 'Logout', 'workscout' ),
		    ),
	) );


 ?>