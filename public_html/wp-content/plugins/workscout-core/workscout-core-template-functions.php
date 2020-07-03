<?php
/**
 * Template Functions
 *
 * Template functions for listings
 *
 * @author 		Lukasz Girek
 * @version     1.0
 */


/**
 * Add custom body classes
 */
function workscout_core_body_class( $classes ) {
	$classes   = (array) $classes;
	$classes[] = sanitize_title( wp_get_theme() );

	return array_unique( $classes );
}

add_filter( 'body_class', 'workscout_core_body_class' );


add_action( 'wpjm_notify_new_user', 'workscout_wp_job_manager_notify_new_user', 10, 3 );

function workscout_wp_job_manager_notify_new_user( $user_id, $password, $new_user ) {
    if( function_exists('workscout_core_get_option') && get_option('workscout_submit_display',true) ) {
            $login_url = get_permalink( workscout_core_get_option( 'workscout_profile_page' ) );
        } else {
            $login_url = wp_login_url();
        }

        $user = get_user_by( 'id', $user_id );
        $user_login = stripslashes($user->user_login);
        $user_email = stripslashes($user->user_email);
        if(empty($password)){
            $password = $new_user['user_pass'];
        }
        $mail_args = array(
            'email'         => $user_email,
            'login'         => $user_login,
            'password'      => $password,
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'display_name'  => $user->display_name,
            'login_url'     => $login_url,
            );
        do_action('workscout_welcome_mail',$mail_args);
        wp_new_user_notification( $user_id, null, 'admin' );
}

function wp_job_manager_notify_new_user( $user_id, $password ) {
    // global $wp_version;

    // if ( version_compare( $wp_version, '4.3.1', '<' ) ) {
    //     // phpcs:ignore WordPress.WP.DeprecatedParameters.Wp_new_user_notificationParam2Found
    //     wp_new_user_notification( $user_id, $password );
    // } else {

            
    //     if( function_exists('workscout_core_get_option') && get_option('workscout_submit_display',true) ) {
    //         $login_url = get_permalink( workscout_core_get_option( 'workscout_profile_page' ) );
    //     } else {
    //         $login_url = wp_login_url();
    //     }

    //     $user = get_user_by( 'id', $user_id );
    //     $user_login = stripslashes($user->user_login);
    //     $user_email = stripslashes($user->user_email);
        
    //     $mail_args = array(
    //         'email'         => $user_email,
    //         'login'         => $user_login,
    //         'password'      => $password,
    //         'first_name'    => $user->first_name,
    //         'last_name'     => $user->last_name,
    //         'display_name'  => $user->display_name,
    //         'login_url'     => $login_url,
    //         );
    //     do_action('workscout_welcome_mail',$mail_args);
    //     wp_new_user_notification( $user_id, null, 'admin' );
    // }
}

