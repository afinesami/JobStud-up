<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WorkScout
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>
<?php $layout = Kirki::get_option( 'workscout','pp_body_style','fullwidth' ); ?>
<body <?php body_class($layout); ?>>

<div class="old-header" id="wrapper">

<header <?php workscout_header_class(); ?> id="main-header">
<div class="container">
	<div class="sixteen columns">
	
		<!-- Logo -->
		<div id="logo">
			 <?php
                
                $logo = Kirki::get_option( 'workscout', 'pp_logo_upload', '' ); 
                $logo_retina = Kirki::get_option( 'workscout', 'pp_retina_logo_upload', '' ); 
                if( is_singular() ) {
                	$header_image = get_post_meta($post->ID, 'pp_job_header_bg', TRUE); 
                	if( !empty($header_image) ) {
                		$transparent_status = get_post_meta($post->ID, 'pp_transparent_header', TRUE); 	

                		if($transparent_status == 'on'){
                			$logo_transparent = Kirki::get_option( 'workscout','pp_transparent_logo_upload');

							$logo =(!empty($logo_transparent)) ? $logo_transparent : $logo ;	
                		}
                	}
                }
                if( is_page_template( 'template-jobs.php' ) ) {

					if(Kirki::get_option( 'workscout','pp_jobs_transparent_header')) {
						$logo_transparent = Kirki::get_option( 'workscout','pp_transparent_logo_upload');
						$logo =(!empty($logo_transparent)) ? $logo_transparent : $logo ;
					}
				}     
				if( is_page_template( 'template-home.php' ) ) {

					if(Kirki::get_option( 'workscout','pp_transparent_header')) {
						$logo_transparent = Kirki::get_option( 'workscout','pp_transparent_logo_upload');
						$logo =(!empty($logo_transparent)) ? $logo_transparent : $logo ;
					}
				}        
				if( is_page_template( 'template-home-resumes.php' ) ) {

					if(Kirki::get_option( 'workscout','pp_resume_home_transparent_header')) {
						$logo_transparent = Kirki::get_option( 'workscout','pp_transparent_logo_upload');
						$logo =(!empty($logo_transparent)) ? $logo_transparent : $logo ;
					}
				}


                if($logo) {
                    if(is_front_page()){ ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><img src="<?php echo esc_url($logo); ?>" data-rjs="<?php echo esc_url($logo_retina); ?>" alt="<?php esc_attr(bloginfo('name')); ?>"/></a>
                    <?php } else { ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url($logo); ?>" data-rjs="<?php echo esc_url($logo_retina); ?>" alt="<?php esc_attr(bloginfo('name')); ?>"/></a>
                    <?php }
                } else {
                    if(is_front_page()) { ?>
                    <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    <?php } else { ?>
                    <h2><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
                    <?php }
                }
                ?>
                <?php if(get_theme_mod('workscout_tagline_switch','hide') == 'show') { ?><div id="blogdesc"><?php bloginfo( 'description' ); ?></div><?php } ?>
		</div>
		<!-- Mobile Navigation -->
		<div class="mmenu-trigger">
			<button class="hamburger hamburger--collapse" type="button">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</button>
		</div>

		<!-- Menu -->
	
		<nav id="navigation" class="menu">

			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'responsive','container' => false ) ); 
			
			$minicart_status = Kirki::get_option( 'workscout', 'pp_minicart_in_header', false );

			if(Kirki::get_option( 'workscout', 'pp_login_form_status', true ) ) { 
										
				if(class_exists('WorkScout_Core_Template_Loader')):
					$template_loader = new WorkScout_Core_Template_Loader;		
					$template_loader->get_template_part( 'account/login-section' ); 
				endif;

			} ?>
	</div>
</div>
</header>
<div class="clearfix"></div>

<?php 
$my_account_display = get_option('workscout_my_account_display', true );
if( true == $my_account_display && !is_page_template( 'template-dashboard.php' ) ) : ?>
	<!-- Sign In Popup -->
	<div id="sign-in-dialog" class="zoom-anim-dialog mfp-hide">

		<div class="small-dialog-header">
			<h3><?php esc_html_e('Sign In','workscout'); ?></h3>
		</div>
		<!--Tabs -->
		<div class="sign-in-form style-1"> 
			<?php do_action('listeo_login_form'); ?>
		</div>
	</div>
	<!-- Sign In Popup / End -->
<?php endif; ?>
<div class="clearfix"></div>