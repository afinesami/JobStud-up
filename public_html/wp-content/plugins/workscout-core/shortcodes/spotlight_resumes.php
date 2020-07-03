<?php

/**
* Spotlight shortcode
* Usage: [spotlight_jobs]
* Shows selected jobs in carousel
*/

function workscout_spotlight_resumes( $atts ) {
    ob_start();

    extract( $atts = shortcode_atts( apply_filters( 'job_manager_output_jobs_defaults', array(
        'per_page'                  => get_option( 'job_manager_per_page' ),
        'orderby'                   => 'featured',
        'order'                     => 'DESC',
        'title'                     => 'Resumes Spotlight',
        'visible'                   => '1,1,1,1',
        'autoplay'                  => "off",
        'delay'                     => 5000,
        // Limit what jobs are shown based on category and type
        'categories'                => '',
        'resume_ids'                => '',
        'candidate_photo'           => "off",
        'featured'                  => null, // True to show only featured, false to hide featured, leave null to show both.
       
        
    ) ), $atts ) );

    $randID = rand(1, 99); 

    // Array handling
    $categories         = is_array( $categories ) ? $categories : array_filter( array_map( 'trim', explode( ',', $categories ) ) );
  
    if ( ! is_null( $featured ) ) {
      
        $featured = ( is_bool( $featured ) && $featured ) || in_array( $featured, array( '1', 'true', 'yes' ) ) ? true : false;
    }

   $query_args = array(
        'post_type'              => 'resume',
        'post_status'            => 'publish',
        'ignore_sticky_posts'    => 1,
        'offset'                 => 0,
        'posts_per_page'         => intval( $per_page ),
        'orderby'                => $orderby,
        'order'                  => $order,
        'fields'                 => 'all'
    );

   if(!empty($resume_ids)) {
        $inc = explode(",", $resume_ids);
        $query_args['post__in'] = $inc;
    }

    if ( ! is_null( $featured ) ) {
        $query_args['meta_query'][] = array(
            'key'     => '_featured',
            'value'   => '1',
            'compare' => $featured ? '=' : '!='
        );
    }



    if ( ! empty( $categories ) ) {
        $field    = is_numeric( $categories[0] ) ? 'term_id' : 'slug';
        $operator = 'all' === get_option( 'resume_manager_category_filter_type', 'all' ) && sizeof( $categories ) > 1 ? 'AND' : 'IN';
        $query_args['tax_query'][] = array(
            'taxonomy'         => 'resume_category',
            'field'            => $field,
            'terms'            => array_values( $categories ),
            'include_children' => $operator !== 'AND' ,
            'operator'         => $operator
        );
    }

    if ( 'featured' === $orderby ) {
        $orderby = array(
            'menu_order' => 'ASC',
            'date'       => 'DESC'
        );
    }
    $resume_photo_style = Kirki::get_option( 'workscout','pp_resume_rounded_photos','off' );

    if($resume_photo_style){
        $photo_class = "square";
    } else {
        $photo_class = "rounded";
    }
   $wp_query = new WP_Query( $query_args );
   if ( $wp_query->have_posts() ):
     
        ?>
 
        <h3 class="margin-bottom-5"><?php echo esc_html($title); ?></h3>
        <!-- Navigation -->
     
        
        <!-- Showbiz Container -->
        <?php $slick_autplay = ($autoplay == 'on') ? true : false ; ?>
        <div id="job-spotlight" data-slick='{"autoplaySpeed": <?php echo $delay; ?>, "autoplay": <?php echo $slick_autplay; ?> }' data-delay="<?php echo $delay; ?>" data-autoplay="<?php echo $autoplay; ?>" class="job-spotlight-car showbiz-container" data-visible="[<?php echo $visible; ?>]">
           
                      <?php  while( $wp_query->have_posts() ) : $wp_query->the_post(); 
                        $id = get_the_id(); ?>
                        
                            <div class="resume-spotlight photo-<?php echo $photo_class?>">
                            <?php if($candidate_photo == 'on')  { the_candidate_photo(); } ?>
                            <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?> <span><?php the_candidate_title(); ?></span></h4></a>
                                <span><i class="fa fa-map-marker"></i> <?php ws_candidate_location(); ?></span>
                                
                                <?php 
                                $currency_position =  get_option('workscout_currency_position','before');

                                $rate_min = get_post_meta( $id, '_rate_min', true ); 
                                if ( $rate_min) { 
                                    $rate_max = get_post_meta( $id, '_rate_max', true );  ?>
                                    <span>
                                        <i class="fa fa-money"></i> <?php  
                                        if( $currency_position == 'before' ) { 
                                            echo get_workscout_currency_symbol(); 
                                        } 
                                        echo esc_html( $rate_min ); 
                                        if( $currency_position == 'after' ) { 
                                            echo get_workscout_currency_symbol(); 
                                        }
                                        if(!empty($rate_max)) { 
                                            echo '- '; 
                                            if( $currency_position == 'before' ) { 
                                                echo get_workscout_currency_symbol(); 
                                            }  
                                            echo $rate_max;
                                            if( $currency_position == 'after' ) { 
                                                echo get_workscout_currency_symbol(); 
                                            } 
                                            } ?> <?php _e('/ hour','workscout_core'); ?>
                                    </span>
                                <?php } ?>

                                <?php 
                                $salary_min = get_post_meta( $id, '_salary_min', true ); 
                                if ( $salary_min ) {
                                    $salary_max = get_post_meta( $id, '_salary_max', true );  ?>
                                    <span>
                                        <i class="fa fa-money"></i>
                                        <?php 
                                        if( $currency_position == 'before' ) { 
                                            echo get_workscout_currency_symbol(); 
                                        } 
                                        echo esc_html( $salary_min );
                                        if( $currency_position == 'after' ) { 
                                            echo get_workscout_currency_symbol(); 
                                        } ?> <?php 
                                        if(!empty($salary_max)) { 
                                            echo ' - ';
                                            if( $currency_position == 'before' ) { 
                                                echo get_workscout_currency_symbol(); 
                                            }
                                            echo $salary_max; 
                                            if( $currency_position == 'after' ) { 
                                                echo get_workscout_currency_symbol(); 
                                            }
                                        } ?>
                                    </span>
                                <?php } ?>
                                
                                <p><?php  
                                    $excerpt = get_the_excerpt();
                                    echo workscout_string_limit_words($excerpt,20); ?>...
                                </p>
                                <?php if ( ( $skills = wp_get_object_terms( $id , 'resume_skill', array( 'fields' => 'names' ) ) ) && is_array( $skills ) ) : ?>
                                <div class="skills">
                                    <?php echo '<span>' . implode( '</span><span>', $skills ) . '</span>'; ?>
                                </div>
                                <div class="clearfix"></div>
                            <?php endif; ?>
                                <a href="<?php the_permalink(); ?>" class="button"><?php esc_html_e('Contact Candidate','workscout_core') ?></a>
                            </div>
                       
                        <?php endwhile; ?>
                        
              
        </div>
    <?php  
        
    endif; 
    wp_reset_postdata();
    $job_listings_output =  ob_get_clean();

    return $job_listings_output;

}?>