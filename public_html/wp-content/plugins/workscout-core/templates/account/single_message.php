<?php $ids = '';
//user_1 ten co wysyla
//user_2 ten co dostaje
if(isset($data)) :
	$ids	 	= (isset($data->ids)) ? $data->ids : '' ;
endif;
if( isset( $_GET["action"]) && $_GET["action"] == 'view' )  {

	$messages = new workscout_Core_Messages();

	//check if user can

	$conversation_id = $_GET["conv_id"]; 
	
	$current_user_id = get_current_user_id();
	
	// get this conversation data
	$this_conv = $messages->get_conversation($conversation_id);	
	if(!$this_conv) { ?>
		<h4><?php esc_html_e('This message does not exists.','workscout_core'); ?></h4>
		<?php return;
	}
	if($current_user_id == (int)$this_conv[0]->user_1 || $current_user_id == (int)$this_conv[0]->user_2 ) :

		// mark this message as read
		$messages->mark_as_read($conversation_id);	
		
		// set who is adversary on that converstation
		$adversary = ($this_conv[0]->user_1 == $current_user_id) ? $this_conv[0]->user_2 : $this_conv[0]->user_1 ;
		$recipient = get_userdata( $adversary ); 
		
		if(empty($recipient->first_name) && empty($recipient->last_name)) {
			$name = $recipient->user_nicename;
		} else {
			$name = $recipient->first_name .' '.$recipient->last_name;
		} 
		
		$referral = $messages->get_conversation_referral($this_conv[0]->referral);
		
		?>
		<div class="messages-container margin-top-0">
			<div class="messages-headline">
				<h4><?php echo esc_html($name); ?><?php if($referral) : ?> <span><?php echo esc_html($referral);  ?></span><?php endif; ?></h4>
				<a href="?action=delete&conv_id=<?php echo esc_attr($conversation_id); ?>" class="message-action" id="message-delete"><i class="sl sl-icon-trash"></i> <?php esc_html_e('Delete Conversation', 'workscout_core' ); ?></a>
			</div>

			<div class="messages-container-inner">

				<!-- Messages -->
				<div class="messages-inbox">
					<?php if($ids) { ?>
					<ul>
						<?php 

							foreach ($ids as $key => $conversation) {
									
									$message_url = add_query_arg( array( 'action' => 'view',  'conv_id' => $conversation->id ), get_permalink( get_option( 'workscout_messages_page' )) );
		
									$last_msg = $messages->get_last_message($conversation->id);
									$conversation_data = $messages->get_conversation($conversation->id);	

									$if_read = $messages->check_if_read($conversation_data);

									$_conv_list_adversary = ($conversation_data[0]->user_1 == $current_user_id) ? $conversation_data[0]->user_2 : $conversation_data[0]->user_1 ;	
									$user_data = get_userdata( $_conv_list_adversary );

									$referral = $messages->get_conversation_referral($conversation->referral);
								?>
								<li <?php if(!$if_read) : ?>class="unread"<?php endif; ?>>
									<a href="<?php echo esc_url($message_url) ?>">
										<div class="message-avatar"><?php echo get_avatar($_conv_list_adversary, '70') ?></div>
					
										<div class="message-by">
											<div class="message-by-headline">
												<?php
												if(empty($user_data->first_name) && empty($user_data->last_name)) {
													$name = $user_data->user_nicename;
												} else {
													$name = $user_data->first_name .' '.$user_data->last_name;
												} ?>
												<h5><?php echo esc_html($name); ?>
												<?php if(!$if_read) : ?><i><?php esc_html_e('Unread','workscout_core') ?></i><?php endif; ?>
											</h5>
											<span><?php echo human_time_diff( $last_msg[0]->created_at, current_time('timestamp')  );  ?></span>
											</div>
											<p>
												<?php if($referral) : echo esc_html($referral); endif; ?>
												<?php 
											//echo $last_msg[0]->message;
											 ?></p>
										</div>
									</a>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>
					
				
				</div>
				<!-- Messages / End -->

				<!-- Message Content -->
				<div class="message-content">
					<div class="message-bubbles">
						<?php
							$conversation = $messages->get_single_conversation($current_user_id,$conversation_id);
							foreach ($conversation as $key => $message) { 
								?>
								<div class="message-bubble <?php if($current_user_id == (int) $message->sender_id ) echo esc_attr('me'); ?>">
									<div class="message-avatar"><a href="<?php echo esc_url(get_author_posts_url($message->sender_id)); ?>"><?php echo get_avatar($message->sender_id, '70') ?></a></div>
									<div class="message-text"><?php echo wpautop($message->message) ?></div>
								</div>
							<?php }
						?>
						
					</div>
					<img style="display: none; " src="<?php echo get_stylesheet_directory_uri(); ?>/images/loader.gif" alt="" class="loading">
					<!-- Reply Area -->
					<div class="clearfix"></div>
					<div class="message-reply">
						<form action="" id="send-message-from-chat">
							<textarea cols="40" id="contact-message" name="message" required rows="3" placeholder="<?php esc_html_e('Your Message', 'workscout_core'); ?>"></textarea>
							<input type="hidden" id="conversation_id" name="conversation_id" value="<?php echo esc_attr($_GET["conv_id"]) ?>">
							<input type="hidden" id="recipient" name="recipient" value="<?php echo esc_attr($adversary) ?>">
							<button class="button"><?php esc_html_e('Send Message', 'workscout_core'); ?></button>
						</form>
					</div>
					
				</div>
				<!-- Message Content -->

			</div>

		</div>
	<?php else: ?>
		<?php esc_html_e("It's not your converstation!",'workscout_core'); ?>
	<?php endif; ?>
<?php } else {
	die();
} ?>