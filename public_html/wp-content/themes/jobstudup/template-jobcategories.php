<?php
/**
 * Template Name: Job Categories Page Template
 *
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage resumes
 * @since resumes 1.0
 */

$header_old = Kirki::get_option('workscout','pp_old_header');
$header_type = (Kirki::get_option('workscout','pp_old_header') == true) ? 'old' : '' ;
$header_type = apply_filters('workscout_header_type',$header_type);
get_header($header_type); 

while ( have_posts() ) : the_post(); ?>
<?php $header_image = get_post_meta($post->ID, 'pp_job_header_bg', TRUE); 
if(!empty($header_image)) { 		$transparent_status = get_post_meta($post->ID, 'pp_transparent_header', TRUE); 	
if($transparent_status == 'on'){ ?>
	<div id="titlebar" class="photo-bg single with-transparent-header" style="background: url('<?php echo esc_url($header_image); ?>')">
<?php } else { ?>
	<div id="titlebar" class="photo-bg" style="background: url('<?php echo esc_url($header_image); ?>')">
<?php } ?>
<?php } else { ?>
<div id="titlebar" class="single">
<?php } ?>

	<div class="container">
		<div class="sixteen columns">
			<div class="ten columns">
				<h1><?php the_title();?></h1>
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
<!-- 960 Container -->
<div class="container page-container home-page-container">
    <article  <?php post_class("sixteen columns"); ?>>
        <?php the_content(); ?>
    </article>
</div>

<div  style="margin-bottom:-45px;"></div>
<?php endwhile; // end of the loop.

get_footer(); ?>