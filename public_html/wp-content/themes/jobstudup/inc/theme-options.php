<?php
/**
 * Initialize the custom Theme Options.
 */
add_action( 'admin_init', 'workscout_custom_theme_options' );

/**
 * Build the custom settings & update OptionTree.
 *
 * @return    void
 * @since     2.0
 */
function workscout_custom_theme_options() {
   global $wpdb;
   $revsliders = array();

   $faicons = workscout_icons_list();
   // $newfaicons = array();
   // foreach ($faicons as $key => $value) {
   //   $newfaicons[] =  array('value'=> $key,'label' => $value);
   // }
   


   /**
   * Get a copy of the saved settings array.
   */
    $saved_settings = get_option( ot_settings_id(), array() );


    $table_name = $wpdb->prefix . "revslider_sliders";
    // Get sliders

    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
      $sliders = $wpdb->get_results( "SELECT alias, title FROM $table_name" );
    } else {
      $sliders = '';
    }

    if($sliders) {
      foreach($sliders as $key => $item) {
        $revsliders[] = array(
          'label' => $item->title,
          'value' => $item->alias
          );
      }
    } else {
      $revsliders[] = array(
        'label' => esc_html__('No Sliders Found','workscout'),
        'value' => ''
        );
    }
  /**
   * Custom settings array that will eventually be
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array(

    'sections'        => array(

      array(
        'title'       => esc_html__('Contact Page','workscout'),
        'id'          => 'contact'
      ),
      array(
        'title'       =>  esc_html__( 'General', 'workscout' ),
        'id'          => 'general_default'
        ), 
   
      array(
        'id'          => 'sidebars',
        'title'       => esc_html__( 'Sidebars', 'workscout' )
      ),    
   
    ),

    'settings'        => array(



        array(
            'label'       => 'Choose "My Bookmarks"',
            'id'          => 'pp_bookmarks_page',
            'type'        => 'page_select',
            'desc'        => 'this page needs to have shortcode [my_bookmarks] in the content',
            'std'         => '',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => '',
            'section'     => 'general_default'
        ),
        
     

        // array(
        //       'id'          => 'pp_custom_css',
        //       'label'       => 'Custom CSS',
        //       'desc'        => 'To prevent problems with theme update, write here any custom css (or use child themes)',
        //       'std'         => '',
        //       'type'        => 'textarea-simple',
        //       'section'     => 'general_default',
        //       'rows'        => '',
        //       'post_type'   => '',
        //       'taxonomy'    => '',
        //       'class'       => ''
        // ),
        
      
      ),
    )
  );

  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( ot_settings_id() . '_args', $custom_settings );

  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( ot_settings_id(), $custom_settings );
  }

}