<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WorkScout
 */


$header_old = Kirki::get_option('workscout','pp_old_header');
$header_type = (Kirki::get_option('workscout','pp_old_header') == true) ? 'old' : '' ;
$header_type = apply_filters('workscout_header_type',$header_type);
get_header($header_type); ?>


<?php $header_image = Kirki::get_option( 'workscout', 'pp_blog_header_upload', '' );  
if(!empty($header_image)) { ?>
		<div id="titlebar" class="photo-bg single" style="background: url('<?php echo esc_url($header_image); ?>')">
	<?php } else { ?>
		<div id="titlebar" class="single">
<?php } ?>
		<div class="container">

			<div class="sixteen columns">
				<h1><?php echo Kirki::get_option( 'workscout', 'pp_blog_title' ); ?></h1>
				<span><?php echo Kirki::get_option( 'workscout', 'pp_blog_subtitle' ); ?></span>
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
