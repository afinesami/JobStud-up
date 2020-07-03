<?php 
add_action( 'vc_before_init', 'workscout_jobs_integrateWithVC' );
function workscout_jobs_integrateWithVC() {

 vc_map( array(
  "name" => esc_html__("Jobs (WPJM)", 'workscout'),
  "base" => "jobs",
  'icon' => 'workscout_icon',
  "category" => esc_html__('WorkScout', 'workscout'),
  "params" => array(
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Per Page', 'workscout' ),
        'param_name' => 'per_page',
        'description' => esc_html__( 'Defaults to the ‘per page’ option in settings. This controls how many jobs get listed per page..', 'workscout' ),
        'save_always' => true,
        ),
      array(
          'type' => 'dropdown',
          'heading' => esc_html__( 'Orderby', 'workscout' ),
          'param_name' => 'orderby',
          'value' => array(
            esc_html__( 'Featured', 'workscout' )   => 'featured',
            esc_html__( 'Title', 'workscout' )      => 'title',
            esc_html__( 'ID', 'workscout' )         => 'ID',
            esc_html__( 'Name', 'workscout' )       => 'name',
            esc_html__( 'Date', 'workscout' )       => 'date',
            esc_html__( 'Modified', 'workscout' )   => 'modified',
            esc_html__( 'Rand', 'workscout' )       => 'rand',
            ),
          'description' => esc_html__("Defaults to ‘featured’. Supports title, ID, name, date, modified, rand, featured.",'workscout')
        ),   
      array(
          'type' => 'dropdown',
          'heading' => esc_html__( 'Order', 'workscout' ),
          'param_name' => 'order',
          'value' => array(
            esc_html__( 'Descending', 'workscout' ) => 'DESC',
            esc_html__( 'Ascending', 'workscout' ) => 'ASC'
            ),
          'description' => esc_html__("Defaults to ‘desc’. Can be set to ‘asc’ or ‘desc’ to choose the sorting direction.",'workscout')
        ),
      array(
        "type" => "dropdown",
        "class" => "",
        "heading" => esc_html__("Show filters (over the list)", 'workscout'),
        "param_name" => "show_filters",
         'save_always' => true,
        "value" => array(
          'False' => 'false',
          'True' => 'true',
          ),
        "description" => ""
      ),    
      array(
        "type" => "dropdown",
        "class" => "",
        "heading" => esc_html__("Show pagination", 'workscout'),
        "param_name" => "show_pagination",
        "value" => array(
          'False' => '',
          'True' => 'true',
          ),
        "description" => " Defaults to false. Enable this to show numbered pagination instead of the ‘load more jobs’ link."
      ),     
      array(
        "type" => "autocomplete",
        "class" => "",
        "heading" => esc_html__("Categories", 'workscout'),
        "param_name" => "categories",
        "description" => "Comma separate slugs to limit the jobs to certain categories. ",
        'settings' => array(
            'multiple' => true,
            'sortable' => true,
          ),
        ),
    array(
        "type" => "autocomplete",
        "class" => "",
        "heading" => esc_html__("Job types", 'workscout'),
        "param_name" => "job_types",
        "description" => "Comma separate slugs to limit the jobs to certain job types. ",
        'settings' => array(
            'multiple' => true,
            'sortable' => true,
          ),
      ),     
      array(
        "type" => "textfield",
        "class" => "",
        "heading" => esc_html__("Location", 'workscout'),
        "param_name" => "location",
        "description" => "Enter a location keyword to search by default."
      ),      
      array(
        "type" => "textfield",
        "class" => "",
        "heading" => esc_html__("Keywords", 'workscout'),
        "param_name" => "keywords",
        "description" => "Enter a keyword to search by default."
      ),
      array(
        "type" => "dropdown",
        "class" => "",
        "heading" => esc_html__("Featured", 'workscout'),
        "param_name" => "featured",
        "value" => array(
          'Empty' => 'empty',
          'False' => 'false',
          'True' => 'true',
          ),
        "description" => "Set to true to show only featured jobs, false to show no featured jobs, or leave out entirely to show both (featured first)."
      ),        
      array(
        "type" => "dropdown",
        "class" => "",
        "heading" => esc_html__("Filled", 'workscout'),
        "param_name" => "filled",
        "value" => array(
          'Empty' => 'empty',
          'False' => 'false',
          'True' => 'true',
          ),
        "description" => "Set to true to show only filled jobs, false to show no filled jobs, or leave out entirely to respect the default settings.."
      ),  

    ),

));
}

add_filter( 'vc_autocomplete_jobs_categories_callback',
  'vc_include_job_categories_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_jobs_categories_render',
  'vc_include_job_categories_render', 10, 1 ); // Render exact product. Must return an array (label,value)
                                               // 
add_filter( 'vc_autocomplete_jobs_job_types_callback',
  'vc_include_job_types_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_jobs_job_types_render',
  'vc_include_job_types_render', 10, 1 ); // Render exact product. Must return an array (label,value)


 ?>