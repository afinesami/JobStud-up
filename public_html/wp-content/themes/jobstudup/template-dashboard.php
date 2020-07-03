<?php
/**
 * Template Name: Dashboard Page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WorkScout
 */

if ( !is_user_logged_in() ) { 
        
$errors = array();

if ( isset( $_REQUEST['login'] ) ) {
    $error_codes = explode( ',', $_REQUEST['login'] );
 
    foreach ( $error_codes as $code ) {
       switch ( $code ) {
            case 'empty_username':
                $errors[] = esc_html__( 'You do have an email address, right?', 'workscout' );
            break;
            case 'empty_password':
                $errors[] =  esc_html__( 'You need to enter a password to login.', 'workscout' );
            break;
            case 'invalid_username':
                $errors[] =  esc_html__(
                    "We don't have any users with that email address. Maybe you used a different one when signing up?",
                    'workscout'
                );
            break;
            case 'incorrect_password':
                $err = __(
                    "The password you entered wasn't quite right. <a href='%s'>Did you forget your password</a>?",
                    'workscout'
                );
                $errors[] =  sprintf( $err, wp_lostpassword_url() );
            break;
            default:
                break;
        }
    }
} 
 // Retrieve possible errors from request parameters
if ( isset( $_REQUEST['register-errors'] ) ) {
    $error_codes = explode( ',', $_REQUEST['register-errors'] );
 
    foreach ( $error_codes as $error_code ) {
        
         switch ( $error_code ) {
            case 'email':
                 $errors[] = esc_html__( 'The email address you entered is not valid.', 'workscout' );
               break;
            case 'email_exists':
                 $errors[] = esc_html__( 'An account exists with this email address.', 'workscout' );
                  break;
            case 'closed':
                 $errors[] = esc_html__( 'Registering new users is currently not allowed.', 'workscout' );
                 break;
            case 'captcha-no':
                 $errors[] = esc_html__( 'Please check reCAPTCHA checbox to register.', 'workscout' );
                 break;
            case 'captcha-fail':
                 $errors[] = esc_html__( "You're a bot, aren't you?.", 'workscout' );
                 break;
            case 'policy-fail':
                 $errors[] = esc_html__( "Please accept the Privacy Policy to register account.", 'workscout' );
                 break;
            case 'first_name':
                 $errors[] = esc_html__( "Please provide your first name", 'workscout' );
                 break;
            case 'last_name':
                 $errors[] = esc_html__( "Please provide your last name", 'workscout' );
                 break;
            case 'empty_user_login':
                 $errors[] = esc_html__( "Please provide your user login", 'workscout' );
                 break;
            case 'password-no':
                 $errors[] = esc_html__( "You have forgot about password.", 'workscout_core', 'workscout' );
                 break;
            case 'incorrect_password':
                $err = __(
                    "The password you entered wasn't quite right. <a href='%s'>Did you forget your password</a>?",
                    'workscout'
                );
                $errors[] =  sprintf( $err, wp_lostpassword_url() );
                break;
            default:
                break;
        }
    }
} 
$header_old = Kirki::get_option('workscout','pp_old_header');
$header_type = (Kirki::get_option('workscout','pp_old_header') == true) ? 'old' : '' ;
$header_type = apply_filters('workscout_header_type',$header_type);
get_header($header_type);

   
$titlebar = get_post_meta( $post->ID, 'pp_page_titlebar', true ); 
$submit_job_page = get_option('job_manager_submit_job_form_page_id');
$resume_job_page = get_option('resume_manager_submit_resume_form_page_id');

if($titlebar == 'off') {
    // no titlebar
} else {
     ?>
        <?php $header_image = get_post_meta($post->ID, 'pp_job_header_bg', TRUE); 
        if(!empty($header_image)) {             
            $transparent_status = get_post_meta($post->ID, 'pp_transparent_header', TRUE);  
            if($transparent_status == 'on'){ ?>
            <div id="titlebar" class="photo-bg single with-transparent-header" style="background: url('<?php echo esc_url($header_image); ?>')">
        <?php } else { ?>
            <div id="titlebar" class="photo-bg" style="background: url('<?php echo esc_url($header_image); ?>')">
        <?php } ?>
    <?php } else { ?>
        <div id="titlebar" class="single">
        <?php } ?>
            <div class="container">

                <div class="sixteen columns">
                    <h1><?php the_title(); ?></h1>
                    <?php if(function_exists('bcn_display')) { ?>
                    <nav id="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
                        <ul>
                            <?php bcn_display_list(); ?>
                        </ul>
                    </nav>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php 
    
}

    
    $class  = "col-md-12"; ?>
    <div class="container">

        <div class="row">

            <article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
                <div class=" sign-in-form style-1 margin-bottom-45">
                    
                <div class="my-account static-login-page">
                    <?php if ( count( $errors ) > 0 ) : ?>
                        <?php foreach ( $errors  as $error ) : ?>
                            <div class="notification error closeable">
                                <p><?php echo ($error); ?></p>
                                <a class="close"></a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if ( isset( $_REQUEST['registered'] ) ) : ?>
                    <div class="notification success closeable">
                        <p>
                            <?php
                            $password_field = get_option('workscout_display_password_field');
                            if($password_field) {
                                printf(
                                    esc_html__( 'You have successfully registered to %s.', 'workscout' ),
                                    '<strong>'.get_bloginfo( 'name' ).'</strong>'
                                );
                            } else {
                                printf(
                                    esc_html__( 'You have successfully registered to %s. We have emailed your password to the email address you entered.', 'workscout' ),
                                    '<strong>'.get_bloginfo( 'name' ).'</strong>'
                                );
                            }
                                
                            ?>
                        </p>
                    </div>
                    <?php endif; ?>
                    
                    <ul class="tabs-nav login-tabs">
                        <li class=""><a href="#tab1"><?php esc_html_e('Login','workscout'); ?></a></li>
                        <li <?php if(isset($_GET['register'])) { echo 'class="active"'; } ?>><a href="#tab2"><?php esc_html_e('Register','workscout'); ?></a></li>
                    </ul>

                    <div class="tabs-container">
                        <!-- Login -->
                        <div class="tab-content" id="tab1" style="display: none;">
                          <?php echo do_action('workscout_login_form');  ?> 
                        </div>

                        <!-- Register -->
                        <div class="tab-content" id="tab2" style="display: none;">
                            <?php echo do_action('workscout_register_form');  ?> 
                          
                        </div>
                    </div>
                    
                    </div>
                </div>
                </article>
            
           

        </div>

    </div>
    <div class="clearfix"></div> 
<?php
    get_footer(); 

} else { //is logged

get_header( 'dashboard' );
$current_user = wp_get_current_user();
$user_id = get_current_user_id();
$roles = $current_user->roles;
$role = array_shift( $roles ); 

?>

<!-- Dashboard -->
<div id="dashboard">
    
    <!-- Navigation
    ================================================== -->

    <!-- Responsive Navigation Trigger -->
    <a href="#" class="dashboard-responsive-nav-trigger"><i class="fa fa-reorder"></i> <?php esc_html_e('Dashboard Navigation','workscout');?></a>

    <div class="dashboard-nav <?php echo esc_attr( $role ); ?>-dashboard-nav">
        <div class="dashboard-nav-inner">
            <ul data-submenu-title="<?php esc_html_e('Main','workscout');?>">
                
                <?php $dashboard_page = get_option('workscout_dashboard_page');  if( $dashboard_page ) : ?>
                <li id="dashboard_page-menu" <?php if( $post->ID == $dashboard_page ) : ?>class="active" <?php endif; ?>><a href="<?php echo esc_url(get_permalink($dashboard_page)); ?>"> <?php esc_html_e('Dashboard','workscout');?></a></li>
                <?php endif; ?>

                
                <?php $messages_page = get_option('workscout_messages_page');  if( $messages_page ) : ?>
                <li id="messages_page-menu" <?php if( $post->ID == $messages_page ) : ?>class="active" <?php endif; ?>>
                    <a href="<?php echo esc_url(get_permalink($messages_page)); ?>"><?php esc_html_e('Messages','workscout');?> 
                    <?php 
                    $counter = workscout_get_unread_counter();
                    if($counter) { ?>
                    <span class="nav-tag messages"><?php echo esc_html($counter); ?></span>
                    <?php } ?>
                    </a>
                </li>
                <?php endif; ?>
                
                <?php $bookmarks_page = get_option('pp_bookmarks_page');  
                if( class_exists('WP_Job_Manager_Bookmarks') && $bookmarks_page ) : ?>
                <li id="bookmarks_page-menu" <?php if( $post->ID == $bookmarks_page ) : ?>class="active" <?php endif; ?>><a href="<?php echo esc_url(get_permalink($bookmarks_page)); ?>"> <?php esc_html_e('Bookmarks','workscout');?></a></li>
                <?php endif; ?>

                 <?php 
                    $alerts_page = get_option('job_manager_alerts_page_id');  
                    if( class_exists('WP_Job_Manager_Alerts') && $alerts_page ) : ?>
                    <li id="alerts_page-menu">
                        <a href="<?php echo esc_url(get_permalink($alerts_page)); ?>">
                            <?php esc_html_e('Job Alerts','workscout');?>
                            <span class="nav-tag"><?php 
                        
                        $total_alerts = workscout_count_posts_by_user($user_id,'job_alert','publish');  
                        echo $total_alerts; ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
            </ul>
            <?php if(in_array($role,array('administrator','admin','employer'))) : ?>
            <ul id="employer-menu" data-submenu-title="<?php esc_html_e('Employer','workscout');?>">

                <?php 
                $jobs_dashboard = get_option('job_manager_job_dashboard_page_id');  
                if( $jobs_dashboard ) : ?>
                <li id="jobs_dashboard-menu">
                    <a href="<?php echo esc_url(get_permalink($jobs_dashboard)); ?>">
                        <?php esc_html_e('Manage Jobs','workscout');?> <span class="nav-tag"><?php 
                        $count_publish =  workscout_count_posts_by_user($user_id,'job_listing','publish');  
                        $count_pending =  workscout_count_posts_by_user($user_id,'job_listing','pending');  
                        $count_pending_payment =  workscout_count_posts_by_user($user_id,'job_listing','pending_payment');  
                        $count_draft =  workscout_count_posts_by_user($user_id,'job_listing','draft');  
                        $total_pending_count = $count_publish + $count_pending+$count_draft; 
                        echo $total_pending_count; ?></span>
                    </a>
                </li>
                <?php endif; ?> 

                <?php 
                $submit_page = get_option('job_manager_submit_job_form_page_id');  
                if( $submit_page ) : ?>
                <li id="submit_page-menu">
                    <a href="<?php echo esc_url(get_permalink($submit_page)); ?>">
                        <?php esc_html_e('Submit Job','workscout');?>
                    </a>
                </li>
                <?php endif; ?>
           
            </ul>  
            <?php endif; ?>


            <?php if(in_array($role,array('administrator','admin','candidate'))) : ?>
            <ul id="candidate-menu" data-submenu-title="<?php esc_html_e('Candidate','workscout');?>">  

                <?php 
                    $resumes_dashboard = get_option('resume_manager_candidate_dashboard_page_id');  
                    if(class_exists('WP_Resume_Manager') &&  $resumes_dashboard ) : ?>
                    <li id="resumes_dashboard-menu">
                        <a href="<?php echo esc_url(get_permalink($resumes_dashboard)); ?>">
                            <?php esc_html_e('Manage Resumes','workscout');?> <span class="nav-tag"><?php 
                        $count_publish =  workscout_count_posts_by_user($user_id,'resume','publish');  
                        $count_pending =  workscout_count_posts_by_user($user_id,'resume','pending');  
                        $count_pending_payment =  workscout_count_posts_by_user($user_id,'resume','pending_payment');  
                        $count_draft =  workscout_count_posts_by_user($user_id,'resume','draft');  
                        $total_pending_count = $count_publish+$count_pending+$count_draft; 
                        echo $total_pending_count; ?></span>
                        </a>
                    </li>
                    <?php endif; ?> 

                    <?php 
                    $submit_resume = get_option('resume_manager_submit_resume_form_page_id');  
                    if(class_exists('WP_Resume_Manager') &&  $submit_resume ) : ?>
                    <li id="submit_resume-menu">
                        <a href="<?php echo esc_url(get_permalink($submit_resume)); ?>">
                            <?php esc_html_e('Add Resume','workscout');?>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php 
                    $applications_page = get_option('workscout_past_applications');  
                    if( class_exists('WP_Job_Manager_Applications') && $applications_page ) : ?>
                    <li id="alerts_page-menu">
                        <a href="<?php echo esc_url(get_permalink($applications_page)); ?>">
                            <?php esc_html_e('My Applications','workscout');?>
                            <span class="nav-tag"><?php 

                            

                                

                                $user_post_count = workscout_count_user_applications( $current_user->ID  ); 

                                echo $user_post_count; 

                            ?></span>
                        </a>
                    </li>
                    <?php endif; ?>

                   
            </ul>   
            <?php endif; ?>
            <ul id="account-menu" data-submenu-title="<?php esc_html_e('Account','workscout');?>">
                <?php $profile_page = get_option('workscout_profile_page');  if( $profile_page ) : ?>
                <li id="profile_page-menu" <?php if( $post->ID == $profile_page ) : ?>class="active" <?php endif; ?>><a href="<?php echo esc_url(get_permalink($profile_page)); ?>"> <?php esc_html_e('My Profile','workscout');?></a></li>
                <?php endif; ?>

                <?php 

                $orders_page_status = get_option('workscout_orders_page');
                
                if( class_exists( 'woocommerce' ) && $orders_page_status ) : 
                
                    $orders_page =  wc_get_endpoint_url('orders', '', get_permalink(get_option('woocommerce_myaccount_page_id')));
                ?>
                <li id="orders_page-menu" <?php if( $post->ID == $orders_page ) : ?>class="active" <?php endif; ?>><a href="<?php echo esc_url($orders_page); ?>"><?php esc_html_e('My Orders','workscout');?></a></li>
                <?php endif; ?>


                <?php 
                $subscription_page_status = get_option('workscout_subscription_page');
                if( class_exists( 'WC_Subscriptions' ) && $subscription_page_status ) {
                    $subscription_page =  wc_get_endpoint_url('subscriptions', '', get_permalink(get_option('woocommerce_myaccount_page_id')));
                    
                    if( $subscription_page ) : ?>
                    <li id="subscription_page-menu" <?php if( $post->ID == $subscription_page ) : ?>class="active" <?php endif; ?>><a href="<?php echo esc_url($subscription_page); ?>"><?php esc_html_e('My Subscriptions','workscout');?></a></li>
                    <?php endif; 
                } ?>


                <li id="logout-menu"><a href="<?php echo wp_logout_url(home_url()); ?>"><?php esc_html_e('Logout','workscout');?></a></li>
            </ul>
           
            
            
        </div>
    </div>
    <!-- Navigation / End -->

<!-- Content
    ================================================== -->  
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
    <div class="dashboard-content" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <!-- Titlebar -->
        <div id="titlebar">
            <div class="row">
                <div class="col-md-12">
                    <?php 
                    global $job_preview;

                    $is_dashboard_page = get_option('workscout_dashboard_page'); 
                    $is_booking_page = get_option('workscout_bookings_page');
                    global $post;
                    if( $is_dashboard_page == $post->ID ) { ?>
                    <h2><?php esc_html_e('Howdy,','workscout'); ?> <?php echo esc_html($name); ?>!</h2>
                    <?php } else if( $is_booking_page == $post->ID ) { 
                        $status = '';
                        if(isset($_GET['status'])){
                            $status = $_GET['status'];
                            switch ($status) {
                                case 'approved': ?>
                                    <h1><?php esc_html_e('Approved Bookings','workscout'); ?></h1>
                                    <?php
                                    break;
                                case 'waiting': ?>
                                    <h1><?php esc_html_e('Pending Bookings','workscout'); ?></h1>
                                    <?php
                                    break;
                                case 'cancelled': ?>
                                    <h1><?php esc_html_e('Cancelled Bookings','workscout'); ?></h1>
                                    <?php
                                    break;
                                
                                default:
                                     ?>
                                    <h1><?php esc_html_e('Bookings','workscout'); ?></h1>
                                    <?php
                                    break;
                            }
                        } else  { ?>
                        <h1><?php the_title(); ?></h1>  
                        <?php }
                    } else { ?>
                    <h1><?php the_title(); ?></h1>  
                    <?php } ?>
                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs">
                        <ul>
                            <li><a href="#"><?php esc_html_e('Home','workscout'); ?></a></li>
                            <li><?php esc_html_e('Dashboard','workscout'); ?></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <?php 

        while ( have_posts() ) : the_post();
            the_content();
        endwhile; // End of the loop. ?>
    
        <!-- Copyrights -->
        <div class="row">
            <div class="col-md-12">
                <div class="copyrights"> <?php $copyrights = Kirki::get_option( 'workscout', 'pp_copyrights' ); 
            
                    echo wp_kses($copyrights,array( 'a' => array('href' => array(),'title' => array()),'br' => array(),'em' => array(),'strong' => array(),));
                     ?></div>
            </div>
        </div>
            
    </div>
</div>
<!-- Dashboard / End -->
<?php 
get_footer('empty'); 
} ?>