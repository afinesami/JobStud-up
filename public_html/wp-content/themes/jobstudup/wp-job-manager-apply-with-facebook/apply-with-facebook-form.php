<form method="post" class="apply-with-facebook-details wp-job-manager-application-details" style="display:none;">
	<div id="fb-root"></div>
	<div class="apply-with-facebook-profile">
		<img src="" />
		<h2 class="profile-name"></h2>
		<strong class="profile-bio"></strong>
		<em class="profile-location"></em>
		<dl>
			<dt class="profile-current-positions"><?php esc_html_e( 'Current', 'workscout' ); ?></dt>
			<dd class="profile-current-positions"><ul></ul></dd>

			<dt class="profile-past-positions"><?php esc_html_e( 'Past', 'workscout' ); ?></dt>
			<dd class="profile-past-positions"><ul></ul></dd>

			<dt class="profile-educations"><?php esc_html_e( 'Education', 'workscout' ); ?></dt>
			<dd class="profile-educations"><ul></ul></dd>

			<dt class="profile-email"><?php esc_html_e( 'Email', 'workscout' ); ?></dt>
			<dd class="profile-email"></dd>

			<?php if ( in_array( $cover_letter, array( 'optional', 'required' ) ) ) : ?>
				<dt class="apply-with-facebook-cover-letter"><label for="apply-with-facebook-cover-letter"><?php esc_html_e( 'Cover letter', 'workscout' ); ?> <?php if ( 'optional' === $cover_letter ) esc_html_e( '(optional)', 'workscout' ); ?></label></dt>
				<dd class="apply-with-facebook-cover-letter">
					<textarea name="apply-with-facebook-cover-letter" id="apply-with-facebook-cover-letter" <?php if ( 'required' === $cover_letter ) echo 'required="required"'; ?>><?php echo _x( 'To whom it may concern,', 'default cover letter', 'workscout' ); ?>


<?php printf( _x( 'I am very interested in the %s position at %s. I believe my skills and work experience make me an ideal candidate for this role. I look forward to speaking with you soon about this position. Thank you for your consideration.', 'default cover letter', 'workscout' ), $job_title, $company_name ); ?>


<?php echo _x( 'Best regards,', 'default cover letter', 'workscout' ); ?> </textarea>
				</dd>

			<?php endif; ?>
		</dl>
		<p class="apply-with-facebook-submit">
			<input type="submit" name="apply-with-facebook-submit" value="<?php esc_attr_e( 'Submit Application', 'workscout' ); ?>" /> <?php printf( esc_html__( 'Clicking submit will submit your full profile to %s.', 'workscout' ), '<strong>' . esc_html( $company_name ) . '</strong>' ); ?>
			<input type="hidden" name="apply-with-facebook-profile-data" id="apply-with-facebook-profile-data" />
			<input type="hidden" name="apply-with-facebook-profile-picture" id="apply-with-facebook-profile-picture" />
			<input type="hidden" name="apply-with-facebook-job-id" value="<?php echo esc_attr( $job_id ); ?>" />
		</p>
	</div>
</form>