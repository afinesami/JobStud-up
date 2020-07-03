<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;
/**
 * Workscout_Core_Messages class
 */
class Workscout_Core_Messages {

	public function __construct() {

		add_shortcode( 'workscout_messages', array( $this, 'workscout_messages' ) );
        add_action('wp_ajax_workscout_send_message', array($this, 'send_message_ajax'));
        add_action('wp_ajax_workscout_send_message_chat', array($this, 'send_message_ajax_chat'));
		add_action('wp_ajax_workscout_get_conversation', array($this, 'get_conversation_ajax'));

        add_action( 'workscout_core_check_for_new_messages', array( $this, 'check_for_new_messages' ) );
	}

    /**
     * Maintenance task to expire listings.
     */
    public function check_for_new_messages() {
        global $wpdb;
        $date_format = get_option('date_format');
       
        //  global $wpdb;
        // if ( $limit != '' ) $limit = " LIMIT " . esc_sql($limit);
        
        // if ( is_numeric($offset)) $offset = " OFFSET " . esc_sql($offset);

        // $result  = $wpdb -> get_results( "
        // SELECT * FROM `" . $wpdb->prefix . "workscout_core_conversations` 
        // WHERE  user_1 = '$user_id' OR user_2 = '$user_id'
        // ORDER BY last_update DESC $limit $offset
        // ");
        
        // return $result;

        // Notifie expiring in 5 days
       $conversation_ids = $wpdb->get_col( $wpdb->prepare( "
                SELECT id FROM {$wpdb->prefix}workscout_core_conversations
                WHERE (read_user_1 = '0'
                OR read_user_2 = '0' )
                AND notification != 'sent'
                AND last_update < %s
            ", strtotime( "-15 minutes" ) 
        )
        );

        if ( $conversation_ids ) {
            foreach ( $conversation_ids as $conversation_id ) {
                
                do_action('workscout_mail_to_user_new_message',$conversation_id);
            }
        }
  
    }
    
	public  function start_conversation( $args = 0 )  {

        global $wpdb;

        // TODO: filter by parameters
        $read_user_1 = '1';
        $read_user_2 = '0';

        $result =  $wpdb->insert( 
            $wpdb->prefix . 'workscout_core_conversations', 
            array(
                'user_1' => get_current_user_id(), //sender
                'user_2' => $args['recipient'], // recipeint
                'referral' => $args['referral'],
                'timestamp' => current_time( 'timestamp' ),
                'read_user_1' => $read_user_1, //sender already read
                'read_user_2' => $read_user_2,
                'notification' => '',
            ),
            array( 
                '%d',
                '%d', 
                '%s', 
                '%d',
                '%d',
                '%d',
            ) 
        );
        
        if(isset($wpdb->insert_id)) {
            $id = $wpdb->insert_id;
             $mail_args = array(
                'conversation_id' => $id,
            );
            do_action('workscout_mail_to_user_new_conversation',$mail_args);
        } else {
            $id = false;
        }
        return $id;
    }

    public  function send_new_message( $args = 0 )  {

        global $wpdb;

        // TODO: filter by parameters
        
        $result =  $wpdb -> insert( $wpdb->prefix . 'workscout_core_messages', array(
            'conversation_id' 	=> $args['conversation_id'],
            'sender_id' 		=> $args['sender_id'],
            'message' 			=> stripslashes_deep($args['message']),
            'created_at' 		=> current_time( 'timestamp' ),
        ));

        if(isset($wpdb->insert_id)) {
            $id = $wpdb->insert_id;
            $conversation = $this->get_conversation($args['conversation_id']);
            if($conversation[0]->user_1 == $args['sender_id']) {
                $user = 'user_2';
            } else {
                $user = 'user_1';
            }
           $this->mark_as_unread($user,$args['conversation_id']);
           $this->converstation_update_date($args['conversation_id']);
        } else {
            $id = false;
        }
        return $id;
    }

    public function send_message_ajax() {

        $recipient = $_REQUEST['recipient'];
        $referral = $_REQUEST['referral'];
        
        $conv_arr = array();
        
        $conv_arr['recipient'] = $recipient;
        $conv_arr['referral'] = $referral;
        $conv_arr['message'] = $message;
        //check if conv exists
        $con_exists = $this->conversation_exists($recipient,$referral);
        $new_converstation  = ($con_exists) ? $con_exists : $this->start_conversation($conv_arr) ;
        

        if($new_converstation){
            $message = $_REQUEST['message'];
            $mess_arr = array();
            $mess_arr['conversation_id'] = $new_converstation;
            $mess_arr['sender_id'] = get_current_user_id();
            $mess_arr['message'] = $message;
            $id = $this->send_new_message($mess_arr);
        }

        if($id) {
            $result['type'] = 'success';
            $result['message'] = __( 'Your message was successfully sent' , 'workscout_core' );
        } else {
            $result['type'] = 'error';
            $result['message'] = __( 'Message couldn\'t be send' , 'workscout_core' );
        }

        $result = json_encode($result);
        echo $result;      
        die();
    }

