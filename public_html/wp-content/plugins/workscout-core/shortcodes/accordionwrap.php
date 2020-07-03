<?php

    function workscout_accordionwrap( $atts, $content ) {
        extract(shortcode_atts(array(), $atts));
        return '<div class="accordion">'.do_shortcode( $content ).'</div>';
    }
?>