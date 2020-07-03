<?php 
add_action( 'vc_before_init', 'ws_workscout_map_integrateWithVC' );
function ws_workscout_map_integrateWithVC() {

  vc_map( array(
    "name" => esc_html__("Jobs/Resumes Map","workscout"),
    "base" => "workscout-map",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Shows map will all jobs/resumes', 'workscout' ),
    "category" => esc_html__('WorkScout',"workscout"),
    "params" => array(

    array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Content source', 'workscout' ),
        'param_name' => 'type',
        'description' => esc_html__( 'Choose maps or resumes (if applicable)', 'workscout' ),
        'value' => array(
          esc_html__( 'Job listings', 'workscout' ) => 'job_listing',
          esc_html__( 'Resumes', 'workscout' ) => 'resume',
          ),
      ),

      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Map height (in px) ', 'workscout' ),
        'value' => '450',
        'param_name' => 'buttontext',
        'description' => esc_html__( 'Put just a number.', 'workscout' )
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