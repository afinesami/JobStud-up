<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;
/**
 * Workscout_Core_Listing class
 */
class Workscout_Core_Activities_Log {
	
	/**
	 * The single instance of the class.
	 *
	 * @var self
	 * @since  1.26
	 */
	private static $_instance = null;

	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
	 *
	 * @since  1.26
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

		// table is set in liste-core.php
		add_shortcode( 'workscout_activities', array( $this, 'show_activities' ) );

		//hooks
		add_action( 'transition_post_status', array( $this, 'hooks_transition_post_status' ), 10, 3 );
		//add_action( 'delete_post', array( $this, 'hooks_delete_post' ) );
		add_action( 'workscout_job_listing_bookmarked', array( $this, 'add_bookmarked_activity' ), 10, 2 );
		add_action( 'workscout_job_listing_unbookmarked', array( $this, 'add_unbookmarked_activity' ), 10, 2 );
	//	add_action( 'transition_comment_status', array( $this, 'add_review_activity' ), 10, 3 );
		add_action( 'wp_ajax_remove_activity', array( $this, 'remove_activity' ) );
		add_action( 'wp_ajax_remove_all_activities', array( $this, 'remove_all_activities' ) );
	}

	/**
	 * @since 1.0.0
	 * 
	 * @param array $args
	 * @return void
	 */
	public function insert( $args ) {
		global $wpdb;

		$args = wp_parse_args(
			$args,
			array(
				
				'log_time'  => current_time( 'timestamp' ),
			)
		);

		$user = get_user_by( 'id', get_current_user_id() );
		if ( $user ) {	
			if ( empty( $args['user_id'] ) )
				$args['user_id'] = $user->ID;
		} else {
			//guest
			if ( empty( $args['user_id'] ) )
				$args['user_id'] = 0;
		}
		
		
		// Make sure for non duplicate.
		$check_duplicate = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT id FROM {$wpdb->prefix}workscout_core_activity_log
					WHERE 	action = %s
						AND related_to_id = %d
						AND user_id = %d
						AND post_id = %d
						AND log_time = %s
				;",
				$args['action'],
				$args['related_to_id'],
				$args['user_id'],
				$args['post_id'],
				$args['log_time']
			)
		);
		
		if ( $check_duplicate )
			return;

		$wpdb->insert(
			$wpdb->prefix.'workscout_core_activity_log',
			array(
				'action'    	=> $args['action'], // action name
				'related_to_id' => $args['related_to_id'], //ID of user who will se this action
				'user_id'   	=> $args['user_id'], // ID of user who did the action
				'post_id' 		=> $args['post_id'], // ID of object the action was done on
				'log_time'  	=> $args['log_time'], //time of action
				
			),
			array( '%s', '%d', '%d', '%d', '%s',  )
		);

		// Remove old items.
		//$this->_delete_old_items();
		do_action( 'workscout_insert_activity', $args );
	}

	/**
	 * @since 1.0.0
	 * @return void
	 */
	public function erase_all_activities() {
		global $wpdb;
		
		$wpdb->query( "TRUNCATE {$wpdb->prefix}workscout_core_activity_log" );
	}

	public function remove_activity(){
		
		// if ( !wp_verify_nonce( $nonce, 'delete_post-' . $_POST['id'] ) ) :
  //           wp_send_json_error(); 
  //           die();
  //       endif;

		$id = esc_sql($_POST['id']);

		global $wpdb;
		//$wpdb->delete( $wpdb->prefix . 'workscout_core_activity_log', [ 'id' => $id ] );
		$wpdb->query( 
			$wpdb->prepare( 
				"DELETE FROM {$wpdb->prefix}workscout_core_activity_log
				 WHERE id = %d
				",
			        $id
		        )
		);
		wp_send_json_success(array( 'success' => true ));
		die();
	}

	public function remove_all_activities(){
		
		// if ( !wp_verify_nonce( $nonce, 'delete_post-' . $_POST['id'] ) ) :
  //           wp_send_json_error(); 
  //           die();
  //       endif;
		$current_user = wp_get_current_user();	
		$id = $current_user->ID;

		global $wpdb;
		//$wpdb->delete( $wpdb->prefix . 'workscout_core_activity_log', [ 'id' => $id ] );
		$wpdb->query( 
			$wpdb->prepare( 
				"DELETE FROM {$wpdb->prefix}workscout_core_activity_log
				 WHERE related_to_id = %d
				",
			        $id
		        )
		);
		wp_send_json_success(array( 'success' => true ));
		die();
	}

	public function show_activities( $atts ){
		
		extract( shortcode_atts( array(
			'items_per_page' => '5',
		), $atts ) );

		global $wpdb;

		$current_user = wp_get_current_user();	 
		$user_id = $current_user->ID;
		$paged = (isset($_GET['activity_paged'])) ? $_GET['activity_paged'] : 1;
		
		$offset = ($paged - 1) *$items_per_page;
		
		
		$items = $wpdb->get_results( $wpdb->prepare(
			'SELECT * FROM '.$wpdb->prefix.'workscout_core_activity_log
					WHERE related_to_id = '.$user_id.'
					ORDER BY  log_time DESC
					LIMIT  %d , %d;',
			$offset, $items_per_page
		) );

		$rowcount = $wpdb->get_var(
			
			'SELECT COUNT(*) FROM '.$wpdb->prefix.'workscout_core_activity_log
					WHERE related_to_id = '.$user_id.'
					ORDER BY  log_time DESC'
			
			);
		$max_num_pages = ceil($rowcount / $items_per_page);		 
		
		
		ob_start(); ?>

			<ul id="workscout-activities-list">
				<?php

				if($items) :

					foreach ($items as $item) { 
					
					$post_title = get_the_title( $item->post_id );
					$post_url	= get_permalink( $item->post_id );
					$start = '<li>';
					$nonce = wp_create_nonce( 'delete_activity-' . $item->post_id  );
					$end = '<span class="activity-time">'.human_time_diff( $item->log_time, current_time('timestamp') ) . esc_html__(' ago','workscout_core').'</span>';
					$end .= '<a href="#" data-nonce="'.$nonce.'" data-id="'.$item->id.'" class="close-list-item"><i class="fa fa-close"></i></a></li>';
					
					switch ($item->action) {
							case 'bookmarked':
								echo $start.'
									<i class="list-box-icon fa fa-star"></i> '.esc_html__('Someone bookmarked your ','workscout_core').' <strong><a href="'.esc_url($post_url).'">'.$post_title.'</a></strong> '.__('listing','workscout_core').'!
								'.$end;
								break;

							case 'unbookmarked':
								echo $start.'
									<i class="list-box-icon fa fa-star-o"></i> '.esc_html__('Someone unbookmarked your','workscout_core').' <strong><a href="'.esc_url($post_url).'">'.$post_title.'</a></strong> '.__('listing','workscout_core').'
								'.$end;
								break;

							case 'listing_updated':
								echo $start.'
									<i class="list-box-icon fa fa-floppy-o"></i> '.esc_html__('Listing','workscout_core').' <strong><a href="'.esc_url($post_url).'">'.$post_title.'</a></strong> '.esc_html__('was updated','workscout_core').'.
								'.$end;
								break;
							case 'listing_created':
								echo $start.'
									<i class="list-box-icon fa fa-file-text-o"></i> '.esc_html__('Listing','workscout_core').' <strong><a href="'.esc_url($post_url).'">'.$post_title.'</a></strong> '.esc_html__('was created.','workscout_core').$end;
								break;
							case 'listing_approved':
								echo $start.'
									<i class="list-box-icon fa fa-check"></i>'.esc_html__('Your Listing','workscout_core').' <strong><a href="'.esc_url($post_url).'">'.$post_title.'</a></strong> '.esc_html__('was approved','workscout_core').'
								'.$end;
								break;
							case 'listing_trashed':
								echo $start.'
									<i class="list-box-icon fa fa-trash"></i> '.esc_html__('Listing','workscout_core').' <strong><a href="'.esc_url($post_url).'">'.$post_title.'</a></strong> '.esc_html__('was removed','workscout_core').'
								'.$end;
								break;

							case 'approved':
								echo '
								<li>
									<i class="list-box-icon fa-file-text-o"></i> '.esc_html__('Your Listing','workscout_core').' <strong><a href="'.esc_url($post_url).'">'.$post_title.'</a></strong> '.esc_html__('has been approved!','workscout_core').'
									<a href="#" class="close-list-item"><i class="fa fa-close"></i></a>
								</li>';
								break;
							case 'added':
								echo '
								<li>
									<i class="list-box-icon fa-file-text-o"></i> '.esc_html__('You have added listing','workscout_core').' <strong><a href="'.esc_url($post_url).'">'.$post_title.'</a></strong> 
									<a href="#" class="close-list-item"><i class="fa fa-close"></i></a>
								</li>';
								break;
							case 'applied':
								echo '
								<li>
									<i class="list-box-icon fa-file-text-o"></i> '.esc_html__('Someone applied to your job ','workscout_core').' <strong><a href="'.esc_url($post_url).'">'.$post_title.'</a></strong> 
									<a href="#" class="close-list-item"><i class="fa fa-close"></i></a>
								</li>';
								break;

						
							default:
								# code...
								break;
						} 
					}
					echo '<li style="display:none;" class="no-icon cleared">'.esc_html__("You don't have any activities logged yet.",'workscout_core').'</li>';
				else : ?>
					<li class="no-icon"><?php esc_html_e("You don't have any activities logged yet.",'workscout_core') ?></li>
				<?php endif; ?>
			</ul>
		</div>
		<div class="clearfix"></div>
		<?php if($max_num_pages > 1) : ?>
			<div class="pagination-container margin-top-30 margin-bottom-0">
				<nav class="pagination">
				<?php 
				$big = 999999999; 
				echo paginate_links( array(
					'base'         => add_query_arg('activity_paged','%#%'),
					'format' => '?activity_paged=%#%',
					'current' => max( 1, $paged ),
					'total' => $max_num_pages,
					'type' => 'list',
					'prev_next'    => true,
			        'prev_text'    => '<i class="sl sl-icon-arrow-left"></i>',
			        'next_text'    => '<i class="sl sl-icon-arrow-right"></i>',
			         'add_args'        => false,
   					 'add_fragment'    => ''
				    
				) );?>
				</nav>
			</div>	
		<?php endif; ?>

		<?php return ob_get_clean();
	}


	//hooks
	public function hooks_transition_post_status( $new_status, $old_status, $post ) {
		if ( 'job_listing' !== get_post_type( $post->ID ) )
			return;
		$action = '';
		if( 'preview' === $old_status && 'publish' == $new_status ) {
			$action = 'listing_created';
		} elseif ( 'preview' === $old_status && 'pending_payment' == $new_status ){
			$action = 'listing_created';
		} elseif ( 'pending' === $old_status && 'publish' == $new_status ){
			$action = 'listing_approved';
		} elseif ( 'trash' === $new_status ) {
			// page was deleted.
			$action = 'listing_trashed';
		} elseif ( 'trash' === $old_status ) {
		 	$action = 'listing_restored';
		} elseif ('publish' == $old_status ) {
			$action = 'listing_updated';
		}
		// if ( 'auto-draft' === $old_status && ( 'auto-draft' !== $new_status && 'inherit' !== $new_status ) ) {
		// 	// page created
		// 	$action = 'listing_created';
		// }
		// elseif ( 'auto-draft' === $new_status || ( 'new' === $old_status && 'inherit' === $new_status ) ) {
		// 	// nvm.. ignore it.
		// 	return;
		// }
		// elseif ( 'trash' === $new_status ) {
		// 	// page was deleted.
		// 	$action = 'listing_trashed';
		// }
		// elseif ( 'trash' === $old_status ) {
		// 	$action = 'listing_restored';
		// }
		// else {
		// 	// page updated. I guess.
		// 	$action = 'listing_updated';
		// }

		if ( wp_is_post_revision( $post->ID ) )
			return;

		// Skip for menu items.
		
		if($action) {
			workscout_insert_log(
				array(
					'action' => $action,
					'related_to_id' => get_post_field( 'post_author', $post->ID ),
					'user_id' => '',
					'post_id' => $post->ID,
					
				)
			);	
		}
		
	}

	public function add_bookmarked_activity( $post_id, $user_id ){

		workscout_insert_log(
			array(
				'action' => "bookmarked",
				'related_to_id' => get_post_field( 'post_author', $post_id ),
				'user_id' => $user_id,
				'post_id' => $post_id,
				
			)
		);

	}	

	public function add_unbookmarked_activity( $post_id, $user_id ){

		workscout_insert_log(
			array(
				'action' => "unbookmarked",
				'related_to_id' => get_post_field( 'post_author', $post_id ),
				'user_id' => $user_id,
				'post_id' => $post_id,
				
			)
		);

	}





}


function workscout_insert_log( $args = array() ) {
	Workscout_Core_Activities_Log::instance()->insert( $args );
}