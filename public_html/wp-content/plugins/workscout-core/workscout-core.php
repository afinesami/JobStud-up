<?php
/*
 * Plugin Name: WorkScout-Core - WorkScout WPJM Plugin by Purethemes
 * Version: 1.0.9
 * Plugin URI: http://www.purethemes.net/
 * Description: WPJM Plugin from Purethemes.net for WorkScout theme
 * Author: Purethemes.net
 * Author URI: http://www.purethemes.net/
 * Requires at least: 4.7
 * Tested up to: 5.3
 *
 * Text Domain: workscout_core
 * Domain Path: /languages/
 *
 * @package WordPress
 * @author Lukasz Girek
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'WORKSCOUT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( 'includes/class-workscout-core-admin.php' );
require_once( 'includes/class-workscout-core.php' );



/**
 * Returns the main instance of workscout_core to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object workscout_core
 */
function WorkScout_Core () {
	$instance = WorkScout_Core::instance( __FILE__, '1.2.1' );

	/*if ( is_null( $instance->settings ) ) {
		$instance->settings =  WorkScout_Core_Settings::instance( $instance );
	}*/
	

	return $instance;
}

/* load template engine*/
if ( ! class_exists( 'Gamajo_Template_Loader' ) ) {
	require_once dirname( __FILE__ ) . '/lib/class-gamajo-template-loader.php';
}

include( dirname( __FILE__ ) . '/includes/class-workscout-core-templates.php' );
$GLOBALS['workscout_core'] = WorkScout_Core();



function workscout_core_activity_log() {
	global $wpdb;

	//$wpdb->hide_errors();

	$collate = '';
	if ( $wpdb->has_cap( 'collation' ) ) {
		if ( ! empty( $wpdb->charset ) ) {
			$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
		}
		if ( ! empty( $wpdb->collate ) ) {
			$collate .= " COLLATE $wpdb->collate";
		}
	}

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	/**
	 * Table for user packages
	 */
	$sql = "
	CREATE TABLE {$wpdb->prefix}workscout_core_activity_log (
	  id bigint(20) NOT NULL auto_increment,
	  user_id bigint(20) NOT NULL,
	  post_id  bigint(20) NOT NULL,
	  related_to_id bigint(20) NOT NULL,
	  action varchar(255) NOT NULL,
	  log_time int(11) NOT NULL DEFAULT '0',
	  PRIMARY KEY  (id)
	) $collate;
	";
	
	dbDelta( $sql );

}
register_activation_hook( __FILE__, 'workscout_core_activity_log' );


function workscout_core_messages_db() {
	global $wpdb;

	//$wpdb->hide_errors();

	$collate = '';
	if ( $wpdb->has_cap( 'collation' ) ) {
		if ( ! empty( $wpdb->charset ) ) {
			$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
		}
		if ( ! empty( $wpdb->collate ) ) {
			$collate .= " COLLATE $wpdb->collate";
		}
	}

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	/**
	 * Table for user packages
	 */
	$sql = "
	CREATE TABLE {$wpdb->prefix}workscout_core_messages (
	  id bigint(20) NOT NULL auto_increment,
	  conversation_id bigint(20) NOT NULL,
	  sender_id bigint(20) NOT NULL,
	  message  varchar(255) NOT NULL,
	  created_at bigint(20) NOT NULL,
	  PRIMARY KEY  (id)
	) $collate;
	";
	
	dbDelta( $sql );

}
register_activation_hook( __FILE__, 'workscout_core_messages_db' );

function workscout_core_conversations_db() {
	global $wpdb;

	//$wpdb->hide_errors();

	$collate = '';
	if ( $wpdb->has_cap( 'collation' ) ) {
		if ( ! empty( $wpdb->charset ) ) {
			$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
		}
		if ( ! empty( $wpdb->collate ) ) {
			$collate .= " COLLATE $wpdb->collate";
		}
	}

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	/**
	 * Table for user packages
	 */
	$sql = "
	CREATE TABLE {$wpdb->prefix}workscout_core_conversations (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `timestamp` varchar(255) NOT NULL DEFAULT '',
	  `user_1` int(11) NOT NULL,
	  `user_2` int(11) NOT NULL,
	  `referral` varchar(255) NOT NULL DEFAULT '',
	  `read_user_1` int(11) NOT NULL,
	  `read_user_2` int(11) NOT NULL,
	  `last_update` bigint(20) DEFAULT NULL,
	  `notification` varchar(20) DEFAULT '',
	  PRIMARY KEY  (id)
	) $collate;
	";
	
	dbDelta( $sql );

}
register_activation_hook( __FILE__, 'workscout_core_conversations_db' );


function workscout_core_missing_cmb2() { ?>
	<div class="error">
		<p><?php _e( 'CMB2 Plugin is missing CMB2!', 'workscout_core' ); ?></p>
	</div>
<?php }

if(function_exists('vc_map')) {
    require_once('workscout-core-vc.php');
    //require_once get_template_directory() . '/inc/vc_modified_shortcodes.php';
}

WorkScout_Core();