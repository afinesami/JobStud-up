<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WorkScout
 */

get_header(); ?>

<!-- Titlebar
================================================== -->

<?php 
$header_image = get_post_meta($post->ID, 'pp_job_header_bg', TRUE); 
//if sinlge post doesn't have, check if blog has:
if(empty($header_image)) {
	$header_image = Kirki::get_option( 'workscout', 'pp_blog_header_upload', '' );  
}
if(!empty($header_image)) {
		$transparent_status = get_post_meta($post->ID, 'pp_transparent_header', TRUE); 	
		if($transparent_status == 'on'){ ?>
			<div id="titlebar" class="photo-bg single with-transparent-header" style="background: url('<?php echo esc_url($header_image); ?>')">
		<?php } else { ?>
			<div id="titlebar" class="photo-bg single" style="background: url('<?php echo esc_url($header_image); ?>')">
		<?php } ?>
	<?php } else { ?>
		<div id="titlebar" class="single">
<?php } ?>
		<div class="container">

			<div class="sixteen columns">
		<h3><?php the_title(); ?></h3>
			<p class="company-tagline"><?php echo the_company_metatitle(); ?></p>
			<p class="company-location"><?php the_company_metalocation(); ?></p>
			</div>

		</div>
	</div>


<!-- Content
================================================== -->
<?php $layout = get_post_meta($post->ID, 'pp_sidebar_layout', true); ?>

<div class="container <?php echo esc_attr($layout); ?>">

	<!-- Blog Posts -->
	<div class="eleven columns">
		<div class="padding-right">

<?php
do_action( 'jmcl_before_main_content' );
?>

<?php while ( have_posts() ) : the_post(); ?>


  
			<?php get_template_part( 'template-parts/content', 'single' ); ?>

<?php endwhile; // end of the loop. ?>

<?php
do_action( 'jmcl_after_main_content' );
?>

		</div><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
</div>
</div>
	<!-- Widgets / End -->


</div>

<?php get_footer(); ?>