// used for tracking error messages
function workscout_form_errors(){
    static $wp_error; // Will hold global variable safely
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

function workscout_show_error_messages() {
    if($codes = workscout_form_errors()->get_error_codes()) {
        echo '<div class="notification closeable error">';
            // Loop error codes and display errors
           foreach($codes as $code){
                $message = workscout_form_errors()->get_error_message($code);
                echo '<span class="error">' . $message . '</span><br/>';
            }
        echo '</div>';
    }   
}


    function workscout_get_unread_counter(){
        $user_id = get_current_user_id();
         global $wpdb;

        $result_1  = $wpdb -> get_var( "
        SELECT COUNT(*) FROM `" . $wpdb->prefix . "workscout_core_conversations` 
        WHERE  user_1 = '$user_id' AND read_user_1 = 0
        ");
        $result_2  = $wpdb -> get_var( "
        SELECT COUNT(*) FROM `" . $wpdb->prefix . "workscout_core_conversations` 
        WHERE  user_2 = '$user_id' AND read_user_2 = 0
        ");
        return $result_1+$result_2;
    }


/*
 * Helpers
 */
function workscout_string_to_bool( $value ) {
    return ( is_bool( $value ) && $value ) || in_array( $value, array( '1', 'true', 'yes' ) ) ? true : false;
}

function workscout_partition( $list, $p ) {
    $listlen = count( $list );
    $partlen = floor( $listlen / $p );
    $partrem = $listlen % $p;
    $partition = array();
    $mark = 0;
    for ($px = 0; $px < $p; $px++) {
        $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
        $partition[$px] = array_slice( $list, $mark, $incr );
        $mark += $incr;
    }
    return $partition;
}


/**
 * Gets a number of posts and displays them as options
 * @param  array $query_args Optional. Overrides defaults.
 * @return array             An array of options that matches the CMB2 options array
 */
function workscout_core_get_post_options( $query_args ) {

    $args = wp_parse_args( $query_args, array(
        'post_type'   => 'post',
        'numberposts' => -1,
    ) );

    $posts = get_posts( $args );

    $post_options = array();
    $post_options[0] = esc_html__('--Choose page--','workscout_core');
    if ( $posts ) {
        foreach ( $posts as $post ) {
          $post_options[ $post->ID ] = $post->post_title;
        }
    }

    return $post_options;
}

/**
 * Gets 5 posts for your_post_type and displays them as options
 * @return array An array of options that matches the CMB2 options array
 */
function workscout_core_get_pages_options() {
    return workscout_core_get_post_options( array( 'post_type' => 'page', ) );
}


if(!function_exists('ws_job_location')) :
function ws_job_location(  $map_link = true, $post = null  ) {
    if(!$post) { global $post; }
    if ( get_option( 'job_manager_enable_regions_filter' ) && class_exists('Astoundify_Job_Manager_Regions') ) {
        if ( is_singular( 'job_listing' ) &&  false != get_the_term_list( $post->ID, 'job_listing_region' )  ) {
            echo get_the_term_list( $post->ID, 'job_listing_region', '', ', ', '' );
        } else {
            
            $terms = wp_get_object_terms( $post->ID, 'job_listing_region', array( 'orderby' => 'term_order', 'order' => 'desc') );
            if ( ! empty( $terms ) ) {
                if ( ! is_wp_error( $terms ) ) 
                    $resultstr = array();{
                    if ( $map_link ) {
                        foreach( $terms as $term ) {
                            $resultstr[] = ' <a href="' . get_term_link( $term->slug, 'job_listing_region' ) . '">' . esc_html( $term->name ) . '</a>'; 
                        }
                    } else {
                        foreach( $terms as $term ) {
                            $resultstr[] = ' '. esc_html( $term->name ); 
                        }
                    }
                    $result = implode(",",$resultstr);
                    echo $result;
                    
                }
            } else {
                $location = get_post_meta($post->ID, '_job_location', TRUE); 

                if ( $location ) {
                    if ( $map_link ) {
                        // If linking to google maps, we don't want anything but text here
                        echo apply_filters( 'the_job_location_map_link', '<a class="google_map_link" href="' . esc_url( 'http://maps.google.com/maps?q=' . urlencode( strip_tags( $location ) ) . '&zoom=14&size=512x512&maptype=roadmap&sensor=false' ) . '" target="_blank">' . esc_html( strip_tags( $location ) ) . '</a>', $location, $post );
                    } else {
                        echo wp_kses_post( $location );
                    }
                } else {
                    echo wp_kses_post( apply_filters( 'the_job_location_anywhere_text', __( 'Anywhere', 'wp-job-manager' ) ) );
                }
            }
        }

    } else {
        $location = get_the_job_location( $post );

        if ( $location ) {
            if ( $map_link ) {
                // If linking to google maps, we don't want anything but text here
                echo apply_filters( 'the_job_location_map_link', '<a class="google_map_link" href="' . esc_url( 'http://maps.google.com/maps?q=' . urlencode( strip_tags( $location ) ) . '&zoom=14&size=512x512&maptype=roadmap&sensor=false' ) . '" target="_blank">' . esc_html( strip_tags( $location ) ) . '</a>', $location, $post );
            } else {
                echo wp_kses_post( $location );
            }
        } else {
            echo wp_kses_post( apply_filters( 'the_job_location_anywhere_text', __( 'Anywhere', 'wp-job-manager' ) ) );
        }
    }
}
endif;


function ws_get_job_types($post){
    ob_start();
    if ( get_option( 'job_manager_enable_types' ) ) {
    $types = get_the_terms( $post->ID, 'job_listing_type' );
        if ( $types && ! is_wp_error( $types ) ) : 
            foreach ( $types as $type ) { ?><span class="job-type <?php echo sanitize_title( $type->slug ); ?>"><?php echo $type->name; ?></span><?php } 
        endif;
    }
    $result = ob_get_clean();
    return $result;
}

function ws_get_candidate_skills($post){
    ob_start();
    if ( ( $skills = wp_get_object_terms( $post->ID, 'resume_skill', array( 'fields' => 'names' ) ) ) && is_array( $skills ) ) : ?>
        <div class="skills"><?php echo '<span>' . implode( '</span><span>', $skills ) . '</span>'; ?></div><div class="clearfix"></div>
    <?php endif; 
    $result = ob_get_clean();
    return $result;
}

function ws_get_job_rate($post) {
    ob_start();
    $currency_position =  get_option('workscout_currency_position','before');
    $job_meta = Kirki::get_option( 'workscout','pp_meta_job_list',array('company','location','rate','salary') ); 
    $rate_min = get_post_meta( $post->ID, '_rate_min', true ); 
    if ( $rate_min && in_array("rate", $job_meta)) { 
        $rate_max = get_post_meta( $post->ID, '_rate_max', true );  ?><li><i class="ln ln-icon-Money-2"></i>  <?php 
            if( $currency_position == 'before' ) { 
                echo get_workscout_currency_symbol(); 
            } 
            echo esc_html( $rate_min ); 
            if( $currency_position == 'after' ) { 
                echo get_workscout_currency_symbol(); 
            }
            if(!empty($rate_max)) { 
                echo '- ';
                if( $currency_position == 'before' ) { 
                    echo get_workscout_currency_symbol(); 
                }   
                echo $rate_max;
                if( $currency_position == 'after' ) { 
                    echo get_workscout_currency_symbol(); 
                } 
            } ?> <?php esc_html_e('/ hour','workscout_core'); ?>
        </li><?php } 
    $result = ob_get_clean();
    return $result;
}


function ws_get_candidate_rate($post) {
    ob_start();
    $currency_position =  get_option('workscout_currency_position','before');
    $rate_min = get_post_meta( $post->ID, '_rate_min', true ); 
    if ( $rate_min ) { 
        
           ?><li><i class="ln ln-icon-Money-2"></i>  <?php 
            if( $currency_position == 'before' ) { 
                echo get_workscout_currency_symbol(); 
            } 
            echo esc_html( $rate_min ); 
            if( $currency_position == 'after' ) { 
                echo get_workscout_currency_symbol(); 
            }
            esc_html_e('/ hour','workscout_core'); ?>
        </li><?php } 
    $result = ob_get_clean();
    return $result;
}


function ws_get_job_salary($post) {
    ob_start();
    $currency_position =  get_option('workscout_currency_position','before');
    $job_meta = Kirki::get_option( 'workscout','pp_meta_job_list',array('company','location','rate','salary') ); 
    $salary_min = get_post_meta( $post->ID, '_salary_min', true ); 
    $salary_max = get_post_meta( $post->ID, '_salary_max', true );
    if( in_array("salary", $job_meta) ) :
        if ( !empty($salary_min) || !empty($salary_max)  ) { ?><li><i class="ln ln-icon-Money-2"></i> 
                <?php 
                if ( $salary_min ) { 
                    if( $currency_position == 'before' ) { 
                        echo get_workscout_currency_symbol(); 
                    }   
                    echo esc_html( $salary_min ); 
                    if( $currency_position == 'after' ) { 
                        echo get_workscout_currency_symbol(); 
                    }
                } 
                if($salary_max) { if ( $salary_min ) { echo ' - '; } 
                    if( $currency_position == 'before' ) { 
                        echo get_workscout_currency_symbol(); 
                    } 
                    echo $salary_max;
                    if( $currency_position == 'after' ) { 
                        echo get_workscout_currency_symbol(); 
                    }
                } ?>
            </li><?php } 
    endif; 
    
    $result = ob_get_clean();
    return $result;
}

if(!function_exists('ws_candidate_location')) :
function ws_candidate_location(  $map_link = true, $post = null  ) {
    if(!$post) { global $post; }
    if ( class_exists('Astoundify_Job_Manager_Regions') && get_option( 'resume_manager_enable_regions_filter' ) ) {
        if ( is_singular( 'resume' ) &&  false != get_the_term_list( $post->ID, 'resume_region' )  ) {
            echo get_the_term_list( $post->ID, 'resume_region', '', ', ', '' );
        } else {
            
            $terms = wp_get_object_terms( $post->ID, 'resume_region', array( 'orderby' => 'term_order', 'order' => 'desc') );
            if ( ! empty( $terms ) ) {
                if ( ! is_wp_error( $terms ) ) 
                    $resultstr = array();{
                    if ( $map_link ) {
                        foreach( $terms as $term ) {
                            $resultstr[] = ' <a href="' . get_term_link( $term->slug, 'resume_region' ) . '">' . esc_html( $term->name ) . '</a>'; 
                        }
                    } else {
                        foreach( $terms as $term ) {
                            $resultstr[] = ' '. esc_html( $term->name ); 
                        }
                    }
                    $result = implode(",",$resultstr);
                    echo $result;
                    
                }
            } else {
                $location = get_post_meta($post->ID, '_candidate_location', TRUE); 

                if ( $location ) {
                    if ( $map_link ) {
                        // If linking to google maps, we don't want anything but text here
                        echo apply_filters( 'the_candidate_location_map_link', '<a class="google_map_link candidate-location" href="http://maps.google.com/maps?q=' . urlencode( $location ) . '&zoom=14&size=512x512&maptype=roadmap&sensor=false">' . $location . '</a>', $location, $post );
                    } else {
                        echo wp_kses_post( $location );
                    }
                } 
            }
        }

    } else {
        $location = get_the_candidate_location( $post );

        if ( $location ) {
            if ( $map_link ) {
                // If linking to google maps, we don't want anything but text here
                echo apply_filters( 'the_candidate_location_map_link', '<a class="google_map_link candidate-location" href="http://maps.google.com/maps?q=' . urlencode( $location ) . '&zoom=14&size=512x512&maptype=roadmap&sensor=false">' . $location . '</a>', $location, $post );
            } else {
                echo wp_kses_post( $location );
            }
        } 
    }
}
endif;


// function to geocode address, it will return false if unable to geocode address
function workscout_geocode($address){
 
    // url encode the address
    $address = urlencode($address);
    $api_key = get_option('workscout_maps_api_server');
    if( empty($api_key) ){
        $api_key = get_option( 'job_manager_google_maps_api_key' );
    }

    // google map geocode api url
    $limit_country = get_option( 'workscout_maps_limit_country');
    
    if($limit_country) {
        $url = "https://maps.google.com/maps/api/geocode/json?address={$address}&key={$api_key}&components=country:".$limit_country;
    } else {
        $url = "https://maps.google.com/maps/api/geocode/json?address={$address}&key={$api_key}";
    }
    // get the json response
    // get the json response
    $resp_json = wp_remote_get($url);

    $file = 'wp-content/geocode.txt';
    //file_put_contents($file, $resp_json);
    // decode the json
    
 
    $resp_json = wp_remote_get($url);
    $resp = json_decode( wp_remote_retrieve_body( $resp_json ), true );
 

    // response status will be 'OK', if able to geocode given address 
    if($resp['status']=='OK'){
 
        // get the important data
        $lati = $resp['results'][0]['geometry']['location']['lat'];
        $longi = $resp['results'][0]['geometry']['location']['lng'];
        $formatted_address = $resp['results'][0]['formatted_address'];
         
        // verify if data is complete
        if($lati && $longi && $formatted_address){
         
            // put the data in the array
            $data_arr = array();            
             
            array_push(
                $data_arr, 
                    $lati, 
                    $longi, 
                    $formatted_address
                );
             
            return $data_arr;
             
        }else{
            return false;
        }
         
    }else{
        return false;
    }
}



 function workscout_get_company_link( $company_name ) {
        global $wp_rewrite;
        $slug = apply_filters( 'wp_job_manager_companies_company_slug', __( 'company', 'workscout_core' ) );
        $company_name = rawurlencode( $company_name );

        if ( $wp_rewrite->permalink_structure == '' ) {
            $url = home_url( 'index.php?'. $slug . '=' . $company_name );
        } else {
            $url = home_url( '/' . $slug . '/' . trailingslashit( $company_name ) );
        }

        return '<a href="'.esc_url( $url ).'">';
    }



if(!function_exists('workscout_newly_posted')) {
    function workscout_newly_posted() {
        global $post;
        $now = date('U'); $published = get_the_time('U');
        $new = false;
        // set to 48 hours in seconds 
        if( $now-$published  <= 2*24*60*60 ) $new = true;
        return $new;
    }
}



function workscout_get_rating_class($average) {
    if(!$average) {
            $class="no-stars";
    } else {
        switch ($average) {
            
            case $average >= 1 && $average < 1.5:
                $class="one-stars";
                break;
            case $average >= 1.5 && $average < 2:
                $class="one-and-half-stars";
                break;
            case $average >= 2 && $average < 2.5:
                $class="two-stars";
                break;
            case $average >= 2.5 && $average < 3:
                $class="two-and-half-stars";
                break;
            case $average >= 3 && $average < 3.5:
                $class="three-stars";
                break;
            case $average >= 3.5 && $average < 4:
                $class="three-and-half-stars";
                break;
            case $average >= 4 && $average < 4.5:
                $class="four-stars";
                break;
            case $average >= 4.5 && $average < 5:
                $class="four-and-half-stars";
                break;
            case $average >= 5:
                $class="five-stars";
                break;

            default:
                $class="no-stars";
                break;
        }
    }
    return $class;
    }

function get_workscout_currency_symbol( $currency = '' ) {
    if ( ! $currency ) {
        $currency = get_option('workscout_currency_setting');
    }

    switch ( $currency ) {
        case 'BHD' :
            $currency_symbol = '.د.ب';
            break;
        case 'AED' :
            $currency_symbol = 'د.إ';
            break;
        case 'AUD' :
        case 'ARS' :
        case 'CAD' :
        case 'CLP' :
        case 'COP' :
        case 'HKD' :
        case 'MXN' :
        case 'NZD' :
        case 'SGD' :
        case 'USD' :
            $currency_symbol = '&#36;';
            break;
        case 'BDT':
            $currency_symbol = '&#2547;&nbsp;';
            break;
        case 'LKR':
            $currency_symbol = '&#3515;&#3540;&nbsp;';
            break;
        case 'BGN' :
            $currency_symbol = '&#1083;&#1074;.';
            break;
        case 'BRL' :
            $currency_symbol = '&#82;&#36;';
            break;
        case 'CHF' :
            $currency_symbol = '&#67;&#72;&#70;';
            break;
        case 'CNY' :
        case 'JPY' :
        case 'RMB' :
            $currency_symbol = '&yen;';
            break;
        case 'CZK' :
            $currency_symbol = '&#75;&#269;';
            break;
        case 'DKK' :
            $currency_symbol = 'DKK';
            break;
        case 'DOP' :
            $currency_symbol = 'RD&#36;';
            break;
        case 'EGP' :
            $currency_symbol = 'EGP';
            break;
        case 'EUR' :
            $currency_symbol = '&euro;';
            break;
        case 'GBP' :
            $currency_symbol = '&pound;';
            break;
        case 'HRK' :
            $currency_symbol = 'Kn';
            break;
        case 'HUF' :
            $currency_symbol = '&#70;&#116;';
            break;
        case 'IDR' :
            $currency_symbol = 'Rp';
            break;
        case 'ILS' :
            $currency_symbol = '&#8362;';
            break;
        case 'INR' :
            $currency_symbol = 'Rs.';
            break;
        case 'ISK' :
            $currency_symbol = 'Kr.';
            break;
        case 'KIP' :
            $currency_symbol = '&#8365;';
            break;
        case 'KRW' :
            $currency_symbol = '&#8361;';
            break;
        case 'MYR' :
            $currency_symbol = '&#82;&#77;';
            break;
        case 'NGN' :
            $currency_symbol = '&#8358;';
            break;
        case 'NOK' :
            $currency_symbol = '&#107;&#114;';
            break;
        case 'NPR' :
            $currency_symbol = 'Rs.';
            break;
        case 'PHP' :
            $currency_symbol = '&#8369;';
            break;
        case 'PLN' :
            $currency_symbol = '&#122;&#322;';
            break;
        case 'PYG' :
            $currency_symbol = '&#8370;';
            break;
        case 'RON' :
            $currency_symbol = 'lei';
            break;
        case 'RUB' :
            $currency_symbol = '&#1088;&#1091;&#1073;.';
            break;
        case 'SEK' :
            $currency_symbol = '&#107;&#114;';
            break;
        case 'THB' :
            $currency_symbol = '&#3647;';
            break;
        case 'TRY' :
            $currency_symbol = '&#8378;';
            break;
        case 'TWD' :
            $currency_symbol = '&#78;&#84;&#36;';
            break;
        case 'UAH' :
            $currency_symbol = '&#8372;';
            break;
        case 'VND' :
            $currency_symbol = '&#8363;';
            break;
        case 'ZAR' :
            $currency_symbol = '&#82;';
            break;
        case 'ZMK' :
            $currency_symbol = 'ZK';
            break;
        default :
            $currency_symbol = '';
            break;
    }
    

    return apply_filters( 'woocommerce_currency_symbol', $currency_symbol, $currency );
}



function workscout_array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}



function workscout_get_nearby_jobs($lat, $lng, $distance, $radius_type){
    global $wpdb;
    if($radius_type=='km') {
        $ratio = 6371;
    } else {
        $ratio = 3959;
    }

    $post_ids = 
            $wpdb->get_results(
                $wpdb->prepare( "
            SELECT DISTINCT
                    geolocation_lat.post_id,
                    geolocation_lat.meta_key,
                    geolocation_lat.meta_value as jobLat,
                    geolocation_long.meta_value as jobLong,
                    ( %d * acos( cos( radians( %f ) ) * cos( radians( geolocation_lat.meta_value ) ) * cos( radians( geolocation_long.meta_value ) - radians( %f ) ) + sin( radians( %f ) ) * sin( radians( geolocation_lat.meta_value ) ) ) ) AS distance 
               
                FROM 
                    $wpdb->postmeta AS geolocation_lat
                    LEFT JOIN $wpdb->postmeta as geolocation_long ON geolocation_lat.post_id = geolocation_long.post_id
                    WHERE geolocation_lat.meta_key = 'geolocation_lat' AND geolocation_long.meta_key = 'geolocation_long'
                    HAVING distance < %d

            ", 
            $ratio, 
            $lat, 
            $lng, 
            $lat, 
            $distance)
        ,ARRAY_A);
    return $post_ids;
 
}


function workscout_manage_table_icons($val){
    switch ($val) {
        
        case 'resume-title':
            $icon = '<i class="fa fa-user"></i> ';
            break;
        case 'candidate-title':
        case 'job_title':
            $icon = '<i class="fa fa-file-text"></i> ';
            break;
        case 'filled':
            $icon = '<i class="fa fa-check-square-o"></i> ';
            break;
        case 'date':
            $icon = '<i class="fa fa-calendar"></i> ';
            break;
        case 'expires':
            $icon = '<i class="fa fa-calendar"></i> ';
            break;
        case 'candidate-location':
            $icon = '<i class="fa fa-map-marker"></i> ';
            break;
        
        default:
            $icon = '';
            break;
    }
    return $icon;
}

function workscout_manage_action_icons($val){
    switch ($val) {
        
        case 'view':
            $icon = '<i class="fa fa-check-circle-o"></i> ';
            break;  
        case 'email':
            $icon = '<i class="fa fa-envelope"></i> ';
            break;      
        case 'toggle_status':
            $icon = '<i class="fa fa-eye-slash"></i> ';
            break;
        case 'delete':
            $icon = '<i class="fa fa-remove"></i> ';
            break;
        case 'hide':
            $icon = '<i class="fa fa-eye-slash"></i> ';
            break;
        case 'edit':
            $icon = '<i class="fa fa-pencil"></i> ';
            break;
        case 'mark_filled':
            $icon = '<i class="fa  fa-check "></i> ';
            break;      
        case 'publish':
            $icon = '<i class="fa  fa-eye "></i> ';
            break;

        case 'mark_not_filled':
            $icon = '<i class="fa  fa-minus "></i> ';
            break;
        case 'continue':
            $icon = '<i class="fa  fa-play "></i> ';
            break;
        case 'duplicate':
            $icon = '<i class="fa  fa-files-o "></i> ';
            break;
        case 'relist':
            $icon = '<i class="fa  fa-refresh "></i> ';
            break;
        default:
            $icon = '';
            break;
    }
    return $icon;
}


 function workscout_count_posts_by_user($post_author=null,$post_type=array(),$post_status=array()) {
        global $wpdb;

        if(empty($post_author))
            return 0;

        $post_status = (array) $post_status;
        $post_type = (array) $post_type;

        $sql = $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = %d AND ", $post_author );

        //Post status
        if(!empty($post_status)){
            $argtype = array_fill(0, count($post_status), '%s');
            $where = "(post_status=".implode( " OR post_status=", $argtype).') AND ';
            $sql .= $wpdb->prepare($where,$post_status);
        }

        //Post type
        if(!empty($post_type)){
            $argtype = array_fill(0, count($post_type), '%s');
            $where = "(post_type=".implode( " OR post_type=", $argtype).') AND ';
            $sql .= $wpdb->prepare($where,$post_type);
        }

        $sql .='1=1';

        $count = $wpdb->get_var($sql);
        return $count;
    } 

function workscout_count_user_applications($user_id){
    
    global $wpdb;
     //$sql = $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = %d AND ", $post_author );
    //'_candidate_user_id'
    
    $sql = $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->prefix}postmeta WHERE (meta_key = '_candidate_user_id' AND meta_value = %d)",$user_id);
    //write_log("SELECT COUNT(*) FROM {$wpdb->prefix}postmeta WHERE (meta_key = '_candidate_user_id' AND meta_value = 1)");
    
    $count = $wpdb->get_var($sql);
    if(empty($count)){
        $count = 0;
    }
    return $count;
}


function workscout_post_view_count(){
    if ( is_singular('job_listing') ){

        global $post;
        $count_post     = get_post_meta( $post->ID, '_job_views_count', true);
        $author_id      = get_post_field( 'post_author', $post->ID );

        $total_views    = get_user_meta($author_id,'workscout_total_jobs_views',true);

        if( $count_post == ''){
        
            $count_post = 1;
            add_post_meta( $post->ID, '_job_views_count', $count_post);
            
            $total_views = (int) $total_views + 1;
            update_user_meta($author_id, 'workscout_total_jobs_views', $total_views);
            
        } else {
        
            $total_views = (int) $total_views + 1;
            update_user_meta($author_id, 'workscout_total_jobs_views', $total_views);

            $count_post = (int)$count_post + 1;
            update_post_meta( $post->ID, '_job_views_count', $count_post);
        
        }
    }  
    if ( is_singular('resume') ){

        global $post;
        $count_post     = get_post_meta( $post->ID, '_resume_views_count', true);
        $author_id      = get_post_field( 'post_author', $post->ID );

        $total_views    = get_user_meta($author_id,'workscout_total_resumes_views',true);

        if( $count_post == ''){
        
            $count_post = 1;
            add_post_meta( $post->ID, '_resume_views_count', $count_post);
            
            $total_views = (int) $total_views + 1;
            update_user_meta($author_id, 'workscout_total_resumes_views', $total_views);
            
        } else {
        
            $total_views = (int) $total_views + 1;
            update_user_meta($author_id, 'workscout_total_resumes_views', $total_views);

            $count_post = (int)$count_post + 1;
            update_post_meta( $post->ID, '_resume_views_count', $count_post);
        
        }
    }
}
add_action('wp_head', 'workscout_post_view_count');


function workscout_count_all_user_jobs_bookmarks($user_id){
    $latest = new WP_Query( array (
        
        'posts_per_page'    => -1,
        'post_type'         => 'job_listing',
        'fields'            => 'ids',
        'author'            => $user_id
    ));
    $ids = $latest->posts;
    $total_bookmark_count = 0;
    global $wpdb;
    if ( false === ( $total_bookmark_count = get_transient( 'workscout_user_bookmark_count_' . $user_id ) ) ) {
        foreach ($ids as $post_id) {
       
            $bookmark_count = absint( $wpdb->get_var( $wpdb->prepare( "SELECT COUNT( id ) FROM {$wpdb->prefix}job_manager_bookmarks WHERE post_id = %d;", $post_id ) ) );
            $total_bookmark_count = $total_bookmark_count + $bookmark_count;
        }

        set_transient( 'workscout_user_bookmark_count_' . $user_id, $total_bookmark_count, 6 * HOUR_IN_SECONDS );
    }
        

    return absint( $total_bookmark_count );
}

function workscout_count_all_user_bookmarks($user_id){
        global $wpdb;
    
        $sql_query = $wpdb->prepare( "SELECT `bm`.* FROM `{$wpdb->prefix}job_manager_bookmarks` `bm` " .
                                         "LEFT JOIN `{$wpdb->posts}` `p` ON `bm`.`post_id`=`p`.`ID` " .
                                         "WHERE `user_id` = %d AND `p`.`post_status` = 'publish' "
                                         , $user_id );
        $results     = $wpdb->get_results( $sql_query );
        $max_results = $wpdb->get_var( "SELECT FOUND_ROWS()" );
        

        return absint( $max_results );
}


/**
 * Uploads a file using WordPress file API.
 *
 * @since 1.21.0
 * @param  array|WP_Error      $file Array of $_FILE data to upload.
 * @param  string|array|object $args Optional arguments
 * @return stdClass|WP_Error Object containing file information, or error
 */
function workscout_upload_file( $file, $args = array() ) {
    global $workscout_upload, $workscout_uploading_file;

    include_once( ABSPATH . 'wp-admin/includes/file.php' );
    include_once( ABSPATH . 'wp-admin/includes/media.php' );

    $args = wp_parse_args( $args, array(
        'file_key'           => '',
        'file_label'         => '',
        'allowed_mime_types' => '',
    ) );

    $workscout_upload         = true;
    $workscout_uploading_file = $args['file_key'];
    $uploaded_file              = new stdClass();
    
    $allowed_mime_types = $args['allowed_mime_types'];
    

    /**
     * Filter file configuration before upload
     *
     * This filter can be used to modify the file arguments before being uploaded, or return a WP_Error
     * object to prevent the file from being uploaded, and return the error.
     *
     * @since 1.25.2
     *
     * @param array $file               Array of $_FILE data to upload.
     * @param array $args               Optional file arguments
     * @param array $allowed_mime_types Array of allowed mime types from field config or defaults
     */
    $file = apply_filters( 'workscout_upload_file_pre_upload', $file, $args, $allowed_mime_types );

    if ( is_wp_error( $file ) ) {
        return $file;
    }

    if ( ! in_array( $file['type'], $allowed_mime_types ) ) {
        if ( $args['file_label'] ) {
            return new WP_Error( 'upload', sprintf( __( '"%s" (filetype %s) needs to be one of the following file types: %s', 'workscout_core' ), $args['file_label'], $file['type'], implode( ', ', array_keys( $allowed_mime_types ) ) ) );
        } else {
            return new WP_Error( 'upload', sprintf( __( 'Uploaded files need to be one of the following file types: %s', 'workscout_core' ), implode( ', ', array_keys( $allowed_mime_types ) ) ) );
        }
    } else {
        $upload = wp_handle_upload( $file, apply_filters( 'submit_property_wp_handle_upload_overrides', array( 'test_form' => false ) ) );
        if ( ! empty( $upload['error'] ) ) {
            return new WP_Error( 'upload', $upload['error'] );
        } else {
            $uploaded_file->url       = $upload['url'];
            $uploaded_file->file      = $upload['file'];
            $uploaded_file->name      = basename( $upload['file'] );
            $uploaded_file->type      = $upload['type'];
            $uploaded_file->size      = $file['size'];
            $uploaded_file->extension = substr( strrchr( $uploaded_file->name, '.' ), 1 );
        }
    }

    $workscout_upload         = false;
    $workscout_uploading_file = '';

    return $uploaded_file;
}

function workscout_get_term_post_count( $taxonomy = 'category', $term = '', $args = [] )
{
    // Lets first validate and sanitize our parameters, on failure, just return false
    if ( !$term )
        return false;

    if ( $term !== 'all' ) {
        if ( !is_array( $term ) ) {
            $term = filter_var(       $term, FILTER_VALIDATE_INT );
        } else {
            $term = filter_var_array( $term, FILTER_VALIDATE_INT );
        }
    }

    if ( $taxonomy !== 'category' ) {
        $taxonomy = filter_var( $taxonomy, FILTER_SANITIZE_STRING );
        if ( !taxonomy_exists( $taxonomy ) )
            return false;
    }

    if ( $args ) {
        if ( !is_array ) 
            return false;
    }

    // Now that we have come this far, lets continue and wrap it up
    // Set our default args
    $defaults = [
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'post_status' => 'publish'
    ];

    if ( $term !== 'all' ) {
        $defaults['tax_query'] = [
            [
                'taxonomy' => $taxonomy,
                'terms'    => $term
            ]
        ];
    }
    $combined_args = wp_parse_args( $args, $defaults );
    $q = new WP_Query( $combined_args );

    // Return the post count
    return $q->found_posts;
}

if ( ! function_exists('workscout_write_log')) {
   function workscout_write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}


?>