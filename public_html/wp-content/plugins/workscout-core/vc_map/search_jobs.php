<?php 
/*
 * [actionbox] 
 *
 */

add_action( 'vc_before_init', 'ws_workscout_search_jobs_integrateWithVC' );
function ws_workscout_search_jobs_integrateWithVC() {

  vc_map( array(
    "name" => esc_html__("Search Jobs Banner","workscout"),
    "base" => "jobs_searchbox",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Shows search box like on home page', 'workscout' ),
    "category" => esc_html__('WorkScout',"workscout"),
    "params" => array(

    array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Wide version (use only on full-width page in full row', 'workscout' ),
        'param_name' => 'full_width',
        'description' => esc_html__( 'Setting this to wide on page with sidebar or not in the maximum wide container will cause layout break.', 'workscout' ),
        'value' => array(
          esc_html__( 'Standard', 'workscout' ) => 'false',
          esc_html__( 'Wide', 'workscout' ) => 'yes',
          ),
      ),
     array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Show jobs counter', 'workscout' ),
        'param_name' => 'show_jobs',
        'description' => esc_html__( 'Show or hide jobs counter', 'workscout' ),
        'value' => array(
          esc_html__( 'Hide', 'workscout' ) => 'no',
          esc_html__( 'Show', 'workscout' ) => 'yes',
          ),
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
 ?>