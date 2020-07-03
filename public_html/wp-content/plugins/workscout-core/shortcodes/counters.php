<?php

function workscout_counters( $atts, $content ) {
    extract(shortcode_atts(array('from_vs' => 'yes'), $atts));
        if($from_vs === 'yes') {
        $output =  '    </div> <!-- eof wpb_wrapper -->
                    </div> <!-- eof vc_column-inner -->
                </div> <!-- eof vc_column_container -->
            </div> <!-- eof vc_row-fluid -->
        </article>
    </div> <!-- eof container -->';

        } else {
        $output = '</article>
        </div>';
    }


    $output .= '<!-- Counters -->
    <div id="counters">
        <div class="container">
        '.do_shortcode( $content ).'
        </div>
    </div>';

    if($from_vs === 'yes') {
      $output .= '
    <div class="container">
        <article class="sixteen columns">
             <div class="vc_row wpb_row vc_row-fluid">
                <div class="wpb_column vc_column_container vc_col-sm-12">
                    <div class="vc_column-inner ">
                        <div class="wpb_wrapper">';
    } else {
        $output .= ' <div class="container">
            <article class="sixteen columns">';
    }
    return $output;
}

?>