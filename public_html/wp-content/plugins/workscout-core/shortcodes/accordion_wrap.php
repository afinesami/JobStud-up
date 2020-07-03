<?php

    function workscout_accordion_wrap( $atts, $content ) {
        extract(shortcode_atts(array(), $atts));
        return '<div class="accordion">'.do_shortcode( $content ).'</div>';
    }
?>