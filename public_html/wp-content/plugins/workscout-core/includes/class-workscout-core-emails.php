<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;
/**
 * workscout_core_listing class
 */
class WorkScout_Core_Emails {

	/**
	 * The single instance of the class.
	 *
	 * @var self
	 * @since  1.0
	 */
	private static $_instance = null;

	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
	 *
	 * @since  1.0
	 * @static
	 * @return self Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {


		add_action( 'workscout_welcome_mail', array($this, 'welcome_mail'));
		add_action( 'workscout_mail_to_user_new_conversation', array($this, 'new_conversation_mail'));
		add_action( 'workscout_mail_to_user_new_message', array($this, 'new_message_mail'));

	}




	function welcome_mail($args){
		$email 		=  $args['email'];

		$args = array(
			'email'         => $email,
	        'login'         => $args['login'],
	        'password'      => $args['password'],
	        'first_name' 	=> $args['first_name'],
	        'last_name' 	=> $args['last_name'],
	        'user_name' 	=> $args['display_name'],
			'user_mail' 	=> $email,
			'login_url' 	=> $args['login_url'],
			
			);
		$subject 	 = get_option('workscout_listing_welcome_email_subject','Welcome to {site_name}!');
		$subject 	 = $this->replace_shortcode( $args, $subject );

		$body 	 = get_option('workscout_listing_welcome_email_content','Welcome to {site_name}! You can log in {login_url}, your username: "{login}", and password: "{password}".');
		
		$body 	 = $this->replace_shortcode( $args, $body );
		self::send( $email, $subject, $body );
	}


