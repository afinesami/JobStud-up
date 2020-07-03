<?php


/**
* Recent work shortcode
* Usage: [clients_carousel title="Recent Work" ] [/clients_carousel]
*/
function workscout_clients_carousel($atts, $content ) {
    extract(shortcode_atts(array(
        'width'             => 'sixteen',
        'place'             => 'center',
        'autoplay'          => "off",
        'delay'             => 5000,
        ), $atts));

    $output = '';
    $width_arr = array(
        'sixteen' => 16, 'fifteen' => 15, 'fourteen' => 14, 'thirteen' => 13, 'twelve' => 12, 'eleven' => 11, 'ten' => 10, 'nine' => 9,
        'eight' => 8, 'seven' => 7, 'six' => 6, 'five' => 5, 'four' => 4, 'three' => 3
        );
    $randID = rand(1, 99); // Get unique ID for carousel
    if(empty($width)) { $width = "sixteen"; }

    switch ( $place ) {
        case "last" :
        $p = "omega";
        break;

        case "center" :
        $p = "alpha omega";
        break;

        case "none" :
        $p = " ";
        break;

        case "first" :
        $p = "alpha";
        break;
        default :
        $p = ' ';
    }

    $carousel_width = $width_arr[$width] - 2;
    $carousel_key_width = array_search ($carousel_width, $width_arr);
    $output .= '
    <!-- Navigation / Left -->
    <div class="one carousel column alpha"><div id="showbiz_left_'.$randID.'" class="sb-navigation-left-2"><i class="fa fa-angle-left"></i></div></div>

    <!-- ShowBiz Carousel -->
    <div id="our-clients"  data-delay="'.$delay.'" data-autoplay="'.$autoplay.'"  class="our-clients-run showbiz-container '.$carousel_key_width.' carousel columns" >

    <!-- Portfolio Entries -->
    <div class="showbiz our-clients" data-left="#showbiz_left_'.$randID.'" data-right="#showbiz_right_'.$randID.'">
        <div class="overflowholder">';
            $output .= do_shortcode( $content );
            $output .='<div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    </div>
    <!-- Navigation / Right -->
    <div class="one carousel column omega"><div id="showbiz_right_'.$randID.'" class="sb-navigation-right-2"><i class="fa fa-angle-right"></i></div></div>';
    return $output;
}

?>