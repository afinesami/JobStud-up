<?php
/**
 * The template for displaying all pages.
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
get_header($header_type); 
if(get_post_meta($post->ID, 'pp_page_slider_status', true) == 'on'){
	$slider = get_post_meta($post->ID, 'pp_page_layer', true);
	if($slider && function_exists('putRevSlider')) { putRevSlider($slider); }
}
while ( have_posts() ) : the_post(); 

	$job_page = get_option('job_manager_jobs_page_id');
	$resume_page = get_option('resume_manager_resumes_page_id');
	
	if(!empty($job_page) && is_page($job_page)){
		$layout = Kirki::get_option('workscout','jobs_list_layout');
		if($layout == 'split'){
			get_template_part('template-parts/archive-jobs-split');
		} else {
			get_template_part('template-parts/archive-jobs-regular');
		}
		
	} elseif (!empty($resume_page) && is_page($resume_page)) {
		$layout = Kirki::get_option('workscout','resumes_list_layout');
		if($layout == 'split'){
			get_template_part('template-parts/archive-resumes-split');
		} else {
			get_template_part('template-parts/archive-resumes-regular');
		}
	
	}
	else {
		get_template_part( 'template-parts/content', 'page' ); 
	}

endwhile; // End of the loop. 

if( ( !empty($job_page) && is_page($job_page) ) || !empty($resume_page) && is_page($resume_page) ){
		$layout = Kirki::get_option('workscout','jobs_list_layout');
		$resume_layout = Kirki::get_option('workscout','resumes_list_layout');
		if($layout == 'split' || $resume_layout == 'split'){
			get_footer('empty'); 
		} else {
			get_footer(); 			
		}
} else {
	get_footer(); 	
}	

?>
