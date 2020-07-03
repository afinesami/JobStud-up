
<div class="notification notice margin-bottom-25"><p class=""><?php esc_html_e( 'Your listings are shown in the table below.', 'workscout' ); ?></p></div>
<div class="dashboard-list-box margin-top-30" id="job-manager-job-dashboard">
	<div class="dashboard-list-box-content">
		
	
	
	<table class="job-manager-jobs manage-table responsive-table">
		<thead>
			<tr>
				<?php 
				foreach ( $job_dashboard_columns as $key => $column ) : ?>
					<th class="<?php echo esc_attr( $key ); ?>"><?php echo workscout_manage_table_icons($key); echo esc_html( $column ); ?></th>
				<?php endforeach; ?>
					<th></th> 
			</tr>
		</thead>

		<tbody>
			<?php if ( ! $jobs ) : ?>
				<tr>
					<td colspan="6"><?php esc_html_e( 'You do not have any active listings.', 'workscout' ); ?></td>
				</tr>
			<?php else : ?>
				<?php foreach ( $jobs as $job ) : ?>
					<tr>
						<?php foreach ( $job_dashboard_columns as $key => $column ) : ?>
							<td class="<?php echo esc_attr( $key ); ?>">
								<?php if ('job_title' === $key ) : ?>
									<?php if ( $job->post_status == 'publish' ) : ?>
										<a href="<?php echo get_permalink( $job->ID ); ?>"><?php echo esc_html($job->post_title); ?></a>
									<?php else : ?>
										<?php echo esc_html($job->post_title); ?> <small>(<?php the_job_status( $job ); ?>)</small>
									<?php endif; ?>
								
									
								<?php elseif ('date' === $key ) : ?>
									<?php echo date_i18n( get_option( 'date_format' ), strtotime( $job->post_date ) ); ?>	
								<?php elseif ('expires' === $key ) : ?>
									<?php echo $job->_job_expires ? date_i18n( get_option( 'date_format' ), strtotime( $job->_job_expires ) ) : '&ndash;'; ?>
								<?php elseif ('filled' === $key ) : ?>
									<?php echo is_position_filled( $job ) ? '&#10004;' : '&ndash;'; ?>
								<?php elseif ('applications' === $key ) : ?>
									<?php 
										global $post;
										echo ( $count = get_job_application_count( $job->ID ) ) ? '<a class="button" href="' . add_query_arg( array( 'action' => 'show_applications', 'job_id' => $job->ID ), get_permalink( $post->ID ) ) . '">'.__('Show','workscout').' (' . $count . ')</a>' : '&ndash;';
 									?>
								<?php else : ?>
									<?php do_action( 'job_manager_job_dashboard_column_' . $key, $job ); ?>
								<?php endif; ?>
							</td>
						<?php endforeach; ?>
							<td class="action">

									<?php
										$actions = array();

										switch ( $job->post_status ) {
											case 'publish' :
												if ( wpjm_user_can_edit_published_submissions() ) {
													$actions[ 'edit' ] = array( 'label' => __( 'Edit', 'workscout' ), 'nonce' => false );
												}
											
												if ( is_position_filled( $job ) ) {
													$actions['mark_not_filled'] = array( 'label' => esc_html__( 'Mark not filled', 'workscout' ), 'nonce' => true );
												} else {
													$actions['mark_filled'] = array( 'label' => esc_html__( 'Mark filled', 'workscout' ), 'nonce' => true );
												}

												$actions['duplicate'] = array( 'label' => __( 'Duplicate', 'wp-job-manager' ), 'nonce' => true );
												break;
											case 'expired' :
												if ( job_manager_get_permalink( 'submit_job_form' ) ) {
													$actions['relist'] = array( 'label' => esc_html__( 'Relist', 'workscout' ), 'nonce' => true );
												}
												break;
											case 'pending_payment' :
											case 'pending' :
												if ( job_manager_user_can_edit_pending_submissions() ) {
													$actions['edit'] = array( 'label' => esc_html__( 'Edit', 'workscout' ), 'nonce' => false );
												}
											case 'draft' :
											case 'preview' :
												$actions['continue'] = array( 'label' => __( 'Continue Submission', 'workscout' ), 'nonce' => true );
												break;
											break;
										}

										$actions['delete'] = array( 'label' => esc_html__( 'Delete', 'workscout' ), 'nonce' => true );
										$actions           = apply_filters( 'job_manager_my_job_actions', $actions, $job );

										foreach ( $actions as $action => $value ) {
											$action_url = add_query_arg( array( 'action' => $action, 'job_id' => $job->ID ) );
											if ( $value['nonce'] ) {
												$action_url = wp_nonce_url( $action_url, 'job_manager_my_job_actions' );
											}
											echo '<a href="' . esc_url( $action_url ) . '" class="job-dashboard-action-' . esc_attr( $action ) . '">' .workscout_manage_action_icons($action) . esc_html( $value['label'] ) . '</a>';
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
<?php 
	$submit_job_page = get_option('job_manager_submit_job_form_page_id');
	if (!empty($submit_job_page)) {  ?>
		<a href="<?php echo get_permalink($submit_job_page) ?>" class="button margin-top-30"><?php esc_html_e('Add Job','workscout'); ?></a>
	<?php } ?>