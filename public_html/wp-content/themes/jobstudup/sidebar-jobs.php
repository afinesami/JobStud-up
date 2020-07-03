<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WorkScout
 */
$locreg_widget = $job_types_widget = $job_categories_widget = $salary_widget = $rate_widget = $job_tags_widget = 'on';

if(is_page()) {
	$locreg_widget 			= get_post_meta($post->ID, 'pp_jobs_filters_locreg_widget', TRUE); 
	$job_types_widget 		= get_post_meta($post->ID, 'pp_jobs_filters_types_widget', TRUE); 
	$job_tags_widget 		= get_post_meta($post->ID, 'pp_jobs_filters_tags_widget', TRUE); 
	$job_categories_widget 	= get_post_meta($post->ID, 'pp_jobs_filters_categories_widget', TRUE); 
	$salary_widget 			= get_post_meta($post->ID, 'pp_jobs_filters_salary_widget', TRUE); 
	$rate_widget 			= get_post_meta($post->ID, 'pp_jobs_filters_rate_widget', TRUE); 
} 
?>
<!-- Widgets -->
<div class="five columns sidebar"  role="complementary">
<?php 
	$search_in_sb =  Kirki::get_option( 'workscout','pp_jobs_search_in_sb');
	if($search_in_sb) {
		if ( ! empty( $_GET['search_keywords'] ) ) {
			$keywords = sanitize_text_field( $_GET['search_keywords'] );
		} else {
			$keywords = '';
		}
		?>
		<div class="widget job-widget-keywords">
			<h4><?php esc_html_e('Keywords','workscout'); ?></h4>
			<?php if(is_page() && is_page_template('template-jobs.php')) { ?>
			<form class="list-search"  method="GET" action="<?php echo get_permalink(); ?>">
			<?php } else { ?>
			<form class="list-search"  method="GET" action="<?php echo get_permalink(get_option('job_manager_jobs_page_id')); ?>">
			<?php }  ?>
				<div class="search_keywords">
					<input type="text" name="search_keywords" id="search_keywords" placeholder="<?php esc_attr_e( 'job title, keywords or company name', 'workscout' ); ?>" value="<?php echo esc_attr( $keywords ); ?>" />
					<div class="clearfix"></div>
				</div>
			</form>
		</div>
	<?php } ?>
