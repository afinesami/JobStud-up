<?php
/**
 * Template Name: Page Template Resume Packages (WooCommerce)
 *
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage workscout
 * @since workscout 1.0
 */

$header_old = Kirki::get_option('workscout','pp_old_header');
$header_type = (Kirki::get_option('workscout','pp_old_header') == true) ? 'old' : '' ;
$header_type = apply_filters('workscout_header_type',$header_type);
get_header($header_type);

?>

<?php $header_image = get_post_meta($post->ID, 'pp_job_header_bg', TRUE); 
	if(!empty($header_image)) { ?>
		<div id="titlebar" class="photo-bg single" style="background: url('<?php echo esc_url($header_image); ?>')">
	<?php } else { ?>
		<div id="titlebar" class="single">
	<?php } ?>
	<div class="container">
		<div class="sixteen columns">
			<h1><?php the_title(); ?></h1>
	        <?php if(function_exists('bcn_display')) { ?>
		        <nav id="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
					<ul>
			        	<?php bcn_display_list(); ?>
			        </ul>
				</nav>
			<?php } ?>
		</div>
	</div>
</div>

<div class="container">
<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('sixteen columns'); ?>>
		<?php the_content(); ?>
	</article>


<?php endwhile; // End of the loop. ?>

<?php 
global $wp_query;

$job_packages = new WP_Query( array(
	'post_type'  => 'product',
	'limit'      => -1,
	'tax_query'  => array(
		array(
			'taxonomy' => 'product_type',
			'field'    => 'slug',
			'terms'    => array('resume_package','resume_package_subscription')
		)
	)
) );
 ?>
	<article <?php post_class(); ?>>

		<?php 
		switch ($job_packages->found_posts) {
			case 2:
				$columns = "eight";
				break;		
			case 3:
				$columns = "one-third";
				break;			
			case 4:
				$columns = "four";
				break;
			
			default:
				$columns = "one-third";
				break;
		}
		
		while ( $job_packages->have_posts() ) : $job_packages->the_post(); 
		

			$job_package = wc_get_product( get_post()->ID ); ?>
		
			<div class="plan product-<?php echo get_post()->ID;?> <?php if($job_package->is_featured()) { echo "color-2 "; } else { echo "color-1 "; } echo esc_attr($columns); ?>  column">
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
				<div class="plan-price">

					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<?php echo '<div class="plan-price-wrap">'.$job_package->get_price_html().'</div>'; ?>

				</div>

				<div class="plan-features">
					<ul>
						<?php 
						$jobslimit = $product->get_limit();
						if(!$jobslimit){
							echo "<li>";
							 esc_html_e('Unlimited number of resumes','workscout'); 
							 echo "</li>";
						} else { ?>
							<li>
								<?php esc_html_e('This plan includes ','workscout'); printf( _n( '%d resume', '%s resumes', $jobslimit, 'workscout' ) . ' ', $jobslimit ); ?>
							</li>
						<?php } 

						$jobduration =  $product->get_duration();
						if(!empty($jobduration)){ ?>

						<li>
							<?php esc_html_e('Resumes are posted ','workscout'); printf( _n( 'for %s day', 'for %s days', $job_package->get_duration(), 'workscout' ), $job_package->get_duration() ); ?>
						</li>
						<?php } ?>

					</ul>
					<?php 
						the_content(); 
						$link 	= $job_package->add_to_cart_url();
					?>
					<a href="<?php echo esc_url( $link ); ?>" class="button"><i class="fa fa-shopping-cart"></i> <?php echo apply_filters( 'add_to_cart_text', esc_html__( 'Add to cart', 'workscout' ) ); ?></a>
					
				</div>
			</div>
		<?php endwhile; ?>
	</article>
</div>

<?php
get_footer(); ?>