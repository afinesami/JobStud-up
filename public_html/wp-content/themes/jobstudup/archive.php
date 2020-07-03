<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WorkScout
 */

$header_old = Kirki::get_option('workscout','pp_old_header');
$header_type = (Kirki::get_option('workscout','pp_old_header') == true) ? 'old' : '' ;
$header_type = apply_filters('workscout_header_type',$header_type);
get_header($header_type); ?>



<div id="titlebar" class="single">
	<div class="container">

		<div class="sixteen columns">
			<?php
				the_archive_title( '<h2 class="page-title">', '</h2>' );
				the_archive_description( '<span class="taxonomy-description">', '</span>' );
			?>
		</div>

	</div>
</div>

<?php 

$layout = Kirki::get_option( 'workscout', 'pp_blog_layout' ); ?>
<!-- Content
================================================== -->
<div class="container <?php echo esc_attr($layout); ?>">

	<!-- Blog Posts -->
	<div class="eleven columns">
		<div class="padding-right">
		<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>
				
			<?php
				get_template_part( 'template-parts/content', get_post_format() );
			?>

			<?php endwhile; ?>

			<?php if(function_exists('wp_pagenavi')) { 
				wp_pagenavi(array(
					'next_text' => '<i class="fa fa-chevron-right"></i>',
					'prev_text' => '<i class="fa fa-chevron-left"></i>',
					'use_pagenavi_css' => false,
					));
			} else {
				workscout_posts_navigation(array(
		 			'prev_text'  => ' ',
		            'next_text'  => ' ',
				)); 
			} ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>


		</div>
	</div>
	<!-- Blog Posts / End -->
	<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>

