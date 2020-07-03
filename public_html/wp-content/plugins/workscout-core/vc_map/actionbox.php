<?php 
/*
 * [actionbox] 
 *
 */
add_action( 'vc_before_init', 'ws_actionbox_integrateWithVC' );
function ws_actionbox_integrateWithVC() {
  vc_map( array(
    "name" => esc_html__("Action Box","workscout"),
    "base" => "actionbox",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Call-to-action box', 'workscout_core' ),
    "category" => esc_html__('WorkScout',"workscout"),
    "params" => array(
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Wide version (use only on full-width page in full row', 'workscout_core' ),
        'param_name' => 'wide',
        'description' => esc_html__( 'Setting this to wide on page with sidebar or not in the maximum wide container will cause layout break.', 'workscout_core' ),
        'value' => array(
          esc_html__( 'Standard', 'workscout_core' ) => 'false',
          esc_html__( 'Wide', 'workscout_core' ) => 'true',
          ),
        'save_always' => true,
      ),
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Title', 'workscout_core' ),
        'param_name' => 'title',
        'value' => 'Start Building Your Own Job Board Now ', // default value
        'description' => '',
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
        'type' => 'from_vs_indicatior',
        'heading' => esc_html__( 'From Visual Composer', 'workscout_core' ),
        'param_name' => 'from_vs',
        'value' => 'yes',
        'save_always' => true,
      )

    ),
  ));
}

?>