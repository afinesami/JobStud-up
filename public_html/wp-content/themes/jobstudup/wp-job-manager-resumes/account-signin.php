<?php if ( is_user_logged_in() ) : ?>

	<div class="notification notice closeable margin-bottom-20">
		
		
			<p><span><?php esc_html_e( 'Welcome to', 'workscout' ); echo ' '.get_bloginfo();?></span><br>
			<?php
				
				$user = wp_get_current_user();
				printf( esc_html__( 'You are currently signed in as %s.', 'workscout' ), $user->user_login );
			?>
			</p>
			<a class="button" href="<?php echo apply_filters( 'submit_resume_form_logout_url', wp_logout_url( get_permalink() ) ); ?>"><?php esc_html_e( 'Sign out', 'workscout' ); ?></a>
	</div>

<?php else :

	$account_required             = resume_manager_user_requires_account();
	$registration_enabled         = resume_manager_enable_registration();
	$registration_fields          = resume_manager_get_registration_fields();
	?>
	<div class="notification notice closeable margin-bottom-40">
		
		
			
			<p><span><?php esc_html_e( 'Have an account?', 'workscout' ); ?></span>
			<?php if ( $registration_enabled ) : ?>

				<?php esc_html_e( 'If you don&rsquo;t have an account you can create one below by entering your email address. A password will be automatically emailed to you.', 'workscout' ); ?>

			<?php elseif ( $account_required ) : ?>

				<?php echo apply_filters( 'submit_resume_form_login_required_message',  esc_html__( 'You must sign in to submit a resume.', 'workscout' ) ); ?>

			<?php endif; ?>
		</p>
		<a class="button" href="<?php echo apply_filters( 'submit_resume_form_login_url', wp_login_url( get_permalink() ) ); ?>"><?php esc_html_e( 'Sign in', 'workscout' ); ?></a>
	</div>
	<?php
	if ( ! empty( $registration_fields ) ) {
		foreach ( $registration_fields as $key => $field ) {
			?>
			<fieldset class="fieldset-<?php echo esc_attr( $key ); ?>">
				<label
					for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field[ 'label' ] ) . wp_kses_post( apply_filters( 'submit_resume_form_required_label', $field[ 'required' ] ? '' : ' <small>' . __( '(optional)', 'wp-job-manager-resumes' ) . '</small>', $field ) ); ?></label>
				<div class="field <?php echo $field[ 'required' ] ? 'required-field' : ''; ?>">
					<?php get_job_manager_template( 'form-fields/' . $field[ 'type' ] . '-field.php', array( 'key'   => $key, 'field' => $field ) ); ?>
				</div>
			</fieldset>
			<?php
		}
		do_action( 'resume_manager_register_form' );
	}
	?>
	

<?php endif; ?>