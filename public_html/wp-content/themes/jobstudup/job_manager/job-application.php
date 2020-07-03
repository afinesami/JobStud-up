<?php if ( $apply = get_the_job_application_method() ) :
	wp_enqueue_script( 'wp-job-manager-job-application' );
	?>
	<div class="job_application application">
		<?php do_action( 'job_application_start', $apply ); ?>
		
		
		<a href="#apply-dialog" class="small-dialog popup-with-zoom-anim button"><?php esc_html_e( 'Apply for job', 'workscout' ); ?></a>

		<div id="apply-dialog" class="small-dialog zoom-anim-dialog mfp-hide apply-popup">
			<div class="small-dialog-headline">
				<h2><?php esc_html_e('Apply For This Job','workscout') ?></h2>
			</div>
			<div class="small-dialog-content">
				<?php
					/**
					 * job_manager_application_details_email or job_manager_application_details_url hook
					 */
					do_action( 'job_manager_application_details_' . $apply->type, $apply );
				?>
			</div>
		</div>
			
			
		<?php do_action( 'job_application_end', $apply ); ?>
	</div>
<?php endif; ?>