<?php

function workscout_counter( $atts, $content ) {
   extract(shortcode_atts(array(
            'title' => 'Resumes Posted',
            'number' => '768',
            'type' => '', //jobs, resumes, posts, members, candidates, employers, 
            'scale' => '',
            'from_vs' => '',
            'width' => 'one-third',

    ), $atts));
    switch ( $type ) {
        case "jobs" :
            $count = wp_count_posts( 'job_listing', 'readable' );
            $number = (isset( $count->publish ))  ? $count->publish : '0'; 
        break;

            case "resumes" :
                $count = wp_count_posts( 'resume'); 
                $number = (isset( $count->publish ))  ? $count->publish : '0'; 
            break;

        case "posts" :
            $count = wp_count_posts( 'posts', 'readable' );
            $number = (isset( $count->publish ))  ? $count->publish : '0'; 
        break;

        

        case "members" :
            $number = get_user_count();
            
        break;        

        case "candidates" :
            $args = array(
                'role' => 'candidate',//substitute your role here as needed
                'fields' => 'ID',
            );

            $users = get_users( $args );
            $number = count( $users );

        break;        

        case "employers" :
            $args = array(
                'role' => 'employer',//substitute your role here as needed
                'fields' => 'ID',
            );
            $users = get_users( $args );
            $number = count( $users );
        break;

        default :
       
    }

    $output = '';
    if($from_vs === 'yes') {
        $output .= '<div class="columns '.$width.'">';
    }
    $output .= '<div class="counter-box">
                <span class="counter">'.$number.'</span>';
         if(!empty($scale)) { $output .= '<i>'.$scale.'</i>';}
    $output .= ' <p>'.$title.'</p>
            </div>';
    if($from_vs === 'yes') {
        $output .= '</div>';
    }
    return $output;
}

?>