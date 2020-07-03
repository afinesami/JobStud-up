<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WorkScout
 */

$header_old = Kirki::get_option('workscout','pp_old_header');
$header_type = (Kirki::get_option('workscout','pp_old_header') == true) ? 'old' : '' ;
$header_type = apply_filters('workscout_header_type',$header_type);
get_header($header_type); ?>

	<!-- Titlebar
	================================================== -->
	<div id="titlebar" class="single submit-page">
		<div class="container">

			<div class="sixteen columns">
				<h1><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'workscout' ); ?></h1>
			</div>

		</div>
	</div>

	<div class="container full-width">
		<article id="post-404">
			<section id="not-found" class="center margin-top-50 margin-bottom-25">
				<h2>404 <i class="icon-line-awesome-question-circle"></i></h2>
				<p>We're sorry, but the page you were looking for doesn't exist</p>
			</section>

			
		</article>
	</div>
<?php get_footer(); ?>