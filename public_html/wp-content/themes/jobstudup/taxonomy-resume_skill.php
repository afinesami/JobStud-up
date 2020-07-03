<?php
/**
 * Job Category
 */

$header_old = Kirki::get_option('workscout','pp_old_header');
$header_type = (Kirki::get_option('workscout','pp_old_header') == true) ? 'old' : '' ;
$header_type = apply_filters('workscout_header_type',$header_type);
get_header($header_type); 
$cat_desc = Kirki::get_option('workscout','pp_resumes_taxonomies_description');



$layout = Kirki::get_option('workscout','jobs_list_layout');

if($layout == 'split'){ ?>


<!-- Page Content
================================================== -->
	<div class="full-page-container with-map">

		<!-- Full Page Content -->
		<div class="full-page-content-container" data-simplebar>
			<div class="full-page-content-inner">
				
				<?php get_template_part('template-parts/resume-split-filters'); ?>	
				
				<?php if($cat_desc): ?>
				<div class="job-category-description">
					<h1><?php the_archive_title(); ?></h1>
					<?php echo category_description(); ?>
				</div> 
				<?php endif; ?>
				
				<div class="listings-container">
					
					
				<?php echo do_shortcode('[resumes  categories='.get_query_var('resume_region').' show_filters="false" show_pagination="true"]')?>
				</div>


				<?php get_template_part('template-parts/split-footer'); ?>	

			</div>
		</div>
		<!-- Full Page Content / End -->


		<!-- Full Page Map -->
		<div class="full-page-map-container">
			<?php $all_map = Kirki::get_option( 'workscout', 'pp_enable_all_resumes_map', 0 ); 
				if($all_map){ 
					echo do_shortcode('[workscout-map type="resume" class="resumes_page"]'); 
				} else { ?>
					<div id="search_map"  data-map-scroll="true" class="resumes_map"></div>
			<?php } ?>
		</div>
		<!-- Full Page Map / End -->

	</div>

</div>
<?php

get_footer('empty'); ?>


<?php } else { 


$map =  Kirki::get_option( 'workscout', 'pp_enable_jobs_map', 0 ); 
$header_image = Kirki::get_option( 'workscout', 'pp_jobs_header_upload', '' );  
$titlebar = Kirki::get_option( 'workscout', 'pp_disable_jobs_titlebar');  
	
$layout = Kirki::get_option( 'workscout', 'pp_blog_layout' );
if(empty($layout)) { $layout = 'right-sidebar'; }

wp_dequeue_script('wp-job-manager-ajax-filters' );
wp_enqueue_script( 'workscout-wp-job-manager-ajax-filters' );


if($titlebar) {
	// no titlebar
} else { 
if(!empty($header_image)) { 
			$transparent_status = Kirki::get_option( 'workscout', 'pp_jobs_transparent_header');
				
			if($transparent_status){ ?>
				<div id="titlebar" class="photo-bg single with-transparent-header <?php if($map) echo " with-map"; ?>"" style="background: url('<?php echo esc_url($header_image); ?>')">
			<?php } else { ?>
				<div id="titlebar" class="photo-bg single <?php if($map) echo " with-map"; ?>" style="background: url('<?php echo esc_url($header_image); ?>')">
			<?php } ?>
				
<?php } else { ?>
	<div id="titlebar" class="single <?php if($map) echo " with-map"; ?>">
<?php } ?>

	<div class="container">
		<div class="sixteen columns">
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
</div>
<?php } 


if($map) { 
	$all_map = Kirki::get_option( 'workscout', 'pp_enable_all_jobs_map', 0 ); 
	if($all_map){ 
		echo do_shortcode('[workscout-map type="resume" class="resumes_page"]'); 
	} else { ?>
		<div id="search_map" data-map-scroll="<?php echo Kirki::get_option( 'workscout','pp_maps_scroll_zoom', 1) == 1 ? 'true' : 'false'; ?>" class="jobs_map"></div>
	<?php 
	}
}
?>

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

			if(empty($search_in_sb)) {

				if ( ! empty( $_GET['search_keywords'] ) ) {
					$keywords = sanitize_text_field( $_GET['search_keywords'] );
				} else {
					$keywords = '';
				}
				?>
				<form class="list-search"  method="GET" action="">
					<div class="search_keywords">
						<button><i class="fa fa-search"></i></button>
						<input type="text" name="search_keywords" id="search_keywords" placeholder="<?php esc_attr_e( 'job title, keywords or company name', 'workscout' ); ?>" value="<?php echo stripslashes(esc_attr( $keywords )); ?>" />
						<div class="clearfix"></div>
					</div>
				</form>

			<?php
			}
			echo do_shortcode('[resumes  categories='.get_query_var('resume_region').' show_filters="false" show_pagination="true"]')?>
			<footer class="entry-footer">
				<?php edit_post_link( esc_html__( 'Edit', 'workscout' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-footer -->
		</div>
	</article>
	

</div>
<?php get_footer(); ?>

<?php } ?>