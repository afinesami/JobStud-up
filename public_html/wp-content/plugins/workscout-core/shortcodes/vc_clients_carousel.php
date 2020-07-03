<?php


function workscout_vc_clients_carousel($atts, $content ) {
    extract(shortcode_atts(array(
        'width' => 'sixteen',
        'logos' => '',
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
    $carousel_width = $width_arr[$width] - 2;
    $carousel_key_width = array_search ($carousel_width, $width_arr);
    $slick_autplay = ($autoplay == 'on') ? true : false ; 
    $output .= ' <!-- Navigation / Left -->
   

    <!-- ShowBiz Carousel -->
    <div id="our-clients" data-slick=\'{"autoplaySpeed": '.$delay.', "autoplay": '.$slick_autplay.' }\'  data-delay="'.$delay.'" data-autoplay="'.$autoplay.'" class="our-clients-run showbiz-container '.$carousel_key_width.' carousel columns" >';
    if(!empty($logos)){
        $logos = explode(',', $logos);
        foreach ($logos as $logo) {
            $logosrc = wp_get_attachment_url( $logo );
            $output .= '<img src="'.$logosrc.'">';
        }
    }
    $output .='
    </div>
    <!-- Navigation / Right -->
  ';

    return $output;
}
add_shortcode('vc_clients_carousel', 'vc_workscout_clients_carousel');

?>