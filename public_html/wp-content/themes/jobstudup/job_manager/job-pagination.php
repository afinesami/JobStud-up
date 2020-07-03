<?php
/**
 * Pagination - Show numbered pagination for the [jobs] shortcode
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( $max_num_pages <= 1 ) {
	return;
}

// Calculate pages to output
$end_size    = 3;
$mid_size    = 3;
$start_pages = range( 1, $end_size );
$end_pages   = range( $max_num_pages - $end_size + 1, $max_num_pages );
$mid_pages   = range( $current_page - $mid_size, $current_page + $mid_size );
$pages       = array_intersect( range( 1, $max_num_pages ), array_merge( $start_pages, $end_pages, $mid_pages ) );
$prev_page   = 0;
?>
<nav class="job-manager-pagination pagination">
	<ul>
		<?php if ( $current_page && $current_page > 1 ) : ?>
			<li style="float:left; position: absolute; left: 0;" class="mobile-hidden"><a href="#" data-page="<?php echo esc_attr($current_page - 1); ?>"><?php esc_html_e('Previous','workscout') ?></a></li>
		<?php endif; ?>

		<?php
			foreach ( $pages as $page ) {
				if ( $prev_page != $page - 1 ) {
					echo '<li><span class="gap">...</span></li>';
				}
				if ( $current_page == $page ) {
					echo '<li><span class="current" data-page="' . $page . '">' . $page . '</span></li>';
				} else {
					echo '<li><a href="#" data-page="' . $page . '">' . $page . '</a></li>';
				}
				$prev_page = $page;
			}
		?>

		<?php if ( $current_page && $current_page < $max_num_pages ) : ?>
			<li style="float:right; position: absolute; right: 0; "><a href="#" data-page="<?php echo esc_attr($current_page + 1); ?>"><?php esc_html_e('Next','workscout') ?></a></li>
		<?php endif; ?>
	</ul>
</nav>