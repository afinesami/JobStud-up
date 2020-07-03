<?php 
add_action( 'vc_before_init', 'pricing_woo_tables_integrateWithVC' );
function pricing_woo_tables_integrateWithVC() {

  vc_map( array(
    "name" => esc_html__("WooCommerce Pricing Tables", 'workscout'),
    "base" => "pricing_woo_tables",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Lists Products from WooCommerce', 'workscout' ),
    "category" => esc_html__('WorkScout', 'workscout'),
    "params" => array(
    
     array(
      'type' => 'from_vs_indicatior',
      'heading' => esc_html__( 'From Visual Composer', 'workscout' ),
      'param_name' => 'from_vs',
      'value' => 'yes',
      'save_always' => true,
      ),
     array(
          'type' => 'textfield',
          'heading' => esc_html__( 'Redirect link', 'workscout' ),
          'param_name' => 'redirect_url',
          
          'description' => esc_html__( 'Leave empty to use default add to cart action', 'workscout' ),
      ),
      array(
        'type' => 'checkbox',
        'heading' => esc_html__( 'Product types', 'workscout' ),
        'param_name' => 'products',
        'value' => array(
          esc_html__( 'Job packages', 'workscout' ) => 'job_package',
          esc_html__( 'Resume packages', 'workscout' ) => 'resume_package',
          esc_html__( 'Job packages subscriptions', 'workscout' ) => 'job_package_subscription',
          esc_html__( 'Resume packages subscriptions', 'workscout' ) => 'resume_package_subscription',
        ),
      ),  
      array(
          'type' => 'textfield',
          'heading' => esc_html__( 'Total items', 'workscout' ),
          'param_name' => 'limit',
          'value' => 3, // default value
          'description' => esc_html__( 'Set max limit for items or enter -1 to display all (limited to 1000).', 'workscout' ),
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order by', 'workscout' ),
        'param_name' => 'orderby',
        'value' => array(
          esc_html__( 'Price', 'workscout' ) => 'price',
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
    
     ),
    ));
}
 ?>