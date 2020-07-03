<?php global $wp; ?>


	<?php if ( $is_bookmarked ) : ?>
		<a class="remove-bookmark button dark" href="<?php echo wp_nonce_url( add_query_arg( 'remove_bookmark', absint( $post->ID ), get_permalink() ), 'remove_bookmark' ); ?>"><i class="fa fa-star"></i> <?php esc_html_e( 'Remove Bookmark', 'workscout' ); ?></a> 
		<?php $bookmarks_page = get_option('pp_bookmarks_page'); 
		if(!empty($bookmarks_page)) { ?>
		<a class="bookmark-notice bookmarked" href="<?php echo get_permalink($bookmarks_page); ?>"><?php printf( esc_html__( 'This %s is bookmarked!', 'workscout' ), $post_type->labels->singular_name ); ?></a>
		<?php } ?>
	<?php else : ?>
		<a class="bookmark-notice small-dialog popup-with-zoom-anim button dark" href="#bookmark-dialog"><i class="fa fa-star"></i>  <?php printf( esc_html__( 'Bookmark This %s', 'workscout' ), ucwords( $post_type->labels->singular_name ) ); ?></a>
	<?php endif; ?>
	<div id="bookmark-dialog" class="small-dialog zoom-anim-dialog mfp-hide apply-popup">
	<form method="post" action="<?php echo defined( 'DOING_AJAX' ) ? '' : esc_url( remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) ) ); ?>" class="job-manager-form wp-job-manager-bookmarks-form">
		<div class="small-dialog-headline">
			<h2><?php esc_html_e('Bookmark Details','workscout'); ?></h2>
		</div>
		<div class="small-dialog-content">
			<p><textarea placeholder="<?php esc_html_e( 'Notes:', 'workscout' ); ?>" name="bookmark_notes" id="bookmark_notes" cols="25" rows="3"><?php echo esc_textarea( $note ); ?></textarea></p>
			<p>
				<?php wp_nonce_field( 'update_bookmark' ); ?>
				<input type="hidden" name="bookmark_post_id" value="<?php echo absint( $post->ID ); ?>" />
				<input type="submit" name="submit_bookmark" value="<?php echo $is_bookmarked ? esc_html__( 'Update Bookmark', 'workscout' ) : esc_html__( 'Add Bookmark', 'workscout' ); ?>" />
			</p>
		</div>
		</form>
	</div>


