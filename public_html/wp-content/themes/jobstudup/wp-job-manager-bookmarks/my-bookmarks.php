<div class="dashboard-list-box margin-top-30">
	<div class="dashboard-list-box-content">
		<div id="job-manager-bookmarks">
			<table class="manage-table job-manager-bookmarks">
				<thead>
					<tr>
						<th><i class="fa fa-heart"></i> <?php esc_html_e( 'Bookmark', 'workscout' ); ?></th>
						<th><i class="fa fa-file-text"></i> <?php esc_html_e( 'Notes', 'workscout' ); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					foreach ( $bookmarks as $bookmark ) : 
						if ( get_post_status( $bookmark->post_id ) !== 'publish' ) {
							continue;
						}
						$has_bookmark = true;
						?>
						<tr>
							<td width="50%">
								<?php echo '<a href="' . get_permalink( $bookmark->post_id ) . '">' . get_the_title( $bookmark->post_id ) . '</a>'; ?>
								
							</td>
							<td width="50%">
								<?php echo wpautop( wp_kses_post( $bookmark->bookmark_note ) ); ?>
							</td>
							<td class="action">
								
									<?php
										$actions = apply_filters( 'job_manager_bookmark_actions', array(
											'delete' => array(
												'label' => esc_html__( 'Delete', 'workscout' ),
												'url'   =>  wp_nonce_url( add_query_arg( 'remove_bookmark', $bookmark->post_id ), 'remove_bookmark' )
											)
										), $bookmark );

										foreach ( $actions as $action => $value ) {
											echo '<a href="' . esc_url( $value['url'] ) . '" class="delete job-manager-bookmark-action-' . $action . '"><i class="fa fa-remove"></i> ' . $value['label'] . '</a>';
										}
									?>
								
							</td>
						</tr>
					<?php endforeach; ?> 

					<?php if ( empty( $has_bookmark ) ) : ?>
						<tr>
							<td width="100%" colspan="2"><?php esc_html_e( 'You currently have no bookmarks', 'workscout' ); ?></td>
							<td class="action"></td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>