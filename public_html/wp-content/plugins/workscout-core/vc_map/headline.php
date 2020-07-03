<?php 

/*
 * Headline for Visual Composer
 *
 */
add_action( 'vc_before_init', 'pp_headline_integrateWithVC' );
function pp_headline_integrateWithVC() {
  vc_map( array(
    "name" => esc_html__("Headline","workscout"),
    "base" => "headline",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Header', 'workscout_core' ),
//    'admin_enqueue_js' => array(get_template_directory_uri().'/vc_templates/js/vc_image_caption_box.js'),
    "category" => esc_html__('WorkScout',"workscout"),
    "params" => array(
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Title', 'workscout_core' ),
        'param_name' => 'content',
        'description' => esc_html__( 'Enter text which will be used as title', 'workscout_core' )
        ),
   array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Subtitle', 'workscout_core' ),
        'param_name' => 'subtitle',
        'description' => esc_html__( 'Optional  subtitle', 'workscout_core' )
        ),
      array(
        'type' => 'font_container',
        'param_name' => 'font_container',
        'value' => '',
        'settings'=>array(
             'fields'=>array(
                 'tag'=>'h3',
                 'text_align',
                 'font_size',
                 'line_height',
                 'color',
                 'tag_description' => __('Select element tag.','workscout_core'),
                 'text_align_description' => __('Select text alignment.','workscout_core'),
                 'font_size_description' => __('Enter font size (add scale like px, %, em etc).','workscout_core'),
                 'line_height_description' => __('Enter line height (add scale like px, %, em etc).','workscout_core'),
                 'color_description' => __('Select color for your element.','workscout_core'),
             ),
         ),
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Top margin', 'workscout_core' ),
        'param_name' => 'margintop',
        'value' => array(
          '0' => '0',
          '10' => '10',
          '15' => '15',
          '20' => '20',
          '25' => '25',
          '30' => '30',
          '35' => '35',
          '40' => '40',
          '45' => '45',
          '50' => '50',
          ),
        'std' => '15',
        'description' => esc_html__( 'Choose top margin (in px)', 'workscout_core' )
        ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Bottom margin', 'workscout_core' ),
        'param_name' => 'marginbottom',
        'value' => array(
          '0' => '0',
          '10' => '10',
          '15' => '15',
          '20' => '20',
          '25' => '25',
          '30' => '30',
          '35' => '35',
          '40' => '40',
          '45' => '45',
          '50' => '50',
          ),
        'std' => '35',
        'description' => esc_html__( 'Choose bottom margin (in px)', 'workscout_core' )
        ),
      array(
          'type' => 'vc_link',
          'heading' => __( 'URL (Link)', 'workscout_core' ),
          'param_name' => 'url',
          'description' => __( 'Button link.', 'workscout_core' )
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Clearfix after?', 'workscout_core' ),
        'param_name' => 'clearfix',
        'description' => esc_html__( 'Add clearfix after headline, you might want to disable it for some elements, like the recent products carousel.', 'workscout_core' ),
        'value' => array(
          esc_html__( 'Yes, please', 'workscout_core' ) => '1',
          esc_html__( 'No, thank you', 'workscout_core' ) => 'no',
          ),
        'std' => '1',
        ),
      ),
  ));
}

?>