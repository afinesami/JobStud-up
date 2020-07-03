<?php
/**
 * The template for displaying all single jobs.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WorkScout
 */

$header_old = Kirki::get_option('workscout','pp_old_header');
$header_type = (Kirki::get_option('workscout','pp_old_header') == true) ? 'old' : '' ;
$header_type = apply_filters('workscout_header_type',$header_type);
get_header($header_type); ?>

		<!-- Titlebar
	================================================== -->
	<div id="titlebar" class="resume">
		<div class="container">
			<div class="sixteen columns">
				<div class="company-titlebar">
					
					<?php if ( get_the_company_name() ) { ?>
						<!-- Company Info -->
						<div class="company-info" itemscope itemtype="http://data-vocabulary.org/Organization">
							<?php the_company_logo(); ?>
							<div class="content">
								<h4><?php the_company_name( '<strong itemprop="name">', '</strong>' ); ?> <?php the_company_tagline( '<span class="company-tagline">- ', '</span>' ); ?></h4>
								<?php if ( $website = get_the_company_website() ) : ?>
									<span><a class="website" href="<?php echo esc_url( $website ); ?>" itemprop="url" target="_blank" rel="nofollow"><i class="fa fa-link"></i> <?php esc_html_e( 'Website', 'workscout' ); ?></a></span>
								<?php endif; ?>
								<?php if ( get_the_company_twitter() ) : ?>
									<span><a href="http://twitter.com/<?php echo get_the_company_twitter(); ?>">
										<i class="fa fa-twitter"></i>
										@<?php echo get_the_company_twitter(); ?>
									</a></span>
								<?php endif; ?>
							</div>
							<div class="clearfix"></div>
						</div>
					<?php } ?>

					
						

				</div>
			</div>
		</div>
	</div>


<?php 
	$layout = Kirki::get_option( 'workscout', 'pp_blog_layout' );
	if(empty($layout)) { $layout = 'right-sidebar'; }
	wp_dequeue_script('wp-job-manager-ajax-filters' );
	wp_enqueue_script( 'workscout-wp-job-manager-ajax-filters' );
?>

<div class="container <?php echo esc_attr($layout); ?>">

	<article id="post-<?php the_ID(); ?>" <?php post_class('eleven columns'); ?>>
		<div class="padding-right">
			<?php 
			if ( ! empty( $_GET['search_keywords'] ) ) {
				$keywords = sanitize_text_field( $_GET['search_keywords'] );
			} else {
				$keywords = '';
			}
			?>
			<form class="list-search"  method="GET" action="<?php echo get_permalink(get_option('job_manager_jobs_page_id')); ?>">
				<div class="search_keywords">
					<button><i class="fa fa-search"></i></button>
					<input type="text" name="search_keywords" id="search_keywords" placeholder="<?php esc_attr_e( 'job title, keywords or company name', 'workscout' ); ?>" value="<?php echo esc_attr( $keywords ); ?>" />
					<div class="clearfix"></div>
				</div>
				
			</form>

			<?php echo do_shortcode('[jobs show_filters="false"]'); ?>
			<footer class="entry-footer">
				<?php edit_post_link( esc_html__( 'Edit', 'workscout' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-footer -->
		</div>
	</article>

	<?php  get_sidebar('jobs');?>

</div>

<?php get_footer(); ?>