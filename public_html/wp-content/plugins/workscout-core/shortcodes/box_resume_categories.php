<?php 

/*
    Shortcode prints grid of categories with icon boxes
    Usage: [box_job_categories orderby="count" order="ASC" number]
*/

function workscout_box_resume_categories( $atts ) {
    extract(shortcode_atts(array(
        'hide_empty'        => 0,
        'orderby'           => 'count',
        'order'             => 'DESC',
        'number'            => '8',
        'browse_link'       => '',
        'jobs_counter'      => 'no',
        'include'           => '',
        'exclude'           => '',
        'flex_layout'       => 'yes',
        'layout'            => 'boxed', //boxed/ new/ flex /classic
        'child_of'          => 0,
        'only_parents'      => 'no'

        ), $atts));
    $include         = is_array( $include ) ? $include : array_filter( array_map( 'trim', explode( ',', $include ) ) );
    $exclude         = is_array( $exclude ) ? $exclude : array_filter( array_map( 'trim', explode( ',', $exclude ) ) );

    if ( !post_type_exists( 'resume' ) ) {
        return;
    }

     switch ($layout) {
        case 'flex':
            $output = '<ul id="popular-categories" class="with-flex">';
            break; 
        case 'classic':
            $output = '<ul id="popular-categories" class="with-flex">';
            break;
        case 'boxed':
            $output = '<div class="categories-boxes-container">';
            break;
        
        default:
             $output = '<div class="categories-boxes-container">';
            break;
    }

    $args =  array(
        'orderby'       => $orderby, // id count name - Default slug term_group - Not fully implemented (avoid using) none
        'order'         => $order, // id count name - Default slug term_group - Not fully implemented (avoid using) none
        'hide_empty'    => $hide_empty,
        'number'        => $number,
        'include'       => $include,
        'exclude'       => $exclude,
        'child_of'      => $child_of,
    );
    
    if($only_parents == 'yes'){
        $args['parent'] = 0;
    }

    $categories = get_terms( 'resume_category', $args);
    
    if ( !is_wp_error( $categories ) ) {
    
        foreach ($categories  as $term ) {
            $t_id = $term->term_id;
            $term_meta = get_option( "taxonomy_$t_id" ); 
            if(isset($term_meta['fa_icon'])) {
                if ($term_meta['fa_icon'] == 'fa fa-' || $term_meta['fa_icon'] == 'ln ln-' ) {
                    $icon = '';
                } else {
                    $icon = $term_meta['fa_icon'];
                }
            } else {
                $icon = '';
            }
            $imageicon = $term_meta['upload_icon'];
            $count = workscout_get_term_post_count('resume_category',$term->term_id);
            if( $layout == 'new') { 
                $output .= '
                    <!-- Category Box -->
                        <a href="' . get_term_link( $term ) . '" class="new-category-box">
                            <div class="category-box-icon">';
                            if (!empty($imageicon)) {
                                $output .= '<img src="'.esc_attr($imageicon).'"/>';
                            } else if(!empty($icon)) { 
                                $check_if_new = substr($icon, 0, 3);
                                if($check_if_new == 'fa ' || $check_if_new == 'ln '  || $check_if_new == 'la ') {
                                    $output .= ' <i class="'.esc_attr($icon).'"></i>'; 
                                } else {
                                    $output .= ' <i class="fa fa-'.esc_attr($icon).'"></i>'; 
                                }
                            }
                    $output .= '</div>
                            <div class="category-box-counter counter">'.$count.'</div>
                            <div class="category-box-content">
                                <h3>'.$term->name.'</h3>
                            </div>
                        </a>';
            } else if( $layout == 'boxed') {
                $output .= '
                <!-- Box -->
                    <a href="' . get_term_link( $term ) . '" class="category-small-box">';
                        if (!empty($imageicon)) {
                            $output .= '<img src="'.esc_attr($imageicon).'"/>';
                        } else if(!empty($icon)) { 
                            $check_if_new = substr($icon, 0, 3);
                            if($check_if_new == 'fa ' ||$check_if_new == 'ln ') {
                                $output .= ' <i class="'.esc_attr($icon).'"></i>'; 
                            } else {
                                $output .= ' <i class="fa fa-'.esc_attr($icon).'"></i>'; 
                            }
                        }
                         $output .= "<h4>{$term->name}</h4>";
                         if($jobs_counter=='yes'){
                             $output .= "<span>{$term->count}</span>";
                           }
                    $output .= "</a>";
            } else {
                $output .= ' 
                    <li>
                        <a href="' . get_term_link( $term ) . '">';
                        if (!empty($imageicon)) {
                            $output .= '<img src="'.esc_attr($imageicon).'"/>';
                        } else if(!empty($icon)) { 
                            $check_if_new = substr($icon, 0, 3);
                            if($check_if_new == 'fa ' ||$check_if_new == 'ln ') {
                                $output .= ' <i class="'.esc_attr($icon).'"></i>'; 
                            } else {
                                $output .= ' <i class="fa fa-'.esc_attr($icon).'"></i>'; 
                            }
                        }
                        
                        $output .=  $term->name;
                            if($jobs_counter=='yes'){
                             $output .= ' ('.$count.')';
                           }
                         $output .= '</a>
                    </li>';
            }
          }  
    }
    if  (is_wp_error( $categories )) {
        $output .= '<li>Please enable  categories for listings in wp-admin > Job Listings -> Settings and add some categories</li>';

    }
    if( $layout == 'boxed' || $layout == 'new') {
        $output .= '</div>';
    } else {
        $output .= '</ul><div class="clearfix"></div>';    
    }
    
         $output .= '<div class="margin-top-30"></div>';
        if($browse_link) {

        $output .= '<a href="'.esc_url( $browse_link   ).'" class="button centered">'.esc_html__('Browse All Categories','workscout_core').'</a>
            <div class="margin-bottom-50"></div>';
        }
    return $output;
}?>