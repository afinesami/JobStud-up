<?php 
/*
 * [spotlight_jobs] 
 *
 */
add_action( 'vc_before_init', 'ws_spotlight_jobs_integrateWithVC' );
function ws_spotlight_jobs_integrateWithVC() {
  vc_map( array(
    "name" => esc_html__("Featured jobs carousel","workscout"),
    "base" => "spotlight_jobs",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Shows carousel with selected jobs', 'workscout' ),
    "category" => esc_html__('WorkScout',"workscout"),
    "params" => array(
      array(
          'type' => 'textfield',
          'heading' => esc_html__( 'Total items', 'workscout' ),
          'param_name' => 'per_page',
          'value' => 3, // default value
          'description' => esc_html__( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'workscout' ),
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order by', 'workscout' ),
        'param_name' => 'orderby',
        'value' => array(
          esc_html__( 'Featured', 'workscout' ) => 'featured',
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
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Title', 'workscout' ),
        'param_name' => 'title',
        'description' => esc_html__( 'Enter text which will be used as title', 'workscout' )
      ),
      array(
            "type"        => "checkbox",
            "heading"     => __("Job Meta data",'workscout'),
            "param_name"  => "meta",
            "admin_label" => true,
            "value"       => array(
               'Company'  =>  'company',
               'Location' =>  'location',
               'Rate'     =>  'rate',
               'Salary'   =>  'salary',
               'Date'     =>  'date',
               'Deadline' =>  'deadline',
               'Expires'  =>  'expires',
            ), //value
            "std"         => " ",
          
      ),
      array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'From Categories only', 'workscout' ),
        'param_name' => 'categories',
        'description' => esc_html__( 'Add job categories.', 'workscout' ),
        'settings' => array(
            'multiple' => true,
            'sortable' => true,
          ),
      ),        
      array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'From job types only', 'workscout' ),
        'param_name' => 'job_types',
        'description' => esc_html__( 'Add job types.', 'workscout' ),
        'settings' => array(
            'multiple' => true,
            'sortable' => true,
          ),
      ),   

       array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'Show only this jobs', 'workscout' ),
        'param_name' => 'job_ids',
        'description' => esc_html__( 'Select jobs.', 'workscout' ),
        'settings' => array(
            'multiple' => true,
            'sortable' => true,
          ),
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Filled', 'workscout' ),
        'param_name' => 'filled',
        'value' => array(
          esc_html__( 'Show all', 'workscout' ) => 'null',
          esc_html__( 'Show only filled', 'workscout' ) => 'true',
          esc_html__( 'Hide filled', 'workscout' ) => 'false'
          ),
        'save_always' => true,
      ),       
      // array(
      //   'type' => 'dropdown',
      //   'heading' => esc_html__( 'Visible Elements', 'workscout' ),
      //   'param_name' => 'visible',
      //   'description' => esc_html__( 'How many elements are visible at once for each screen size (desktop, netbook, tablet, mobile phone).', 'workscout' ),
      //   'value' => array(
      //     esc_html__( '1,1,1,1', 'workscout' ) => '1,1,1,1',
      //     esc_html__( '2,1,1,1', 'workscout' ) => '2,1,1,1',
      //     esc_html__( '2,2,1,1', 'workscout' ) => '2,2,1,1',
      //     esc_html__( '3,2,1,1', 'workscout' ) => '3,2,1,1',
      //     esc_html__( '3,3,1,1', 'workscout' ) => '3,3,2,1',
      //     esc_html__( '4,3,2,2', 'workscout' ) => '4,3,2,2',
      //     ),
      //   'save_always' => true,
      // ), 
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Auto play', 'workscout' ),
        'param_name' => 'autoplay',
        'value' => array(
          esc_html__( 'Off', 'workscout' ) => 'off',
          esc_html__( 'On', 'workscout' ) => 'on'
          ),
      ),    
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Delay', 'workscout' ),
        'param_name' => 'delay',
        'description' => esc_html__( 'Autoplay delay value', 'workscout' ),
        'value' => 5000
      ), 
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Featured', 'workscout' ),
        'param_name' => 'featured',
        'value' => array(
          esc_html__( 'Show all', 'workscout' ) => 'false',
          esc_html__( 'Show only featured', 'workscout' ) => 'true',
          ),
        'save_always' => true,
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Limit content by', 'workscout' ),
        'param_name' => 'limitby',
        'value' => array(
          esc_html__( 'Words', 'workscout' ) => 'words',
          esc_html__( 'Characters', 'workscout' ) => 'characters',
          ),
      ),
     array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Limit', 'workscout' ),
        'param_name' => 'limit',
        'description' => esc_html__( 'Limit number', 'workscout' ),
        'value' => 20
      ), 
    ),
  ));
}
add_filter( 'vc_autocomplete_spotlight_jobs_categories_callback',
  'vc_include_job_categories_search', 10, 1 ); // Get suggestion(find). Must return an array

 add_filter( 'vc_autocomplete_spotlight_jobs_categories_render',
  'vc_include_job_categories_render', 10, 1 ); // Render exact product. Must return an array (label,value)

add_filter( 'vc_autocomplete_spotlight_jobs_job_ids_callback',
  'vc_include_job_job_ids_search', 10, 1 ); // Get suggestion(find). Must return an array

 add_filter( 'vc_autocomplete_spotlight_jobs_job_ids_render',
  'vc_include_job_job_ids_render', 10, 1 ); // Render exact product. Must return an array (label,value)

add_filter( 'vc_autocomplete_spotlight_jobs_job_types_callback',
  'vc_include_job_types_search', 10, 1 ); // Get suggestion(find). Must return an array

 add_filter( 'vc_autocomplete_spotlight_jobs_job_types_render',
  'vc_include_job_types_render', 10, 1 ); // Render exact product. Must return an array (label,value)
?>