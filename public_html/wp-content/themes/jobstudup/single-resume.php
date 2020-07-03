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
<?php while ( have_posts() ) : the_post(); ?>
<?php if ( resume_manager_user_can_view_resume( $post->ID ) ) : 

	$resume_photo_style = Kirki::get_option( 'workscout','pp_resume_rounded_photos','off' );

	if($resume_photo_style){
		$photo_class = "square";
	} else {
		$photo_class = "rounded";
	}
?>
	
	<!-- Titlebar
	================================================== -->
	<div id="titlebar" class="resume">
		<div class="container">
			<div class="ten columns">
				<div class="resume-titlebar photo-<?php echo $photo_class?>">
					<?php the_candidate_photo('workscout-resume', get_template_directory_uri().'/images/candidate.png'); ?>

					<div class="resumes-content">
						<h4><?php the_title(); ?> <span><?php the_candidate_title(); ?></span></h4>
						<span class="icons"><i class="fa fa-map-marker"></i><?php ws_candidate_location(); ?></span>
						<?php $rate = get_post_meta( $post->ID, '_rate_min', true );
						$currency_position =  get_option('workscout_currency_position','before');

						if(!empty($rate)) { ?>
							<span class="icons"><i class="fa fa-money"></i> <?php 
							 if( $currency_position == 'before' ) { 
		                            echo get_workscout_currency_symbol(); 
		                        } 
							 echo get_post_meta( $post->ID, '_rate_min', true );
							 if( $currency_position == 'after' ) { 
		                            echo get_workscout_currency_symbol(); 
		                        }
							  ?> <?php esc_html_e('/ hour','workscout') ?></span>
						<?php } ?>
						<?php foreach( get_resume_links() as $link ) : ?>
							<?php
								$parsed_url = parse_url( $link['url'] );
								$host       = isset( $parsed_url['host'] ) ? current( explode( '.', $parsed_url['host'] ) ) : '';
							?>
							<span class="icons">
								<a rel="nofollow" href="<?php echo esc_url( $link['url'] ); ?>"><i class="fa fa-link"></i> <?php echo esc_html( $link['name'] ); ?></a>
							</span>
						<?php endforeach; ?>
						<?php if ( resume_has_file() ) : ?>
							<?php
							if ( ( $resume_files = get_resume_files() ) && apply_filters( 'resume_manager_user_can_download_resume_file', true, $post->ID ) ) : ?>
								<?php foreach ( $resume_files as $key => $resume_file ) : ?>
									<span class="icons">
										<a rel="nofollow" href="<?php echo esc_url( get_resume_file_download_url( null, $key ) ); ?>"><i class="fa fa-file"></i> <?php echo basename( $resume_file ); ?></a>
									</span>
								<?php endforeach; ?>
							<?php endif; ?>
						<?php endif; ?>
						<div class="resume-meta-skills">
							
						
							<?php if ( ( $skills = wp_get_object_terms( $post->ID, 'resume_skill', array( 'fields' => 'names' ) ) ) && is_array( $skills ) ) : ?>
								<div class="skills">
									<?php echo '<span>' . implode( '</span><span>', $skills ) . '</span>'; ?>
								</div>
								<div class="clearfix"></div>
							<?php endif; ?>
							<?php if ( ( $categories = wp_get_object_terms( $post->ID, 'resume_category', array( 'fields' => 'names' ) ) ) && is_array( $categories ) ) : ?>
								<div class="skills">
									<?php echo '<span>' . implode( '</span><span>', $categories ) . '</span>'; ?>
								</div>
								<div class="clearfix"></div>
							<?php endif; ?>
						</div>

					</div>
				</div>
			</div>

			<div class="six columns">
				<div class="two-buttons">
					<?php 
					$private_messages = get_option('workscout_private_messages_resumes'); 
				
					if($private_messages) :
						if(is_user_logged_in()):
									$owner_id = get_the_author_meta( 'ID' );
									$owner_data = get_userdata( $owner_id );
							?>
								<!-- Reply to review popup -->
								<div id="small-dialog" class="zoom-anim-dialog mfp-hide small-dialog apply-popup ">


									<div class="small-dialog-header">
										<h3><?php esc_html_e('Send Message', 'workscout'); ?></h3>
									</div>
									<div class="message-reply margin-top-0">
										<form action="" id="send-message-from-widget" data-listingid="<?php echo esc_attr($post->ID); ?>">
											<textarea 
											required
											data-recipient="<?php echo esc_attr($owner_id); ?>"  
											data-referral="listing_<?php echo esc_attr($post->ID); ?>"  
											cols="40" id="contact-message" name="message" rows="3" placeholder="<?php esc_attr_e('Your message to ','workscout');  the_title(); ?>"></textarea>
											<button class="button">
											<i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i><?php esc_html_e('Send Message', 'workscout'); ?></button>	
											<div class="notification closeable success margin-top-20"></div>

										</form>
										
									</div>
								</div>


								<a href="#small-dialog" class="send-message-to-owner button popup-with-zoom-anim"><i class="sl sl-icon-envelope-open"></i> <?php esc_html_e('Send Message', 'workscout'); ?></a>
							
						<?php else:
						$popup_login = get_option( 'workscout_popup_login' ); 
						if( $popup_login == 'ajax') { ?>
							<a href="#login-dialog" class="send-message-to-owner button popup-with-zoom-anim"><i class="sl sl-icon-envelope-open"></i> <?php esc_html_e('Login to Send Message', 'workscout'); ?></a>
						<?php } else { 
							$login_page = get_option('workscout_profile_page'); ?>
							<a href="<?php echo esc_url(get_permalink($login_page)); ?>" class="send-message-to-owner button"><i class="sl sl-icon-envelope-open"></i> <?php esc_html_e('Login to Send Message', 'workscout'); ?></a>
						<?php } ?>
						<?php endif; ?>
					<?php else: ?>
					<?php get_job_manager_template( 'contact-details.php', array( 'post' => $post ), 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>
					<?php endif; ?>
					<?php do_action('workscout_bookmark_hook') ?>
					
					
				</div>
			</div>
			
		</div>
	</div>


	<!-- Content
	================================================== -->
	<div class="container ">
	<?php do_action( 'single_resume_start' ); ?>

		<?php 
		$squere_buttons = Kirki::get_option( 'workscout','pp_resumes_styled_list',false );
		$education = get_post_meta( $post->ID, '_candidate_education', true );
		$experience = get_post_meta( $post->ID, '_candidate_experience', true );
		if(empty($education) && empty($experience) ) { ?>
		<div class="sixteen columns resume_description <?php if($squere_buttons) { echo "styled-list"; } ?> ">
				<?php the_candidate_video(); ?>
				<?php echo do_shortcode(apply_filters( 'the_resume_description', get_the_content() )); ?>

		</div>
		<?php } else { ?>
		<!-- Recent Jobs -->
		<div class="eight columns">
			<div class="padding-right resume_description <?php if($squere_buttons) { echo "styled-list"; } ?> ">
				<?php the_candidate_video(); ?>
				<?php echo do_shortcode(apply_filters( 'the_resume_description', get_the_content() )); ?>
				<?php do_action( 'single_resume_meta_start' ); ?>
				<?php do_action( 'single_resume_meta_end' ); ?>
			</div>
		</div>

		<!-- Widgets -->
		<div class="eight columns">
			<?php if ( $items = get_post_meta( $post->ID, '_candidate_education', true ) ) : ?>
				<h3 class="margin-bottom-20"><?php esc_html_e( 'Education', 'workscout' ); ?></h3>
				<dl class="resume-table resume-manager-education">
				<?php
					foreach( $items as $item ) : ?>

						<dt>
							<small class="date"><?php echo esc_html( $item['date'] ); ?></small>
							<strong><?php printf( esc_html__( '%s at %s', 'workscout' ), '<span class="qualification">' . esc_html( $item['qualification'] ) . '</span>', '<span class="location">' . esc_html( $item['location'] ) . '</span>' ); ?></strong> 
						</dt>
						<dd>
							<?php if(isset( $item['notes'] ) ) { echo wpautop( wptexturize($item['notes']) ); } ?>
						</dd>

					<?php endforeach;
				?>
				</dl>
			<?php endif; ?>
			
			<?php if ( $items = get_post_meta( $post->ID, '_candidate_experience', true ) ) : ?>
				<h3 class="margin-bottom-20"><?php esc_html_e( 'Experience', 'workscout' ); ?></h3>
				<dl class="resume-table resume-manager-experience">
				<?php
					foreach( $items as $item ) : ?>

						<dt>
							<small class="date"><?php echo esc_html( $item['date'] ); ?></small>
							<strong><?php printf( esc_html__( '%s at %s', 'workscout' ), '<span class="job_title">' . esc_html( $item['job_title'] ) . '</span>', '<span class="employer">' . esc_html( $item['employer'] ) . '</span>' ); ?></strong> 
						</dt>
						<dd>
							<?php echo wpautop( wptexturize( $item['notes'] ) ); ?>
						</dd>

					<?php endforeach;
				?>
				</dl>
			<?php endif; ?>

		</div>
		<?php } ?>

		<?php do_action( 'single_resume_end' ); ?>

	</div>
	<div class="margin-top-10"></div>
	<div class="clearfix"></div>
	<div class="container">
		<div class="columns sixteen">
		<?php
			if(get_option('workscout_enable_resume_comments')) {
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			}
		?>
		</div>
	</div>
<?php else : ?>

	<?php get_job_manager_template_part( 'access-denied', 'single-resume', 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>

<?php endif; ?>
<?php endwhile; // End of the loop. ?>
<?php get_footer(); ?>