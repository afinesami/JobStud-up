<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$action = !empty( $_POST['register'] ) && $_POST['register'] == 'Register'  ? 'register' : 'login';

?>


<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<div id="login-register-password" class="columns six my-account woo-login-form">
	<?php do_action('workscout-before-login'); ?>

<?php wc_print_notices(); ?>
		<ul class="tabs-nav-o" id="login-tabs">
			<li class="<?php if ($action == 'login') echo 'active'; ?>"><a href="#tab-login"><?php esc_html_e('Login','workscout'); ?></a></li>
		
<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
			<li class="<?php if ($action == 'register') echo 'active'; ?>"><a href="#tab-register"><?php esc_html_e('Register','workscout'); ?></a></li>
<?php endif; ?>
		</ul>

		<div id="tab-login" class="tab-content"  style="<?php if ( $action != 'login' ) echo 'display:none' ?>">
			<form method="post" class="login workscout_form">

				<?php do_action( 'woocommerce_login_form_start' ); ?>

				<p class="form-row form-row-wide">
					<label for="username"><?php _e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span>
					<i class="ln ln-icon-Male"></i><input type="text" class="input-text" name="username" id="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( $_POST['username'] ) : ''; ?>" />
					</label>
				</p>
				<p class="form-row form-row-wide">
					<label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span>
					<i class="ln ln-icon-Lock-2"></i><input class="input-text" type="password" name="password" id="password" />
					</label>
				</p>

				<?php do_action( 'woocommerce_login_form' ); ?>

				<p class="form-row">
					<?php wp_nonce_field( 'woocommerce-login' ); ?>
					<input type="submit" class="button" name="login" value="<?php esc_attr_e( 'Login', 'workscout' ); ?>" />
					<label for="rememberme" class="inline">
						<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'workscout' ); ?>
					</label>
				</p>
				<p class="lost_password">
					<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'workscout' ); ?></a>
				</p>
				<input type="hidden" name="redirect_to" value="<?php echo get_permalink(get_option( 'job_manager_job_dashboard_page_id')); ?>" />

				<?php do_action( 'woocommerce_login_form_end' ); ?>

			</form>
		</div>

	<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
		<div id="tab-register" class="tab-content" style="<?php if ( $action != 'register' ) echo 'display:none' ?>">
			<form method="post" class="register workscout_form">

				<?php do_action( 'woocommerce_register_form_start' ); ?>

				<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

					<p class="form-row form-row-wide">
						<label for="reg_username"><?php _e( 'Username', 'workscout' ); ?> <span class="required">*</span>
						 <i class="ln ln-icon-Male"></i><input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" /></label>
					</p>

				<?php endif; ?>

				<p class="form-row form-row-wide">
					<label for="reg_email"><?php _e( 'Email address', 'workscout' ); ?> <span class="required">*</span>
					<i class="ln ln-icon-Mail"></i><input type="email" class="input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
					</label>
				</p>

				<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

					<p class="form-row form-row-wide">
						<label for="reg_password"><?php _e( 'Password', 'workscout' ); ?> <span class="required">*</span>
						<i class="ln ln-icon-Lock-2"></i>					
						<input type="password" class="input-text" name="password" id="reg_password" />
						</label>
					</p>

				<?php endif; 
				$recaptcha  = Kirki::get_option( 'workscout','pp_woo_recaptcha', false);
				if($recaptcha){ ?>
				
				<p class="form-row captcha_wrapper">
                    <div class="g-recaptcha" data-sitekey="<?php echo get_option('job_manager_recaptcha_site_key'); ?>"></div>
                </p>
                <?php } ?>
				<!-- Spam Trap -->
				<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'workscout' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

				<?php do_action( 'woocommerce_register_form' ); ?>
				<?php do_action( 'register_form' ); ?>

				<p class="form-row">
					<?php wp_nonce_field( 'woocommerce-register' ); ?>
					<input type="submit" class="button" name="register" value="<?php esc_attr_e( 'Register', 'workscout' ); ?>" />
				</p>

				<?php do_action( 'woocommerce_register_form_end' ); ?>

			</form>
		</div>
	<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
