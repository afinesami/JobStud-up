<?php
/**
 * Related jobs
 */

global $post;

$tags = get_the_terms( $post->ID, 'job_listing_category' );

if ( ! $tags || is_wp_error( $tags ) || ! is_array( $tags ) ) {
	return;
}

$tags = wp_list_pluck( $tags, 'term_id' );

$related_args = array(
	'post_type' => 'job_listing',
	'orderby'   => 'rand',
	'posts_per_page' => 6,
	'post_status' => 'publish',
	'post__not_in' => array( $post->ID ),
	'tax_query' => array(
		array(
			'taxonomy' => 'job_listing_category',
			'field'    => 'id',
			'terms'    => $tags
		)
	)
);

$wp_query = new WP_Query($related_args );

if ( ! $wp_query->have_posts() ) {
	return;
}
$randID = rand(1, 99); 
 
?>
<div id="related-job-container">

    <h3 class="margin-bottom-5 margin-top-55"><?php esc_html_e('Related Jobs','workscout'); ?></h3>


    <!-- Showbiz Container -->
    <div id="related-job-spotlight" class="related-job-spotlight-car showbiz-container" data-visible="[2,2,1,1]">
     
          
                  <?php  while( $wp_query->have_posts() ) : 

                  $wp_query->the_post(); 

                    $id = get_the_id(); ?>
                 
                        <div class="job-spotlight">
                            <?php $job_meta = Kirki::get_option( 'workscout','pp_meta_job_list',array('company','location','rate','salary') ); ?>
                            <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?> 
                            <?php if ( get_option( 'job_manager_enable_types' ) ) { ?><?php $types = wpjm_get_the_job_types(); 

                if ( ! empty( $types ) ) : foreach ( $types as $type ) :  ?>
                    <span class="job-type <?php echo esc_attr( sanitize_title( $type->slug ) ); ?>" itemprop="employmentType"><?php echo esc_html( $type->name ); ?></span>

                <?php endforeach; endif; ?>
                            <?php } ?>
                            </h4></a>
                            <?php if (in_array("company", $job_meta) && get_the_company_name()) { ?>
                            <span class="ws-meta-company-name"><i class="fa fa-briefcase"></i> <?php the_company_name(  ); ?></span>
                            <?php } ?>

                            <?php if (in_array("location", $job_meta)) { ?>
                            <span class="ws-meta-job-location"><i class="fa fa-map-marker"></i> <?php ws_job_location(); ?></span>
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
                                            } ?> <?php esc_html_e('/ hour','workscout'); ?>
                                    </span>
                                <?php } ?>

                            <?php 
                            $salary_min = get_post_meta( $id, '_salary_min', true ); 
                            if ( $salary_min && in_array("salary", $job_meta) ) {
                                $salary_max = get_post_meta( $id, '_salary_max', true );  ?>
                                <span class="ws-meta-salary">
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
                            <a href="<?php the_permalink(); ?>" class="button"><?php esc_html_e('Apply For This Job','workscout') ?></a>
                        </div>
                    
                    <?php endwhile; ?>
      
    </div>
</div>
<?php wp_reset_query(); ?>
