<!-- Filters Container -->
<div class="filters-container">

	<!-- Page Title -->
	<h3 class="filters-headline"><?php esc_html_e( 'Find Candidate', 'workscout' ); ?></h3>
	<?php if(is_page() && is_page_template('template-jobs.php')) { ?>
	<form class="resume_filters in_sidebar"  method="GET" action="<?php echo get_permalink(); ?>">
	<?php } else { ?>
	<form class="resume_filters in_sidebar"  method="GET" action="<?php echo get_permalink(); ?>">
	<?php }  ?>
	<!-- Filters Flexbox Row -->
	<div class="filters-flexbox-row">
		

		<div class="filters-flexbox-child flex-one-half resume-filters-keywords">
			<?php get_template_part('search-fields/split-resume','keywords'); ?>		
		</div>

		<div class="filters-flexbox-child flex-one-half resume-filters-location">
			<?php get_template_part('search-fields/split','location'); ?>	
        </div>

		<div class="filters-flexbox-child flex-one-half resume-filters-resume_category">
			<?php get_template_part('search-fields/split-resume','resume_category'); ?>	
		</div>

		<div class="filters-flexbox-child flex-one-half resume-filters-resume_skill">
			<?php get_template_part('search-fields/split-resume','resume_skill'); ?>	
		</div>
	</div>
		<div class="panel-wrapper widget_range_filter">

			<?php if(get_option('workscout_maps_api_server')) : get_template_part('search-fields/split','radius'); endif; ?>		
						
			<?php if(get_option('workscout_enable_resume_filter_rate')) : ?>
								
					<?php get_template_part('search-fields/split-resume','rate') ?>			
					
			<?php endif; ?>
		</div>
	
	
	</form>
	<!-- Filters Flexbox Row / End -->


</div>
<!-- Filters Container / End -->