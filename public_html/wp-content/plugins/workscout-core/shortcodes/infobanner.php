<?php 

function workscout_infobanner( $atts, $content ) {
   extract(shortcode_atts(array(
            'title' => 'Perfect Template for Your Own Job Board',
            'url' => '#',
            'target' => '',
            'buttontext' => 'Get This Theme',
            ), $atts));

    $output = '
    <div class="info-banner">
        <div class="info-content">
            <h3>'.$title.'</h3>
            <p>'.do_shortcode( $content ).'</p>
        </div>';
        if($url) {
            if($target){
                $output .= '<a target="'.$target.'" href="'.$url.'" class="button color">'.$buttontext.'</a>';
            } else {
                $output .= '<a href="'.$url.'" class="button">'.$buttontext.'</a>';
            }
        }
    $output .= '<div class="clearfix"></div>
    </div>';
    return $output;
}

?>