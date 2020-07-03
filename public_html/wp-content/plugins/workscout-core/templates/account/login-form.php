
<?php  $loginpage = get_option( 'workscout_dashboard_page' );  ?>

<?php
// show any error messages after form submission
workscout_show_error_messages(); 

/*WPEngine compatibility*/
if (defined('PWP_NAME')) { ?>
    <form method="post" id="workscout_login_form"  class="workscout_form" action="<?php echo wp_login_url().'?wpe-login=';echo PWP_NAME;?>">
<?php } else { ?>
    <form method="post" id="workscout_login_form"  class="workscout_form" action="<?php echo wp_login_url(); ?>">
<?php } ?>

    <p class="status"></p>
    <fieldset>
        <p class="form-row form-row-wide">
            <label for="workscout_user_Login">
                <i class="ln ln-icon-Male"></i>
                <input name="log" id="workscout_user_login" placeholder="<?php _e('Username','workscout_core'); ?>" class="required" type="text"/>
            </label>
        </p>
        <p>
            <label for="workscout_user_pass">
              
                <i class="ln ln-icon-Lock-2"></i>
                <input name="pwd" id="workscout_user_pass" placeholder="<?php _e('Password','workscout_core'); ?>" class="required" type="password"/>
            </label>
        </p>
        <div class="checkboxes margin-top-10">
                <input name="rememberme" type="checkbox" id="remember-me" value="forever" /> 
                <label for="remember-me"><?php esc_html_e( 'Remember Me', 'workscout_core' ); ?></label>
        </div>
        <p>
            <?php wp_nonce_field( 'workscout-ajax-login-nonce', 'login_security' ); ?>
            <input id="workscout_login_submit" type="submit" value="<?php esc_attr_e('Login','workscout_core'); ?>"/>
        </p>
        <p>
            <?php esc_html_e('Don\'t have an account?','workscout_core'); ?> <a class="modal-register-link" href="<?php echo get_permalink($loginpage); ?>?action=register"><?php esc_html_e('Sign up now','workscout_core'); ?></a>!
        </p>
        <p>
            <a href="<?php echo wp_lostpassword_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e('Lost Password?','workscout_core'); ?>"><?php esc_html_e('Lost Password?','workscout_core'); ?></a>
         </p>
         <div class="notification error reg-form-output closeable" style="display: none; margin-top: 20px; margin-bottom: 0px;">
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