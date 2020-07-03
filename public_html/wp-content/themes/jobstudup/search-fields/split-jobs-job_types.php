<?php if ( get_option( 'job_manager_enable_types' ) ) { ?>
							
		<!-- Panel Dropdown -->
		<div class="panel-dropdown " id="tax-job_type-panel">
			<a href="#"><?php esc_html_e('Job Type','workscout'); ?></a>
			<div class="panel-dropdown-content checkboxes ">
				<div class="row  ">
					<div class="panel-checkboxes-container ">
				
						<?php get_job_manager_template( 'job-filter-job-types.php', array( 'job_types' => '', 'atts' => array('orderby' => 'name'), 'selected_job_types' => '' ) ); ?>
									
					</div>
				</div>	
			</div>
		</div>
	
<?php } ?>	