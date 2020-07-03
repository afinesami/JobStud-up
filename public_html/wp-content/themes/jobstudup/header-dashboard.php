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
<?php 
$layout = Kirki::get_option( 'workscout','pp_body_style','fullwidth' ); 
$sticky = Kirki::get_option( 'workscout','pp_sticky_header','fullwidth' ); 
$fullwidth = Kirki::get_option( 'workscout','pp_fullwidth_header',false ); 

?>
<body <?php body_class($layout); ?>>
<?php  


if(is_singular()){
	$transparent_header = get_post_meta($post->ID, 'pp_transparent_header',true); 
	$header_image = get_post_meta($post->ID, 'pp_job_header_bg', TRUE); 

	  $header_image = get_post_meta($post->ID, 'pp_job_header_bg', TRUE); 
	  if(empty($header_image)) {
	  	$transparent_header = false;
	  }
} else {
	$transparent_header = false;
}

?>
<div id="wrapper" class="fullwidth new-header">

<header id="header-container" class="fullwidth sticky_new dashboard-header" >
	<!-- Header -->
	<div id="header">
		<div class="container">
			
			<!-- Left Side Content -->
			<div class="left-side">
				<div id="logo_nh">
				<?php
	                
	                $logo = Kirki::get_option( 'workscout', 'pp_logo_upload', '' ); 
	                $logo_retina = Kirki::get_option( 'workscout', 'pp_retina_logo_upload', '' ); 
	       //          if( is_singular() ) {
	                	
	       //          	$header_image = get_post_meta($post->ID, 'pp_job_header_bg', TRUE); 
	                	
	       //          	if( !empty($header_image) ) {
	       //          		$transparent_status = get_post_meta($post->ID, 'pp_transparent_header', TRUE); 	

	       //          		if($transparent_status == 'on'){

	       //          			$logo_transparent = Kirki::get_option( 'workscout','pp_transparent_logo_upload');
	       //          			$logo_retina = Kirki::get_option( 'workscout', 'pp_transparent_retina_logo_upload', '' ); 
								// $logo =(!empty($logo_transparent)) ? $logo_transparent : $logo ;	
	                	
	       //          		}
	       //          	}
	       //          }
	 

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
				<!-- eof logo -->

				<!-- menu -->
	
				<nav id="navigation" class="menu">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'responsive','container' => false ) ); ?>
				</nav>
				<div class="clearfix"></div>
				<!-- Main Navigation / End -->
				
			</div>
			<!-- Left Side Content / End -->

			<!-- Right Side Content / End -->
			<div class="right-side">

				<!-- Header Widget -->
				<div class="header-widget">
					<?php 
					$my_account_display = get_option('workscout_my_account_display', true );
					if(is_user_logged_in()){
						if(class_exists('WorkScout_Core_Template_Loader')):
							$template_loader = new WorkScout_Core_Template_Loader;		
							$template_loader->get_template_part( 'account/logged_section' ); 
						endif;	
					} else { 

					$popup_login = get_option( 'workscout_popup_login' ); 
					
					?>
					<div class="login-register-buttons">
					<?php
					if(function_exists('WorkScout_Core')):

						if( $popup_login == 'ajax' && !is_page_template('template-dashboard.php') ) { ?>
							
							<a href="#login-dialog" class="small-dialog popup-with-zoom-anim login-btn"><i class="la la-sign-in-alt"></i> <?php esc_html_e('Log In', 'workscout_core', 'workscout'); ?></a>
							<a href="#signup-dialog" class="small-dialog popup-with-zoom-anim register-btn"><i class="la la-plus-circle"></i> <?php esc_html_e('Register', 'workscout_core', 'workscout'); ?></a>
						
						<?php } else {
							$login_page = get_option('workscout_profile_page'); ?>
							<a href="<?php echo esc_url(get_permalink($login_page)); ?>" class="login-btn"><i class="la la-sign-in-alt"></i> <?php esc_html_e('Log In','workscout'); ?></a>
							<a href="<?php echo esc_url(get_permalink($login_page)); ?>#tab2" class="register-btn"><i class="la la-plus-circle"></i> <?php esc_html_e('Register','workscout'); ?></a>
						<?php } 

					endif; ?>
					</div>				
	
					<?php } ?>
					
				</div>
				<!-- Header Widget / End -->

				<!-- Mobile Navigation Button -->
				<span class="mmenu-trigger">
					<button class="hamburger hamburger--collapse" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</span>

			</div>
			<!-- Right Side Content / End -->

		</div>
	</div>
	<!-- Header / End -->

</header>
<div class="clearfix"></div>
<!-- Header Container / End -->

<?php 
if( true == $my_account_display && !is_page_template( 'template-dashboard.php' ) ) : ?>
	<!-- Sign In Popup -->
	<div id="login-dialog" class="small-dialog apply-popup zoom-anim-dialog mfp-hide workscout-signup-popup">

		<div class="small-dialog-headline">
			<h2><?php esc_html_e('Log In','workscout'); ?></h2>
		</div>
		<!--Tabs -->
		<div class="small-dialog-content"> 
			<?php do_action('workscout_login_form'); ?>
		</div>
	</div>


	<div id="signup-dialog" class="small-dialog apply-popup zoom-anim-dialog mfp-hide  workscout-signup-popup">

		<div class="small-dialog-headline">
			<h2><?php esc_html_e('Sign Up','workscout'); ?></h2>
		</div>
		<!--Tabs -->

		<div class="small-dialog-content"> 
			<?php do_action('workscout_registration_form'); ?>
		</div>
	</div>
	<!-- Sign In Popup / End -->
<?php endif; ?>
<div class="clearfix"></div>
<!-- Header Container / End -->