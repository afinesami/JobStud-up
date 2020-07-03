<?php



function workscout_pricing_table($atts, $content) {
    extract(shortcode_atts(array(
        "type" => 'color-1',
        "width" => 'four',
        "color" => '',
        "title" => '',
        "currency" => '$',
        "price" => '',
        "discounted" => '',
        "per" => '',
        "buttonstyle" => '',
        "buttonlink" => '',
        "buttontext" => 'Sign Up',
        "place" =>'',
        "from_vs" => 'no'
        ), $atts));

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
    $output = '';
    if($from_vs == 'yes') {
        $output .= '
    <div class="'.$type.' plan">';
    } else {
        $output .= '
    <div class="'.$type.' plan '.$width.' '.$p.' columns">';
    }
    $output .= '
        <div class="plan-price" style="background-color: '.$color.';">
            <h3>'.$title.'</h3>';
            if(!empty($discounted)){ 
                    $output .= '<div class="plan-price-wrap"><del><span class="amount">'.$currency.''.$price.'</span></del> <ins><span class="amount">'.$currency.''.$discounted.'</span></ins></div>';                
            } else {

                $output .= '<span class="plan-currency">'.$currency.'</span>
                            <span class="value">'.$price.'</span>';

            }
        $output .= '</div>
        <div class="plan-features">'.do_shortcode( $content );
        if($buttonlink) {
            $output .=' <a class="button"  style="background-color: '.$color.';" href="'.$buttonlink.'"><i class="fa fa-shopping-cart"></i> '.$buttontext.'</a>';
        }
    $output .=' </div>
    </div>';
    return $output;
}


 ?>