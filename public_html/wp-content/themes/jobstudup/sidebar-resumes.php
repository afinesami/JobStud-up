<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WorkScout
 */


?>
<!-- Widgets -->
<div class="five columns sidebar "  role="complementary">
<form class="resume_filters in_sidebar">
	<div class="job_filters_links"></div>
<?php if ( get_option( 'resume_manager_regions_filter' ) || is_tax( 'resume_region' ) ) {  ?>
	<div class="widget ">
		<h4><?php esc_html_e('Region','workscout'); ?></h4>
		<div class="search_location">
			<?php

			if(is_tax('resume_region')){
				$region = get_query_var('resume_region');
				$term = get_term_by('slug', $region, 'resume_region');
				$selected = $term->term_id;
				
			} else {
				$selected = isset( $_GET[ 'search_region' ] ) ? $_GET[ 'search_region' ] : '';
			}
			
		  	$dropdown = wp_dropdown_categories( apply_filters( 'job_manager_regions_dropdown_args', array(
                'show_option_all' => __( 'All Regions', 'wp-job-manager-locations', 'workscout' ),
                'hierarchical' => true,
                'orderby' => 'name',
                'taxonomy' => 'resume_region',
                'name' => 'search_region',
                'id' => 'search_location',
                'class' => 'search_region job-manager-category-dropdown select2-single ' . ( is_rtl() ? 'chosen-rtl' : '' ),
                'hide_empty' => 0,
                'selected' => $selected,
                'echo'=>false,
            ) ) );
            $fixed_dropdown = str_replace("&nbsp;", "", $dropdown); echo $fixed_dropdown;
			?>
		</div>
	</div>
	<?php } else { ?>
	<div class="widget job-widget-location">
		<h4><?php esc_html_e('Location','workscout'); ?></h4>
		<div class="search_location widget_range_filter">
			<?php 
			if ( ! empty( $_GET['search_location'] ) ) {
				$location = sanitize_text_field( $_GET['search_location'] );
			} else {
				$location = '';
			} ?>
			<div class="sidebar-search_location-container ">
				<input type="text" name="search_location" id="search_location" placeholder="<?php esc_attr_e( 'Location', 'workscout' ); ?>" value="<?php echo esc_attr( $location ); ?>" />
				<a href="#"><i title="<?php esc_html_e('Find My Location','workscout') ?>" class="tooltip left la la-map-marked-alt"></i></a>
	            <?php if(get_option('workscout_map_address_provider','osm') == 'osm') : ?><span class="type-and-hit-enter"><?php esc_html_e('type and hit enter','workscout') ?></span> <?php endif; ?>
			</div>
			<?php 
						
						$geocode = get_option( 'workscout_maps_api_server', 0);
						$default_radius = get_option( 'workscout_maps_default_radius');
						if($geocode) : ?>
						  <h4 class="checkboxes" style="margin-bottom: 0;">
								<input type="checkbox" name="filter_by_radius_check" id="radius_check" class="filter_by_radius" <?php if(get_option('workscout_radius_state') == 'enabled') echo "checked";?>> 
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
	<!-- Skills -->
	<?php if ( get_option( 'resume_manager_enable_skills' ) ) : ?>
		<?php
			if ( ! empty( $_GET['search_skills'] ) ) {
				$selected_skills = sanitize_text_field( $_GET['search_skills'] );
			} else {
				$selected_skills  = '';
			}
			if ( ! is_tax( 'resume_skill' ) && get_terms( 'resume_skill' ) ) : ?>
			<div class="widget">
				<h4><?php esc_html_e('Filter by Skills','workscout'); ?></h4>
				<div class="search_categories resume-filter">
					<?php job_manager_dropdown_categories( array( 'taxonomy' => 'resume_skill', 'hierarchical' => 1, 'name' => 'search_skills', 'orderby' => 'name', 'selected' => $selected_skills, 'hide_empty' => false, 'class' => 'select2-multiple', 'id'=>'search_skills', 'placeholder'=> esc_html__('Choose a skill','workscout') ) ); ?>
					
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	
	<?php 
		if ( ! empty( $_GET['search_categories'] ) ) {
			$selected_category = sanitize_text_field( $_GET['search_categories'] );
		} else {
			$selected_category  = '';
		}

	if ( get_option( 'resume_manager_enable_categories' ) && ! is_tax( 'resume_category' ) && get_terms( 'resume_category' ) ) : ?>
		<div class="widget">
		<h4><?php esc_html_e('Filter by Categories','workscout'); ?></h4>
			<div class="search_categories resume-filter">
				<?php job_manager_dropdown_categories( array( 'taxonomy' => 'resume_category', 'hierarchical' => 1, 'name' => 'search_categories', 'orderby' => 'name', 'class' => 'select2-multiple', 'selected' => $selected_category, 'hide_empty' => false, 'id'=>'search_categories' ) ); ?>
			</div>
		</div>
	<?php else: ?>
		<input type="hidden" name="search_categories[]" value="<?php echo sanitize_title( get_query_var('resume_category') ); ?>" />
	<?php endif; ?>

	<?php if(get_option('workscout_enable_resume_filter_rate')) : ?>
	<div class="widget widget_range_filter">
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
	

</form>

	<?php dynamic_sidebar( 'sidebar-resumes' ); ?>
</div><!-- #secondary -->
