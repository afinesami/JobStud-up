<?php


/**
* List style shortcode
* Usage: [list type="check"] [/list] // check, arrow, checkbg, arrowbg
*/
function workscout_list($atts, $content = null) {
    extract(shortcode_atts(array(
        "style" => '1',
        "color" => 'no'
        ), $atts));
    if($color=='yes') { $class="color"; } else { $class = ' '; };
    $output = '<div class="list-'.$style.' '.$class.'">'.$content.'</div>';
    return $output;
}

?>