<?php 
if ( ! empty( $_GET['search_location'] ) ) {
	$location = sanitize_text_field( $_GET['search_location'] );
} else {
	$location = '';
} ?>
<div class="sidebar-search_location-container">
	<input type="text" name="search_location" id="search_location" placeholder="<?php esc_attr_e( 'Location', 'workscout' ); ?>" value="<?php echo esc_attr( $location ); ?>" />
	<a href="#"><i title="<?php esc_html_e('Find My Location','workscout') ?>" class="tooltip left la la-map-marked-alt"></i></a>
    <?php if(get_option('workscout_map_address_provider','osm') == 'osm') : ?><span class="type-and-hit-enter"><?php esc_html_e('type and hit enter','workscout') ?></span> <?php endif; ?>
</div>
