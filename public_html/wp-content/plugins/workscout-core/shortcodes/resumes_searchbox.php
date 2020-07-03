<?php 

 function workscout_resumes_searchbox($atts, $content ) {

      extract(shortcode_atts(array(
           
            'full_width'    => 'no',
            'show_resumes'     => 'yes',
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

<div id="banner" <?php echo workscout_get_resume_search_header();?>  class="workscout-search-banner  resumes-search-banner <?php if( $fancy_header) { ?> with-transparent-header parallax background <?php } ?>" >
    <div class="container">
        <div class="sixteen columns">
            
            <div class="search-container sc-resumes">

                <!-- Form -->
                <h2><?php echo Kirki::get_option( 'workscout','pp_resume_home_title','Find Candidate');  ?></h2>
                <form method="GET" action="<?php echo get_permalink(get_option('resume_manager_resumes_page_id')); ?>">
            
                    <input type="text" id="search_keywords" name="search_keywords"  class="ico-01" placeholder="<?php esc_attr_e( 'Search freelancer services (e.g. logo design)', 'workscout_core' ); ?>" value=""/>
                   
               
                    <?php if ( get_option( 'resume_manager_regions_filter' ) || is_tax( 'resume_region' ) ) {  ?>
                        <?php
                        $dropdown = wp_dropdown_categories( apply_filters( 'job_manager_regions_dropdown_args', array(
                            'show_option_all' => __( 'All Regions', 'wp-job-manager-locations' ),
                            'hierarchical' => true,
                            'orderby' => 'name',
                            'taxonomy' => 'resume_region',
                            'name' => 'search_region',
                            'id' => 'search_location',
                            'class' => 'search_region job-manager-category-dropdown chosen-select-deselect ' . ( is_rtl() ? 'chosen-rtl' : '' ),
                            'hide_empty' => 0,
                            'selected' => isset( $_GET[ 'search_region' ] ) ? $_GET[ 'search_region' ] : '',
                            'echo'=>false,
                        ) ) );
                        $fixed_dropdown = str_replace("&nbsp;", "", $dropdown); echo $fixed_dropdown;
                    } else { ?>
                    <input type="text" id="search_location" name="search_location" class="ico-02" placeholder="<?php esc_attr_e('city, province or region','workscout_core'); ?>" value=""/> 
                    <?php } ?>

                    <button><i class="fa fa-search"></i></button>

                </form>

                <div class="browse-jobs">
                    <?php 
                    if(Kirki::get_option( 'workscout','pp_resume_categories_page')){
                        $categories_page = Kirki::get_option( 'workscout','pp_resume_categories_page');
                    } 

                    if(!empty($categoriespage)) { 
                        printf( __( ' Or browse resumes by <a href="%s">category</a>', 'workscout_core' ), get_permalink($categories_page) );
                    } ?>
                </div>
                <?php 
                if(Kirki::get_option( 'workscout','pp_home_resume_counter')) : ?>
                <!-- Announce -->
                <div class="announce">
                    <?php $count_jobs = wp_count_posts( 'resume', 'readable' ); 
                    printf( esc_html__( 'We have %s resumes in our database', 'workscout_core' ), '<strong>' . $count_jobs->publish . '</strong>' ) ?>
                </div>
                <?php endif; ?>

            </div>

        </div>
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