<?php
/* Get user info. */
global $wp_roles;
$current_user = wp_get_current_user();

$template_loader = new Workscout_Core_Template_Loader; 

if ( isset($_GET['updated']) && $_GET['updated'] == 'true' ) : ?> 
	<div class="notification success closeable margin-bottom-35"><p><?php esc_html_e('Your profile has been updated.', 'workscout_core'); ?></p><a class="close" href="#"></a></div> 
<?php endif; ?>
     

<?php if ( !is_user_logged_in() ) : ?>
    <p class="warning">
        <?php esc_html_e('You must be logged in to edit your profile.', 'workscout_core'); ?>
    </p><!-- .warning -->
<?php else : ?>

<div class="row">

		<!-- Profile -->
		<div class="col-lg-6 col-md-12">
			<div class="dashboard-list-box margin-top-0">
				<h4 class="gray"><?php esc_html_e('Profile Details','workscout_core') ?></h4>
				<form method="post" enctype='multipart/form-data' id="edit_user" action="<?php the_permalink(); ?>">
				<div class="dashboard-list-box-static">
					
				<?php
					$custom_avatar = $current_user->workscout_core_avatar_id;
					$custom_avatar = wp_get_attachment_url($custom_avatar); 				
					?>

					<!-- Details -->
					<div class="my-profile">
						
						<label for="workscout_core_avatar_id"><?php esc_html_e('Avatar','workscout_core') ?></label>
					   <div class="avatar-wrapper workscout-avatar-form" data-tippy-placement="bottom" title="<?php esc_html_e('Change Avatar','workscout_core') ?>">
					   		
					   		<?php if($custom_avatar){ ?>
                            	<img class="profile-pic" src="<?php echo esc_attr($custom_avatar); ?>" alt="" />
                            <?php } else { ?>
								<img class="profile-pic" src="<?php echo get_stylesheet_directory_uri(); ?>/images/avatar.jpg" alt="" />
                            <?php } ?>
                            <div class="upload-button"></div>
                            <input class="file-upload"  name="workscout_core_avatar_id" id="workscout_core_avatar_id"  type="file" accept="image/*"/>
                        </div>	
					
						<div class="clearfix"></div>

							
						  	<label for="first-name"><?php esc_html_e('First Name', 'workscout_core'); ?></label>
			                <input class="text-input" name="first-name" type="text" id="first-name" value="<?php  echo $current_user->user_firstname; ?>" />
						  	
						  	<label for="last-name"><?php esc_html_e('Last Name', 'workscout_core'); ?></label>
			                <input class="text-input" name="last-name" type="text" id="last-name" value="<?php echo $current_user->user_lastname; ?>" />

							<label for="phone"><?php esc_html_e('Phone', 'workscout_core'); ?></label>
							<input class="text-input" name="phone" type="text" id="phone" value="<?php echo $current_user->phone; ?>" type="text">
							
							<?php  if ( isset($_GET['user_err_pass']) && !empty($_GET['user_err_pass'])  ) : ?> 
							<div class="notification error closeable margin-top-35"><p>
								<?php
								switch ($_GET['user_err_pass']) {
								 	case 'error_1':
								 		echo esc_html_e('The Email you entered is not valid or empty. Please try again.','workscout_core');
								 		break;
								 	case 'error_2':
								 		echo esc_html_e('This email is already used by another user, please try a different one.','workscout_core');
								 		break;					 	
								 	
								 	
								 	default:
								 		# code...
								 		break;
								 }  ?>
									
								</p><a class="close" href="#"></a>
							</div> 
							<?php endif; ?>
							<label for="email"><?php esc_html_e('E-mail', 'workscout_core'); ?></label>
			                <input class="text-input" name="email" type="text" id="email" value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>" />
			                 
							<label for="description"><?php esc_html_e('About me', 'workscout_core'); ?></label>
			               	<?php 
								$user_desc = get_the_author_meta( 'description' , $current_user->ID);
								$user_desc_stripped = strip_tags($user_desc, '<p>'); //replace <p> and <a> with whatever tags you want to keep after the strip
							?>
			                <textarea name="description" id="description" cols="30" rows="10"><?php echo $user_desc_stripped; ?></textarea>
							<div id="my-profile_socials">
								
							
							<label><i class="fa fa-twitter"></i> <?php esc_html_e( 'Twitter', 'workscout_core' ); ?></label>
							<input class="text-input" name="twitter" type="text" id="twitter" value="<?php  echo $current_user->twitter; ?>" />

							<label><i class="fa fa-facebook-square"></i> <?php esc_html_e( 'Facebook', 'workscout_core' ); ?></label>
							<input class="text-input" name="facebook" type="text" id="facebook" value="<?php  echo $current_user->facebook; ?>" />


							<label><i class="fa fa-linkedin"></i> <?php esc_html_e( 'Linkedin', 'workscout_core' ); ?></label>
							<input class="text-input" name="linkedin" type="text" id="linkedin" value="<?php  echo $current_user->linkedin; ?>" />


							<label><i class="fa fa-instagram"></i> <?php esc_html_e( 'Instagram', 'workscout_core' ); ?></label>
							<input class="text-input" name="instagram" type="text" id="instagram" value="<?php  echo $current_user->instagram; ?>" />

							<label><i class="fa fa-youtube"></i> <?php esc_html_e( 'YouTube', 'workscout_core' ); ?></label>
							<input class="text-input" name="youtube" type="text" id="youtube" value="<?php  echo $current_user->youtube; ?>" />

							<label><i class="fa fa-whatsapp"></i> <?php esc_html_e( 'WhatsApp', 'workscout_core' ); ?></label>
							<input class="text-input" name="whatsapp" type="text" id="whatsapp" value="<?php  echo $current_user->whatsapp; ?>" />

							<label><i class="fa fa-skype"></i> <?php esc_html_e( 'Skype', 'workscout_core' ); ?></label>
							<input class="text-input" name="skype" type="text" id="skype" value="<?php  echo $current_user->skype; ?>" />

							</div>


							<input type="hidden" name="my-account-submission" value="1" />
							<button type="submit" form="edit_user" value="<?php esc_html_e( 'Submit', 'workscout_core' ); ?>" class="button margin-top-20 margin-bottom-20"><?php esc_html_e('Save Changes', 'workscout_core'); ?></button>
					
						<?php endif; ?>
					

					
				</div>
	
						
					</div>
				</div>
			</div>
		</form>
		<!-- Change Password -->
			<div class="col-lg-6 col-md-12">
				<div class="dashboard-list-box margin-top-0">
					<h4 class="gray"><?php esc_html_e('Change Password','workscout_core') ?></h4>
					<div class="dashboard-list-box-static">

						<!-- Change Password -->
						<div class="my-profile">
							<div class="row">
								<div class="col-md-12">
									<div class="notification notice margin-top-0 margin-bottom-0">
										<p><?php esc_html_e('Your password should be at least 12 random characters long to be safe','workscout_core') ?></p>
									</div>
								</div>
							</div>
							<?php if ( isset($_GET['updated_pass']) && $_GET['updated_pass'] == 'true' ) : ?> 
								<div class="notification success closeable margin-bottom-35"><p><?php esc_html_e('Your password has been updated.', 'workscout_core'); ?></p><a class="close" href="#"></a></div> 
							<?php endif; ?>

							<?php  if ( isset($_GET['err_pass']) && !empty($_GET['err_pass'])  ) : ?> 
							<div class="notification error closeable margin-bottom-35"><p>
								<?php
								switch ($_GET['err_pass']) {
								 	case 'error_1':
								 		echo esc_html_e('Your current password does not match. Please retry.','workscout_core');
								 		break;
								 	case 'error_2':
								 		echo esc_html_e('The passwords do not match. Please retry..','workscout_core');
								 		break;					 	
								 	case 'error_3':
								 		echo esc_html_e('A bit short as a password, don\'t you think?','workscout_core');
								 		break;					 	
								 	case 'error_4':
								 		echo esc_html_e('Password may not contain the character "\\" (backslash).','workscout_core');
								 		break;
								 	case 'error_5':
								 		echo esc_html_e('An error occurred while updating your profile. Please retry.','workscout_core');
								 		break;
								 	
								 	default:
								 		# code...
								 		break;
								 }  ?>
									
								</p><a class="close" href="#"></a>
							</div> 
							<?php endif; ?>
							<form name="resetpasswordform" action="" method="post">
								<label><?php esc_html_e('Current Password','workscout_core'); ?></label>
								<input type="password" name="current_pass">

								<label for="pass1"><?php esc_html_e('New Password','workscout_core'); ?></label>
								<input name="pass1" type="password">

								<label for="pass2"><?php esc_html_e('Confirm New Password','workscout_core'); ?></label>
								<input name="pass2" type="password">

								<input type="submit" name="wp-submit" id="wp-submit" class="margin-top-20 button" value="<?php esc_html_e('Save Changes','workscout_core'); ?>" />
								
								<input type="hidden" name="workscout_core-password-change" value="1" />
							</form>
							

						</div>
						
					</div>
				</div>
			</div>
			<?php if ( class_exists( 'plugin_delete_me' ) ) : ?>
				<div class="col-lg-6 col-md-12 delete-account-section margin-top-40">
					<div class="dashboard-list-box margin-top-0">
						<h4 class="gray"><?php esc_html_e('Delete Your Account','workscout_core') ?></h4>
						<div class="dashboard-list-box-static">
							<?php echo do_shortcode( '[plugin_delete_me /]' ); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

		</div>

		