<?php
/**
 * The template for displaying search forms in Nevia
 *
 * @package Nevia
 * @since Nevia 1.0
 */
?>
<div class="widget-box search">
	<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<input type="hidden" name="post_type" value="post" />
		<div class="input"><input class="search-field" type="text" name="s" placeholder="<?php esc_attr_e('To search type and hit enter','workscout') ?>" value=""/></div>
	</form>
</div>


