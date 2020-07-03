<?php if ( ! empty( $field['value'] ) && is_array( $field['value'] ) ) : ?>
	<?php foreach ( $field['value'] as $index => $value ) : ?>
		<div class="resume-manager-data-row">
			<input type="hidden" class="repeated-row-index" name="repeated-row-<?php echo esc_attr( $key ); ?>[]" value="<?php echo absint( $index ); ?>" />
			<a href="#" class="resume-manager-remove-row remove-box button"><i class="fa fa-close"></i> </a>
			<?php foreach ( $field['fields'] as $subkey => $subfield ) : ?>
				<fieldset class="fieldset-<?php echo esc_attr( $subkey ); ?>">
					<label for="<?php echo esc_attr( $subkey ); ?>"><?php echo $subfield['label'] . ( $subfield['required'] ? '' : ' <small>' . esc_html__( '(optional)', 'workscout' ) . '</small>' ); ?></label>
					<div class="field">
						<?php
							// Get name and value
							$subfield['name']  = $key . '_' . $subkey . '_' . $index;
							$subfield['value'] = $value[ $subkey ];
							$class->get_field_template( $subkey, $subfield );
						?>
					</div>
				</fieldset>
			<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
<?php endif; ?>

<a href="#" class="resume-manager-add-row button gray" data-row="<?php

	ob_start();
	?>
		<div class="resume-manager-data-row">
			<input type="hidden" class="repeated-row-index" name="repeated-row-<?php echo esc_attr( $key ); ?>[]" value="%%repeated-row-index%%" />
			<a href="#" class="resume-manager-remove-row remove-box button"><i class="fa fa-close"></i> </a>
			<?php foreach ( $field['fields'] as $subkey => $subfield ) : ?>
				<fieldset class="fieldset-<?php echo esc_attr( $subkey ); ?>">
					<label for="<?php echo esc_attr( $subkey ); ?>"><?php echo $subfield['label'] . ( $subfield['required'] ? '' : ' <small>' . esc_html__( '(optional)', 'workscout' ) . '</small>' ); ?></label>
					<div class="field">
						<?php
							$subfield['name']  = $key . '_' . $subkey . '_%%repeated-row-index%%';
							$class->get_field_template( $subkey, $subfield );
						?>
					</div>
				</fieldset>
			<?php endforeach; ?>
		</div>
	<?php
	echo esc_attr( ob_get_clean() );

?>"><i class="fa fa-plus-circle"></i>  <?php echo esc_html( ! empty( $field['add_row'] ) ? $field['add_row'] : esc_html__('Add URL', 'workscout' )); ?></a>
<?php if ( ! empty( $field['description'] ) ) : ?><p class="note"><?php echo $field['description']; ?></p><?php endif; ?>
