<?php 
        // show any error messages after form submission
        workscout_show_error_messages(); ?>
        
        <?php 
        if (defined('PWP_NAME')) { ?>
            <form class="register workscout_form" id="register" action="<?php echo wp_registration_url().'&wpe-login=';echo PWP_NAME; ?>" method="post">
        <?php } else { ?>
            <form class="register workscout_form" id="register" action="<?php echo wp_registration_url(); ?>" method="post">
        <?php } ?>  
        
            <p class="status"></p>
            <fieldset>
                

                <?php   
                $role_status  = get_option('workscout_registration_hide_role');
                
                if(!$role_status) {?>
                    <div class="account-type">
                        <div>
                            <input type="radio" name="user_role" id="freelancer-radio" value="candidate" class="account-type-radio" checked/>
                            <label for="freelancer-radio"><i class="sl sl-icon-user"></i> <?php esc_html_e('Candidate','workscout_core') ?></label>
                        </div>

                        <div>
                            <input type="radio" name="user_role" id="employer-radio" value="employer" class="account-type-radio"/>
                            <label for="employer-radio" ><i class="sl sl-icon-briefcase"></i> <?php esc_html_e('Employer','workscout_core') ?></label>
                        </div>
                    </div>
                    <div class="clearfix"></div>
               
                <?php } ?>


                <?php if(!get_option('workscout_registration_hide_username')) : ?>
                    <p>
                        <label for="workscout_user_login">
                            <i class="ln ln-icon-Male"></i>
                            <input name="username" id="workscout_user_login" placeholder="<?php _e('Username','workscout_core'); ?>" class="required" type="text"/>
                        </label>
                    </p>
                <?php endif; ?>

                <?php if(get_option('workscout_display_password_field')) : ?>
                    <p>
                        <label for="reg_password">
                        <i class="ln ln-icon-Lock-2"></i><input type="password" class="input-text" placeholder="<?php _e( 'Password', 'workscout_core' ); ?>" name="password" id="reg_password" />
                        </label>
                    </p>
                <?php endif; ?>

                <?php if(get_option('workscout_display_first_last_name')) : ?>
                    <p>
                        <label for="first-name">
                            <i class="ln ln-icon-Pen"></i>
                            <input type="text" name="first_name" placeholder="<?php esc_html_e( 'First Name', 'workscout_core' ); ?>" id="first-name">
                        </label>
                    </p>
             
                    <p class="form-row form-row-wide">
                        <label for="last-name">
                            <i class="ln ln-icon-Pen"></i>
                            <input type="text" name="last_name" placeholder="<?php esc_html_e( 'Last Name', 'workscout_core' ); ?>" id="last-name">
                        </label>
                    </p>    
                <?php endif; ?>

                <p>
                    <label for="workscout_user_email">
                        <i class="ln ln-icon-Mail"></i>
                        <input name="email" id="workscout_user_email" class="required" placeholder="<?php _e('Email','workscout_core'); ?>" type="email"/>
                    </label>
                </p>


                
                <?php $recaptcha  = get_option('workscout_recaptcha');
                $recaptcha_version = get_option('workscout_recaptcha_version','v2');
                if($recaptcha && $recaptcha_version == 'v2'){ ?>
                
                <p class="form-row captcha_wrapper">
                    <div class="g-recaptcha" data-sitekey="<?php echo get_option('workscout_recaptcha_sitekey'); ?>"></div>
                </p>
                <?php } 

                if($recaptcha && $recaptcha_version == 'v3'){ ?>
                    <input type="hidden" id="action" name="action" value="login">
                    <input type="hidden" id="token" name="token">
                <?php } ?>

              
                <?php 
                     $privacy_policy_status = get_option('workscout_privacy_policy');

                    if ( $privacy_policy_status && function_exists( 'the_privacy_policy_link' ) ) { ?>
                        <p class="form-row margin-top-10 margin-bottom-10">
                            <label for="privacy_policy"><input type="checkbox" id="privacy_policy" name="privacy_policy"><?php esc_html_e( 'I agree to the', 'workscout_core' ); ?> <a href="<?php echo get_privacy_policy_url(); ?>"><?php esc_html_e( 'Privacy Policy', 'workscout_core' ); ?></a>    </label>
                        
                        </p>
                                
                <?php } ?>
                <p style="display:none">
                    <label for="confirm_email"><?php esc_html_e('Please leave this field empty','workscout_core'); ?></label>
                    <input type="text" name="confirm_email" id="confirm_email" class="input" value="">
                </p>
                <p>
                    <input type="hidden" name="workscout_register_nonce" value="<?php echo wp_create_nonce('workscout-register-nonce'); ?>"/>
                    <input type="hidden" name="workscout_register_check" value="1"/>
                    <?php wp_nonce_field( 'workscout-ajax-login-nonce', 'register_security' ); ?>
                    <input type="submit" value="<?php esc_html_e('Register Your Account','workscout_core'); ?>"/>
                </p>
                <?php if(!get_option('workscout_display_password_field')) : ?>
                
                    <div class="notification password-notice notice closeable" style=" margin-top: 20px; margin-bottom: 0px;">
                        <p><?php esc_html_e('Password will be generated and sent to your email address.','workscout_core') ?></p> 
                    </div>
                
                <?php endif; ?>
                <div class="notification reg-form-output error closeable" style="display: none; margin-top: 20px; margin-bottom: 0px;">
                    <p></p> 
                </div>
            </fieldset>
        </form>

<?php if(function_exists('_wsl_e')) { ?>
<div class="social-login-separator"><span><?php esc_html_e('Sign In with Social Network','workscout_core'); ?></span></div>
<?php do_action( 'wordpress_social_login' ); ?>

<?php } ?>

<?php
if(function_exists('mo_openid_initialize_social_login')) { ?>
    <div class="social-miniorange-container">
        <div class="social-login-separator"><span><?php esc_html_e('Sign In with Social Network','workscout_core'); ?></span></div><?php echo do_shortcode( '[miniorange_social_login  view="horizontal" heading=""]' ); 
        ?>
</div>
<?php } ?>