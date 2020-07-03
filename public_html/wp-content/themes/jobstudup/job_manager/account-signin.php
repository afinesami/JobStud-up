<?php if ( is_user_logged_in() ) : ?>
	<div class="notification notice closeable margin-bottom-40">
		
		<p><span><?php esc_html_e( 'Welcome to', 'workscout' ); echo ' '.get_bloginfo(); ?></span><br>
			<?php
				$user = wp_get_current_user();
				printf( __( 'You are currently signed in as <strong>%s</strong>.', 'workscout' ), $user->user_login );
			?>
		</p>
		<a class="button" href="<?php echo apply_filters( 'submit_job_form_logout_url', wp_logout_url( get_permalink() ) ); ?>"><?php esc_html_e( 'Sign out', 'workscout' ); ?></a>
	</div>
	
<?php else :
	$account_required      = job_manager_user_requires_account();
	$registration_enabled  = job_manager_enable_registration();
	$registration_fields   = wpjm_get_registration_fields();
	?>
	<fieldset>
	<div class="notification notice closeable margin-bottom-40">
		
		<p><span><?php esc_html_e( 'Have an account?', 'workscout' ); ?></span>

			<?php if ( $registration_enabled ) : ?>

				<?php printf( esc_html__( 'If you don&rsquo;t have an account you can %screate one below by entering your email address/username. Your account details will be confirmed via email.', 'workscout' ), $account_required ? '' : esc_html__( 'optionally', 'workscout' ) . ' ' ); ?>

			<?php elseif ( $account_required ) : ?>

				<?php echo apply_filters( 'submit_job_form_login_required_message',  esc_html__('You must sign in to create a new listing.', 'workscout' ) ); ?>

			<?php endif; ?>
		</p> 
		<a class="button" href="<?php echo apply_filters( 'submit_job_form_login_url', wp_login_url( ) ); ?>"><?php esc_html_e( 'Sign in', 'workscout' ); ?></a>
	</div>
	</fieldset>
	<?php
	if ( ! empty( $registration_fields ) ) {
		foreach ( $registration_fields as $key => $field ) {
			?>
			<fieldset class="fieldset-<?php echo esc_attr( $key ); ?>">
				<label
					for="<?php echo esc_attr( $key ); ?>"><?php echo $field[ 'label' ] . apply_filters( 'submit_job_form_required_label', $field[ 'required' ] ? '' : ' <small>' . __( '(optional)', 'wp-job-manager' ) . '</small>', $field ); ?></label>
				<div class="field <?php echo $field[ 'required' ] ? 'required-field' : ''; ?>">
					<?php get_job_manager_template( 'form-fields/' . $field[ 'type' ] . '-field.php', array( 'key'   => $key, 'field' => $field ) ); ?>
				</div>
			</fieldset>
			<?php
		}
		do_action( 'job_manager_register_form' );
	}
	?>

<?php endif;
