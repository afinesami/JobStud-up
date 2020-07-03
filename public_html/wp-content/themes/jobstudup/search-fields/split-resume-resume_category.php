<?php 
if ( ! is_tax( 'resume_category' ) && get_terms( 'resume_category' ) ) :
	$show_category_multiselect = get_option( 'resume_manager_enable_default_category_multiselect', false ); 

	if ( !empty( $_GET['search_category'] ) ) {
		$selected_category = sanitize_text_field( $_GET['search_category'] );
	} else {
		$selected_category = "";
	}
	?>
	<div>
		
		<div class="search_categories">
			
			<?php if ( $show_category_multiselect ) : ?>
				<?php 
				job_manager_dropdown_categories( 
					array( 
						'taxonomy' => 'resume_category', 
						'hierarchical' => 1,
						'depth' => -1, 
						'class' =>  'select2-multiple job-manager-category-dropdown ' . ( is_rtl() ? 'chosen-rtl' : '' ),
						'name' => 'search_categories', 
						'orderby' => 'name', 
						'selected' => $selected_category, 
						'hide_empty' => false ) 
					); ?>
			<?php else : ?>
				<?php job_manager_dropdown_categories( array( 
					'taxonomy' => 'resume_category', 
					'hierarchical' => 1, 
					'class' =>  'select2-single job-manager-category-dropdown ' . ( is_rtl() ? 'chosen-rtl' : '' ),
					'show_option_all' => esc_html__( 'Any category', 'workscout' ), 
					'name' => 'search_categories', 
					'orderby' => 'name', 
					'selected' => $selected_category, 
					'multiple' => false,
					'hide_empty' => false ) ); ?>
			<?php endif; ?>
			
		</div>
	</div>
<?php else: ?>
	<input type="hidden" name="search_categories[]" value="<?php echo sanitize_title( get_query_var('resume_category') ); ?>" />
<?php endif; ?>