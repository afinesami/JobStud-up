<?php 
add_action( 'vc_before_init', 'clients_carousel_integrateWithVC' );
function clients_carousel_integrateWithVC() {

  vc_map( array(
    "name" => esc_html__("Client logos carousel", 'workscout_core'),
    "base" => "vc_clients_carousel",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Carousel with logos', 'workscout_core' ),
    "category" => esc_html__('WorkScout', 'workscout_core'),
    "params" => array(
     array(
      'type' => 'attach_images',
      'heading' => esc_html__( 'Clients logos', 'workscout_core' ),
      'param_name' => 'logos',
      'value' => '',
      'description' => esc_html__( 'Select images from media library.', 'workscout_core' )
      ),
     array(
      'type' => 'from_vs_indicatior',
      'heading' => esc_html__( 'From Visual Composer', 'workscout_core' ),
      'param_name' => 'from_vs',
      'value' => 'yes',
      'save_always' => true,
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Auto play', 'workscout_core' ),
        'param_name' => 'autoplay',
        'value' => array(
          esc_html__( 'Off', 'workscout_core' ) => 'off',
          esc_html__( 'On', 'workscout_core' ) => 'on'
          ),
      ),    
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Delay', 'workscout_core' ),
        'param_name' => 'delay',
        'description' => esc_html__( 'Autoplay delay value', 'workscout_core' ),
        'value' => 5000
      ), 
     ),
    ));
}
 ?>