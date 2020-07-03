<?php

/*
 * Iconbox for Visual Composer
 *
 */
add_action( 'vc_before_init', 'pp_flipbanner_integrateWithVC' );
function pp_flipbanner_integrateWithVC() {
  vc_map( array(
    "name" => esc_html__("Flip Banner","workscout"),
    "base" => "flip_banner",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Banner with text on hover', 'workscout_core' ),
    "category" => esc_html__('WorkScout',"workscout"),
    "params" => array(
        array(
          'type' => 'textfield',
          'heading' => esc_html__( 'Visible text', 'workscout_core' ),
          'param_name' => 'text_visible',
          
          'save_always' => true,
          ),          
        array(
          'type' => 'textfield',
          'heading' => esc_html__( 'Text displayed on hover', 'workscout_core' ),
          'param_name' => 'text_hidden',
          
          'save_always' => true,
          ),        
        array(
          'type' => 'textfield',
          'heading' => esc_html__( 'Banner url', 'workscout_core' ),
          'param_name' => 'url',
          
          'save_always' => true,
          ),      
        array(
          'type' => 'attach_image',
          'heading' => esc_html__( 'Background image', 'workscout_core' ),
          'param_name' => 'background',
          'value' => '',
          'description' => esc_html__( 'Select image from media library.', 'workscout_core' )
        ),  
        array(
          'type' => 'colorpicker',
          'heading' => esc_html__( 'Overlay color', 'workscout_core' ),
          'param_name' => 'color',
          'value' => '#274abb',
          'description' => esc_html__( 'Select color.', 'workscout_core' )
        ),
        array(
          'type' => 'textfield',
          'heading' => esc_html__( 'Opacity', 'workscout_core' ),
          'param_name' => 'opacity',
          'value' => '0.92', // default value
          'description' => '',
           'save_always' => true,
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