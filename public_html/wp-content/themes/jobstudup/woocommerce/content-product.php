<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}


// Extra post classes
$classes = array();

$layout = Kirki::get_option( 'workscout', 'pp_shop_layout' ); 
if($layout=='full-width'){ 
	$classes[] = 'plan columns one-third';
} else {
	$classes[] = 'plan columns half';
}

if($product->is_featured()) { 
	$classes[] = "color-2 "; 
} else { 
	$classes[] = "color-1 "; 
} 
		
	if($product->get_type() == "job_package" || $product->get_type() == "resume_package" || $product->get_type() == "resume_package_subscription" || $product->get_type() == "job_package_subscription") { ?>

	<li <?php post_class( $classes ); ?>>
		<?php
		if ( has_post_thumbnail() ) {
			$attachment_count = count( $product->get_gallery_image_ids() );
			$gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
			$props            = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
			$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title'	 => $props['title'],
				'alt'    => $props['alt'],
			) );
			echo apply_filters(
				'woocommerce_single_product_image_html',
				sprintf(
					'%s',
					
					$image
				),
				$post->ID
			);
		}
		?>
		<?php if($product->get_type() == "job_package" || $product->get_type() == "resume_package") { ?>
			<div class="plan-price">

				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<div class="plan-price-wrap"><?php echo $product->get_price_html(); ?></div>

			</div>

			<div class="plan-features">
			
	        <?php if($product->get_type() == "job_package" ) { ?>
				<ul>
					<?php 
					$jobslimit = $product->get_limit();
					if(!$jobslimit){
						echo "<li>";
						esc_html_e('Unlimited number of jobs','workscout'); 
						echo "</li>";
					} else { ?>
					<li>
						<?php esc_html_e('This plan includes ','workscout'); printf( _n( '%d job', '%s jobs', $jobslimit, 'workscout' ) . ' ', $jobslimit ); ?>
					</li>
					<?php } 

					$jobduration =  $product->get_duration();
					if(!empty($jobduration)){ ?>
					<li>
						<?php esc_html_e('Jobs are posted ','workscout'); printf( _n( 'for %s day', 'for %s days', $product->get_duration(), 'workscout' ), $product->get_duration() ); ?>
					</li>
					<?php } ?>

				</ul>
			<?php } ?>
			
			<?php if($product->get_type() == "resume_package" ) { ?>
				<ul>
					<?php 
					$jobslimit = $product->get_limit();
					if(!$jobslimit){
						echo "<li>";
						esc_html_e('Unlimited number of Resumes','workscout'); 
						echo "</li>";
					} else { ?>
						<li>
							<?php esc_html_e('This plan includes ','workscout'); printf( _n( '%d resume', '%s resumes', $jobslimit, 'workscout' ) . ' ', $jobslimit ); ?>
						</li>
					<?php } 

					$jobduration =  $product->get_duration();
					if(!empty($jobduration)){ ?>
						<li>
							<?php esc_html_e('Resumes are posted ','workscout'); printf( _n( 'for %s day', 'for %s days', $product->get_duration(), 'workscout' ), $product->get_duration() ); ?>
						</li>
					<?php } ?>

				</ul>
			<?php } ?>

				<?php 
					the_content(); 
					$link 	= $product->add_to_cart_url();
					$label 	= apply_filters( 'add_to_cart_text', esc_html__( 'Add to cart', 'workscout' ) );
				?>
				<a href="<?php echo esc_url( $link ); ?>" class="button"><i class="fa fa-shopping-cart"></i> <?php echo $label; ?></a>
				
			</div>
		<?php } else { ?>
			<div class="plan-price">

				<h3><?php the_title(); ?></h3>
				<div class="plan-price-wrap"><?php echo $product->get_price_html(); ?></div>

			</div>
			<div class="plan-features">
				<span class="product-category">
				<?php
				echo woocommerce_get_product_thumbnail('workscout-small-blog');
					$product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );
					if ( $product_cats && ! is_wp_error ( $product_cats ) ){
						$single_cat = array_shift( $product_cats );
						echo $single_cat->name;
					} 
				?>
				</span>
				<?php 
				$link 	= $product->add_to_cart_url();
				$label 	= apply_filters( 'add_to_cart_text', esc_html__( 'Add to cart', 'workscout' ) );
				?>
				<a href="<?php echo esc_url( $link ); ?>" class="button"><i class="fa fa-shopping-cart"></i> <?php echo $label; ?></a>
				
				<?php	do_action( 'woocommerce_after_shop_loop_item_title' );	?>
			</div>
		<?php }	?>
	</li>

<?php } else {
	
	$classes[] = 'regular-product'; ?>
	<li <?php post_class( $classes ); ?>>
		
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		
			<div class="mediaholder">
				<?php
					/**
					 * woocommerce_before_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_show_product_loop_sale_flash - 10
					 * @hooked woocommerce_template_loop_product_thumbnail - 10
					 */
					do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
			</div>

			<section>
				<span class="product-category">
				<?php
					$product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );
					if ( $product_cats && ! is_wp_error ( $product_cats ) ){
					$single_cat = array_shift( $product_cats );
					echo $single_cat->name;
					} ?>
				</span>

				<h5><?php the_title(); ?></h5>
				<?php
					/**
					 * woocommerce_after_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_template_loop_rating - 5
					 * @hooked woocommerce_template_loop_price - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item_title' );
				?>
			</section>	
		<?php

			/**
			 * woocommerce_after_shop_loop_item hook
			 *
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item' );

		?>

	</li>
<?php }
