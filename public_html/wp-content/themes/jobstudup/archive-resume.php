<?php get_header(); 

$layout = Kirki::get_option('workscout','resumes_list_layout');
if($layout == 'split'){ ?>

<!-- Page Content
================================================== -->
<div class="full-page-container with-map">

	<!-- Full Page Content -->
	<div class="full-page-content-container" data-simplebar>
		<div class="full-page-content-inner">
			
			<?php get_template_part('template-parts/resume-split-filters'); ?>	

			<div class="listings-container">
				
			<?php 
				$order = Kirki::get_option( 'workscout', 'pp_resumes_order', 'DESC' ); 
				$orderby = Kirki::get_option( 'workscout', 'pp_resumes_orderby', 'date' ); 
				$per_page = Kirki::get_option( 'workscout', 'pp_resumes_per_page', 10 ); 
				echo do_shortcode('[resumes show_filters="false" orderby="'.$orderby.'" order="'.$order.'" per_page="'.$per_page.'" show_pagination="true"]')?>
				
			</div>

			<?php get_template_part('template-parts/split-footer'); ?>	

		</div>
	</div>
	<!-- Full Page Content / End -->


	<!-- Full Page Map -->
	<div class="full-page-map-container">
		<?php $all_map = Kirki::get_option( 'workscout', 'pp_enable_all_jobs_map', 0 ); 
			if($all_map){ 
				echo do_shortcode('[workscout-map type="resume" class="resumes_page"]'); 
			} else { ?>
				<div id="search_map" data-map-scroll="true" class="resumes_map"></div>
		<?php } ?>
	</div>
	<!-- Full Page Map / End -->

</div>

</div>

<?php
get_footer('empty'); 
} else { ?>


	<!-- Titlebar
	================================================== -->
	<?php 
	$map =  Kirki::get_option( 'workscout', 'pp_enable_resumes_map', 0 ); 
	$header_image = Kirki::get_option( 'workscout', 'pp_resumes_header_upload', '' );  
		
	$layout = Kirki::get_option( 'workscout', 'pp_blog_layout' );
	if(empty($layout)) { $layout = 'right-sidebar'; }

	if(!empty($header_image)) { ?>
		<div id="titlebar" class="photo-bg single <?php if($map) echo " with-map"; ?>" style="background: url('<?php echo esc_url($header_image); ?>')">
	<?php } else { ?>
		<div id="titlebar" class="single <?php if($map) echo " with-map"; ?>">
	<?php } ?>
		
		<div class="container">
			<div class="sixteen columns">
				<div class="ten columns">
					<?php $count_jobs = wp_count_posts( 'resume', 'readable' );	?>
					<span><?php printf( esc_html__( 'We have %s resumes in our database', 'workscout' ), $count_jobs->publish ) ?></span>
					<h2 class="showing_jobs"><?php esc_html_e('Showing all resumes','workscout') ?></h2>
				</div>

				<?php 
				$call_to_action = Kirki::get_option( 'workscout', 'pp_call_to_action_resumes', 'resume' );
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
	<?php	
	if($map) { 
		$all_map = Kirki::get_option( 'workscout', 'pp_enable_all_resumes_map', 0 ); 
		if($all_map){ 
			echo do_shortcode('[workscout-map type="resume" class="resumes_page"]'); 
		} else { ?>
			<div id="search_map" data-map-scroll="<?php echo Kirki::get_option( 'workscout','pp_maps_scroll_zoom', 1) == 1 ? 'true' : 'false'; ?>" class="resumes_map"></div>
		<?php 
		}
	} ?>
	<div class="container wpjm-container <?php echo esc_attr($layout); ?>">
		<?php  get_sidebar('resumes');?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('eleven columns'); ?>>
			<div class="padding-right">
				<?php 
				if ( ! empty( $_GET['search_keywords'] ) ) {
					$keywords = sanitize_text_field( $_GET['search_keywords'] );
				} else {
					$keywords = '';
				}
				?>
				<form class="list-search"  method="GET" action="<?php echo get_permalink(get_option('resume_manager_resumes_page_id')); ?>">
					<div class="search_resumes">
						<button><i class="fa fa-search"></i></button>
						<input type="text" name="search_keywords" id="search_keywords" placeholder="<?php esc_attr_e( 'Search freelancer services (e.g. logo design)', 'workscout' ); ?>" value="<?php echo esc_attr( $keywords ); ?>" />
						<div class="clearfix"></div>
					</div>
				</form>

				<?php 
				$order = Kirki::get_option( 'workscout', 'pp_resumes_order', 'DESC' ); 
				$orderby = Kirki::get_option( 'workscout', 'pp_resumes_orderby', 'date' ); 
				$per_page = Kirki::get_option( 'workscout', 'pp_resumes_per_page', 10 ); 
				echo do_shortcode('[resumes show_filters="false" orderby="'.$orderby.'" order="'.$order.'" per_page="'.$per_page.'" show_pagination="true"]')?>
				<footer class="entry-footer">
					<?php edit_post_link( esc_html__( 'Edit', 'workscout' ), '<span class="edit-link">', '</span>' ); ?>
				</footer><!-- .entry-footer -->
			</div>
		</article>
		

	</div>

	<?php get_footer();  ?>
<?php } ?>