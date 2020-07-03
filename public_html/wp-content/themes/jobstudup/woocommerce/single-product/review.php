<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$rating   = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
$verified = wc_review_is_from_verified_owner( $comment->comment_ID );
?>

<li itemprop="reviews" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

		<div class="avatar"><?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '60' ), '' ); ?></div>
		<div class="comment-content"><div class="arrow-comment"></div>
			<div class="comment-by"><strong itemprop="author"><?php comment_author(); ?></strong><span class="date"><time itemprop="datePublished" datetime="<?php echo get_comment_date( 'c' ); ?>"><?php echo get_comment_date( __( get_option( 'date_format' ), 'workscout' ) ); ?></time></span>
<?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) :
		$avclass = workscout_get_rating_class($rating); ?>
		<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( esc_html__( 'Rated %d out of 5', 'workscout' ), $rating ) ?>">
			<div class="rating <?php echo esc_attr($avclass); ?>"><div class="star-rating"></div><div class="star-bg"></div></div>
		</div>
		
<?php endif; ?>
			</div>
			<div itemprop="description" class="description">
				<?php comment_text(); ?>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<p class="meta"><em><?php esc_html_e( 'Your comment is awaiting approval', 'workscout' ); ?></em></p>
				<?php else : ?>
					<p class="meta">
					<?php
						if ( get_option( 'woocommerce_review_rating_verification_label' ) === 'yes' )
							if ( $verified )
								echo '<em class="verified">(' . esc_html__( 'verified owner', 'workscout' ) . ')</em> ';
					?></p>
				<?php endif; ?>
			</div>


		</div>
	</div>







