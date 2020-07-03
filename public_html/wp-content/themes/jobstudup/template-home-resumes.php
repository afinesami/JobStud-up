<?php
/**
 * Template Name: Page with Resumes Search
 *
 * @package WordPress
 * @subpackage workscout
 * @since workscout 1.0
 */


$header_old = Kirki::get_option('workscout','pp_old_header');
$header_type = (Kirki::get_option('workscout','pp_old_header') == true) ? 'old' : '' ;
get_header($header_type); ?>
<?php $fancy_header = get_post_meta($post->ID, 'pp_transparent_header','true'); ?>



<!-- Intro Banner
================================================== -->
<div class="intro-banner intro-resumes-banner dark-overlay" <?php echo workscout_get_new_resume_search_header();?>>

    <!-- Transparent Header Spacer -->
    <div class="transparent-header-spacer"></div>
        <div class="container">
        
        <!-- Intro Headline -->
        <div class="row">
            <div class="sixteen columns ">
                <div class="banner-headline-alt">
                    <h3>
                        <strong><?php echo Kirki::get_option( 'workscout','pp_resume_home_title','Find Candidate');  ?></strong>
                        <span><?php echo Kirki::get_option( 'workscout','pp_resume_home_subtitle','Hire experts or be hired in');  ?> 
                             <?php if(get_option('pp_resume_home_typed_status','enable') == 'enable') { ?><div class="typed-words"></div><?php } ?>
                         </span>
                    </h3>
                </div>
            </div>
        </div>

        <?php 
            $search_elements = Kirki::get_option( 'workscout', 'pp_resume_search_elements',array('keywords','location')); 
            $el_nr = count($search_elements); 
        ?>
        <form method="GET" class="workscout_main_search_form" action="<?php echo get_permalink(get_option('resume_manager_resumes_page_id')); ?>">
            <!-- Search Bar -->
            <div class="row">
                <div class="sixteen columns sc-resumes">
                    <div class="intro-banner-search-form">
                        
                            <?php if (in_array("keywords", $search_elements)) : ?>
                                <!-- Search Field -->
                                <div class="intro-search-field">
                                    <label for ="intro-keywords" class="field-title ripple-effect"><?php esc_html_e('What candidate are you looking for?','workscout') ?></label>
                                    <input id="intro-keywords" name="search_keywords" type="text" placeholder="<?php esc_html_e('Search freelancer services (e.g. logo design)','workscout'); ?>">
                                </div>
                            <?php endif; ?>
                            
                            <?php if (in_array("location", $search_elements)) : ?>
                            <!-- Search Field -->
                                <div class="intro-search-field with-autocomplete">
                                    <label for="autocomplete-input" class="field-title ripple-effect"><?php esc_html_e('Where?','workscout') ?></label>
                                    <?php if ( get_option( 'job_manager_regions_filter' ) || is_tax( 'job_listing_region' ) ) {  ?>
                                    <?php
                                    $dropdown = wp_dropdown_categories( apply_filters( 'job_manager_regions_dropdown_args', array(
                                        'show_option_all' => __( 'All Regions', 'wp-job-manager-locations', 'workscout' ),
                                        'hierarchical' => true,
                                        'orderby' => 'name',
                                        'taxonomy' => 'resume_region',
                                        'name' => 'search_region',
                                        'id' => 'search_location',
                                        'class' => 'search_region job-manager-category-dropdown ' . ( is_rtl() ? 'chosen-rtl' : '' ),
                                        'hide_empty' => 0,
                                        'selected' => isset( $_GET[ 'search_region' ] ) ? $_GET[ 'search_region' ] : '',
                                        'echo'=>false,
                                    ) ) );
                                    $fixed_dropdown = str_replace("&nbsp;", "", $dropdown); echo $fixed_dropdown;
                                    } else { ?>
                                        <div class="input-with-icon">
                                            <input id="search_location" name="search_location" type="text" placeholder="<?php esc_attr_e('city, province or region','workscout'); ?>">
                                            
                                            <a href="#"><i title="<?php esc_html_e('Find My Location','workscout') ?>" class="tooltip left la la-map-marked-alt"></i></a>
                                            <?php if(get_option('workscout_map_address_provider','osm') == 'osm') : ?><span class="type-and-hit-enter"><?php esc_html_e('type and hit enter','workscout') ?></span> <?php endif; ?>
                                        </div>
                                    <?php } ?>
                                   
                                </div>
                            <?php endif; ?>

                            
                            <?php if (in_array("category", $search_elements)) :   ?>
                            <!-- Search Field -->
                                <div class="intro-search-field">
                                    <label for="categories" class="field-title ripple-effect"><?php esc_html_e('Categories','workscout') ?></label>
                                    <?php 
                                    
                             
                                        $html =  wp_dropdown_categories( 
                                            array(
                                                'taxonomy'          => 'resume_category',
                                                'name'              => 'search_category',
                                                'orderby'           => 'name',
                                                'class'             => 'select-on-home',
                                                'hierarchical'      => true,
                                                'hide_empty'        => true ,
                                                'show_option_all'   => esc_html__('All categories','workscout'),
                                                'echo' => 0
                                                )
                                            );
                                        echo str_replace( '&nbsp;&nbsp;&nbsp;', '- ', $html );                   
                                ?>
                                </div>
                            <?php endif; ?>

                            <!-- Button -->
                            <div class="intro-search-button">
                                <button class="button ripple-effect">
                                    <span><?php esc_html_e('Search','workscout') ?></span>
                                    <i></i>
                                </button>
                            </div>

                    </div>
                </div>
            </div>
        </form>
        <?php if(Kirki::get_option('workscout','pp_home_resume_advanced')) {  ?>
        <!-- Stats -->
        <div class="row">
            <div class="sixteen columns">
                <div class="adv-search-btn">
                    <span><?php esc_html_e('Need more search options?','workscout') ?> </span>
                    <a href="<?php echo get_post_type_archive_link( 'resume' ) ?>"><?php esc_html_e('Advanced Search','workscout') ?> <i class="la la-long-arrow-alt-right"></i></a>
                </div>
            </div>
        </div>
        <?php } ?>


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