<form class="job_filters in_sidebar">
	<?php 
		if ( ! empty( $_GET['search_keywords'] ) ) {
			$keywords = sanitize_text_field( $_GET['search_keywords'] );
		} else {
			$keywords = '';
		}
	?>
	<input type="hidden" name="search_keywords" id="search_keywords" placeholder="<?php esc_attr_e( 'job title, keywords or company name', 'workscout' ); ?>" value="<?php echo esc_attr( $keywords ); ?>" />
	
	<div class="job_filters_links"></div>
	<?php if(get_query_var( 'company')) {?>
		<input type="hidden" name="company_field" value="<?php echo urldecode( get_query_var( 'company') ) ?>">
	<?php } ?>
		
	
	<?php if(get_option('workscout_enable_location_sidebar') == 1) { ?>
		<?php if ( class_exists('Astoundify_Job_Manager_Regions') &&  ( get_option( 'job_manager_regions_filter' ) || is_tax( 'job_listing_region' ) ) ) {  ?>
			<div class="widget job-widget-regions" <?php if($locreg_widget == "off" || is_tax( 'job_listing_region' ) ) : echo ' style="display:none;" '; endif; ?>>
				<h4><?php esc_html_e('Region','workscout'); ?></h4>
				<div class="search_location">
					<?php

					if(is_tax('job_listing_region')){
						$region = get_query_var('job_listing_region');
						$term = get_term_by('slug', $region, 'job_listing_region');
						$selected = $term->term_id;
						
					} else {
						$selected = isset( $_GET[ 'search_region' ] ) ? $_GET[ 'search_region' ] : '';
					}
					
				  	// $dropdown = wp_dropdown_categories( apply_filters( 'job_manager_regions_dropdown_args', array(
       //                  'show_option_all' => __( 'All Regions', 'wp-job-manager-locations' ),
       //                  'hierarchical' => true,
       //                  'orderby' => 'name',
       //                  'taxonomy' => 'job_listing_region',
       //                  'name' => 'search_region',
       //                  'id' => 'search_location',
       //                  'class' => 'search_region select2-multiple job-manager-category-dropdown' . ( is_rtl() ? 'chosen-rtl' : '' ),
       //                  'hide_empty' => 1,
       //                  'selected' => $selected,
       //                  'echo'=>false,
       //              ) ) );
       //              $fixed_dropdown = str_replace("&nbsp;", "", $dropdown); echo $fixed_dropdown;



					job_manager_dropdown_categories( 
						array( 
							'taxonomy' => 'job_listing_region', 
							'hierarchical' => 1,
							'depth' => -1, 
							'class' =>  'select2-multiple job-manager-category-dropdown ' . ( is_rtl() ? 'chosen-rtl' : '' ),
							'name' => 'search_region', 
							'orderby' => 'name', 
							'selected' => $selected, 
							'hide_empty' => false ) 
						);
					?>
				</div>
			</div>
			<?php } else { ?>
			<div class="widget job-widget-location" <?php if($locreg_widget == "off") : echo ' style="display:none;" '; endif; ?>>
				<h4><?php esc_html_e('Location','workscout'); ?></h4>
				<div class="search_location widget_range_filter">
					<?php 
					if ( ! empty( $_GET['search_location'] ) ) {
						$location = sanitize_text_field( $_GET['search_location'] );
					} else {
						$location = '';
					} ?>
					<div class="sidebar-search_location-container">
						<input type="text" name="search_location" id="search_location" placeholder="<?php esc_attr_e( 'Location', 'workscout' ); ?>" value="<?php echo esc_attr( $location ); ?>" />
						<a href="#"><i title="<?php esc_html_e('Find My Location','workscout') ?>" class="tooltip left la la-map-marked-alt"></i></a>
                        <?php if(get_option('workscout_map_address_provider','osm') == 'osm') : ?><span class="type-and-hit-enter"><?php esc_html_e('type and hit enter','workscout') ?></span> <?php endif; ?>
                    </div>
                 
					<?php 
						
						$geocode = get_option( 'workscout_maps_api_server', 0);
						$default_radius = get_option( 'workscout_maps_default_radius');
						if($geocode) : ?>
						  <h4 class="checkboxes" style="margin-bottom: 0;">
								<input type="checkbox" name="filter_by_radius_check" id="radius_check" class="filter_by_radius" <?php if(get_option('workscout_radius_state') == 'enabled') echo "checked";?> > 
								<label for="radius_check"><?php esc_html_e('Search by Radius','workscout'); ?></label>
							</h4>
		                    
					
							<div class="widget_range_filter-inside">
								<span class="range-slider-subtitle"><?php esc_html_e('Radius around selected destination','workscout') ?></span>
								<div class="radius_amount range-indicator">
									<span><?php echo $default_radius; ?></span> <?php echo get_option('workscout_radius_unit'); ?>
								</div>
							    <input type="hidden" name="search_radius" value="<?php echo $default_radius; ?>" id="radius_amount" type="checkbox"   >
								<div id="radius-range"></div>
								<div class="margin-bottom-50"></div>
							</div>
							<div class="clearfix"></div> 
					<?php endif; ?>	
				</div>
				  

			</div>
		<?php } ?>
	<?php } ?>
	

	<?php if ( get_option( 'job_manager_enable_types' ) ) { ?>
	<div class="widget job-widget-job-types" <?php if($job_types_widget == "off") : echo ' style="display:none;" '; endif; ?>>
		<?php if ( ! is_tax( 'job_listing_type' ) ) : ?><h4><?php esc_html_e('Job type','workscout'); ?></h4><?php endif; ?>
		<?php get_job_manager_template( 'job-filter-job-types.php', array( 'job_types' => '', 'atts' => array('orderby' => 'rand'), 'selected_job_types' => '' ) ); ?>
	</div>
	<?php } ?>


	<?php 
	if ( ! is_tax( 'job_listing_category' ) && get_terms( 'job_listing_category' ) ) :
		$show_category_multiselect = get_option( 'job_manager_enable_default_category_multiselect', false ); 

		if ( !empty( $_GET['search_category'] ) ) {
			$selected_category = sanitize_text_field( $_GET['search_category'] );
		} else {
			$selected_category = "";
		}
		?>
		<div class="widget job-widget-categories" <?php if($job_categories_widget == "off") : echo ' style="display:none;" '; endif; ?>>
			<h4><?php esc_html_e('Category','workscout'); ?></h4>
			<div class="search_categories">
				
				<?php if ( $show_category_multiselect ) : ?>
					<?php 
					job_manager_dropdown_categories( 
						array( 
							'taxonomy' => 'job_listing_category', 
							'hierarchical' => 1,
							'depth' => -1, 
							'class' =>  'select2-multiple job-manager-category-dropdown ' . ( is_rtl() ? 'chosen-rtl' : '' ),
							'name' => 'search_categories', 
							'orderby' => 'name', 
							'selected' => $selected_category, 
							'hide_empty' => false ) 
						); ?>
				<?php else : ?>
					<?php job_manager_dropdown_categories( array( 
					'taxonomy' => 'job_listing_category', 
					'hierarchical' => 1, 
					'class' =>  'select2-single job-manager-category-dropdown ' . ( is_rtl() ? 'chosen-rtl' : '' ),
					'show_option_all' => esc_html__( 'Any category', 'workscout' ), 
					'name' => 'search_categories', 
					'orderby' => 'name', 
					'selected' => $selected_category, 
					'multiple' => false,
					'hide_empty' => false ) ); ?>
				<?php endif; ?>
				
			</div>
		</div>
	<?php else: ?>
		<input type="hidden" name="search_categories[]" value="<?php echo sanitize_title( get_query_var('job_listing_category') ); ?>" />
	<?php endif; ?>

	<?php if(get_option('workscout_enable_filter_salary')) : ?>
	<div class="widget widget_range_filter widget-salary-filter" <?php if($salary_widget == "off") : echo ' style="display:none;" '; endif; ?>>

		<h4 class="checkboxes" style="margin-bottom: 0;">
			<input type="checkbox" name="filter_by_salary_check" id="salary_check" class="filter_by_check"> 
			<label for="salary_check"><?php esc_html_e('Filter by Salary','workscout'); ?></label>
		</h4>

		<div class="widget_range_filter-inside">
			<div class="salary_amount range-indicator">
				<span class="from"></span> &mdash; <span class="to"></span>
			</div>
		    <input type="hidden" name="filter_by_salary" id="salary_amount" type="checkbox"   >
			<div id="salary-range"></div>
			<div class="margin-bottom-50"></div>
		</div>

	</div>
	<?php endif; ?>

	<?php if(get_option('workscout_enable_filter_rate')) : ?>
	<div class="widget widget_range_filter widget-rate-filter" <?php if($rate_widget == "off") : echo ' style="display:none;" '; endif; ?>>
		<h4 class="checkboxes" style="margin-bottom: 0;">
			<input type="checkbox" name="filter_by_rate_check" id="filter_by_rate" class="filter_by_check"> 
			<label for="filter_by_rate"><?php esc_html_e('Filter by Rate','workscout'); ?></label>
		</h4>
		<div class="widget_range_filter-inside">
			<div class="rate_amount range-indicator">
				<span class="from"></span> &mdash; <span class="to"></span>
			</div>
		    <input type="hidden" name="filter_by_rate" id="rate_amount" type="checkbox"  >
			<div id="rate-range"></div>
		</div>
	</div>
	<?php endif; ?>

	<?php if ( taxonomy_exists( "job_listing_tag" ) && get_option('workscout_enable_job_tags_sidebar') ) { ?>
	<div class="widget widget_range_filter widget-tag" <?php if($job_tags_widget == "off") : echo ' style="display:none;" '; endif; ?>>
		<div class="filter_wide filter_by_tag">
			<h4><?php esc_html_e( 'Filter by tag:', 'workscout' ) ?></h4>
			<span class="filter_by_tag_cloud"></span>
		</div>
	</div>
	<?php } ?>

</form>
	<?php dynamic_sidebar( 'sidebar-jobs' ); ?>
</div><!-- #secondary -->
