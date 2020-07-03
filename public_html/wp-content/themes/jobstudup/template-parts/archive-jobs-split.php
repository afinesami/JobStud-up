<?php 

wp_dequeue_script('wp-job-manager-ajax-filters' );
wp_enqueue_script( 'workscout-wp-job-manager-ajax-filters' );

?>

<!-- Page Content
================================================== -->
<div class="full-page-container with-map">

	<!-- Full Page Content -->
	<div class="full-page-content-container" data-simplebar>
		<div class="full-page-content-inner">
			
			<?php get_template_part('template-parts/jobs-split-filters'); ?>	

			<div class="listings-container">
				<?php the_content(); ?>
			</div>

			<?php get_template_part('template-parts/split-footer'); ?>	
			

		</div>
	</div>
	<!-- Full Page Content / End -->


	<!-- Full Page Map -->
	<div class="full-page-map-container">
		<?php $all_map = Kirki::get_option( 'workscout', 'pp_enable_all_jobs_map', 0 ); 
			if($all_map){ 
				echo do_shortcode('[workscout-map type="job_listing" class="jobs_page"]'); 
			} else { ?>
				<div id="search_map"  data-map-scroll="true" class="jobs_map"></div>
		<?php } ?>
	</div>
	<!-- Full Page Map / End -->

</div>

</div>
