<?php
/**
 * Job Category
 */

$header_old = Kirki::get_option('workscout','pp_old_header');
$header_type = (Kirki::get_option('workscout','pp_old_header') == true) ? 'old' : '' ;
$header_type = apply_filters('workscout_header_type',$header_type);
get_header($header_type); 



$layout = Kirki::get_option('workscout','jobs_list_layout');

if($layout == 'split'){ ?>


<!-- Page Content
================================================== -->
	<div class="full-page-container with-map">

		<!-- Full Page Content -->
		<div class="full-page-content-container" data-simplebar>
			<div class="full-page-content-inner">
				
				<?php get_template_part('template-parts/jobs-split-filters'); ?>	

				<div class="listings-container">
					
					
					<?php
					$order = Kirki::get_option( 'workscout', 'pp_jobs_order', 'DESC' ); 
					$orderby = Kirki::get_option( 'workscout', 'pp_jobs_orderby', 'date' ); 
					$per_page = Kirki::get_option( 'workscout', 'pp_jobs_per_page', 10 ); 
				
					echo do_shortcode('[jobs orderby="'.$orderby.'" order="'.$order.'" per_page="'.$per_page.'"  show_filters="false"]'); ?>
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
			<div class="ten columns">
					<?php $hide_counter =  Kirki::get_option( 'workscout', 'pp_disable_jobs_counter', true );
					if($hide_counter) { ?>
					<?php $count_jobs = wp_count_posts( 'job_listing', 'readable' ); ?>
					<span class="showing_jobs" style="display: none">
						<?php esc_html_e('Browse Jobs','workscout') ?>
					</span>
					<h2><?php 
 					printf(_n(  'We have <em class="count_jobs">%s</em> <em class="job_text">job offer</em> for you', 'We have <em class="count_jobs">%s</em> <em class="job_text">job offers</em> for you' , $count_jobs->publish, 'workscout' ), $count_jobs->publish); ?>
 						
 					</h2>
					<?php } else { ?>
						<?php if(!empty(get_option('job_manager_jobs_page_id'))) { ?>
						<h1><?php echo get_the_title(get_option('job_manager_jobs_page_id')); ?></h1>
						<?php } else { ?>
						<h1><?php esc_html_e('Jobs','workscout'); ?></h1>
						<?php } ?>
					<?php } ?>
					
			</div>

			<?php 
			$call_to_action = Kirki::get_option( 'workscout', 'pp_call_to_action_jobs', 'job' );
			switch ($call_to_action) {
			  	case 'job':
			  		get_template_part( 'template-parts/button', 'job' );
			  		break;			  	
			  	case 'resume':
			  		get_template_part( 'template-parts/button', 'resume' );
			  		break;
			  	default:
			  		# code...
			  		break;
		  	}  
		 	?>
		      
		</div>
	</div>
</div>
<?php } 


if($map) { 
	$all_map = Kirki::get_option( 'workscout', 'pp_enable_all_jobs_map', 0 ); 
	if($all_map){ 
		echo do_shortcode('[workscout-map type="job_listing" class="jobs_page"]'); 
	} else { ?>
		<div id="search_map" data-map-scroll="<?php echo Kirki::get_option( 'workscout','pp_maps_scroll_zoom', 1) == 1 ? 'true' : 'false'; ?>" class="jobs_map"></div>
	<?php 
	}
}
?>

<div class="container  wpjm-container <?php echo esc_attr($layout); ?>">
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
			$order = Kirki::get_option( 'workscout', 'pp_jobs_order', 'DESC' ); 
			$orderby = Kirki::get_option( 'workscout', 'pp_jobs_orderby', 'date' ); 
			$per_page = Kirki::get_option( 'workscout', 'pp_jobs_per_page', 10 ); 
		
			echo do_shortcode('[jobs orderby="'.$orderby.'" order="'.$order.'" per_page="'.$per_page.'"  show_filters="false"]'); ?>
			<footer class="entry-footer">
				<?php edit_post_link( esc_html__( 'Edit', 'workscout' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-footer -->
		</div>
	</article>
	

</div>
<?php get_footer(); ?>

<?php } ?>