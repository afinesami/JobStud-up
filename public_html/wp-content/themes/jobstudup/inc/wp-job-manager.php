<?php 


add_post_type_support( 'job_listing', 'excerpt' );
add_post_type_support( 'resume', 'excerpt' );

function workscout_job_manager_output_jobs_defaults( $defaults ) {
        $job_page = get_option('job_manager_jobs_page_id');
		if(!empty($job_page) && is_page($job_page)){
        	$defaults[ 'show_filters' ] = false;
        }
        return $defaults;
    }
add_filter( 'job_manager_output_jobs_defaults','workscout_job_manager_output_jobs_defaults');


remove_shortcode('jobs');
remove_shortcode('resumes');


/* sending user to sign up to Login page if exists */
add_filter( 'submit_job_form_login_url', 'workscout_custom_login_url' );
add_filter( 'job_manager_job_dashboard_login_url', 'workscout_custom_login_url' );
add_filter( 'submit_resume_form_login_url', 'workscout_custom_login_url' );
add_filter( 'resume_manager_candidate_dashboard_login_url', 'workscout_custom_login_url' );
add_filter( 'job_manager_alerts_login_url', 'workscout_custom_login_url' );
add_filter( 'job_manager_bookmark_form_login_url', 'workscout_custom_login_url' );
add_filter( 'job_manager_job_applications_login_required_message', 'workscout_custom_login_url' );

 
function workscout_custom_login_url() {

	$login_page = get_option('workscout_dashboard_page');
	if(empty($login_page)){
		$login_page = wp_login_url( get_permalink() );
	}
	
	
	return get_permalink($login_page);

}
	
/*remove bookmarks link*/
if ( class_exists( 'WP_Job_Manager_Bookmarks' ) ) {
	global $job_manager_bookmarks;
	remove_action( 'single_job_listing_meta_after', array( $job_manager_bookmarks, 'bookmark_form' ) );
	remove_action( 'single_resume_start', array( $job_manager_bookmarks, 'bookmark_form' ) );

	add_action( 'workscout_bookmark_hook', array( $job_manager_bookmarks, 'bookmark_form' ) );
	add_action( 'workscout_bookmark_hook', array( $job_manager_bookmarks, 'bookmark_form' ) );
}

/* register with role */

add_action( 'register_form', 'workscout_register_form' );
function workscout_register_form() {
	$role_status  = Kirki::get_option( 'workscout','pp_singup_role_status', false);
	$role_revert  = Kirki::get_option( 'workscout','pp_singup_role_revert', false);
	if(!$role_status) {
	    global $wp_roles;
	    echo '<label for="user_email">'.esc_html__('I want to register as','workscout').'</label>';
	    echo '<select name="role" class="input chosen-select">';
	    if($role_revert){
	    echo '<option value="candidate">'.esc_html__("Candidate","workscout").'</option>';
	    }
	    echo '<option value="employer">'.esc_html__("Employer","workscout").'</option>';
	    if(!$role_revert){
	    	echo '<option value="candidate">'.esc_html__("Candidate","workscout").'</option>';
        }
   
	    echo '</select>';
    }
}


//2. Add validation.
add_filter( 'registration_errors', 'workscout_registration_errors', 10, 3 );
function workscout_registration_errors( $errors, $sanitized_user_login, $user_email ) {

    if ( empty( $_POST['role'] ) || ! empty( $_POST['role'] ) && trim( $_POST['role'] ) == '' ) {
         $errors->add( 'role_error', esc_html__( '<strong>ERROR</strong>: You must include a role.', 'workscout' ) );
    }

    return $errors;
}

//3. Finally, save our extra registration user meta.
add_action( 'user_register', 'workscout_user_register' );
function workscout_user_register( $user_id ) {

	if(isset($_POST['role'])){
			$role = $_POST['role'];
			if(!in_array($role,array('employer','candidate'))){
	    		$role = get_option('default_role');	
	    	}
   			
   			$user_id = wp_update_user( array( 'ID' => $user_id, 'role' => $role ) );
   	}
}


// Add comment support to the post type
add_filter( 'register_post_type_resume', 'register_post_type_resume_enable_comments' );

function register_post_type_resume_enable_comments( $post_type ) {
	$post_type['supports'][] = 'comments';
	return $post_type;
}





function custom_job_manager_get_listings_result($result, $jobs) {
	$result['post_count'] = $jobs->found_posts;
	return $result;
}
add_filter( 'job_manager_get_listings_result', 'custom_job_manager_get_listings_result',10,2 );



function custom_default_company_logo($logo_url) {
	$image =  Kirki::get_option( 'workscout','pp_jobs_default_image_upload', '');
	if($image){
		return $image;
	}
	return $logo_url;
}
add_filter('job_manager_default_company_logo', 'custom_default_company_logo');

/*
function has_active_job_package_capability_check( $allcaps, $cap, $args ) {
	// Only interested in has_active_job_package
	if ( empty( $cap[0] ) || $cap[0] !== 'has_active_job_package' || ! function_exists( 'wc_paid_listings_get_user_packages' ) ) {
		return $allcaps;
	}

	$user_id  = $args[1];
	$packages = wc_paid_listings_get_user_packages( $user_id, 'job_listing' );

	// Has active package
	if ( is_array( $packages ) && sizeof( $packages ) > 0 ) {
		$allcaps[ $cap[0] ] = true;
	}

	return $allcaps;
}

add_filter('job_manager_candidates_can_apply','block_applying');
function block_applying($can_apply ){
	if(current_user_can( 'has_active_job_package' )) {
		$can_apply = true;
	} else {
		$can_apply = false;
	}
	return $can_apply;

}*/


// add_filter( 'job_manager_geolocation_endpoint', 'workscout_add_geolocation_key_to_endpoint' ); 
// function workscout_add_geolocation_key_to_endpoint( $endpoint ) { 

// 	$api_key = Kirki::get_option( 'workscout','pp_maps_browser_api', '');
// 	if(!empty($api_key)) {
// 		$endpoint = add_query_arg( 'key', $api_key, $endpoint ); 
// 		$endpoint = str_ireplace('http:', 'https:', $endpoint);
// 	}
// 	return $endpoint; 
// }

?>
