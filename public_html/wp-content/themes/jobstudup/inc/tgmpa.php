<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Workscout for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'workscout_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function workscout_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin bundled with a theme.
		 array(
		            'name'          		=> 'WPBakery Page Builder', // The plugin name
		            'slug'          		=> 'js_composer', // The plugin slug (typically the folder name)
		            'source'            	=> get_template_directory() . '/plugins/js_composer.zip', // The plugin source
		            'required'          	=> true, // If false, the plugin is only 'recommended' instead of required
		            'version'          		=> '6.2.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
		            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
		            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		            'external_url'      	=> '', // If set, overrides default API URL and points to an external URL
        ),
	    array(
			        'name'                  => 'Revolution Slider',
			        'slug'                  => 'revslider',
			        'source'                => get_template_directory() . '/plugins/revslider.zip',
			        'version'               => '6.2.2',
			        'required'              => true,
	    ),
	    array(
			        'name'                  => 'WorkScout Core',
			        'slug'                  => 'workscout-core',
			        'source'                => get_template_directory() . '/plugins/workscout-core.zip',
			        'version'               => '1.0.9',
			        'required'              => true,
	    ),
		// array(
		// 	        'name'                  => 'Purethemes.net Shortcodes',
		// 	        'slug'                  => 'purethemes-shortcodes',
		// 	        'source'                => get_template_directory() . '/plugins/purethemes-shortcodes.zip',
		// 	        'version'               => '2.2',
		// 	        'required'              => true,
	 //    ),
     //    array(
			  //       'name'                  => 'Web Fonts Social Icons WP',
			  //       'slug'                  => 'web-font-social-icons',
			  //       'source'                => get_template_directory_uri() . '/plugins/web-font-social-icons.zip',
			  //       'version'               => '1.4',
			  //       'required'              => false,
	    // ),
        array(
			        'name'                  => 'Purethemes.net CPT',
			        'slug'                  => 'purethemes-cpt',
			        'source'                => get_template_directory_uri() . '/plugins/purethemes-cpt.zip',
			        'version'               => '1.1',
			        'required'              => false,
	    ),
	    array(
		            'name' => 'Envato Market',
		            'slug' => 'envato-market',
		            'source' => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
		            'required' => false,
		            'recommended' => true,
		            'version'               => '2.0.0',
            
        ),

        	array(
			'name'      			=> 'CMB2',
			'slug'      			=> 'cmb2',
			'required'  			=> true,
		),		
		array(
			'name'      			=> 'CMB2 Field Slider',
			'slug'      			=> 'cmb2-field-slider',
			'source'    			=> get_template_directory() . '/plugins/cmb2-field-slider.zip',
			'required'  			=> true,
		),	

		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
			'name'      			=> 'Contact Form 7',
			'slug'      			=> 'contact-form-7',
			'required'  			=> false,
		),

	    array(
	        'name'                  => 'WP-PageNavi', // The plugin name
	        'slug'                  => 'wp-pagenavi', // The plugin slug (typically the folder name)
	        'required'              => false, // If false, the plugin is only 'recommended' instead of required
	    ),

	    array(
	        'name'                  => 'Breadcrumb NavXT', // The plugin name
	        'slug'                  => 'breadcrumb-navxt', // The plugin slug (typically the folder name)
	        'required'              => true, // If false, the plugin is only 'recommended' instead of required
	    ),	    

	    array(
	        'name'                  => 'WP Job Manager', // The plugin name
	        'slug'                  => 'wp-job-manager', // The plugin slug (typically the folder name)
	        'required'              => true, // If false, the plugin is only 'recommended' instead of required
	    ),    
	    array(
	        'name'                  => 'WooCommerce', // The plugin name
	        'slug'                  => 'woocommerce', // The plugin slug (typically the folder name)
	        'required'              => true, // If false, the plugin is only 'recommended' instead of required
	    ),
   		// array(
	    //     'name'                  => 'WP Job Manager - Company Profiles', // The plugin name
	    //     'slug'                  => 'wp-job-manager-companies', // The plugin slug (typically the folder name)
	    //     'required'              => false, // If false, the plugin is only 'recommended' instead of required
	    // ),   		
	    // array(
	    //     'name'                  => 'Widget Importer & Exporter', // The plugin name
	    //     'slug'                  => 'widget-importer-exporter', // The plugin slug (typically the folder name)
	    //     'required'              => false, // If false, the plugin is only 'recommended' instead of required
	    // ),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'workscout',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                            // Message to output right before the plugins table.

		
	);

	tgmpa( $plugins, $config );
}