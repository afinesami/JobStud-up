<?php if ( ! empty( $_GET['search_keywords'] ) ) {
	$keywords = sanitize_text_field( $_GET['search_keywords'] );
} else {
	$keywords = '';
} ?>
<div class="search_keywords">
	<input type="text" name="search_keywords" id="search_keywords" placeholder="<?php esc_attr_e( 'job title, keywords or company name', 'workscout' ); ?>" value="<?php echo esc_attr( $keywords ); ?>" />
	
</div>