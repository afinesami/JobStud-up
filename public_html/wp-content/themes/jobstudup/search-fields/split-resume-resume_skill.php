<?php 
if ( ! is_tax( 'resume_skill' ) && get_terms( 'resume_skill' ) ) :
	

	if ( ! empty( $_GET['search_skills'] ) ) {
		$selected_skills = sanitize_text_field( $_GET['search_skills'] );
	} else {
		$selected_skills  = '';
	}
	?>
	<div>
		<div class="search_categories">
	
			<?php job_manager_dropdown_categories( array( 'taxonomy' => 'resume_skill', 'hierarchical' => 1, 'name' => 'search_skills', 'orderby' => 'name', 'selected' => $selected_skills, 'hide_empty' => false, 'class' => 'select2-multiple', 'id'=>'search_skills', 'placeholder'=> esc_html__('Choose a skill','workscout') ) ); ?>
		</div>
	</div>
<?php else: ?>
	<input type="hidden" name="search_categories[]" value="<?php echo sanitize_title( get_query_var('resume_category') ); ?>" />
<?php endif; ?>