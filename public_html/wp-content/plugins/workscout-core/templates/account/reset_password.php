<div class="col-md-8">
	<div class="row">
		<div class="col-md-6 my-account">
		<?php 
			$errors = array();
			if(isset($data)) :
				$errors	 	= (isset($data->errors)) ? $data->errors : '' ;
				$attributes	 	= (isset($data->attributes)) ? $data->attributes : '' ;
			endif;
		?>
			
			<form name="resetpassform" id="resetpassform" action="<?php echo site_url( 'wp-login.php?action=resetpass' ); ?>" method="post" autocomplete="off">
				<input type="hidden" id="user_login" name="rp_login" value="<?php echo esc_attr( $attributes['login'] ); ?>" autocomplete="off" />
				<input type="hidden" name="rp_key" value="<?php echo esc_attr( $attributes['key'] ); ?>" />

				<?php if ( count( $attributes['errors'] ) > 0 ) : ?>
					<?php foreach ( $attributes['errors'] as $error ) : ?>
						<p>
							<?php echo $error; ?>
						</p>
					<?php endforeach; ?>
				<?php endif; ?>

				<p>
					<label for="pass1"><?php _e( 'New password', 'workscout_core' ) ?></label>
					<input type="password" name="pass1" id="pass1" class="input" size="20" value="" autocomplete="off" />
				</p>
				<p>
					<label for="pass2"><?php _e( 'Repeat new password', 'workscout_core' ) ?></label>
					<input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off" />
				</p>

				<p class="description"><?php echo wp_get_password_hint(); ?></p>

				<p class="resetpass-submit">
					<input type="submit" name="submit" id="resetpass-button"
					       class="button" value="<?php _e( 'Reset Password', 'workscout_core' ); ?>" />
				</p>
			</form>
		</div>
	</div>
</div>