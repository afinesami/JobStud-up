<?php
$classes            = array( 'input-text' );
$allowed_mime_types = array_keys( ! empty( $field['allowed_mime_types'] ) ? $field['allowed_mime_types'] : get_allowed_mime_types() );
$field_name         = isset( $field['name'] ) ? $field['name'] : $key;
$field_name         .= ! empty( $field['multiple'] ) ? '[]' : '';

if ( ! empty( $field['ajax'] ) && job_manager_user_can_upload_file_via_ajax() ) {
	wp_enqueue_script( 'wp-job-manager-ajax-file-upload' );
	$classes[] = 'wp-job-manager-file-upload';
?>

<label class="fake-upload-btn">
	<div class="job-manager-uploaded-files">
		<?php if ( ! empty( $field['value'] ) ) : ?>
			<?php if ( is_array( $field['value'] ) ) : ?>
				<?php foreach ( $field['value'] as $value ) : ?>
					<?php get_job_manager_template( 'form-fields/uploaded-file-html.php', array( 'key' => $key, 'name' => 'current_' . $field_name, 'value' => $value, 'field' => $field ) ); ?>
				<?php endforeach; ?>
			<?php elseif ( $value = $field['value'] ) : ?>
				<?php get_job_manager_template( 'form-fields/uploaded-file-html.php', array( 'key' => $key, 'name' => 'current_' . $field_name, 'value' => $value, 'field' => $field ) ); ?>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<input type="file" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" data-file_types="<?php echo esc_attr( implode( '|', $allowed_mime_types ) ); ?>" <?php if ( ! empty( $field['multiple'] ) ) echo 'multiple'; ?> name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?><?php if ( ! empty( $field['multiple'] ) ) echo '[]'; ?>" id="<?php echo esc_attr( $key ); ?>" placeholder="<?php echo empty( $field['placeholder'] ) ? '' : esc_attr( $field['placeholder'] ); ?>" />
    <div  class="upload-btn"><i class="fa fa-upload"></i> <?php _e('Browse','workscout'); ?></div>
</label>

<?php } else { ?>

<label class="fake-upload-btn no_ajax">
	<div class="job-manager-uploaded-files">
		<?php if ( ! empty( $field['value'] ) ) : ?>
			<?php if ( is_array( $field['value'] ) ) : ?>
				<?php foreach ( $field['value'] as $value ) : ?>
					<?php get_job_manager_template( 'form-fields/uploaded-file-html.php', array( 'key' => $key, 'name' => 'current_' . $field_name, 'value' => $value, 'field' => $field ) ); ?>
				<?php endforeach; ?>
			<?php elseif ( $value = $field['value'] ) : ?>
				<?php get_job_manager_template( 'form-fields/uploaded-file-html.php', array( 'key' => $key, 'name' => 'current_' . $field_name, 'value' => $value, 'field' => $field ) ); ?>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<input type="file" class="ws-file-upload <?php echo esc_attr( implode( ' ', $classes ) ); ?>" data-file_types="<?php echo esc_attr( implode( '|', $allowed_mime_types ) ); ?>" <?php if ( ! empty( $field['multiple'] ) ) echo 'multiple'; ?> name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?><?php if ( ! empty( $field['multiple'] ) ) echo '[]'; ?>" id="<?php echo esc_attr( $key ); ?>" placeholder="<?php echo empty( $field['placeholder'] ) ? '' : esc_attr( $field['placeholder'] ); ?>" />
    <div  class="upload-btn"><i class="fa fa-upload"></i> <?php _e('Browse','workscout');  ?></div>
</label>


<?php } ?>

<small class="description">
	<?php if ( ! empty( $field['description'] ) ) : ?>
		<?php $allowed_tags = wp_kses_allowed_html( 'post' ); echo wp_kses($field['description'],$allowed_tags); ?>
	<?php else : ?>
		<?php printf( esc_html__( 'Maximum file size: %s.', 'workscout' ), size_format( wp_max_upload_size() ) ); ?>
	<?php endif; ?>
</small>