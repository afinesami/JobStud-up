<?php
// Get selected value
if ( isset( $field['value'] ) ) {
	$selected = $field['value'];
} elseif ( is_int( $field['default'] ) ) {
	$selected = $field['default'];
} elseif ( ! empty( $field['default'] ) && ( $term = get_term_by( 'slug', $field['default'], $field['taxonomy'] ) ) ) {
	$selected = $term->term_id;
} else {
	$selected = '';
}

// Select only supports 1 value
if ( is_array( $selected ) ) {
	$selected = current( $selected );
}

$dropdown = wp_dropdown_categories( apply_filters( 'job_manager_term_select_field_wp_dropdown_categories_args', array(
	'taxonomy'         => $field['taxonomy'],
	'hierarchical'     => 1,
	'show_option_all'  => false,
	'show_option_none' => $field['required'] ? '' : '-',
	'name'             => isset( $field['name'] ) ? $field['name'] : $key,
	'orderby'          => 'name',
	'class'            => 'select2-single',
	'echo'=>false,
	'selected'         => $selected,
	'hide_empty'       => false
), $key, $field ) );
$string = str_replace("&nbsp;", "", $dropdown); echo $string;
$allowed_tags = wp_kses_allowed_html( 'post' );
if ( ! empty( $field['description'] ) ) : ?><small class="description"><?php echo wp_kses($field['description'],$allowed_tags); ?></small><?php endif; ?>
