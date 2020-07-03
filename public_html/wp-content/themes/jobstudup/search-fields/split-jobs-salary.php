<!-- Panel Dropdown -->
<div class="panel-dropdown checkboxes" id="salary-panel">
	<a href="#"><?php esc_html_e( 'Salary', 'workscout' ); ?></a>
	<div class="panel-dropdown-content ">
		 
		 <div class="widget_range_filter-inside">
			<div class="range-slider-subtitle"><?php esc_html_e( 'Select min and max salary range', 'workscout' ); ?></div>
			
			<div class="salary_amount range-indicator">
				<span class="from"></span> &mdash; <span class="to"></span>
			</div>
		    <input type="hidden" name="filter_by_salary" id="salary_amount" type="checkbox"   >
			<div id="salary-range"></div>
		
		</div>
		  						<!-- Panel Dropdown -->
		<div class="panel-buttons">
			
			<input type="checkbox" name="filter_by_salary_check"  id="salary_check" class="filter_by_check" autocomplete="off">
			<label for="salary_check"><?php esc_html_e( 'Enable Salary Filter', 'workscout' ); ?></label>
			
			
		
		</div>
	</div>
</div>