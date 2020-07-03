<?php
/**
 * The template for displaying company content in the single-company.php template
 *
 * This template can be overridden by copying it to yourtheme/buddypress_job_manager/content-single-job_company.php.
 *
 * HOWEVER, on occasion BuddyPress Job Manager will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @author 		Kishore
 * @package 	BuddyPress Job Manager/Templates
 * @version     1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}

do_action( 'jmcl_before_single_company' );
?>

<div class="single_company_listing">

	<?php
	do_action( 'jmcl_before_single_company_summary' );
	?>

	<div class="jmcl-item-header">
		<div class="jmcl-item-header-logo"><?php the_post_thumbnail(); ?></div>

		<div class="jmcl-item-header-content">
			
		</div>
	</div>

	<div class="summary entry-summary cmp-entry-summary">

		<?php
		$tabs = apply_filters( 'jmcl_company_tabs', array() );

		if ( ! empty( $tabs ) ) : ?>

			<div class="company-listings-tabs jmcl-tabs-wrapper">
				<ul class="tabs jmcl-tabs" role="tablist">
					<?php foreach ( $tabs as $key => $tab ) : ?>
						<li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
							<a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'company_listings_company_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
				<?php foreach ( $tabs as $key => $tab ) : ?>
					<div class="company-listings-Tabs-panel company-listings-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
						<?php call_user_func( $tab['callback'], $key, $tab ); ?>
					</div>
				<?php endforeach; ?>
			</div>

		<?php endif; ?>

		<?php
		do_action( 'jmcl_single_company_summary' );
		?>

	</div><!-- .summary -->

	<?php
	do_action( 'jmcl_after_single_company_summary' );
	?>

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'jmcl_after_single_company' ); ?>
