<!-- Panel Dropdown -->
<div class="panel-dropdown checkboxes" id="rate-panel">
	<a href="#"><?php esc_html_e('Rate','workscout'); ?></a>
	<div class="panel-dropdown-content ">
		 
		 <div class="widget_range_filter-inside">
			<div class="range-slider-subtitle"><?php esc_html_e('Select min and max rate range','workscout'); ?></div>

			<div class="rate_amount range-indicator">
				<span class="from"></span> &mdash; <span class="to"></span>
			</div>
		    <input type="hidden" name="filter_by_rate" id="rate_amount" type="checkbox"  >
			<div id="rate-range"></div>
		</div>
		  						<!-- Panel Dropdown -->
		<div class="panel-buttons">
			
			<input type="checkbox" name="filter_by_rate_check" id="filter_by_rate" class="filter_by_check"> 
			<label for="filter_by_rate"><?php esc_html_e('Enable Rate Filter','workscout'); ?></label>
			
		</div>
	</div>
</div>
<!-- Panel Dropdown -->
