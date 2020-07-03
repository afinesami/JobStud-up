<?php
/**
 * Lists the job applications for a particular job listing.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-applications/job-applications.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager - Applications
 * @category    Template
 * @version     1.7.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="job-manager-job-applications">
	<div class="sixteen columns alpha omega">
		<p class="margin-bottom-25" style="float: left;"><?php printf( esc_html__( 'The job applications for "%s" are listed below.', 'workscout' ), '<a href="' . get_permalink( $job_id ) . '"><strong>' . get_the_title( $job_id ) . '</strong></a>' ); ?></p>
		<strong><a href="<?php echo esc_url( add_query_arg( 'download-csv', true ) ); ?>" class="download-csv job-applications-download-csv"><?php esc_html_e( 'Download CSV', 'workscout' ); ?></a></strong>
	</div>
	<div class="job-applications">
		<form class="filter-job-applications" method="GET">
			<div class="eight columns alpha">
				<select name="application_status" class="select2-single">
					<option value=""><?php esc_html_e( 'Filter by status', 'workscout' ); ?>...</option>
					<?php foreach ( get_job_application_statuses() as $name => $label ) : ?>
						<option value="<?php echo esc_attr( $name ); ?>" <?php selected( $application_status, $name ); ?>><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
			<div class="margin-bottom-15"></div>
			</div>

			<div class="eight columns omega">
				<select name="application_orderby" class="select2-single">
					<option value=""><?php esc_html_e( 'Newest first', 'workscout' ); ?></option>
					<option value="name" <?php selected( $application_orderby, 'name' ); ?>><?php esc_html_e( 'Sort by name', 'workscout' ); ?></option>
					<option value="rating" <?php selected( $application_orderby, 'rating' ); ?>><?php esc_html_e( 'Sort by rating', 'workscout' ); ?></option>
				</select>
				<input type="hidden" name="action" value="show_applications" />
				<input type="hidden" name="job_id" value="<?php echo absint( $_GET['job_id'] ); ?>" />
				<?php if ( ! empty( $_GET['page_id'] ) ) : ?>
					<input type="hidden" name="page_id" value="<?php echo absint( $_GET['page_id'] ); ?>" />
				<?php endif; ?>
				<div class="margin-bottom-35"></div>
			</div>
		</form>

		<!-- Applications -->
		<div class="sixteen columns alpha omega">
			
				<?php foreach ( $applications as $application ) :
				 ?>
					<div class="application job-application" id="application-<?php echo esc_attr( $application->ID ); ?>">
						<div class="app-content">
							
							<!-- Name / Avatar -->
							<div class="info">
								<?php echo get_job_application_avatar( $application->ID, 90 ) ?>
								<span><?php if ( ( $resume_id = get_job_application_resume_id( $application->ID ) ) && 'publish' === get_post_status( $resume_id ) && function_exists( 'get_resume_share_link' ) && ( $share_link = get_resume_share_link( $resume_id ) ) ) : ?>
									<a href="<?php echo esc_attr( $share_link ); ?>"><?php echo $application->post_title; ?></a>
									<?php else : ?>
										<?php echo $application->post_title; ?>
									<?php endif; ?>
								</span>
								<ul>
									<?php if ( $attachments = get_job_application_attachments( $application->ID ) ) : ?>
										<?php foreach ( $attachments as $attachment ) : ?>
											<li><a href="<?php echo esc_url( $attachment ); ?>" title="<?php echo esc_attr( get_job_application_attachment_name( $attachment ) ); ?>" class=" job-application-attachment"><i class="fa fa-file-text"></i> <?php echo esc_html( get_job_application_attachment_name( $attachment, 15 ) ); ?></a></li>
										<?php endforeach; ?>
									<?php endif; ?>
									<?php if ( $email = get_job_application_email( $application->ID ) ) : ?>
										<li><a href="mailto:<?php echo esc_attr( $email ); ?>?subject=<?php echo esc_attr( sprintf( esc_html__( 'Your job application for %s', 'workscout' ), strip_tags( get_the_title( $job_id ) ) ) ); ?>&amp;body=<?php echo esc_attr( sprintf( esc_html__( 'Hello %s', 'workscout' ), get_the_title( $application->ID ) ) ); ?>" title="<?php esc_html_e( 'Email', 'workscout' ); ?>" class="bjob-application-contact"><i class="fa fa-envelope"></i>  <?php esc_html_e( 'Email', 'workscout' ); ?></a></li>
									<?php endif; ?>
									<?php 
									if ( ( $resume_id = get_job_application_resume_id( $application->ID ) ) && 'publish' === get_post_status( $resume_id ) && function_exists( 'get_resume_share_link' ) && (
									 $share_link = get_resume_share_link( $resume_id ) ) ) : ?>
										<li><a href="<?php echo esc_attr( $share_link ); ?>" target="_blank" class="job-application-resume">
										<i class="fa fa-download" aria-hidden="true"></i><?php esc_html_e('View Resume', 'workscout' ); ?></a></li>
									<?php endif; ?>
								</ul>
							</div>
							
							<!-- Buttons -->
							<div class="buttons">
							
								<a href="#edit-<?php echo esc_attr($application->ID );?>" title="<?php esc_html_e( 'Edit', 'workscout' ); ?>" class="button gray app-link job-application-toggle-edit"><i class="fa fa-pencil"></i> <?php esc_html_e( 'Edit', 'workscout' ); ?></a>
								<a href="#notes-<?php echo esc_attr($application->ID );?>" title="<?php esc_html_e( 'Notes', 'workscout' ); ?>" class="button gray app-link job-application-toggle-notes"><i class="fa fa-sticky-note"></i> <?php esc_html_e( 'Notes', 'workscout' ); ?></a>
								<a href="#details-<?php echo esc_attr($application->ID );?>" title="<?php esc_html_e( 'Details', 'workscout' ); ?>" class="button gray app-link job-application-toggle-content"><i class="fa fa-plus-circle"></i> <?php esc_html_e( 'Details', 'workscout' ); ?></a>
							
							</div>
							<div class="clearfix"></div>

						</div>

						<!--  Hidden Tabs -->
						<div class="app-tabs">

							<a href="#" class="close-tab button gray"><i class="fa fa-close"></i></a>
							
							<!-- First Tab -->
						    <div class="app-tab-content" id="edit-<?php echo esc_attr($application->ID );?>">
								<form class="job-manager-application-edit-form job-manager-form" method="post">

									<fieldset class="select-grid fieldset-status">
										<label for="application-status-<?php echo esc_attr( $application->ID ); ?>"><?php esc_html_e( 'Application status', 'workscout' ); ?>:</label>
										<div class="field">
											<select class="select2-single" id="application-status-<?php echo esc_attr( $application->ID ); ?>" name="application_status">
												<?php foreach ( get_job_application_statuses() as $name => $label ) : ?>
													<option value="<?php echo esc_attr( $name ); ?>" <?php selected( $application->post_status, $name ); ?>><?php echo esc_html( $label ); ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</fieldset>

									<fieldset class="select-grid fieldset-rating">
										<label for="application-rating-<?php echo esc_attr( $application->ID ); ?>"><?php esc_html_e( 'Rating (out of 5)', 'workscout' ); ?>:</label>
										<div class="field">
											<input type="number" id="application-rating-<?php echo esc_attr( $application->ID ); ?>" name="application_rating" step="0.1" max="5" min="0" placeholder="0" value="<?php echo esc_attr( get_job_application_rating( $application->ID ) ); ?>" />
										</div>
									</fieldset>
									<div class="clearfix"></div>
									<p>
										<a class="button gray margin-top-15 delete-application delete_job_application" href="<?php echo wp_nonce_url( add_query_arg( 'delete_job_application', $application->ID ), 'delete_job_application' ); ?>"><?php esc_html_e( 'Delete this application', 'workscout' ); ?></a>
										<input class="button margin-top-15" type="submit" name="wp_job_manager_edit_application" value="<?php esc_attr_e( 'Save changes', 'workscout' ); ?>" />
										<input type="hidden" name="application_id" value="<?php echo absint( $application->ID ); ?>" />
										<?php wp_nonce_field( 'edit_job_application' ); ?>
									</p>
								</form>
						    </div>
						    
						    <!-- Second Tab -->
						    <div class="app-tab-content"  id="notes-<?php echo esc_attr($application->ID );?>">
								<?php job_application_notes( $application ); ?>
						    </div>
						    
						    <!-- Third Tab -->
						    <div class="app-tab-content"  id="details-<?php echo esc_attr($application->ID );?>">
						    	<?php job_application_meta( $application ); ?>
								<?php job_application_content( $application ); ?>
							</div>

						</div>

						<!-- Footer -->
						<div class="app-footer">
							<?php $rating = get_job_application_rating( $application->ID ); ?>
							<div class="rating <?php echo workscout_get_rating_class($rating); ?>">
								<div class="star-rating"></div>
								<div class="star-bg"></div>
							</div>
							
							

							<?php global $wp_post_statuses; ?>
							<ul class="meta">
								<li><i class="fa fa-file-text-o"></i><?php echo $wp_post_statuses[ $application->post_status ]->label; ?></li>
								<li><i class="fa fa-calendar"></i> <?php echo date_i18n( get_option( 'date_format' ), strtotime( $application->post_date ) ); ?></li>
							</ul>
							<div class="clearfix"></div>

						</div>
				
					</div>
				<?php endforeach; ?>
			
		</div>
		<?php get_job_manager_template( 'pagination.php', array( 'max_num_pages' => $max_num_pages ) ); ?>
	</div>
</div>