<?php
/**
 * Job Category
 *
 * @package WorkScout
 * @since WorkScout 1.0
 */

$taxonomy = get_taxonomy( get_queried_object()->taxonomy );


$header_old = Kirki::get_option('workscout','pp_old_header');
$header_type = (Kirki::get_option('workscout','pp_old_header') == true) ? 'old' : '' ;
$header_type = apply_filters('workscout_header_type',$header_type);

get_header($header_type); 
$cat_desc = Kirki::get_option('workscout','pp_taxonomies_description');


$layout = Kirki::get_option('workscout','jobs_list_layout');

if($layout == 'split'){ ?>

<!-- Page Content
================================================== -->
	<div class="full-page-container with-map">

		<!-- Full Page Content -->
		<div class="full-page-content-container" data-simplebar>
			<div class="full-page-content-inner">
				
				<?php get_template_part('template-parts/jobs-split-filters'); ?>	
				
				<?php if($cat_desc): ?>
				<div class="job-category-description">
					<h1><?php the_archive_title(); ?></h1>
					<?php echo category_description(); ?>
				</div> 
				<?php endif; ?>
				
				<div class="listings-container">
					
					
					<?php echo do_shortcode('[jobs job_types='.get_query_var('job_listing_type').' show_filters="false"]'); ?>
					

				</div>


				<?php get_template_part('template-parts/split-footer'); ?>	
				<!-- Footer / End -->

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
<?php

get_footer('empty'); ?>


<?php } else { ?>


	<?php 
	$t_id = get_queried_object()->term_id;
	$term_meta = get_option( "taxonomy_$t_id" ); 
	$map =  Kirki::get_option( 'workscout', 'pp_enable_jobs_map', 0 ); 

	$header_image = isset($term_meta['upload_header']) ? $term_meta['upload_header'] : '';
	if(!empty($header_image)) { ?>
		<div id="titlebar" class="photo-bg single <?php if($map) echo " with-map"; ?>" style="background: url('<?php echo esc_url($header_image); ?>')">
	<?php } else { ?>
		<div id="titlebar" class="single <?php if($map) echo " with-map"; ?>">
	<?php } ?>
			<div class="container">
				<div class="sixteen columns">
						<h1><?php single_term_title(); ?></h1>
						<?php if(function_exists('bcn_display')) { ?>
				        <nav id="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
							<ul>
					        	<?php bcn_display_list(); ?>
					        </ul>
						</nav>
						<?php } ?>
					</div>
			</div>
		</div>
	<?php 
		$layout = Kirki::get_option( 'workscout', 'pp_blog_layout' );
		if(empty($layout)) { $layout = 'right-sidebar'; }

		wp_dequeue_script('wp-job-manager-ajax-filters' );
		wp_enqueue_script( 'workscout-wp-job-manager-ajax-filters' );

	if($map) { 
		$all_map = Kirki::get_option( 'workscout', 'pp_enable_all_jobs_map', 0 ); 
		if($all_map){ 
			echo do_shortcode('[workscout-map type="job_listing" class="jobs_page"]'); 
		} else { ?>
			<div id="search_map" data-map-scroll="<?php echo Kirki::get_option( 'workscout','pp_maps_scroll_zoom', 1) == 1 ? 'true' : 'false'; ?>" class="jobs_map"></div>
		<?php 
		}
	} ?>

	<div class="container  wpjm-container <?php echo esc_attr($layout); ?>">
		

		<?php if($cat_desc): ?>
				<div class="job-category-description sixteen columns margin-bottom-50">
					<h1><?php the_archive_title(); ?></h1>
					<?php echo category_description(); ?>
				</div> 
		<?php endif; ?>

		<?php  get_sidebar('jobs');?>

		<article id="post-<?php the_ID(); ?>" <?php post_class('eleven columns'); ?>>
			<div class="padding-right">
				<?php 
				$search_in_sb =  Kirki::get_option( 'workscout','pp_jobs_search_in_sb');
				if(!$search_in_sb) {
					if ( ! empty( $_GET['search_keywords'] ) ) {
						$keywords = sanitize_text_field( $_GET['search_keywords'] );
					} else {
						$keywords = '';
					}
					?>
					<form class="list-search"  method="GET" action="<?php echo get_permalink(); ?>">
						<div class="search_keywords">
							<button><i class="fa fa-search"></i></button>
							<input type="text" name="search_keywords" id="search_keywords" placeholder="<?php esc_attr_e( 'job title, keywords or company name', 'workscout' ); ?>" value="<?php echo esc_attr( $keywords ); ?>" />
							<div class="clearfix"></div>
						</div>
					</form>
				<?php } ?>
				<?php echo do_shortcode('[jobs job_types='.get_query_var('job_listing_type').' show_filters="false"]'); ?>

			</div>
		</article>

	</div>
	<?php
	get_footer(); 
	?>
<?php } ?>