<?php 
/*
 * WooCommerce Products list for Visual Composer
 *
 */

add_action( 'vc_before_init', 'workscout_pricing_table_integrateWithVC' );
function workscout_pricing_table_integrateWithVC() {
  vc_map( array(
    "name" => esc_html__("Pricing table", 'workscout'),
    "base" => "pricing_table",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Pricing table', 'workscout' ),
    "category" => esc_html__('WorkScout', 'workscout'),
    "params" => array(
    array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Type of table', 'workscout' ),
        'param_name' => 'type',
        'value' => array(
          esc_html__('Standard','workscout') => 'color-1',
          esc_html__('Featured','workscout') => 'color-2',
          ),
        ),
    array(
      'type' => 'colorpicker',
      'heading' => esc_html__( 'Custom color', 'workscout' ),
      'param_name' => 'color',
      'description' => esc_html__( 'Select custom background color for table.', 'workscout' ),
      //'dependency' => array( 'element' => 'bgcolor', 'value' => array( 'custom' ) )
    ),
    array(
      'type' => 'textfield',
      'heading' => esc_html__( 'Title', 'workscout' ),
      'param_name' => 'title',
      'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'workscout' ),
      'save_always' => true,
      ),
    array(
      'type' => 'textfield',
      'heading' => esc_html__( 'Currency', 'workscout' ),
      'param_name' => 'currency',
      'value' => '$',
      'save_always' => true,
      'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'workscout' )
      ),
    array(
      'type' => 'textfield',
      'heading' => esc_html__( 'Price', 'workscout' ),
      'param_name' => 'price',
      'value' => '30',
      'save_always' => true,
      ),
    array(
      'type' => 'textfield',
      'heading' => esc_html__( 'Per', 'workscout' ),
      'param_name' => 'per',
      'value' => 'per month',
      'save_always' => true,
      ),
      array(
      'type' => 'textarea_html',
      'heading' => esc_html__( 'Content', 'workscout' ),
      'param_name' => 'content',
      'description' => esc_html__( 'Put here simple UL list', 'workscout' )
      ),
    array(
      'type' => 'textfield',
      'heading' => esc_html__( 'Button URL', 'workscout' ),
      'param_name' => 'buttonlink',
      'value' => ''
      ),
    array(
      'type' => 'textfield',
      'heading' => esc_html__( 'Button text', 'workscout' ),
      'param_name' => 'buttontext',
      'value' => ''
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
} ?>