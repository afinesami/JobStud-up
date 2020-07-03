<?php 


/**
* Box shortcodes
* Usage: [box type=""] [/box]
*/

function workscout_box($atts, $content = null) {
    extract(shortcode_atts(array(
        "type" => 'notice'
        ), $atts));
    return '<div class="notification closeable '.$type.'"><p>'.do_shortcode( $content ).'</p></div>';
}
add_shortcode('box', 'pp_box');

?>