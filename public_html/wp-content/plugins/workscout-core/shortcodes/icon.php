<?php
/**
* Icon shortcode
* Usage: [icon icon="icon-exclamation"]
*/
function workscout_icon($atts) {
    extract(shortcode_atts(array(
        'icon'=>''), $atts));
    return '<i class="fa fa-'.$icon.'"></i>';
}

?>