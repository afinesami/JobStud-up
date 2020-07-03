<?php 
add_action( 'vc_before_init', 'ws_box_resume_categories_integrateWithVC' );
function ws_box_resume_categories_integrateWithVC() {
  $box_resumes_categories = array('None' => ' ');

  $resume_categories = get_terms( 'resume_category', 'orderby=count&hide_empty=0' );
  if ( is_array( $resume_categories ) && ! empty( $resume_categories ) ) {
    foreach ( $resume_categories as $resume_category ) {
        $box_resumes_categories[ $resume_category->name ] =  esc_attr($resume_category->term_id) ;
    }
  }
  vc_map( array(
    "name" => esc_html__("Resumes categories grid","workscout"),
    "base" => "box_resume_categories",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Grid with icons', 'workscout_core' ),
    "category" => esc_html__('WorkScout',"workscout_core"),
    "params" => array(
      array(
        "type" => "dropdown",
        "class" => "",
        "heading" => esc_html__("Empty categories..", 'workscout_core'),
        "param_name" => "hide_empty",
        "value" => array(
         'Hide' => '1',     
         'Show' => '0',
        ),
        'save_always' => true,
        "description" => "Hides categories that doesn't have any resumes"
      ),
      array(
        "type" => "dropdown",
        "class" => "",
        "heading" => esc_html__("Show only parent categories", 'workscout_core'),
        "param_name" => "only_parents",
        "value" => array(
              
         'Disable' => 'no',
         'Enable' => 'yes',
          ),
        'save_always' => true,
        "description" => "Show only parent categories"
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
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order by', 'workscout_core' ),
        'param_name' => 'orderby',
        'value' => array(
          esc_html__( 'Name', 'workscout_core' ) => 'name',
          esc_html__( 'ID', 'workscout_core' ) => 'ID',
          esc_html__( 'Count', 'workscout_core' ) => 'count',
          esc_html__( 'Slug', 'workscout_core' ) => 'slug',
          esc_html__( 'None', 'workscout_core' ) => 'none',
          ),
         'save_always' => true,
        ),

      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order', 'workscout_core' ),
        'param_name' => 'order',
        'value' => array(
          esc_html__( 'Descending', 'workscout_core' ) => 'DESC',
          esc_html__( 'Ascending', 'workscout_core' ) => 'ASC'
          ),
         'save_always' => true,
      ),

       array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Total items', 'workscout_core' ),
        'param_name' => 'number',
        'value' => 10, // default value
        'description' => esc_html__( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'workscout_core' ),
      ),

      array(
        'type' => 'href',
        'heading' => esc_html__( '"Browse categories" button', 'workscout_core' ),
        'param_name' => 'browse_link',
        'description' => esc_html__( 'The button will be added to the end of the grid.', 'workscout_core' ),
        
      ),
       array(
        "type" => "dropdown",
        "class" => "",
        "heading" => esc_html__("Layout of category boxes", 'workscout_core'),
        "param_name" => "layout",
        "value" => array(
         'Boxed (new)' => 'new',     
         'Boxed' => 'boxed',     
         'Old classic' => 'classic',     
         'Old flex' => 'flex',
        ),
        'save_always' => true,
        "description" => ""
      ),




      array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'Include only', 'workscout_core' ),
        'param_name' => 'include',
        'description' => esc_html__( 'Add resume categories.', 'workscout_core' ),
        'settings' => array(
            'multiple' => true,
            'sortable' => true,
          ),
        ),      
      array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'Exclude only', 'workscout_core' ),
        'param_name' => 'exclude',
        'description' => esc_html__( 'Add resume categories.', 'workscout_core' ),
        'settings' => array(
            'multiple' => true,
            'sortable' => true,
          ),
        ),

      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Child of', 'workscout_core' ),
        'param_name' => 'child_of',
        'value' => $box_resumes_categories,
      ),
    )
  ));
}

add_filter( 'vc_autocomplete_box_resume_categories_include_callback',
  'vc_include_resume_categories_search', 10, 1 ); // Get suggestion(find). Must return an array

 add_filter( 'vc_autocomplete_box_resume_categories_include_render',
  'vc_include_resume_categories_render', 10, 1 ); // Render exact product. Must return an array (label,value)

add_filter( 'vc_autocomplete_box_resume_categories_exclude_callback',
  'vc_include_resume_categories_search', 10, 1 ); // Get suggestion(find). Must return an array

 add_filter( 'vc_autocomplete_box_resume_categories_exclude_render',
  'vc_include_resume_categories_render', 10, 1 ); // Render exact product. Must return an array (label,value)

?>