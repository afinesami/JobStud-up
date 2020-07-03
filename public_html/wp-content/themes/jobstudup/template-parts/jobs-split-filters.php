<?php if(is_page()) {
	$locreg_widget 			= get_post_meta($post->ID, 'pp_jobs_filters_locreg_widget', TRUE); 
	$job_types_widget 		= get_post_meta($post->ID, 'pp_jobs_filters_types_widget', TRUE); 
	$job_tags_widget 		= get_post_meta($post->ID, 'pp_jobs_filters_tags_widget', TRUE); 
	$job_categories_widget 	= get_post_meta($post->ID, 'pp_jobs_filters_categories_widget', TRUE); 
	$salary_widget 			= get_post_meta($post->ID, 'pp_jobs_filters_salary_widget', TRUE); 
	$rate_widget 			= get_post_meta($post->ID, 'pp_jobs_filters_rate_widget', TRUE); 
} else {
	$locreg_widget = $job_types_widget = $job_tags_widget = $job_categories_widget = $salary_widget = $rate_widget = 'yes';
}
?>
<!-- Filters Container -->
<div class="filters-container">

	<!-- Page Title -->
	<h3 class="filters-headline"><?php esc_html_e( 'Find Job', 'workscout' ); ?></h3>
	<?php if(is_page() && is_page_template('template-jobs.php')) { ?>
	<form class="job_filters in_sidebar"  method="GET" action="<?php echo get_permalink(); ?>">
	<?php } else { ?>
	<form class="job_filters in_sidebar"  method="GET" action="<?php echo get_permalink(); ?>">
	<?php }  ?>
	<!-- Filters Flexbox Row -->
		<div class="filters-flexbox-row">
			
			<div class="filters-flexbox-child flex-one-half jobs-filters-keyword">
				<?php get_template_part('search-fields/split-jobs','keywords'); ?>	
			</div>
			
			<?php if($locreg_widget != 'off'): ?>
				<div class="filters-flexbox-child flex-one-half jobs-filters-location">
					<?php get_template_part('search-fields/split','location'); ?>	
                </div>
        	<?php endif; ?>
			
			<?php if($job_categories_widget != 'off'): ?>
			<div class="filters-flexbox-child flex-full-width jobs-filters-job-category">
				<?php get_template_part('search-fields/split-jobs','job_listing_category') ?>
			</div>
			<?php endif; ?>

		</div>
		<div class="panel-wrapper widget_range_filter">
			
			<?php 
			if(!is_tax( 'job_listing_type' )) {
				if($job_types_widget != 'off' ) : get_template_part('search-fields/split-jobs','job_types'); endif; 
			} else { ?>
				<input type="hidden" name="search_categories[]" value="<?php echo sanitize_title( get_query_var('job_listing_type') ); ?>" />
			<?php }
			?>

			<?php if(get_option('workscout_maps_api_server')) : get_template_part('search-fields/split','radius'); endif; ?>		
			
			<?php if(get_option('workscout_enable_filter_salary')) : ?>
					<?php if($salary_widget != 'off') : get_template_part('search-fields/split-jobs','salary') ; endif; ?>											
			<?php endif; ?>

			<?php if(get_option('workscout_enable_filter_rate')) : ?>
					<?php if($rate_widget != 'off') :  get_template_part('search-fields/split-jobs','rate');  endif; ?>			
			<?php endif; ?>

		</div>				
	
	</form>
	<!-- Filters Flexbox Row / End -->
</div>
<!-- Filters Container / End -->