<?php 
// Begin Shortcodes
class WorkScout_Core_Shortcodes {
    
    function __construct() {
    
        //Initialize shortcodes
        add_action( 'init', array( $this, 'add_shortcodes' ) );
            
    }

    function add_shortcodes() {

        $shortcodes = array(
            'accordion',
            'accordion_wrap',
            'accordionwrap',
            'actionbox',
            'box',
            'box_job_categories',
            'box_resume_categories',
            'button',
            'centered_headline',
            'clear',
            'clients_carousel',
            'column',
            'counter',
            'counters',
            'dropcap',
            'headline',
            'icon',
            'iconbox',
            'infobanner',
            'jobs',
            'jobs_categories',
            'jobs_searchbox',
            'resumes_searchbox',
            'latest_from_blog',
            'liststyle',
            'list',
            'popup',
            'pricing_table',
            'pricing_woo_tables',
            'resume_categories',
            'skill_categories',
            'resumes',
            'simple_resumes',
            'spacer',
            'space',
            'spotlight_jobs',
            'spotlight_resumes',
            'tab',
            'tab_group',
            'tabgroup',
            'testimonials_wide',
            'testimonials_carousel',
            'vc_clients_carousel',
            'flip_banner',
            'imagebox',
        );

        foreach ( $shortcodes as $shortcode ) {
            $function = 'workscout_' .  $shortcode ;
            if (!function_exists($function)) {
                 include_once wp_normalize_path( WORKSCOUT_PLUGIN_DIR . '/shortcodes/'.$shortcode.'.php' );
                 add_shortcode( $shortcode, $function);
            }
        }
    }


}



/* Visual Composer Shortcodes*/
?>