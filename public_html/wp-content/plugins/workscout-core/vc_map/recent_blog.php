<?php 
/*
 * Recent blog posts for Visual Composer
 *
 */

add_action( 'vc_before_init', 'workscout_recent_blog_integrateWithVC' );
function workscout_recent_blog_integrateWithVC() {
  vc_map( array(
    "name" => esc_html__("Recent blog posts","workscout"),
    "base" => "latest_from_blog",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Recent posts list', 'workscout' ),
    "category" => esc_html__('WorkScout',"workscout"),
    /*  'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
    'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),*/
    "params" => array(
      array(
          'type' => 'textfield',
          'heading' => esc_html__( 'Total items', 'workscout' ),
          'param_name' => 'limit',
          'value' => 3, // default value
          'save_always' => true,
          'description' => esc_html__( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'workscout' ),
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'In how many columns will be post displayed', 'workscout' ),
        'param_name' => 'columns',
        'save_always' => true,
        'value' => array('2','3','4'),
        'save_always' => true,
        ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Masonry mode', 'workscout' ),
        'param_name' => 'masonry',
        'save_always' => true,
        'value' => array(
          esc_html__( 'Disable', 'workscout' ) => 'no',
          esc_html__( 'Enable', 'workscout' ) => 'yes'
          ),
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order by', 'workscout' ),
        'param_name' => 'orderby',
         'save_always' => true,
        'value' => array(
          esc_html__( 'Date', 'workscout' ) => 'date',
          esc_html__( 'ID', 'workscout' ) => 'ID',
          esc_html__( 'Author', 'workscout' ) => 'author',
          esc_html__( 'Title', 'workscout' ) => 'title',
          esc_html__( 'Modified', 'workscout' ) => 'modified',
          esc_html__( 'Random', 'workscout' ) => 'rand',
          esc_html__( 'Comment count', 'workscout' ) => 'comment_count',
          esc_html__( 'Menu order', 'workscout' ) => 'menu_order'
          ),
        ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order', 'workscout' ),
        'param_name' => 'order',
         'save_always' => true,
        'value' => array(
          esc_html__( 'Descending', 'workscout' ) => 'DESC',
          esc_html__( 'Ascending', 'workscout' ) => 'ASC'
          ),
        ),

      array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'Exclude posts, leave empty to not exclude anything', 'workscout' ),
        'param_name' => 'exclude_posts',
        'settings' => array(
          'post_type' => 'post',
          ),
        ),
      array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'Show only this categories', 'workscout' ),
        'param_name' => 'categories',
        'taxonomy' => 'category',
        ),
      array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'Show only this tags', 'workscout' ),
        'param_name' => 'tags',
        'taxonomy' => 'post_tag',
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
        'param_name' => 'limit_words',
        'description' => esc_html__( 'Limit number', 'workscout' ),
        'value' => 20
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
}


add_filter( 'vc_autocomplete_latest_from_blog_exclude_posts_callback',
  'vc_exclude_field_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_latest_from_blog_exclude_posts_render',
  'vc_exclude_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

add_filter( 'vc_autocomplete_latest_from_blog_categories_callback',
  'ws_categories_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_latest_from_blog_categories_render',
  'ws_categories_render', 10, 1 ); // Render exact product. Must return an array (label,value)

add_filter( 'vc_autocomplete_latest_from_blog_tags_callback',
  'ws_tags_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_latest_from_blog_tags_render',
  'ws_tags_render', 10, 1 ); // Render exact product. Must return an array (label,value)

 ?>