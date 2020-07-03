<?php 
/*
 * Counter for Visual Composer
 *
 */

add_action( 'vc_before_init', 'workscout_counterbox_integrateWithVC' );
function workscout_counterbox_integrateWithVC() {
  vc_map( array(
    "name" => esc_html__("Counters wraper", "workscout_core"),
    "base" => "counters",
    "as_parent" => array('only' => 'counter'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "category" => esc_html__('WorkScout', 'workscout_core'),
    'icon' => 'workscout_icon',
    "show_settings_on_create" => false,
    "params" => array(
        // add params same as with any other content element
      array(
        "type" => "textfield",
        "heading" => esc_html__("Extra class name", "workscout_core"),
        "param_name" => "el_class",
        "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "workscout")
        ),
      array(
        'type' => 'from_vs_indicatior',
        'heading' => esc_html__( 'From Visual Composer', 'workscout_core' ),
        'param_name' => 'from_vs',
        'value' => 'yes',
        'save_always' => true,
        )
      ),
    "js_view" => 'VcColumnView'
    ));
  vc_map( array(
    "name" => esc_html__("Count up box", 'workscout_core'),
    "base" => "counter",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Box with animated number\'s counting', 'workscout_core' ),
    "category" => esc_html__('WorkScout', 'workscout_core'),
    "params" => array(
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Title', 'workscout_core' ),
        'param_name' => 'title',
        'description' => esc_html__( 'Enter text which will be used as title.', 'workscout_core' )
        ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Get automatic value of', 'workscout_core' ),
        'param_name' => 'type',
        'description' => esc_html__( 'Ignore the next "number" attribute if this is set to something else then "custom"', 'workscout_core' ),
        'value' => array(
           '' => 'custom',
          esc_html__('Jobs','workscout_core') => 'jobs',
          esc_html__('Resumes','workscout_core') => 'resumes',
          esc_html__('Posts','workscout_core') => 'posts',
          esc_html__('Members','workscout_core') => 'members',
          esc_html__('Candidates','workscout_core') => 'candidates',
          esc_html__('Employers','workscout_core') => 'employers',
          ),
        'save_always' => false,
      ),
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Value', 'workscout_core' ),
        'param_name' => 'number',
        'description' => esc_html__( 'Only number (for example 2,147).', 'workscout_core' )
        ),      

      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Scale', 'workscout_core' ),
        'param_name' => 'scale',
        'description' => esc_html__( 'Optional. For example %, degrees, k, etc.', 'workscout_core' )
        ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Width of the box', 'workscout_core' ),
        'param_name' => 'width',
        'description' => esc_html__( 'Applicable if the element is a child of "counters" element', 'workscout_core' ),
        'value' => array(
          esc_html__('One-third','workscout_core') => 'one-third',
          esc_html__('Two','workscout_core') => 'two',
          esc_html__('Three','workscout_core') => 'three',
          esc_html__('Four','workscout_core') => 'four',
          ),
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

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Counters extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Counter extends WPBakeryShortCode {
    }
}
 ?>