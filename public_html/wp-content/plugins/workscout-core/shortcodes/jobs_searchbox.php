<?php 

 function workscout_jobs_searchbox($atts, $content ) {

      extract(shortcode_atts(array(
           
            'full_width'    => 'no',
          
            'from_vs'       => 'no',
        ), $atts));
/**/
         ob_start();

        if($full_width == 'yes') {
            if($from_vs === 'yes') { ?>
                            </div> <!-- eof wpb_wrapper -->
                        </div> <!-- eof vc_column-inner -->
                    </div> <!-- eof vc_column_container -->
                </div> <!-- eof vc_row-fluid -->
            </article>
        </div> <!-- eof container -->
        <?php 
            } else { ?>
             </article>
        </div>
        <?php }
        } ?>
 
<!-- Intro Banner
================================================== -->
<div class="intro-banner dark-overlay" <?php echo workscout_get_new_search_header();?>>

    <!-- Transparent Header Spacer -->
    <div class="transparent-header-spacer"></div>
        <div class="container">
        
        <!-- Intro Headline -->
        <div class="row">
            <div class="sixteen columns">
                <div class="banner-headline-alt">
                    <h3>
                        <strong><?php echo Kirki::get_option( 'workscout','pp_jobs_home_title','Find Job');  ?></strong>
                        <span><?php echo Kirki::get_option( 'workscout','pp_jobs_home_subtitle','Hire experts or be hired in ');  ?> 
                             <?php if(get_option('pp_jobs_home_typed_status','enable') == 'enable') { ?> <div class="typed-words"></div><?php } ?>
                         </span>
                    </h3>
                </div>
            </div>
        </div>
          
        <?php 
            $search_elements = Kirki::get_option( 'workscout', 'pp_job_search_elements',array('keywords','location')); 
            $el_nr = count($search_elements); 
        ?>
        <form method="GET"  class="workscout_main_search_form" action="<?php echo get_permalink(get_option('job_manager_jobs_page_id')); ?>">
        <!-- Search Bar -->
        <div class="row">
            <div class="sixteen columns  sc-jobs">
                <div class="intro-banner-search-form">
                    
                        <?php if (in_array("keywords", $search_elements)) : ?>
                            <!-- Search Field -->
                            <div class="intro-search-field">
                                <label for ="intro-keywords" class="field-title ripple-effect"><?php esc_html_e('What job are you looking for?','workscout') ?></label>
                                <input id="intro-keywords" name="search_keywords" type="text" placeholder="<?php esc_attr_e( 'Job title, Skill, Industry', 'workscout' ); ?>">
                            </div>
                        <?php endif; ?>
                        
                        <?php if (in_array("location", $search_elements)) : ?>
                        <!-- Search Field -->
                            <div class="intro-search-field with-autocomplete">
                                <label for="search_location" class="field-title ripple-effect"><?php esc_html_e('Where?','workscout') ?></label>
                                <?php if ( class_exists('Astoundify_Job_Manager_Regions') && get_option( 'job_manager_regions_filter' ) || is_tax( 'job_listing_region' ) ) {  ?>
                                <?php
                                $dropdown = wp_dropdown_categories( array(
                                    'show_option_all'           => __( 'All Regions', 'workscout' ),
                                    'hierarchical'              => true,
                                    'orderby'                   => 'name',
                                    'taxonomy'                  => 'job_listing_region',
                                    'name'                      => 'search_region',
                                    'id'                        => 'search_location',
                                    'class'                     => 'search_region select-on-home job-manager-category-dropdown',
                                    'hide_empty'                => 1,
                                    'selected'                  => isset( $_GET[ 'search_region' ] ) ? $_GET[ 'search_region' ] : '',
                                    'echo'                      => false,
                                )  );
                                $fixed_dropdown = str_replace("&nbsp;", "", $dropdown); echo $fixed_dropdown;
                                } else { ?>
                                    <div class="input-with-icon location">
                                        <input id="search_location" name="search_location" type="text" placeholder="<?php esc_attr_e('City, State or Zip','workscout'); ?>">
                                        
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
                                            'taxonomy'          => 'job_listing_category',
                                            'name'              => 'search_category',
                                            'orderby'           => 'name',
                                            'class'             => 'select-on-home',
                                            'hierarchical'      => true,
                                            'hide_empty'        => true ,
                                            'show_option_all'   => esc_html__('All Categories','workscout'),
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


        <!-- Stats -->
        <?php if(Kirki::get_option('workscout','pp_home_job_advanced')) {  ?>
        <div class="row">
            <div class="sixteen columns">
                <div class="adv-search-btn">
                    <span><?php esc_html_e('Need more search options?','workscout') ?> </span>
                    <a href="<?php echo get_post_type_archive_link( 'job_listing' ) ?>"><?php esc_html_e('Advanced Search','workscout') ?> <i class="la la-long-arrow-alt-right"></i></a>
                </div>
            </div>
        </div>
        <?php } ?>


    </div>
</div>       

<?php 


    if($full_width == 'yes') {
       if($from_vs === 'yes') { ?>
              
    <div class="container">
        <article class="sixteen columns">
             <div class="vc_row wpb_row vc_row-fluid">
                <div class="wpb_column vc_column_container vc_col-sm-12">
                    <div class="vc_column-inner ">
                        <div class="wpb_wrapper">
        <?php } else { ?>
            <div class="container">
                <article class="sixteen columns">
        <?php  }
    }
       $output =  ob_get_clean() ;
       return  $output ;
    }?>