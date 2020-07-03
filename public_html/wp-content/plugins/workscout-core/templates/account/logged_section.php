<!-- User Profile -->
<?php 
	$current_user = wp_get_current_user();
	$roles = $current_user->roles;
	$role = array_shift( $roles ); 
	if(!empty($current_user->user_firstname)){
		$name = $current_user->user_firstname;
	} else {
		$name =  $current_user->display_name;
	}
?>
<div class="header-notifications user-menu">
	<div class="header-notifications-trigger">
		<a href="#">
			<div class="user-avatar status-online"><?php echo get_avatar( $current_user->user_email, 32 );?></div>
			<div class="user-avatar-title"><?php esc_attr_e( 'Hi,', 'workscout_core' ); ?> <b><?php echo $name; ?></b>!</div>
		</a>
	</div>

	<div class="header-notifications-dropdown">
		<ul class="user-menu-small-nav">
			<?php $dashboard_page = get_option('workscout_dashboard_page');  if( $dashboard_page ) : ?>
                <li <?php if( is_page() && $post->ID == $dashboard_page ) : ?>class="active" <?php endif; ?>><a href="<?php echo esc_url(get_permalink($dashboard_page)); ?>"> <?php esc_html_e('Dashboard','workscout_core');?></a></li>
                <?php endif; ?>

			<?php $messages_page = get_option('workscout_messages_page');  if( $messages_page ) : ?>
                <li <?php if(  is_page() && $post->ID == $messages_page ) : ?>class="active" <?php endif; ?>>
                    <a href="<?php echo esc_url(get_permalink($messages_page)); ?>"><?php esc_html_e('Messages','workscout_core');?> 
                    <?php 
                    $counter = workscout_get_unread_counter();
                    if($counter) { ?>
                    <span class="small-tag"><?php echo esc_html($counter); ?></span>
                    <?php } ?>
                    </a>
                </li>
                <?php endif; ?>
			<!-- <li><a href="#">My Profile</a></li> -->
			<li><a href="<?php echo wp_logout_url(get_permalink()); ?>"><i class="sl sl-icon-power"></i><?php esc_html_e('Logout','workscout_core');?></a></li>
		</ul>
	</div>
</div>