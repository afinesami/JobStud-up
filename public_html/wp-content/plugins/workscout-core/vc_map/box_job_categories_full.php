<?php 
add_action( 'vc_before_init', 'ws_box_job_categories_full_integrateWithVC' );
function ws_box_job_categories_full_integrateWithVC() {
  $box_jobs_categories = array('None' => ' ');

  $job_listing_categories = get_terms( 'job_listing_category', 'orderby=count&hide_empty=0' );
  if ( is_array( $job_listing_categories ) && ! empty( $job_listing_categories ) ) {
    foreach ( $job_listing_categories as $job_listing_category ) {
        $box_jobs_categories[ $job_listing_category->name ] =  esc_attr($job_listing_category->term_id) ;
    }
  }
  vc_map( array(
    "name" => esc_html__("Job categories list","workscout"),
    "base" => "jobs_categories",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Categories as list', 'workscout_core' ),
    "category" => esc_html__('WorkScout',"workscout"),
    "params" => array(
      /*    
    
        'type' => 'parent',  
       */
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Title', 'workscout_core' ),
        'param_name' => 'title',
        'description' => esc_html__( 'Enter text which will be used as title', 'workscout_core' )
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Wide version (use only on full-width page in full row', 'workscout_core' ),
        'param_name' => 'full_width',
        'description' => esc_html__( 'Setting this to wide on page with sidebar or not in the maximum wide container will cause layout break.', 'workscout_core' ),
        'value' => array(
          esc_html__( 'Standard', 'workscout_core' ) => 'false',
          esc_html__( 'Wide', 'workscout_core' ) => 'yes',
          ),
         'save_always' => true,
      ),
      array(
        "type" => "dropdown",
        "class" => "",
        "heading" => esc_html__("Hide empty", 'workscout_core'),
        "param_name" => "hide_empty",
        "value" => array(
         'Hide' => '1',
         'Show' => '0',
          ),
        'save_always' => true,
        "description" => "Hides categories that doesn't have any jobs"
      ),          
  array(
        "type" => "dropdown",
        "class" => "",
        "heading" => esc_html__("Show jobs counter", 'workscout_core'),
        "param_name" => "jobs_counter",
        "value" => array(
        'Enable' => 'yes',     
         'Disable' => 'no',
          ),
        'save_always' => true,
        "description" => "Show number of jobs assigned to this category"
      ),      
      array(
        "type" => "dropdown",
        "class" => "",
        "heading" => esc_html__("Type ", 'workscout_core'),
        "param_name" => "type",
        "value" => array(
         'none' => '',
            'Group by parent' => 'group_by_parents' ,
            'Show all categories' => 'all',
            'Show only parent categories' => 'only_parents',
            'Show just child categories from selectd parent' => 'parent' ,
          ),
         'save_always' => true,
        "description" => ""
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Parent id', 'workscout_core' ),
        'param_name' => 'parent_id',
        'value' => $box_jobs_categories,
        'dependency' => array(
          'element' => 'type',
          'value' => array( 'parent' ),
        ),
         'save_always' => true,
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order by', 'workscout_core' ),
        'param_name' => 'orderby',
        'save_always' => true,
        'value' => array(
          esc_html__( 'Name', 'workscout_core' ) => 'name',
          esc_html__( 'ID', 'workscout_core' ) => 'ID',
          esc_html__( 'Count', 'workscout_core' ) => 'count',
          esc_html__( 'Slug', 'workscout_core' ) => 'slug',
          esc_html__( 'None', 'workscout_core' ) => 'none',
          ),
        ),

      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order', 'workscout_core' ),
        'param_name' => 'order',
        'save_always' => true,
        'value' => array(
          esc_html__( 'Descending', 'workscout_core' ) => 'DESC',
          esc_html__( 'Ascending', 'workscout_core' ) => 'ASC'
          ),
      ),
       array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Total items', 'workscout_core' ),
        'param_name' => 'number',
        'value' => 10, // default value
        'description' => esc_html__( 'Set max limit for items  (limited to 1000).', 'workscout_core' ),
      ),
      array(
        'type' => 'from_vs_indicatior',
        'heading' => esc_html__( 'From Visual Composer', 'workscout_core' ),
        'param_name' => 'from_vs',
        'value' => 'yes',
        'save_always' => true,
        )
    )
  ));
}
 ?>