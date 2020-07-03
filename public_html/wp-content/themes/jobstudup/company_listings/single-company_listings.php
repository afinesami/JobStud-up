<?php
/**
 * The Template for displaying all single company
 *
 * This template can be overridden by copying it to yourtheme/company_listings/single-company.php.
 *
 * HOWEVER, on occasion Buddypress Job Manager will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @author 		Kishore
 * @package 	Company Listings/Templates
 * @version     1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$header_old = Kirki::get_option('workscout','pp_old_header');
$header_type = (Kirki::get_option('workscout','pp_old_header') == true) ? 'old' : '' ;
$header_type = apply_filters('workscout_header_type',$header_type);
get_header($header_type); ?>

<?php
do_action( 'jmcl_before_main_content' );
?>

<?php while ( have_posts() ) : the_post(); ?>


    <?php get_company_listings_template_part( 'content-single', 'company_listings' ); ?>

<?php endwhile; // end of the loop. ?>

<?php
do_action( 'jmcl_after_main_content' );
?>


<?php get_footer();

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
