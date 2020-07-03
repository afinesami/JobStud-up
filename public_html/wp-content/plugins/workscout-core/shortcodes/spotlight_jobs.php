<?php 


/**
* Spotlight shortcode
* Usage: [spotlight_jobs]
* Shows selected jobs in carousel
*/


function workscout_spotlight_jobs( $atts ) {
    ob_start();

    extract( $atts = shortcode_atts( apply_filters( 'job_manager_output_jobs_defaults', array(
        'per_page'                  => get_option( 'job_manager_per_page' ),
        'orderby'                   => 'featured',
        'order'                     => 'DESC',
        'title'                     => 'Job Spotlight',
        'visible'                   => '1,1,1,1',
        'meta'                      => 'company,location,rate,salary',
        'autoplay'                  => "off",
        'delay'                     => 5000,
        'limit'                     => 20,
        'limitby'                   => 'words', //characters
        // Limit what jobs are shown based on category and type
        'categories'                => '',
        'job_types'                 => '',
        'job_ids'                   => '',
        'featured'                  => null, // True to show only featured, false to hide featured, leave null to show both.
        'filled'                    => null, // True to show only filled, false to hide filled, leave null to show both/use the settings.

        
    ) ), $atts ) );

    $randID = rand(1, 99); 

    if ( ! is_null( $filled ) ) {
        $filled = ( is_bool( $filled ) && $filled ) || in_array( $filled, array( '1', 'true', 'yes' ) ) ? true : false;
    }

    // Array handling
    $categories         = is_array( $categories ) ? $categories : array_filter( array_map( 'trim', explode( ',', $categories ) ) );
    $job_types          = is_array( $job_types ) ? $job_types : array_filter( array_map( 'trim', explode( ',', $job_types ) ) );
    if ( ! is_null( $featured ) ) {
      
        $featured = ( is_bool( $featured ) && $featured ) || in_array( $featured, array( '1', 'true', 'yes' ) ) ? true : false;
    }

   $query_args = array(
        'post_type'              => 'job_listing',
        'post_status'            => 'publish',
        'ignore_sticky_posts'    => 1,
        'offset'                 => 0,
        'posts_per_page'         => intval( $per_page ),
        'orderby'                => $orderby,
        'order'                  => $order,
        'fields'                 => 'all'
    );

   if(!empty($job_ids)) {
        $inc = explode(",", $job_ids);
        $query_args['post__in'] = $inc;
    }

    if ( ! is_null( $featured ) ) {
        $query_args['meta_query'][] = array(
            'key'     => '_featured',
            'value'   => '1',
            'compare' => $featured ? '=' : '!='
        );
    }

    if ( ! is_null( $filled) || 1 === absint( get_option( 'job_manager_hide_filled_positions' ) ) ) {
        $query_args['meta_query'][] = array(
            'key'     => '_filled',
            'value'   => '1',
            'compare' => $filled ? '=' : '!='
        );
    }

    if ( ! empty( $job_types ) ) {
        $query_args['tax_query'][] = array(
            'taxonomy' => 'job_listing_type',
            'field'    => 'slug',
            'terms'    => $job_types
        );
    }

    if ( ! empty( $categories ) ) {
        $field    = is_numeric( $categories[0] ) ? 'term_id' : 'slug';
        
        $operator = 'all' === get_option( 'job_manager_category_filter_type', 'all' ) && sizeof( $categories ) > 1 ? 'AND' : 'IN';
        $query_args['tax_query'][] = array(
            'taxonomy'         => 'job_listing_category',
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

   $wp_query = new WP_Query( $query_args );
   if ( $wp_query->have_posts() ):
     
        ?>
 
        <h3 class="margin-bottom-5"><?php echo esc_html($title); ?></h3>
        <!-- Navigation -->
  <!--       <div class="showbiz-navigation">
            <div id="showbiz_left_<?php echo esc_attr($randID); ?>" class="sb-navigation-left"><i class="fa fa-angle-left"></i></div>
            <div id="showbiz_right_<?php echo esc_attr($randID); ?>" class="sb-navigation-right"><i class="fa fa-angle-right"></i></div>
        </div>
        <div class="clearfix"></div> -->
        
        <!-- Showbiz Container -->
        <?php $slick_autplay = ($autoplay == 'on') ? true : false ; ?>
        <div id="job-spotlight" data-slick='{"autoplaySpeed": <?php echo $delay; ?>, "autoplay": <?php echo $slick_autplay; ?> }'
        class="job-spotlight-car showbiz-container" data-visible="[<?php echo $visible; ?>]">
                      <?php  while( $wp_query->have_posts() ) : $wp_query->the_post(); 
                        $id = get_the_id(); ?>
            
                            <div class="job-spotlight">
                                <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?> 
                                <?php 
                                $types = get_the_terms( $id, 'job_listing_type' );
                                if ( $types && ! is_wp_error( $types ) ) : 
                                    foreach ( $types as $type ) { ?>
                                        <span class="job-type <?php echo sanitize_title( $type->slug ); ?>"><?php echo $type->name; ?></span>
                                <?php }
                                endif;?>
                                </h4></a>
                                <?php $job_meta = explode(",",$meta);?>
                
                                <?php if (in_array("company", $job_meta) && get_the_company_name()) { ?>
                                    <span class="ws-meta-company-name"><i class="fa fa-briefcase"></i> <?php the_company_name();?></span>
                                <?php } ?>
                                
                                <?php if (in_array("location", $job_meta)) { ?>
                                    <span class="ws-meta-job-location"><i class="fa fa-map-marker"></i> <?php ws_job_location( false ); ?></span>
                                <?php } ?>
                                
                                <?php 
                                $currency_position =  get_option('workscout_currency_position','before');

                                $rate_min = get_post_meta( $id, '_rate_min', true ); 
                                if ( $rate_min && in_array("rate", $job_meta)) { 
                                    $rate_max = get_post_meta( $id, '_rate_max', true );  ?>
                                    <span class="ws-meta-rate">
                                        <i class="fa fa-money"></i> 
                                        <?php 
                                            if( $currency_position == 'before' ) { 
                                                echo get_workscout_currency_symbol(); 
                                            } 
                                            echo esc_html( $rate_min );
                                            if( $currency_position == 'after' ) { 
                                                echo get_workscout_currency_symbol(); 
                                            }
                                            if(!empty($rate_max)) { 
                                                echo '- '; 
                                                if($currency_position == 'before' ) { 
                                                    echo get_workscout_currency_symbol(); 
                                                } 
                                                echo esc_html($rate_max); 
                                                if( $currency_position == 'after' ) { 
                                                    echo get_workscout_currency_symbol(); 
                                                }
                                            } ?> <?php esc_html_e('/ hour','workscout_core'); ?>
                                    </span>
                                <?php } ?>

                                <?php 
                                $salary_min = get_post_meta( $id, '_salary_min', true ); 
                                $salary_max = get_post_meta( $id, '_salary_max', true );
                                if ( in_array("salary", $job_meta) ) {
                                    if(!empty($salary_min) || !empty($salary_max) ) { ?>
                                    
                                    <span class="ws-meta-salary">
                                        <i class="fa fa-money"></i>
                                        <?php 
                                        if(!empty($salary_min)) {
                                            if( $currency_position == 'before' ) { 
                                                echo get_workscout_currency_symbol(); 
                                            } 
                                            echo esc_html( $salary_min );
                                            if( $currency_position == 'after' ) { 
                                                        echo get_workscout_currency_symbol(); 
                                            }
                                        } ?> <?php 
                                        if(!empty($salary_max)) { 
                                            if(!empty($salary_min)) { echo ' - '; }
                                            if( $currency_position == 'before' ) { 
                                                echo get_workscout_currency_symbol(); 
                                            } 
                                            echo $salary_max; 
                                            if( $currency_position == 'after' ) { 
                                                echo get_workscout_currency_symbol(); 
                                            }
                                        } ?>
                                    </span>

                                <?php }
                                } ?>
                                
                                <?php if (in_array("date", $job_meta)) { ?>
                                    <span class="ws-meta-job-date"><i class="fa fa-calendar"></i> <?php the_job_publish_date() ?></span>
                                <?php } ?>

                                <?php if (in_array("deadline", $job_meta)) { ?>
                                    <?php 
                                    if ( $deadline = get_post_meta( $id, '_application_deadline', true ) ) {
                                        $expiring_days = apply_filters( 'job_manager_application_deadline_expiring_days', 2 );
                                        $expiring = ( floor( ( time() - strtotime( $deadline ) ) / ( 60 * 60 * 24 ) ) >= $expiring_days );
                                        $expired  = ( floor( ( time() - strtotime( $deadline ) ) / ( 60 * 60 * 24 ) ) >= 0 );?>
                                        <span class="ws-meta-job-deadline"><i class="fa fa-calendar-times-o"></i> 
                                        <?php  echo  ( $expired ? __( 'Closed', 'workscout_core' ) : __( 'Closes', 'workscout_core' ) ) .': ' . date_i18n( get_option( 'date_format' ), strtotime( $deadline ) ) ?>
                                        </span>
                                <?php } 
                                }?>             

                                <?php if (in_array("expires", $job_meta)) { ?>
                                    <span class="ws-meta-job-expires"><i class="fa fa-calendar-check-o"></i> 
                                    <?php esc_html_e( 'Expires', 'workscout_core' ) ?>:  <?php echo date_i18n( get_option( 'date_format' ), strtotime( get_post_meta( $id, '_job_expires', true ) ) ) ?>
                                    </span>
                                <?php } ?>
                                
                                <p><?php  
                                    $excerpt = get_the_excerpt();
                                    if($limitby=='words'){
                                        echo workscout_string_limit_words($excerpt,$limit); 
                                    } else {
                                        echo workscout_get_excerpt($excerpt,$limit);
                                    }
                                    ?>
                                    ...
                                </p>
                                <a href="<?php the_permalink(); ?>" class="button"><?php esc_html_e('Apply For This Job','workscout_core') ?></a>
                            </div>
                        
                        <?php endwhile; ?>
        </div>
    <?php  
        
    endif; 
    wp_reset_postdata();
    $job_listings_output =  ob_get_clean();

    return $job_listings_output;

}

?>