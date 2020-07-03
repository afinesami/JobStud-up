<?php
/**
 * Template Name: Page with Jobs Search (old version)
 *
 * @package WordPress
 * @subpackage workscout
 * @since workscout 1.0
 */

$header_old = Kirki::get_option('workscout','pp_old_header');
$header_type = (Kirki::get_option('workscout','pp_old_header') == true) ? 'old' : '' ;
$header_type = apply_filters('workscout_header_type',$header_type);
get_header($header_type); ?>
<?php $fancy_header = Kirki::get_option( 'workscout','pp_transparent_header');  ?>

<div id="banner" <?php echo workscout_get_search_header();?>  class="workscout-search-banner jobs-search-banner <?php if( $fancy_header ) { ?> with-transparent-header parallax background <?php } ?>" >
    <div class="container">
        <div class="sixteen columns">
            
            <div class="search-container sc-jobs">

                <!-- Form -->
                <h2><?php echo Kirki::get_option( 'workscout','pp_jobs_home_title','Find Job');  ?></h2>
                <?php 
                $search_elements = Kirki::get_option( 'workscout', 'pp_job_search_elements',array('keywords','location')); 
                $el_nr = count($search_elements); ?>
                <form method="GET" class="inputs-number-<?php echo esc_attr($el_nr); ?>" action="<?php echo get_permalink(get_option('job_manager_jobs_page_id')); ?>">

                    
                    <?php if (in_array("keywords", $search_elements)) : ?>
                    <input type="text" id="search_keywords" name="search_keywords"  class="ico-01" placeholder="<?php 
                    (  $el_nr == 3 ) ? esc_attr_e('keywords','workscout') : esc_attr_e('job title, keywords or company name','workscout'); ?>" value=""/>
                    <?php endif; ?>
                    
                    <?php if (in_array("location", $search_elements)) : ?>
                    <?php if ( get_option( 'job_manager_regions_filter' ) || is_tax( 'job_listing_region' ) ) {  ?>
                        <?php
                        $dropdown = wp_dropdown_categories( array(
                            'show_option_all'           => __( 'All Regions', 'workscout' ),
                            'hierarchical'              => true,
                            'orderby'                   => 'name',
                            'taxonomy'                  => 'job_listing_region',
                            'name'                      => 'search_region',
                            'id'                        => 'search_location',
                            'class'                     => 'search_region job-manager-category-dropdown select2-multiple ' . ( is_rtl() ? 'chosen-rtl' : '' ),
                            'hide_empty'                => 1,
                            'selected'                  => isset( $_GET[ 'search_region' ] ) ? $_GET[ 'search_region' ] : '',
                            'echo'                      => false,
                        )  );
                        $fixed_dropdown = str_replace("&nbsp;", "", $dropdown); echo $fixed_dropdown;
                    } else { ?>
                        <input type="text" id="search_location" name="search_location" class="ico-02" placeholder="<?php esc_attr_e('city, province or region','workscout'); ?>" value=""/> 
                    <?php } ?>
                    <?php endif; ?>

                    <?php 
                        if (in_array("category", $search_elements)) :                
                   /*         job_manager_dropdown_categories( array( 
                                'taxonomy' => 'job_listing_category', 
                                'hierarchical' => 1, 
                        
                                'show_option_all' => esc_html__( 'Any category', 'workscout' ), 
                                'name' => 'search_categories', 
                                'orderby' => 'name', 
                                'selected' => '', 
                                'name'              => 'search_category',
                                'multiple' => false,
                                'hide_empty' => true ) );*/ 
                            $html =  wp_dropdown_categories( 
                                array(
                                    'taxonomy'          => 'job_listing_category',
                                    'name'              => 'search_category',
                                    'orderby'           => 'name',
                                    'class'             => 'select2-multiple',
                                    'hierarchical'      => true,
                                    'hide_empty'        => true ,
                                    'show_option_all'   => esc_html__('All categories','workscout'),
                                    'echo' => 0
                                    )
                                );
                            echo str_replace( '&nbsp;&nbsp;&nbsp;', '- ', $html );
                        endif;
                   
                    ?>

                   
                    <button><i class="fa fa-search"></i></button>

                </form>
                <!-- Browse Jobs -->
                <div class="browse-jobs">
                    <?php 
                    if(Kirki::get_option( 'workscout','pp_categories_page')){
                        $categoriespage = Kirki::get_option( 'workscout','pp_categories_page');
                    } elseif (get_option('pp_categories_page')){
                        $categoriespage = get_option('pp_categories_page'); 
                    }

                    if(!empty($categoriespage)) { 
                        printf( __( ' Or browse job offers by <a href="%s">category</a>', 'workscout' ), get_permalink($categoriespage) );
                    } ?>
                </div>
                
                <?php 
                if(Kirki::get_option( 'workscout','pp_home_job_counter')) { ?>
                <!-- Announce -->
                <div class="announce">
                    <?php $count_jobs = wp_count_posts( 'job_listing', 'readable' ); 
                  

                    printf( _n( 'We have %s job offer for you!', 'We have %s job offers for you!', $count_jobs->publish, 'workscout' ), '<strong>' . $count_jobs->publish . '</strong>' ); ?>

                </div>
                <?php } ?>
            </div>

        </div>
    </div>
</div>

<?php
while ( have_posts() ) : the_post(); ?>
<!-- 960 Container -->
<div class="container page-container home-page-container">
    <article <?php post_class("sixteen columns"); ?>>
                <?php the_content(); ?>
    </article>
</div>
<?php endwhile; // end of the loop.

get_footer(); ?>