<?php 
$selected_job_types = implode( ',', array_values( get_job_listing_types( 'id=>slug' ) ) );
$selected_job_types = is_array( $selected_job_types ) ? $selected_job_types : array_filter( array_map( 'trim', explode( ',', $selected_job_types ) ) );

 ?>

<?php if ( ! is_tax( 'job_listing_type' ) ) : ?>
	<ul class="job_types checkboxes">
		<?php foreach ( get_job_listing_types() as $type ) : ?>
			<li>
				<input type="checkbox" name="filter_job_type[]" value="<?php echo esc_attr($type->slug); ?>" <?php checked( in_array( $type->slug, $selected_job_types ), true ); ?> id="job_type_<?php echo esc_attr($type->slug); ?>" />
				<label for="job_type_<?php echo esc_attr($type->slug); ?>" class="<?php echo sanitize_title( $type->name ); ?>"> <?php echo esc_attr($type->name); ?></label>
			</li>
		<?php endforeach; ?>
	</ul>
	<input type="hidden" name="filter_job_type[]" value="" />
<?php else : ?>
	
		<input type="hidden" name="filter_job_type[]" value="<?php echo sanitize_title(get_query_var('job_listing_type')) ; ?>" />

<?php endif;
 ?>
