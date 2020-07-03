<?php


    function workscout_popup($atts, $content = null) {
        extract(shortcode_atts(array(
            'buttontext'=>' Open Popup',
            'title'=>' Modal popup',
            ), $atts));
         $randID = rand(1, 99);
  $output = '
        <a class="popup-with-zoom-anim button color" href="#small-dialog'.$randID.'" ><i class="fa fa-info-circle"></i> '.$buttontext.'</a><br/>
            <div id="small-dialog'.$randID.'" class="small-dialog zoom-anim-dialog mfp-hide">
                <h2 class="margin-bottom-10">'.$title.'</h2>
                <p class="margin-reset">'.do_shortcode( $content ).'</p>
            </div>';
    return $output;
    }
   

?>