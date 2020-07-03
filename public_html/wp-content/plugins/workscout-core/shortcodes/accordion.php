<?php

/**
* Accordion shortcode
* Usage: [accordion title="Tab"] [/accordion]
*/

    function workscout_accordion( $atts, $content ) {
        extract(shortcode_atts(array(
            'title' => 'Tab'
            ), $atts));
        return '<h3>'.$title.'</h3><div><p>'.do_shortcode( $content ).'</p></div>';
    }
    add_shortcode( 'accordion', 'pp_accordion' );
?>