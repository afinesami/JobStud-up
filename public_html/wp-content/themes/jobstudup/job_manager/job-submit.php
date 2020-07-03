<?php
/**
 * Job Submission Form
 */
if ( ! defined( 'ABSPATH' ) ) exit;

global $job_manager;
?>


<form action="<?php echo esc_url( $action ); ?>" method="post" id="submit-job-form" class="job-manager-form" enctype="multipart/form-data">

	<?php do_action( 'submit_job_form_start' ); ?>

	<?php if ( apply_filters( 'submit_job_form_show_signin', true ) ) : ?>

		<?php get_job_manager_template( 'account-signin.php' ); ?>

	<?php endif; ?>
	
		<div class="dashboard-list-box">
			<div class="dashboard-list-box-content">
			
				<h4><?php esc_html_e( 'Job Details', 'workscout' ); ?></h4>
				
				<?php if ( job_manager_user_can_post_job() ) : ?>
					<div class="submit-page">
					<!-- Job Information Fields -->
					<?php do_action( 'submit_job_form_job_fields_start' ); ?>

					<?php foreach ( $job_fields as $key => $field ) : ?>
						<fieldset class="form fieldset-<?php echo esc_attr( $key ); ?>">
							<label for="<?php echo esc_attr( $key ); ?>"><?php echo $field['label'] . apply_filters( 'submit_job_form_required_label', $field['required'] ? '' : ' <small>' . esc_html__( '(optional)', 'workscout' ) . '</small>', $field ); ?></label>
							<div class="field <?php echo $field['required'] ? 'required-field' : ''; ?>">
								<?php get_job_manager_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field ) ); ?>
							</div>
						</fieldset>
					<?php endforeach; ?>

					<?php do_action( 'submit_job_form_job_fields_end' ); ?>

					<!-- Company Information Fields -->
					<?php if ( $company_fields ) : ?>
					</div>
			</div>
		</div>
		<div class="dashboard-list-box margin-top-30">
			<div class="dashboard-list-box-content">
				<h4><?php esc_html_e( 'Company Details', 'workscout' ); ?></h4>
				<div class="submit-page">
					<?php do_action( 'submit_job_form_company_fields_start' ); ?>

					<?php foreach ( $company_fields as $key => $field ) : ?>
						<fieldset class="form fieldset-<?php echo esc_attr( $key ); ?>">
							<label for="<?php echo esc_attr( $key ); ?>"><?php echo $field['label'] . apply_filters( 'submit_job_form_required_label', $field['required'] ? '' : ' <small>' . esc_html__( '(optional)', 'workscout' ) . '</small>', $field ); ?></label>
							<div class="field <?php echo $field['required'] ? 'required-field' : ''; ?>">
								<?php get_job_manager_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field ) ); ?>
							</div>
						</fieldset>
					<?php endforeach; ?>

					<?php do_action( 'submit_job_form_company_fields_end' ); ?>
					<?php endif; ?>

					<?php do_action( 'submit_job_form_end' ); ?>

					

				<?php else : ?>

					<?php do_action( 'submit_job_form_disabled' ); ?>

				<?php endif; ?>
			</div>
		</div>

	</div>
	<p class="send-btn-border">
		<input type="hidden" name="job_manager_form" value="<?php echo esc_attr($form); ?>" />
		<input type="hidden" name="job_id" value="<?php echo esc_attr( $job_id ); ?>" />
		<input type="hidden" name="step" value="<?php echo esc_attr( $step ); ?>" />
		<input type="submit" name="submit_job" class="button big" value="<?php echo esc_attr( $submit_button_text ); ?>" />
	</p>
</form>