    public function send_message_ajax_chat() {        
       
        $conversation_id = $_REQUEST['conversation_id'];
    	$message = $_REQUEST['message'];
        if(empty($message)){
            $result['type'] = 'error';
            $result['message'] = __( 'Empty message' , 'workscout_core' );
            $result = json_encode($result);
            echo $result;  
           
            die();
        }
        if(empty($conversation_id)){
            $result['type'] = 'error';
            $result['message'] = __( 'Whoops, we have a problem' , 'workscout_core' );
            $result = json_encode($result);
            echo $result;  
           
            die();
        }
    	    	
    	$mess_arr['conversation_id'] = $conversation_id;
    	$mess_arr['sender_id'] = get_current_user_id();
    	$mess_arr['message'] = $message;
    	$id = $this->send_new_message($mess_arr);
        
        if($id) {
            $result['type'] = 'success';
            $result['message'] = __( 'Your message was successfully sent' , 'workscout_core' );
        } else {
            $result['type'] = 'error';
            $result['message'] = __( 'Message couldn\'t be send' , 'workscout_core' );
        }

        $result = json_encode($result);
        echo $result;  
	   
	    die();
    }

   /**
	* Get user conversations
	*
    *
	*/
	public function get_conversations( $user_id, $limit = '', $offset = '')  {

        global $wpdb;
        if ( $limit != '' ) $limit = " LIMIT " . esc_sql($limit);
        
        if ( is_numeric($offset)) $offset = " OFFSET " . esc_sql($offset);

        $result  = $wpdb -> get_results( "
        SELECT * FROM `" . $wpdb->prefix . "workscout_core_conversations` 
        WHERE  user_1 = '$user_id' OR user_2 = '$user_id'
        ORDER BY last_update DESC $limit $offset
        ");
        
        return $result;
    }

    public function delete_conversations( $conv_id ) {
        global $wpdb;
        $user_id = get_current_user_id();
        $conversation = $this->get_conversation($conv_id);
        
        if($conversation){
            
            if($conversation[0]->user_1 == $user_id || $conversation[0]->user_2 == $user_id ){

                $result = $wpdb -> delete( $wpdb->prefix . 'workscout_core_conversations', array( 'id' => $conv_id) );
                $wpdb -> delete( $wpdb->prefix . 'workscout_core_messages', array( 'conversation_id' => $conv_id) );
                return $result;
            
            } else {
            
                return false;
            
            }
        } else {
            return false;
        }
       
        return false;
    }

//     public function get_conversations_by_latest(){
//         global $wpdb
// SELECT conv.id FROM wp_workscout_core_conversations AS conv LEFT JOIN wp_workscout_core_messages AS mes ON conv.id=mes.conversation_id  order by mes.created_at DESC 
//     }

    public function get_conversation_ajax() {
        $conversation_id = $_REQUEST['conversation_id'];
        if(!$conversation_id) {
            return;
            die();
        }
            $user_id = get_current_user_id();
            $conversation = $this->get_single_conversation($user_id,$conversation_id);
            
            ob_start();
            foreach ($conversation as $key => $message) { ?>
                <div class="message-bubble <?php if($user_id == $message->sender_id ) echo esc_attr('me'); ?>">
                    <div class="message-avatar"><a href="<?php echo esc_url(get_author_posts_url($message->sender_id)); ?>"><?php echo get_avatar($message->sender_id, '70') ?></a></div>
                    <div class="message-text"><?php echo wpautop($message->message) ?></div>
                </div>
            <?php }
            $output = ob_get_clean();
            
            $result['type'] = 'success';
            $result['message'] = $output;
            $result = json_encode($result);
            echo $result;  
        die();
    }

    public function get_conversation( $conversation_id)  {

        global $wpdb;

        $result  = $wpdb -> get_results( "
        SELECT * FROM `" . $wpdb->prefix . "workscout_core_conversations` 
        WHERE  id = '$conversation_id'

        ");

        return $result;

    }

    public  function get_single_conversation( $user_id, $conversation_id)  {

        global $wpdb;

        $result  = $wpdb -> get_results( "
        SELECT * FROM `" . $wpdb->prefix . "workscout_core_messages` 
        WHERE  conversation_id = '$conversation_id' 
        ORDER BY created_at ASC
        ");

        return $result;

    }

    public function get_conversation_referral( $referral ) {
        if($referral){
            //$referral = $conversation[0]->referral;

            if (strpos($referral, 'listing_') !== false) {

                   $listing_id = str_replace('listing_','',$referral);
                   return get_the_title($listing_id);
            } 
            if (strpos($referral, 'booking_') !== false) {

                   $booking_id = str_replace('booking_','',$referral);
                   $bookings = new Workscout_Core_Bookings_Calendar;
                   $booking_data = $bookings->get_booking($booking_id);
                   $title = get_the_title($booking_data['listing_id']);
                   $status = $booking_data['status'];
                   return __('Reservation for ','workscout_core').$title;
            }
        }
        
    }

    /**
    * Get user conversations
    *
    *
    */
    public  function get_last_message( $conversation)  {

        global $wpdb;

        $result  = $wpdb -> get_results( "
        SELECT * FROM `" . $wpdb->prefix . "workscout_core_messages` 
        WHERE  conversation_id = '$conversation'
        ORDER BY created_at DESC LIMIT 1
        ");

        return $result;

    }

    /**
    * Mark as read
    *
    *
    */
    public  function mark_as_read( $conversation)  {

        global $wpdb;
        
        $conv = $this->get_conversation($conversation);
        
        if($conv[0]->user_1 == get_current_user_id()) {
            $user = 'user_1';
        } else {
            $user = 'user_2';
        }

        $result  = $wpdb->update( 
            $wpdb->prefix . 'workscout_core_conversations', 
            array( 'read_'.$user  => 1 ), 
            array( 'id' => $conversation ) 
        );
        
        return $result;
    }
    /**
    * Mark as unread
    *
    *
    */
    public  function converstation_update_date( $conversation )  {

        global $wpdb;

        $result  = $wpdb->update( 
            $wpdb->prefix . 'workscout_core_conversations', 
            array( 'last_update' => current_time( 'timestamp' ) ), 
            array( 'id' => $conversation ) 
        );
        
        return $result;
    } 

    /**
    * Mark as unread
    *
    *
    */
    public  function mark_as_unread( $user, $conversation)  {

        global $wpdb;
        $result  = $wpdb->update( 
            $wpdb->prefix . 'workscout_core_conversations', 
            array( 'read_'.$user => 0,  'notification' => ''  ), 
            array( 'id' => $conversation )
            
        );
       
        
        return $result;
    }  

    /**
	* Check if read
	*
    *
	*/
	public  function check_if_read( $conversation_data)  {
        $user_id = get_current_user_id();
       
        if(isset($conversation_data)){
            if( (string) $conversation_data[0]->user_1 == $user_id){
                return $conversation_data[0]->read_user_1;
            } else {
                return $conversation_data[0]->read_user_2;
            }
        }
        
    }

    public function conversation_exists($recipient,$referral){
         $user_id = get_current_user_id();
         $conversations = $this->get_conversations($user_id);
         foreach ($conversations as $key => $conv) {
             if($user_id == (string)$conv->user_1 && $recipient == (string)$conv->user_2 && $referral == $conv->referral){
                return $conv->id;
             } elseif ($user_id == $conv->user_2 && $recipient == $conv->user_1  && $referral == $conv->referral) {
                return $conv->id;
            }
         }
         return false;
    }
	/**
	 * User messages shortcode
	 */
	public function workscout_messages( $atts ) {
		
		if ( ! is_user_logged_in() ) {
			return __( 'You need to be signed in to manage your messages.', 'workscout_core' );
		}

		$user_id = get_current_user_id();
	
		extract( shortcode_atts( array(
			'posts_per_page' => '25',
		), $atts ) );
        $limit = 7;
        $page = (isset($_GET['messages-page'])) ? $_GET['messages-page'] : 1;
        
        $offset = ( absint( $page ) - 1 ) * absint( $limit );
        
		ob_start();
		$template_loader = new Workscout_Core_Template_Loader;
        if( isset( $_GET["action"]) && $_GET["action"] == 'view' )  {
            $template_loader->set_template_data( 
                array( 
                    'ids' => $this->get_conversations($user_id) 
                )
            ) -> get_template_part( 'account/single_message' ); 
        } else {
            if( isset( $_GET["action"]) && $_GET["action"] == 'delete' )  {
                if(isset( $_GET["conv_id"]) && !empty($_GET["conv_id"])) {
                    $conv_id = $_GET["conv_id"];
                    $delete = $this->delete_conversations($conv_id);   
                    if($delete) { ?>
                        <div class="notification success"><p><?php esc_html_e('Conversation was removed','workscout_core'); ?></p></div>
                    <?php } else { ?>
                        <div class="notification error"><p><?php esc_html_e('Conversation couldn\'t be removed.','workscout_core'); ?></p></div>
                    <?php }
                } 
            }
            $total = count($this->get_conversations($user_id));
            $max_number_pages = ceil($total/$limit);
            $template_loader->set_template_data( 
                array( 
                    'ids' => $this->get_conversations($user_id,$limit,$offset),
                    'total_pages' => $max_number_pages
                ) 
            ) -> get_template_part( 'account/messages' ); 
        }

		return ob_get_clean();
	}
}