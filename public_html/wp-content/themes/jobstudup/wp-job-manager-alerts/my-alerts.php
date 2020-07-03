<div class="notification notice margin-bottom-25"><p class=""><?php printf( esc_html__( 'Your job alerts are shown in the table below. Your alerts will be sent to %s.', 'workscout' ), $user->user_email ); ?></p></div>

<div class="dashboard-list-box margin-top-30" id="job-manager-job-dashboard">
	<div class="dashboard-list-box-content">

		<div id="job-manager-alerts">
			
			<table class="manage-table resumes responsive-table job-manager-alerts">
				<thead>
					<tr>
						<th><i class="fa fa-file-text"></i> <?php esc_html_e( 'Alert Name', 'workscout' ); ?></th>
						
						<th><i class="fa fa-tags"></i> <?php esc_html_e( 'Keywords', 'workscout' ); ?></th>
						<?php if ( get_option( 'job_manager_enable_categories' ) && wp_count_terms( 'job_listing_category' ) > 0 ) : ?>
							<th><i class="fa fa-tags"></i> <?php _e( 'Categories', 'wp-job-manager-alerts' ); ?></th>
						<?php endif; ?>
						<?php if ( taxonomy_exists( 'job_listing_tag' ) ) : ?>
							<th><i class="fa fa-tags"></i> <?php _e( 'Tags', 'wp-job-manager-alerts' ); ?></th>
						<?php endif; ?>
						<th><i class="fa fa-map-marker"></i> <?php esc_html_e( 'Location', 'workscout' ); ?></th>
						<th><i class="fa fa-clock-o"></i> <?php esc_html_e( 'Frequency', 'workscout' ); ?></th>
						<th><i class="fa fa-check-square-o"></i> <?php esc_html_e( 'Status', 'workscout' ); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php if ( ! $alerts ) : ?>
						<tr>
							<td colspan="8"><?php esc_html_e( 'You do not have any job alerts.', 'workscout' ); ?></td>
							
						</tr>
					<?php endif;  ?>
					<?php foreach ( $alerts as $alert ) : ?>
						<?php
						$search_terms = WP_Job_Manager_Alerts_Post_Types::get_alert_search_terms( $alert->ID );
						?>
						<tr class="alert-<?php echo $alert->post_status === 'draft' ? 'disabled' : 'enabled'; ?>">
							<td>
								<?php echo esc_html( $alert->post_title ); ?>
							</td>
							<td class="alert_keyword"><?php
								if ( $value = get_post_meta( $alert->ID, 'alert_keyword', true ) )
									echo esc_html( '&ldquo;' . $value . '&rdquo;' );
								else
									echo '&ndash;';
							?></td>
							<?php if ( get_option( 'job_manager_enable_categories' ) && wp_count_terms( 'job_listing_category' ) > 0 ) : ?>
								<td class="alert_category"><?php
									$term_ids = ! empty( $search_terms['categories'] ) ? $search_terms['categories'] : array();
									$terms = array();
									if ( ! empty( $term_ids ) ) {
										$terms = get_terms( array(
											'taxonomy'         => 'job_listing_category',
											'fields'           => 'names',
											'include'          => $term_ids,
											'hide_empty'       => false,
										) );
									}
									echo $terms ? esc_html( implode( ', ', $terms ) ) : '&ndash;';
								?></td>
							<?php endif; ?>
							<?php if ( taxonomy_exists( 'job_listing_tag' ) ) : ?>
								<td class="alert_tag"><?php
									$term_ids = ! empty( $search_terms['tags'] ) ? $search_terms['tags'] : array();
									$terms = array();
									if ( ! empty( $term_ids ) ) {
										$terms = get_terms( array(
											'taxonomy'         => 'job_listing_tag',
											'fields'           => 'names',
											'include'          => $term_ids,
											'hide_empty'       => false,
										) );
									}
									echo $terms ? esc_html( implode( ', ', $terms ) ) : '&ndash;';
								?></td>
							<?php endif; ?>
							<td class="alert_location"><?php
								if ( taxonomy_exists( 'job_listing_region' ) && wp_count_terms( 'job_listing_region' ) > 0 ) {
									$terms = wp_get_post_terms( $alert->ID, 'job_listing_region', array( 'fields' => 'names' ) );
									echo esc_html( implode( ', ', $terms ) );
								} else {
									$value = get_post_meta( $alert->ID, 'alert_location', true );
									echo $value ? esc_html( '&ldquo;' . $value . '&rdquo;' ) : '&ndash;';
								}
							?></td>
							<td class="alert_frequency"><?php
								$schedules = WP_Job_Manager_Alerts_Notifier::get_alert_schedules();
								$freq      = get_post_meta( $alert->ID, 'alert_frequency', true );

								if ( ! empty( $schedules[ $freq ] ) ) {
									echo esc_html( $schedules[ $freq ]['display'] );
								}

								echo '<small>' . sprintf( __( 'Next: %s at %s', 'wp-job-manager-alerts' ), date_i18n( get_option( 'date_format' ), wp_next_scheduled( 'job-manager-alert', array( $alert->ID ) ) ),  date_i18n( get_option( 'time_format' ), wp_next_scheduled( 'job-manager-alert', array( $alert->ID ) ) ) ) . '</small>';
							?></td>
							<td class="status"><?php echo $alert->post_status == 'draft' ? esc_html__( 'Disabled', 'workscout' ) : esc_html__( 'Enabled', 'workscout' ); ?></td>
							<td class="action">
								
									<?php
										$actions = apply_filters( 'job_manager_alert_actions', array(
											'view' => array(
												'label' => esc_html__( 'Show Results', 'workscout' ),
												'nonce' => false
											),
											'email' => array(
												'label' => esc_html__( 'Email', 'workscout' ),
												'nonce' => true
											),
											'edit' => array(
												'label' => esc_html__( 'Edit', 'workscout' ),
												'nonce' => false
											),
											'toggle_status' => array(
												'label' => $alert->post_status == 'draft' ? esc_html__( 'Enable', 'workscout' ) : esc_html__( 'Disable', 'workscout' ),
												'nonce' => true
											),
											'delete' => array(
												'label' => esc_html__( 'Delete', 'workscout' ),
												'nonce' => true
											)
										), $alert );

										foreach ( $actions as $action => $value ) {
											$action_url = remove_query_arg( 'updated', add_query_arg( array( 'action' => $action, 'alert_id' => $alert->ID ) ) );

											if ( $value['nonce'] )
												$action_url = wp_nonce_url( $action_url, 'job_manager_alert_actions' );

											echo '<a href="' . $action_url . '" class="job-alerts-action-' . $action . '">' .workscout_manage_action_icons($action)  . $value['label'] . '</a>';
										}
									?>
								
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		
					
		</div>
	</div>
</div>

<a class="button margin-top-30" href="<?php echo remove_query_arg( 'updated', add_query_arg( 'action', 'add_alert' ) ); ?>"><?php esc_html_e( 'Add alert', 'workscout' ); ?></a>



