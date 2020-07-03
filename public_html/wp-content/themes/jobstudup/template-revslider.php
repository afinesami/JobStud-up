<?php
/**
 * Template Name: Page Template with Revolution Slider
 *
 * A custom page template with Revolution Slider
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage trizzy
 * @since trizzy 1.0
 */

$header_old = Kirki::get_option('workscout','pp_old_header');
$header_type = (Kirki::get_option('workscout','pp_old_header') == true) ? 'old' : '' ;
$header_type = apply_filters('workscout_header_type',$header_type);
get_header($header_type);


$slider = get_post_meta($post->ID, 'pp_page_layer', true);
if($slider && function_exists('putRevSlider')) { putRevSlider($slider); }

while ( have_posts() ) : the_post(); 
	
get_template_part( 'template-parts/content', 'page' ); 

 endwhile; // end of the loop.

get_footer(); ?>