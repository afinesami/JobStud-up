<div class="panel-dropdown checkboxes" id="salary-panel">
	<a href="#"><?php esc_html_e('Radius','workscout'); ?></a>
	<div class="panel-dropdown-content ">
		 
		 <div class="widget_range_filter-inside">
			<span class="range-slider-subtitle"><?php esc_html_e('Radius around selected destination','workscout'); ?></span>
			<div class="radius_amount range-indicator">
				<span><?php echo get_option('workscout_maps_default_radius'); ?></span> <?php echo get_option('workscout_radius_unit'); ?>
			</div>
		    <input type="hidden" value="<?php echo get_option('workscout_maps_default_radius'); ?>" name="search_radius" id="radius_amount" type="checkbox">
			<div id="radius-range"></div>
		
		</div>
		<!-- Panel Dropdown -->
		<div class="panel-buttons">
			
			<input type="checkbox" name="filter_by_radius_check" id="radius_check" class="filter_by_radius" <?php if(get_option('workscout_radius_state') == 'enabled') echo "checked";?>> 
			<label for="radius_check"><?php esc_html_e('Search by Radius','workscout'); ?></label>

		</div>
	</div>
</div>