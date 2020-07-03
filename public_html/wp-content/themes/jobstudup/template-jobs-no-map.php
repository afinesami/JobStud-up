<?php
/**
 * Template Name: Page with Jobs Filters No Map
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WorkScout
 */

$header_old = Kirki::get_option('workscout','pp_old_header');
$header_type = (Kirki::get_option('workscout','pp_old_header') == true) ? 'old' : '' ;
$header_type = apply_filters('workscout_header_type',$header_type);
get_header($header_type); ?><!-- Titlebar
================================================== -->
<?php 
$map 			= false; 
$titlebar 		= get_post_meta( $post->ID, 'pp_page_titlebar', true ); 
$header_image 	= Kirki::get_option( 'workscout', 'pp_jobs_header_upload', '' ); 

if($titlebar == 'off') {
	// no titlebar
} else { 
	if(!empty($header_image)) { ?>
		<div id="titlebar" class="photo-bg single <?php if($map) echo " with-map"; ?>" style="background: url('<?php echo esc_url($header_image); ?>')">
	<?php } else { ?>
		<div id="titlebar" class="single <?php if($map) echo " with-map"; ?>">
	<?php } ?>
		<div class="container">
			<div class="sixteen columns">
					<h1><?php the_title(); ?></h1>
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
}
	$layout  = get_post_meta($post->ID, 'pp_sidebar_layout', true);
	if(empty($layout)) { $layout = 'right-sidebar'; }

	wp_dequeue_script('wp-job-manager-ajax-filters' );
	wp_enqueue_script( 'workscout-wp-job-manager-ajax-filters' );
?>

<div class="container  wpjm-container <?php echo esc_attr($layout); ?>">
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
		<?php
		while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>

			<footer class="entry-footer">
				<?php edit_post_link( esc_html__( 'Edit', 'workscout' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-footer -->
		<?php endwhile; ?>

		</div>
	</article>

</div>
<?php
get_footer(); 
?>
