<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account-dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woothemes.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */
?>
<?php
	printf(
		__( '<h2 class="my-acc-h2">Hello <strong>%1$s</strong></h2>', 'workscout' ) . ' ',
		$current_user->display_name,
		wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) )
	);
?>

<p class="woocommerce-dashboard-welcome">
	<?php
		echo sprintf( esc_attr__( 'From your account dashboard you can view your %1$srecent orders%2$s, manage your %3$sshipping and billing addresses%2$s and %4$sedit your password and account details%2$s.', 'workscout' ), 
			'<a href="' . esc_url( wc_get_endpoint_url( 'orders' ) ) . '">', 
			'</a>', 
			'<a href="' . esc_url( wc_get_endpoint_url( 'edit-address' ) ) . '">', 
			'<a href="' . esc_url( wc_get_endpoint_url( 'edit-account' ) ) . '">' );
	?>
</p>
<p>
	<?php
		$candidate_dashboard_page_id = get_option( 'resume_manager_candidate_dashboard_page_id' );
		$employer_dashboard_page_id = get_option( 'job_manager_job_dashboard_page_id' );
		$user = wp_get_current_user();
		if(class_exists( 'WP_Job_Manager_Applications' )) {
			if ( in_array( 'employer', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) : 
			echo sprintf( 
				esc_attr__( 'To check your Job Listings and Applications visit %1$sEmployer Dashboard%2$s.', 'workscout' ),
				'<a href="' . esc_url( get_permalink($employer_dashboard_page_id)) . '">', 
				'</a>'
				);
			echo '<br/>';
			endif;
			if ( in_array( 'candidate', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) :
			echo sprintf( 
				esc_attr__( 'To check your Resumes and Past Applications visit %1$sCandidate Dashboard%2$s.', 'workscout' ),
				'<a href="' . esc_url( get_permalink($candidate_dashboard_page_id)) . '">', 
				'</a>'
				);
			endif;
		} else {
			if ( in_array( 'employer', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) : 
			echo sprintf( 
				esc_attr__( 'To check your Job Listings visit %1$sEmployer Dashboard%2$s.', 'workscout' ),
				'<a href="' . esc_url( get_permalink($employer_dashboard_page_id)) . '">', 
				'</a>'
				);
			endif;
			if ( in_array( 'candidate', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) :
			echo sprintf( 
				esc_attr__( 'To check your Resumes visit %1$sCandidate Dashboard%2$s.', 'workscout' ),
				'<a href="' . esc_url( get_permalink($candidate_dashboard_page_id)) . '">', 
				'</a>'
				);
			endif;
		
		}
	?>
</p>


<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );
	
	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );
?>
