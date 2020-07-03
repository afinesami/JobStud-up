

<div class="dashboard-list-box margin-top-30" id="job-manager-job-dashboard">
	<div class="dashboard-list-box-content">
		<h4><?php esc_html_e( 'Add New Alert', 'workscout' ); ?></h4>
		<form method="post" class="job-manager-form submit-page">
			<fieldset class="form">
				<label for="alert_name"><?php esc_html_e( 'Alert Name', 'workscout' ); ?></label>
				<div class="field">
					<input type="text" name="alert_name" value="<?php echo esc_attr( $alert_name ); ?>" id="alert_name" class="input-text" placeholder="<?php esc_html_e( 'Enter a name for your alert', 'workscout' ); ?>" />
				</div>
			</fieldset>
			<fieldset class="form">
				<label for="alert_keyword"><?php esc_html_e( 'Keyword', 'workscout' ); ?></label>
				<div class="field">
					<input type="text" name="alert_keyword" value="<?php echo esc_attr( $alert_keyword ); ?>" id="alert_keyword" class="input-text" placeholder="<?php esc_html_e( 'Optionally add a keyword to match jobs against', 'workscout' ); ?>" />
				</div>
			</fieldset>
			<?php if ( taxonomy_exists( 'job_listing_region' ) && wp_count_terms( 'job_listing_region' ) > 0 ) : ?>
				<fieldset class="form">
					<label for="alert_regions"><?php esc_html_e( 'Job Region', 'workscout' ); ?></label>
					<div class="field">
						<?php
							job_manager_dropdown_categories( array(
								'show_option_all' => false,
								'hierarchical'    => true,
								'orderby'         => 'name',
								'taxonomy'        => 'job_listing_region',
								'name'            => 'alert_regions',
								'class'           => 'alert_regions select2-multiple',
								'hide_empty'      => 0,
								'selected'        => $alert_id ? wp_get_post_terms( $alert_id, 'job_listing_region', array( 'fields' => 'ids' ) ) : $alert_region,
								'placeholder'     => esc_html__( 'Any region', 'workscout' )
							) );
						?>
					</div>
				</fieldset>
			<?php else : ?>
				<fieldset class="form">
					<label for="alert_location"><?php esc_html_e( 'Location', 'workscout' ); ?></label>
					<div class="field">
						<input type="text" name="alert_location" value="<?php echo esc_attr( $alert_location ); ?>" id="alert_location" class="input-text" placeholder="<?php esc_html_e( 'Optionally define a location to search against', 'workscout' ); ?>" />
					</div>
				</fieldset>
			<?php endif; ?>
			<?php if ( get_option( 'job_manager_enable_categories' ) && wp_count_terms( 'job_listing_category' ) > 0 ) : ?>
				<fieldset class="form">
					<label for="alert_cats"><?php esc_html_e( 'Categories', 'workscout' ); ?></label>
					<div class="field">
						<?php
							wp_enqueue_script( 'wp-job-manager-term-multiselect' );

							job_manager_dropdown_categories( array(
								'taxonomy'     => 'job_listing_category',
								'hierarchical' => 1,
								'name'         => 'alert_cats',
								'orderby'      => 'name',
								'selected'     => $alert_cats,
								'hide_empty'   => false,
								'placeholder'  => esc_html__( 'Any category', 'workscout' )
							) );
						?>
					</div>
				</fieldset>
			<?php endif; ?>
			<?php if ( taxonomy_exists( 'job_listing_tag' ) && wp_count_terms( 'job_listing_tag' ) > 0 ) : ?>
					<fieldset class="form">
					<label for="alert_tags"><?php _e( 'Tags', 'wp-job-manager-alerts' ); ?></label>
					<div class="field">
						<?php
							wp_enqueue_script( 'wp-job-manager-term-multiselect' );

							job_manager_dropdown_categories( array(
								'taxonomy'     => 'job_listing_tag',
								'hierarchical' => 0,
								'name'         => 'alert_tags',
								'orderby'      => 'name',
								'selected'     => $alert_tags,
								'hide_empty'   => false,
								'placeholder'  => __( 'Any tag', 'wp-job-manager-alerts' )
							) );
						?>
					</div>
				</fieldset>
			<?php endif; ?>
			<fieldset class="form">
				<label for="alert_job_type"><?php esc_html_e( 'Job Type', 'workscout' ); ?></label>
				<div class="field">
					<select name="alert_job_type[]" data-placeholder="<?php esc_html_e( 'Any job type', 'workscout' ); ?>" id="alert_job_type" multiple="multiple" class="select2-multiple">
						<?php
							$terms = get_job_listing_types();
							foreach ( $terms as $term )
								echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( in_array( $term->slug, $alert_job_type ), true, false ) . '>' . esc_html( $term->name ) . '</option>';
						?>
					</select>
				</div>
			</fieldset>
			<fieldset class="form">
				<label for="alert_frequency"><?php esc_html_e( 'Email Frequency', 'workscout' ); ?></label>
				<div class="field">
					<select name="alert_frequency" class="select2-single" id="alert_frequency">
						<?php foreach ( WP_Job_Manager_Alerts_Notifier::get_alert_schedules() as $key => $schedule ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $alert_frequency, $key ); ?>><?php echo esc_html( $schedule['display'] ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</fieldset>
			<p id="add_alert_button">
				<?php wp_nonce_field( 'job_manager_alert_actions' ); ?>
				<input type="hidden" name="alert_id" value="<?php echo absint( $alert_id ); ?>" />
				<input type="submit" name="submit-job-alert" value="<?php esc_html_e( 'Save alert', 'workscout' ); ?>" />
			</p>
		</form>		
	</div>
</div>