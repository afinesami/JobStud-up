<?php
global $resume_preview;

if ( $resume_preview ) {
	return;
}

if ( resume_manager_user_can_view_contact_details( $post->ID ) ) :
	wp_enqueue_script( 'wp-resume-manager-resume-contact-details' );
	?>
	<div class="resume_contact">
		
		<a href="#resume-dialog" class="small-dialog popup-with-zoom-anim button"><i class="fa fa-envelope"></i> <?php esc_html_e( 'Contact', 'workscout' ); ?></a>
		<div id="resume-dialog" class="small-dialog zoom-anim-dialog mfp-hide apply-popup">
			<div class="small-dialog-headline">
				<h2><?php esc_html_e('Send Message','workscout'); ?></h2>
			</div>
			<div class="small-dialog-content">
				<?php do_action( 'resume_manager_contact_details' ); ?>
			</div>
		</div>
	</div>
<?php else : ?>

	<?php get_job_manager_template_part( 'access-denied', 'contact-details', 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>

<?php endif; ?>