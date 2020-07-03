<?php 
// ----------- FOOTER OPTIONS ----------

Kirki::add_section( 'footer', array(
    'title'          => esc_html__( 'Footer Options', 'workscout'  ),
    'description'    => esc_html__( 'Footer related options', 'workscout'  ),
    'panel'          => '', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

    Kirki::add_field( 'workscout', array(
        'type'        => 'upload',
        'settings'     => 'pp_footer_logo_upload',
        'label'       => esc_html__( 'Footer Logo image', 'workscout' ),
        'description' => esc_html__( 'Upload logo for footer top area', 'workscout' ),
        'section'     => 'footer',
        'default'     => '',
        'priority'    => 10,
    ) );   
    $imicons = workscout_line_icons_list();
    $footer_icons = array();
    foreach ($imicons as $key ) {
        $footer_icons[$key] = ltrim($key, 'icon-'); 
        

    }  
    Kirki::add_field( 'workscout', array(
            'type'        => 'repeater',
            'label'       => esc_html__( 'Stats counter', 'kirki' ),
            'section'     => 'footer',
            'priority'    => 10,
            'row_label' => array(
                'type'  => 'text',
                'value' => esc_html__( 'Counter', 'kirki' ),
            ),
            'button_label' => esc_html__('"Add new" counter ', 'kirki' ),
            'settings'     => 'footer_stat_counters',
            
            'fields' => array(
                'icons' => array(
                    'type'        => 'select',
                    'label'       => esc_html__( 'Icon', 'kirki' ),
                    //'description' => esc_html__( 'This will be the label for your link', 'kirki' ),
                    'default'     => '',
                    'choices'     => $footer_icons
                ),
                'number'  => array(
                    'type'        => 'number',
                    'label'       => esc_html__( 'Number', 'kirki' ),
                    //'description' => esc_html__( 'This will be the link URL', 'kirki' ),
                    'default'     => '',
                ), 
                'label'  => array(
                    'type'        => 'text',
                    'label'       => esc_html__( 'Label', 'kirki' ),
                    //'description' => esc_html__( 'This will be the link URL', 'kirki' ),
                    'default'     => '',
                ),
            )
        ) );
	Kirki::add_field( 'workscout', array(
	    'type'        => 'textarea',
	    'settings'    => 'pp_copyrights',
	    'label'       => esc_html__( 'Copyrights text', 'workscout' ),
	    'default'     => '&copy; Theme by Purethemes.net. All Rights Reserved.',
	    'section'     => 'footer',
	    'priority'    => 10,
	) );

	Kirki::add_field( 'workscout', array(
        'type'        => 'text',
        'settings'    => 'pp_new_footer_widgets',
        'label'       => esc_html__( 'Footer widgets layout', 'workscout' ),
        'description' => esc_html__( 'Total width of footer is 12 columns, here you can decide layout based on columns number for each widget area in footer', 'workscout' ),
        'section'     => 'footer',
        'default'     => '2,2,2,4',
        'priority'    => 10,
       
	) );

    Kirki::add_field( 'workscout', array(
            'type'        => 'repeater',
            'label'       => esc_html__( 'Social Icons', 'kirki' ),
            'section'     => 'footer',
            'priority'    => 10,
            'row_label' => array(
                'type'  => 'text',
                'value' => esc_html__( 'Icon', 'kirki' ),
            ),
            'button_label' => esc_html__('"Add new" button label (optional) ', 'kirki' ),
            'settings'     => 'pp_footericons',
            
            'fields' => array(
                'icons_service' => array(
                    'type'        => 'select',
                    'label'       => esc_html__( 'Address of marker on map', 'kirki' ),
                    //'description' => esc_html__( 'This will be the label for your link', 'kirki' ),
                    'default'     => '',
                    'choices'     => array(
                        
                        '--' => 'Select Icon',
                        'twitter' => 'Twitter',
                        'wordpress' => 'WordPress',
                        'facebook' => 'Facebook',
                        'linkedin' => 'LinkedIN',
                        'steam' => 'Steam',
                        'tumblr' => 'Tumblr',
                        'github' => 'GitHub',
                        'delicious' => 'Delicious',
                        'instagram' => 'Instagram',
                        'xing' => 'Xing',
                        'amazon'=> 'Amazon',
                        'dropbox'=> 'Dropbox',
                        'paypal'=> 'PayPal',
                   
                        'stumbleupon' => 'StumbleUpon',
                        'yahoo' => 'Yahoo',
                        'pinterest' => 'Pinterest',
                        'dribbble' => 'Dribbble',
                        'flickr' => 'Flickr',
                        'reddit' => 'Reddit',
                        'vimeo' => 'Vimeo',
                        'spotify' => 'Spotify',
                        'rss' => 'RSS',
                        'youtube' => 'YouTube',
                        'blogger' => 'Blogger',
                        'evernote' => 'Evernote',
                        'digg' => 'Digg',
                        'fivehundredpx' => '500px',
                        'forrst' => 'Forrst',
                        'appstore' => 'AppStore',
                        'lastfm' => 'LastFM',
                        'telegram' => 'Telegram',
                    ),
                ),
                'icons_url'  => array(
                    'type'        => 'text',
                    'label'       => esc_html__( 'URL to profile page', 'kirki' ),
                    //'description' => esc_html__( 'This will be the link URL', 'kirki' ),
                    'default'     => '',
                ),
            )
        ) );
 ?>