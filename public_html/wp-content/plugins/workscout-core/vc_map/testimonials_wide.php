<?php 
/*
 * [testimonials_wide] 
 *
 */
add_action( 'vc_before_init', 'ws_testimonials_wide_integrateWithVC' );
function ws_testimonials_wide_integrateWithVC() {
  vc_map( array(
    "name" => esc_html__("Testimonials (old)","workscout"),
    "base" => "testimonials_wide",
    'icon' => 'workscout_icon',
  
    "category" => esc_html__('WorkScout',"workscout"),
    "params" => array(
      array(
          'type' => 'textfield',
          'heading' => esc_html__( 'Total items', 'workscout' ),
          'param_name' => 'per_page',
          'value' => 4, // default value
          'description' => esc_html__( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'workscout' ),
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order by', 'workscout' ),
        'param_name' => 'orderby',
        'value' => array(

          esc_html__( 'Date', 'workscout' ) => 'date',
          esc_html__( 'ID', 'workscout' ) => 'ID',
          esc_html__( 'Author', 'workscout' ) => 'author',
          esc_html__( 'Title', 'workscout' ) => 'title',
          esc_html__( 'Modified', 'workscout' ) => 'modified',
          esc_html__( 'Random', 'workscout' ) => 'rand',
          ),
        ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order', 'workscout' ),
        'param_name' => 'order',
        'value' => array(
          esc_html__( 'Descending', 'workscout' ) => 'DESC',
          esc_html__( 'Ascending', 'workscout' ) => 'ASC'
          ),
      ),
      array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'Exclude Testomionials', 'workscout' ),
        'param_name' => 'exclude_posts',
        'settings' => array(
            'multiple' => true,
            'sortable' => true,
          ),
      ),       
      array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'Include Testomionials', 'workscout' ),
        'param_name' => 'include_posts',
        'settings' => array(
            'multiple' => true,
            'sortable' => true,
          ),
      ),        
      array(
        'type' => 'attach_image',
        'heading' => esc_html__( 'Background Image for Testomionials section', 'workscout' ),
        'param_name' => 'background',
        'value' => '',
        'description' => esc_html__( 'Select image from media library.', 'workscout' )
        ),
      array(
        'type' => 'from_vs_indicatior',
        'heading' => esc_html__( 'From Visual Composer', 'workscout' ),
        'param_name' => 'from_vs',
        'value' => 'yes',
        'save_always' => true,
      )
    ),
  ));
}

add_filter( 'vc_autocomplete_testimonials_wide_include_posts_callback',
  'vc_include_testimonials_search', 10, 1 ); // Get suggestion(find). Must return an array

 add_filter( 'vc_autocomplete_testimonials_wide_include_posts_render',
  'vc_include_testimonials_render', 10, 1 ); // Render exact product. Must return an array (label,value)

add_filter( 'vc_autocomplete_testimonials_wide_exclude_posts_callback',
  'vc_include_testimonials_search', 10, 1 ); // Get suggestion(find). Must return an array

 add_filter( 'vc_autocomplete_testimonials_wide_exclude_posts_render',
  'vc_include_testimonials_render', 10, 1 ); // Render exact product. Must return an array (label,value)

?>