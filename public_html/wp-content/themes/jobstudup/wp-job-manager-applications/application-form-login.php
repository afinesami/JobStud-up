<p class="account-sign-in"><?php esc_html_e( 'You need to be signed in to apply for this position.', 'workscout' ); ?> </p>
	<a class="button" href="<?php echo apply_filters( 'job_manager_job_dashboard_login_url', wp_login_url( get_permalink() ) ); ?>"><?php esc_html_e( 'Sign in', 'workscout' ); ?></a>
