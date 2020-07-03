<?php 
/**
 * Change the Shop archive page title.
 * @param  string $title
 * @return string
 */

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		$layout = Kirki::get_option( 'workscout', 'pp_shop_layout' ); 
		if($layout=='full-width'){ 
			return 3;
		} else {
			return 2;
		}
	}
}

//add_filter('woocommerce_short_description', 'workscout_woocommerce_short_description', 10, 1);
function workscout_woocommerce_short_description($post_excerpt){
	global $product;
	if($product->get_type() == "job_package" || $product->get_type() == "resume_package") {
       		if($product->get_type() == "job_package" ) { 
				$output = '<ul>';
					
					$jobslimit = $product->get_limit();
					if(!$jobslimit){
						$output .= "<li>";
						$output .= esc_html__('Unlimited number of jobs','workscout'); 
						$output .=  "</li>";
					} else { 
						$output .= '<li>';
						$output .= esc_html__('This plan includes ','workscout'); $output .= sprintf( _n( '%d job', '%s jobs', $jobslimit, 'workscout' ) . ' ', $jobslimit ); 
						$output .= '</li>';

						$jobduration =  $product->get_duration();
						if(!empty($jobduration)){ 
						$output .= '<li>';
						$output .= esc_html__('Jobs are posted ','workscout'); $output .= sprintf( _n( 'for %s day', 'for %s days', $product->get_duration(), 'workscout' ), $product->get_duration() ); 
						$output .= '</li>';
					 } 
				$output .= "</ul>";
				} 
			}
			if($product->get_type() == "resume_package" ) { 
				$output = '<ul>';
					 
					$jobslimit = $product->get_limit();
					if(!$jobslimit){
						$output .= '<li>';
						$output .= esc_html__('Unlimited number of Resumes','workscout'); 
						$output .= '</li>';
					} else { 
						$output .= '<li>';
						$output .= esc_html__('This plan includes ','workscout'); $output .= sprintf( _n( '%d resume', '%s resumes', $jobslimit, 'workscout' ) . ' ', $jobslimit ); 
						$output .= '</li>';
					} 

					$jobduration =  $product->get_duration();
					if(!empty($jobduration)){ 
						$output .= '<li>';
						$output .= esc_html__('Resumes are posted ','workscout'); $output .= sprintf( _n( 'for %s day', 'for %s days', $product->get_duration(), 'workscout' ), $product->get_duration() ); 
						$output .= '</li>';
					 } 

				$output .= "</ul>";
			}

        $post_excerpt = $output . $post_excerpt;
    }
    return $post_excerpt;
}


remove_action( 'woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_before_shop_loop_item_title','woocommerce_template_loop_add_to_cart', 10 );

add_filter( 'woocommerce_show_page_title', 'workscout_hide_shop_title' );
function workscout_hide_shop_title() { return false; }



remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15 );

if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
	function woocommerce_output_upsells() {
	    woocommerce_upsell_display( 3,3 ); // Display 3 products in rows of 3
	}
}

add_filter( 'woocommerce_output_related_products_args', 'workscout_related_woo_per_page' );

function workscout_related_woo_per_page( $args ) { 
    $args = wp_parse_args( array( 'posts_per_page' => 3 ), $args );
    return $args;
}


add_filter('workscout_userpage', 'workscout_woo_redirect_candidate_to_dashboard');
add_filter('workscout_woo_userpage', 'workscout_woo_redirect_candidate_to_dashboard');
function workscout_woo_redirect_candidate_to_dashboard($loginlink){
	
	$login_system = Kirki::get_option( 'workscout', 'pp_login_form_system' );
	if($login_system==='woocommerce' || $login_system==='workscout' ) {
		$redirect_can =  Kirki::get_option( 'workscout', 'pp_woo_redirect_user_page_candidate');
		$redirect_emp =  Kirki::get_option( 'workscout', 'pp_woo_redirect_user_page_employer');
		$user = wp_get_current_user();
		if($redirect_can){
			if ( in_array( 'candidate', (array) $user->roles )   ) {
				$candidate_dashboard_page_id = get_option( 'resume_manager_candidate_dashboard_page_id' ); 
				$loginlink = get_permalink($candidate_dashboard_page_id);
			}
		}		
		if($redirect_emp){
			if ( in_array( 'employer', (array) $user->roles )   ) {
				$employer_dashboard_page_id = get_option( 'job_manager_job_dashboard_page_id' );
				$loginlink = get_permalink($employer_dashboard_page_id);
			}
			
		}
	}
	
	return $loginlink;
}
?>