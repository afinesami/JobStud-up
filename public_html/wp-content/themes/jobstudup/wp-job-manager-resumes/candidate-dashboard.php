<?php
$submission_limit           = get_option( 'resume_manager_submission_limit' );
$submit_resume_form_page_id = get_option( 'resume_manager_submit_resume_form_page_id' );
?>

<div class="notification notice margin-bottom-25"><p class=""><?php echo _n( 'Your resume can be viewed, edited or removed below.', 'Your resume(s) can be viewed, edited or removed below.', resume_manager_count_user_resumes(), 'workscout' ); ?></p>
</div>


<div class="dashboard-list-box margin-top-30" id="job-manager-job-dashboard">
	<div class="dashboard-list-box-content">

		<div id="resume-manager-candidate-dashboard">
	
		<table class="resume-manager-resumes manage-table resumes responsive-table">
			<thead>
				<tr>
					<?php foreach ( $candidate_dashboard_columns as $key => $column ) : ?>
						<th class="<?php echo esc_attr( $key ); ?>"><?php echo workscout_manage_table_icons($key); echo esc_html( $column ); ?></th>
					<?php endforeach; ?>
						<th></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( ! $resumes ) : ?>
					<tr>
						<td colspan="<?php echo sizeof( $candidate_dashboard_columns ); ?>"><?php esc_html_e( 'You do not have any active resume listings.', 'workscout' ); ?></td>
						<td></td>
					</tr>
				<?php else : ?>
					<?php foreach ( $resumes as $resume ) : ?>
						<tr>
							<?php foreach ( $candidate_dashboard_columns as $key => $column ) : ?>
								<td class="<?php echo esc_attr( $key ); ?>">
									<?php if ( 'resume-title' === $key ) : ?>
										<?php if ( $resume->post_status == 'publish' ) : ?>
											<a href="<?php echo get_permalink( $resume->ID ); ?>"><?php echo esc_html( $resume->post_title ); ?></a>
										<?php else : ?>
											<?php echo esc_html( $resume->post_title ); ?> <small>(<?php the_resume_status( $resume ); ?>)</small>
										<?php endif; ?>
										
									<?php elseif ( 'candidate-title' === $key ) : ?>
										<?php the_candidate_title( '', '', true, $resume ); ?>
									<?php elseif ( 'candidate-location' === $key ) : ?>
										<?php ws_candidate_location( false, $resume ); ?></td>
									<?php elseif ( 'resume-category' === $key ) : ?>
										<?php the_resume_category( $resume ); ?>
									<?php elseif ( 'status' === $key ) : ?>
										<?php the_resume_status( $resume ); ?>
									<?php elseif ( 'date' === $key ) : ?>
										<?php
										if ( ! empty( $resume->_resume_expires ) && strtotime( $resume->_resume_expires ) > current_time( 'timestamp' ) ) {
											printf( esc_html__( 'Expires %s', 'workscout' ), date_i18n( get_option( 'date_format' ), strtotime( $resume->_resume_expires ) ) );
										} else {
											echo date_i18n( get_option( 'date_format' ), strtotime( $resume->post_date ) );
										}
										?>
									<?php else : ?>
										<?php do_action( 'resume_manager_candidate_dashboard_column_' . $key, $resume ); ?>
									<?php endif; ?>
								</td>
								
							<?php endforeach; ?>
							<td class="action">
									
											<?php
												$actions = array();

												switch ( $resume->post_status ) {
													case 'publish' :
														$actions['edit'] = array( 'label' => esc_html__( 'Edit', 'workscout' ), 'nonce' => false );
														$actions['hide'] = array( 'label' => esc_html__( 'Hide', 'workscout' ), 'nonce' => true );
													break;
													case 'hidden' :
														$actions['edit'] = array( 'label' => esc_html__( 'Edit', 'workscout' ), 'nonce' => false );
														$actions['publish'] = array( 'label' => esc_html__( 'Publish', 'workscout' ), 'nonce' => true );
													break;
													case 'expired' :
														if ( get_option( 'resume_manager_submit_resume_form_page_id' ) ) {
															$actions['relist'] = array( 'label' => esc_html__( 'Relist', 'workscout' ), 'nonce' => true );
														}
													break;
												}

												$actions['delete'] = array( 'label' => esc_html__( 'Delete', 'workscout' ), 'nonce' => true );

												$actions = apply_filters( 'resume_manager_my_resume_actions', $actions, $resume );

												foreach ( $actions as $action => $value ) {
													$action_url = add_query_arg( array( 'action' => $action, 'resume_id' => $resume->ID ) );
													if ( $value['nonce'] )
														$action_url = wp_nonce_url( $action_url, 'resume_manager_my_resume_actions' );
													echo '<a href="' . $action_url . '" class="candidate-dashboard-action-' . $action . '">'.workscout_manage_action_icons($action) . $value['label'] . '</a>';
												}
											?>
										
								</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>


	<?php get_job_manager_template( 'pagination.php', array( 'max_num_pages' => $max_num_pages ) ); ?>
</div>
</div>

</div>
	<?php if ( $submit_resume_form_page_id && ( resume_manager_count_user_resumes() < $submission_limit || ! $submission_limit ) ) : ?>
		
			<a class="button margin-top-30" href="<?php echo esc_url( get_permalink( $submit_resume_form_page_id ) ); ?>"><?php esc_html_e( 'Add Resume', 'workscout' ); ?></a>
				
	<?php endif; ?>