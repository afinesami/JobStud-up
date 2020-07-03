<?php

/**
* Recent work shortcode
* Usage: [recent_blog limit="4" title="Recent Work" orderby="date" order="DESC"  carousel="yes"] [/recent_blog]
*/

function workscout_latest_from_blog($atts, $content ) {
    extract(shortcode_atts(array(
        'limit'=>'3',
        'columns' => '3',
        'orderby'=> 'date',
        'order'=> 'DESC',
        'categories' => '',
        'masonry' => '',
        'tags' => '',
        'show_author' => '',
        'show_date' => '',
        'width' => 'sixteen',
        'place' => 'center',
        'exclude_posts' => '',
        'ignore_sticky_posts' => 1,
        'limit_words'                     => 15,
        'limitby'                   => 'words', //characters
        'from_vs' => 'no'
        ), $atts));

    $output = '';
    $randID = rand(1, 99); // Get unique ID for carousel

    if(empty($width)) { $width = "sixteen"; } //set width to 16 even if empty value

    switch ( $place ) {
        case "last" :
        $p = "omega";
        break;

        case "center" :
        $p = "alpha omega";
        break;

        case "none" :
        $p = " ";
        break;

        case "first" :
        $p = "alpha";
        break;
        default :
        $p = ' ';
    }
    
    wp_reset_postdata();

    if($masonry == 'yes') {
        $output.= '<div class="recent-blog-posts masonry">';
    } else {
        $output.= '<div class="recent-blog-posts vc_row vc_no-gutters">';
    }
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $limit,
        'orderby' => $orderby,
        'order' => $order,
        );
    if(!empty($exclude_posts)) {
        $exl = is_array( $exclude_posts ) ? $exclude_posts : array_filter( array_map( 'trim', explode( ',', $exclude_posts ) ) );
        $args['post__not_in'] = $exl;
    }

    if($from_vs === 'yes'){
        if(!empty($categories)) {
            $categories         = is_array( $categories ) ? $categories : array_filter( array_map( 'trim', explode( ',', $categories ) ) );
            $args['category__and'] = $categories;
        }
    } else {
        if(!empty($categories)) {
            
            $args['category_name'] = $categories;
        }

    }

    if(!empty($tags)) {
        $tags         = is_array( $tags ) ? $tags : array_filter( array_map( 'trim', explode( ',', $tags ) ) );
        $args['tag__in'] = $tags;
    }
    $i = 0;
    $wp_query = new WP_Query( $args );
    if($from_vs === 'yes'){
        switch ($columns) {
            case '2':
                $mainclass = "vc_col-sm-6 wpb_column";
                break;
            case '3':
                $mainclass = "vc_col-sm-4 wpb_column";
                break;
            case '4':
                $mainclass = "vc_col-sm-3 wpb_column";
                break;
            default:
                # code...
                break;
        }
    } else {
        switch ($columns) {
            case '2':
                $mainclass = "eight columns recent-blog";
                break;
            case '3':
                $mainclass = "one-third columns recent-blog";
                break;
            case '4':
                $mainclass = "four columns recent-blog";
                break;
            default:
                # code...
                break;
        }
    }
    if ( $wp_query->have_posts() ):
        while( $wp_query->have_posts() ) : $wp_query->the_post();
            $i++;
            $id = $wp_query->post->ID;
            if($masonry != 'yes') {
                if($i == 1 || ($i % $columns) === 1) {
                    $colclass = 'alpha';
                } elseif ($i == $columns || ($i % $columns) === 0 ) {
                    $colclass = 'omega';
                } else {
                    $colclass= '';
                }
            } else {
                $colclass= '';
            }

            $thumb = get_post_thumbnail_id();
            $img_url = wp_get_attachment_url();

            $author_id = $wp_query->post->post_author;

            $output .= '
                <div class="'.$mainclass.' '.$colclass.'">
                    <article class="recent-post">';
                    $format = get_post_format();
                    if( false === $format )  $format = 'standard';

                    if($format == 'standard' && has_post_thumbnail()){
                        $output .= '
                        <figure class="recent-post-img">
                            <a href="'.get_permalink().'">'.get_the_post_thumbnail($id,'workscout-small-blog').'</a>
                            <div class="hover-icon"></div>
                        </figure>
                        ';
                    }


                    if($format == 'image' && has_post_thumbnail()){
                        $output .= '
                        <figure class="recent-post-img">
                            <a href="'.get_permalink().'">'.get_the_post_thumbnail($id,'workscout-small-blog').'</a>
                            <div class="hover-icon"></div>
                        </figure>
                        ';
                    }

                    if($format == 'gallery') {
                        $gallery = get_post_meta($id, '_format_gallery', TRUE);
                        preg_match( '/ids=\'(.*?)\'/', $gallery, $matches );
                        if ( isset( $matches[1] ) ) {
                            // Found the IDs in the shortcode
                            $ids = explode( ',', $matches[1] );
                        } else {
                            // The string is only IDs
                            $ids = ! empty( $gallery ) && $gallery != '' ? explode( ',', $gallery ) : array();
                        }
                        $output .= '<div class="basic-slider royalSlider rsDefault">';
                        foreach ($ids as $imageid) {
                            $image_link = wp_get_attachment_url( $imageid );
                            if ( ! $image_link )
                                continue;
                                $image          = wp_get_attachment_image_src( $imageid, 'large');
                                $imageRSthumb   = wp_get_attachment_image_src( $imageid, $imagesize );
                                $image_title    = esc_attr( get_the_title( $imageid ) );
                                $output .= '<a href="'.$image[0].'" class="mfp-gallery"  title="'.esc_attr($image_title).'"><img class="rsImg" src="'.$imageRSthumb[0].'"  data-rsTmb="'.$imageRSthumb[0].'" /></a>';
                            }
                        $output .= '</div>';
                    }

                    if($format == 'quote') {
                        $output .= '<figure class="post-quote">
                            <span class="icon"></span>
                            <blockquote>
                              '.get_post_meta($id, '_format_quote_content', TRUE).'
                              <a href="'.esc_url(get_post_meta($id, '_format_quote_source_url', TRUE)).'"><span>- '.get_post_meta($id, '_format_quote_source_name', TRUE).'</span></a>
                            </blockquote>
                      </figure>';
                    } // eof gallery


                    if($format == 'video') {
                        $video = get_post_meta($id, '_format_video_embed', true);
                        if(!empty($video)) {
                            $output .= '<div class="embed">';
                                if(wp_oembed_get($video)) { $output .= wp_oembed_get($video); } else { $output .= $video;}
                            $output .= '</div>';
                        }
                    } // eof gallery

                    $output .= '
                    <section class="from-the-blog-content">
                        <a href="'.get_permalink().'"><h4>'.get_the_title().'</h4></a>';
                   
                    $output .= ' <div class="meta-tags">';
                    if ($show_author) {
                        $output .= '<span>'.esc_html__('By','workscout_core'). ' <a class="author-link" itemprop="url" rel="author" href="'.get_author_posts_url(get_the_author_meta('ID',$author_id )).'">'.get_the_author_meta('display_name',$author_id).'</a></span>'.' ';
                    }
                    if ($show_date) {
                        $output .= '<span>'.get_the_date().'</span>';
                    }
                    $excerpt = get_the_excerpt();

                    $output .= '</div>
                            <p>';

                            if($limitby=='words'){
                                $output .= workscout_string_limit_words($excerpt,$limit_words); 
                            } else {
                                $output .= workscout_get_excerpt($excerpt,$limit_words);
                            }
                        $output .= '</p>
                        <a href="'.get_permalink().'" class="button">'.esc_html__("Read More","workscout_core").'</a>
                    </section>

                </article>
            </div>';
        endwhile;  // close the Loop
    endif;
     $output .= '</div>';
     wp_reset_postdata(); 
    return $output;
}

?>