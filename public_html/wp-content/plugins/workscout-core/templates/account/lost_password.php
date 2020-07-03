<div class="col-md-8">
	<div class="row">
		<div class="col-md-6 my-account">
		<?php 
		$errors = array();
		if(isset($data)) :
			$errors	 	= (isset($data->errors)) ? $data->errors : '' ;
		endif;
		?>
		<?php if ( count( $errors ) > 0 ) : ?>
			<?php foreach ( $errors as $error ) : ?>
				<p>
					<?php echo $error; ?>
				</p>
			<?php endforeach; ?>
		<?php endif; ?>
		<?php
		/*WPEngine compatibility*/
		if (defined('PWP_NAME')) { ?>
			<form id="lostpasswordform" class="sign-in-form"  action="<?php echo wp_lostpassword_url().'&wpe-login=';echo PWP_NAME;?>" method="post">
		<?php } else { ?>
			<form id="lostpasswordform" class="sign-in-form" action="<?php echo wp_lostpassword_url(); ?>" method="post">
		<?php } ?>
		
			<p class="form-row">
				<label for="user_login">
					<i class="im im-icon-Mail"></i>
					<input type="text" name="user_login" placeholder="<?php _e( 'Email Address:', 'workscout_core' ); ?>" id="user_login">
				</label>
			</p>

			<p class="lostpassword-submit">
				<input type="submit" name="submit" class="lostpassword-button"
				       value="<?php _e( 'Reset Password', 'workscout_core' ); ?>"/>
			</p>
		</form>
	</div>
	</div>
</div>