	function new_conversation_mail($args){
		$conversation_id = $args['conversation_id']; 
		//{user_mail},{user_name},{listing_name},{listing_url},{site_name},{site_url}
		global $wpdb;

        $conversation_data  = $wpdb -> get_results( "
        SELECT * FROM `" . $wpdb->prefix . "workscout_core_conversations` 
        WHERE  id = '$conversation_id'

        ");

        $read_user_1 = $conversation_data[0]->read_user_1;
        if($read_user_1==0){
        	$user_who_send = $conversation_data[0]->user_2;
        	$user_to_notify = $conversation_data[0]->user_1;
        }
        $read_user_2 = $conversation_data[0]->read_user_2;
        if($read_user_2==0){
        	$user_who_send = $conversation_data[0]->user_1;
        	$user_to_notify = $conversation_data[0]->user_2;
        }


		$user_to_notify_data   	= 	get_userdata( $user_to_notify ); 
		$email 		=  $user_to_notify_data->user_email;

		$user_who_send_data = get_userdata( $user_who_send ); 
		$sender = $user_who_send_data->first_name;
		if(empty($sender)){
			$sender = $user_who_send_data->nickname;
		}
        // ["id"]=> string(2) "36" ["timestamp"]=> string(10) "1573163130" ["user_1"]=> string(1) "1" ["user_2"]=> string(2) "14" ["referral"]=> string(14) "author_archive" ["read_user_1"]=> string(1) "1" ["read_user_2"]=> string(1) "0" ["last_update"]=> string(10) "1573172773"

		$args = array(
			'user_mail'     => $email,
	        'user_name' 	=> $user_to_notify_data->first_name,
			'conversation_url' => get_permalink('workscout_messages_page').'?action=view&conv_id='.$conversation_id,
			'sender'		=> $sender,
			);
		$subject 	 = get_option('workscout_new_conversation_notification_email_subject','You got new conversation!');
		$subject 	 = $this->replace_shortcode( $args, $subject );

		$body 	 = get_option('workscout_new_conversation_notification_email_content',"Hi {user_name},<br>
                    There's a new conversation from {sender} waiting for your on {site_name}.<br> Check it  <a href='{conversation_url}'>here</a>
                    <br>Thank you");
		
		$body 	 = $this->replace_shortcode( $args, $body );
		self::send( $email, $subject, $body );
	}

	function new_message_mail($id){
		$conversation_id = $id; 
		//{user_mail},{user_name},{listing_name},{listing_url},{site_name},{site_url}
		global $wpdb;

        $conversation_data  = $wpdb -> get_results( "
        SELECT * FROM `" . $wpdb->prefix . "workscout_core_conversations` 
        WHERE  id = '$conversation_id'

        ");

        $read_user_1 = $conversation_data[0]->read_user_1;
        if($read_user_1==0){
        	$user_who_send = $conversation_data[0]->user_2;
        	$user_to_notify = $conversation_data[0]->user_1;
        }
        $read_user_2 = $conversation_data[0]->read_user_2;
        if($read_user_2==0){
        	$user_who_send = $conversation_data[0]->user_1;
        	$user_to_notify = $conversation_data[0]->user_2;
        }


		$user_to_notify_data   	= 	get_userdata( $user_to_notify ); 
		$email 		=  $user_to_notify_data->user_email;

		$user_who_send_data = get_userdata( $user_who_send ); 
		$sender = $user_who_send_data->first_name;
		if(empty($sender)){
			$sender = $user_who_send_data->nickname;
		}
        // ["id"]=> string(2) "36" ["timestamp"]=> string(10) "1573163130" ["user_1"]=> string(1) "1" ["user_2"]=> string(2) "14" ["referral"]=> string(14) "author_archive" ["read_user_1"]=> string(1) "1" ["read_user_2"]=> string(1) "0" ["last_update"]=> string(10) "1573172773"

		$args = array(
			'user_mail'     => $email,
	        'user_name' 	=> $user_to_notify_data->first_name,
			'sender'		=> $sender,
			'conversation_url' => get_permalink('workscout_messages_page').'?action=view&conv_id='.$conversation_id,
			);
		$subject 	 = get_option('workscout_new_message_notification_email_subject','You got new conversation!');
		$subject 	 = $this->replace_shortcode( $args, $subject );

		$body 	 = get_option('workscout_new_message_notification_email_content',"Hi {user_name},<br>
                    There's a new message from {sender} waiting for your on {site_name}.<br> Check it  <a href='{conversation_url}'>here</a>
                    <br>Thank you");
		
		$body 	 = $this->replace_shortcode( $args, $body );
		global $wpdb;
		$result  = $wpdb->update( 
            $wpdb->prefix . 'workscout_core_conversations', 
            array( 'notification'  => 'sent' ), 
            array( 'id' => $conversation_id ) 
        );

		self::send( $email, $subject, $body );

		//mark this converstaito as sent
		
	}
	
	/**
	 * general function to send email to agent with specify subject, body content
	 */
	public static function send( $emailto, $subject, $body ){

		$from_name 	= get_option('workscout_emails_name',get_bloginfo( 'name' ));
		$from_email = get_option('workscout_emails_from_email', get_bloginfo( 'admin_email' ));
		$headers 	= sprintf( "From: %s <%s>\r\n Content-type: text/html", $from_name, $from_email );

		if( empty($emailto) || empty( $subject) || empty($body) ){
			return ;
		}
		$template_loader = new workscout_core_Template_Loader;
		ob_start();

			$template_loader->get_template_part( 'emails/header' ); ?>
			<tr>
				<td align="left" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 25px; padding-right: 25px; padding-bottom: 28px; width: 87.5%; font-size: 16px; font-weight: 400; 
				padding-top: 28px; 
				color: #666;
				font-family: sans-serif;" class="paragraph">
				<?php echo $body;?>
				</td>
			</tr>
		<?php
			$template_loader->get_template_part( 'emails/footer' ); 
			$content = ob_get_clean();
		wp_mail( @$emailto, @$subject, @$content, $headers );

	}

	public  function replace_shortcode( $args, $body ) {

		$tags =  array(
			'user_mail' 	=> "",
			'user_name' 	=> "",
			'booking_date' => "",
			'listing_name' => "",
			'listing_url' => '',
			'site_name' => '',
			'site_url'	=> '',
			'payment_url'	=> '',
			'expiration'	=> '',
			'dates'	=> '',
			'children'	=> '',
			'adults'	=> '',
			'tickets'	=> '',
			'details'	=> '',
			'login'	=> '',
			'password'	=> '',
			'first_name'	=> '',
			'last_name'	=> '',
			'login_url'	=> '',
			'sender'	=> '',
			'conversation_url'	=> '',
		);
		$tags = array_merge( $tags, $args );

		extract( $tags );

		$tags 	 = array( '{user_mail}',
						  '{user_name}',
						  '{booking_date}',
						  '{listing_name}',
						  '{listing_url}',
						  '{site_name}',
						  '{site_url}',
						  '{payment_url}',
						  '{expiration}',
						  '{dates}',
						  '{children}',
						  '{adults}',
						  '{tickets}',
						  '{details}',
						  '{login}',
						  '{password}',
						  '{first_name}',
						  '{last_name}',
						  '{login_url}',
						  '{sender}',
						  '{conversation_url}',
						);

		$values  = array(   $user_mail, 
							$user_name ,
							$booking_date,
							$listing_name,
							$listing_url,
							get_bloginfo( 'name' ) ,
							get_home_url(), 
							$payment_url,
							$expiration,
							$dates,
							$children,
							$adults,
							$tickets,
							$details,
							$login,
							$password,
							$first_name,
							$last_name,
							$login_url,
							$sender,
							$conversation_url,
		);
	
		$message = str_replace($tags, $values, $body);
		$message = nl2br($message);

		return $message;
	}
}
?>