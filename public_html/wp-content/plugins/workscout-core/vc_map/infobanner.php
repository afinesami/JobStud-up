<?php 
/*
 * [actionbox] 
 *
 */
add_action( 'vc_before_init', 'ws_workscout_info_banner_integrateWithVC' );
function ws_workscout_info_banner_integrateWithVC() {
  $target_arr = array(
    esc_html__( 'Same window', 'workscout_core' ) => '_self',
    esc_html__( 'New window', 'workscout_core' ) => '_blank'
  );
  vc_map( array(
    "name" => esc_html__("Info Banner","workscout_core"),
    "base" => "infobanner",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Shows call-to-action box', 'workscout_core' ),
    "category" => esc_html__('WorkScout',"workscout"),
    "params" => array(

      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Title', 'workscout_core' ),
        'param_name' => 'title',
        'value' => 'Start Building Your Own Job Board Now ', // default value
        'description' => '',
      ),     
      array(
      'type' => 'textarea_html',
      'heading' => esc_html__( 'Content', 'workscout_core' ),
      'param_name' => 'content',
      'description' => esc_html__( 'Put here simple UL list', 'workscout_core' )
      ), 
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'URL', 'workscout_core' ),
        'param_name' => 'url',
        'description' => esc_html__( 'Where button will link.', 'workscout_core' )
      ),
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Button text', 'workscout_core' ),
        'param_name' => 'buttontext',
        'description' => esc_html__( 'Button text - leave empty to hide button.', 'workscout_core' )
      ),
      array(
        "type" => "dropdown",
        "class" => "",
        "heading" => esc_html__("Link target", 'workscout_core'),
        "param_name" => "type",
        "value" => $target_arr,
        "description" => ""
      ),
      array(
        'type' => 'from_vs_indicatior',
        'heading' => esc_html__( 'From Visual Composer', 'workscout_core' ),
        'param_name' => 'from_vs',
        'value' => 'yes',
        'save_always' => true,
      )

    ),
  ));
} ?>