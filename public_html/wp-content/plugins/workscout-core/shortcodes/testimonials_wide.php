<?php

/**
* Testimonials shortcode
* Usage: [testimonials_wide]
* Shows selected jobs in carousel
*/

function workscout_testimonials_wide($atts) { 
    extract(shortcode_atts(array(
        'per_page'                  =>'4',
        'orderby'                   => 'date',
        'order'                     => 'DESC',
        'exclude_posts'             => '',
        'include_posts'             => '',
        'background'                => '',
        'from_vs'                   => '',
        ), $atts));

    $randID = rand(1, 99);

    $args = array(
        'post_type' => array('testimonial'),
        'showposts' => $per_page,
        'orderby' => $orderby,
        'order' => $order,
    );
    if(!empty($exclude_posts)) {
        $exl = explode(",", $exclude_posts);
        $args['post__not_in'] = $exl;
    }
    if(!empty($include_posts)) {
        $inc = explode(",", $include_posts);
        $args['post__in'] = $inc;
    }
    $wp_query = new WP_Query( $args );
   
    if($from_vs === 'yes') {
        $bg_url = wp_get_attachment_url( $background );
    } else {
        $bg_url = $background;
    }

    //    if($from_vs === 'yes') {
    //     $output =  '    </div> <!-- eof wpb_wrapper -->
    //                 </div> <!-- eof vc_column-inner -->
    //             </div> <!-- eof vc_column_container -->
    //         </div> <!-- eof vc_row-fluid -->
    //     </article>
    // </div> <!-- eof container -->';

    // } else {
    //      $output = '</article>
    //     </div>';
    // }
   
    $output = '<!-- Testimonials -->
    <div id="testimonials" style="background-image: url('.$bg_url.');">
        <!-- Slider -->
        <div class="container">
            <div class="sixteen columns">
                <div class="testimonials-slider">
                      <ul class="slides">';
                if ( $wp_query->have_posts() ):
                        while( $wp_query->have_posts() ) : $wp_query->the_post(); 
                        $id = $wp_query->post->ID;
                        $author = get_post_meta($id, 'pp_author', true);
                        $link = get_post_meta($id, 'pp_link', true);
                        $position = get_post_meta($id, 'pp_position', true);
                        
                        $output .= '<li>
                          <p>'.get_the_content().'
                          <span>'.get_the_title($id);
                             if(!empty($position)){
                                $output .= ', '.$position;
                                } 
                          $output .= '</span></p>
                        </li>';

                        endwhile;  // close the Loop
                endif;
                $output .='
                      </ul>
                </div>
            </div>
        </div>
    </div>';
    // if($from_vs === 'yes') {
    // $output .= '
    // <div class="container">
    //     <article class="sixteen columns">
    //          <div class="vc_row wpb_row vc_row-fluid">
    //             <div class="wpb_column vc_column_container vc_col-sm-12">
    //                 <div class="vc_column-inner ">
    //                     <div class="wpb_wrapper">';
    // } else {
    //     $output .= ' <div class="container">
    //         <article class="sixteen columns">';
    // }
    
    return $output;
}?>