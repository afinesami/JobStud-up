<?php 
	$minicart_status 	= Kirki::get_option( 'workscout', 'pp_minicart_in_header' );
	$custom_userpage 	= get_option('workscout_dashboard_page');
	$user_page_status 	= Kirki::get_option( 'workscout', 'pp_user_page_status' );
?>

<ul class="float-right">
	
	<?php if($minicart_status) {  
		get_template_part( 'inc/mini_cart'); 
	} 

	if ( is_user_logged_in() ) { 
		if( ! empty( $custom_userpage )) {  
			$userpage_link = get_permalink($custom_userpage );
			$user = wp_get_current_user();
			// if ( in_array( 'candidate', (array) $user->roles ) ) { 
			// 	$candidate_dashboard_page_id = get_option( 'resume_manager_candidate_dashboard_page_id' );
			// 	$userpage_link = get_permalink($candidate_dashboard_page_id);
			// }
			// if ( in_array( 'employer', (array) $user->roles ) ) { 
			// 	$employer_dashboard_page_id = get_option( 'job_manager_job_dashboard_page_id' );
			// 	$userpage_link = get_permalink($employer_dashboard_page_id);
			// } 
			$userpage_link = apply_filters('workscout_user_page_url',$userpage_link);
			if($user_page_status){	?>
			<li>
				<a href="<?php echo esc_url(apply_filters('workscout_userpage', $userpage_link)); ?>"><i class="fa fa-cog"></i> <?php esc_html_e('Dashboard','workscout_core') ?></a>
			</li>
		<?php 
			}
		} ?>
		<li><a href="<?php echo wp_logout_url( home_url() );  ?>"><i class="fa fa-sign-out"></i> <?php esc_html_e('Log Out','workscout_core') ?></a></li>
	</ul>
<?php } else { //user not logged in

	$login_popup = get_option('workscout_popup_login','ajax');

	if($login_popup == 'page') {
		$custom_userpage = get_option('workscout_dashboard_page');

		$login_page_url = !empty($custom_userpage) ?  get_permalink(  $custom_userpage ) : wp_login_url( get_permalink() );

		$register_page_url = !empty($custom_userpage) ?  get_permalink(  $custom_userpage ) : wp_registration_url();
		?>
			<li><a href="<?php echo esc_url($register_page_url); ?>#tab-register"><i class="fa fa-user"></i> <?php esc_html_e('Sign Up','workscout_core') ?></a></li>
			<li><a href="<?php echo esc_url($login_page_url); ?>"><i class="fa fa-lock"></i> <?php esc_html_e('Log In','workscout_core') ?></a></li>
		<?php 
	//login in popup:	
	} else { ?>
			<li><a href="#signup-dialog" class="small-dialog popup-with-zoom-anim"><i class="fa fa-user"></i> <?php esc_html_e('Sign Up','workscout_core') ?></a></li>
			<li><a href="#login-dialog" class="small-dialog popup-with-zoom-anim"><i class="fa fa-lock"></i> <?php esc_html_e('Log In','workscout_core') ?></a></li>
	<?php } ?>
</ul>
</nav>
<?php 
	if($login_popup) { ?>
		<div id="signup-dialog" class="small-dialog workscout-way zoom-anim-dialog mfp-hide apply-popup workscout-signup-popup">
			<div class="small-dialog-headline">
				<h2><?php esc_html_e('Sign Up','workscout-core'); ?></h2>
			</div>
			<div class="small-dialog-content"> 
				<?php echo do_action('workscout_register_form'); ?> 
			</div>
		</div>
		<div id="login-dialog" class="small-dialog workscout-way zoom-anim-dialog mfp-hide apply-popup workscout-login-popup">
			<div class="small-dialog-headline">
				<h2><?php esc_html_e('Login','workscout-core'); ?></h2>
			</div>
			<div class="small-dialog-content">
				<?php echo do_action('workscout_login_form');  ?> 
			</div>
		</div>
		<?php 
	}
} ?>