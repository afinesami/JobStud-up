<?php

function workscout_centered_headline($atts, $content ) { 
    extract(shortcode_atts(array(
        'wide'                      => 'true',
        'title'                     => 'Start Building Your Own Job Board Now ',
        'url'                       => '#',
        'subtitle'                  => '',
        'from_vs'                   => '',
        ), $atts));
    $output = '';

    if($wide=='true') {
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
        $output .='<!-- Infobox -->
               <h3 class="centered-headline">'.$title;
                   if(!empty($url)) { 
                        $output .=' <a href="'.$url.'"><span>'.$subtitle.'</span></a>'; 
                    } else {
                        $output .=' <span>'.$subtitle.'</span>'; 
                    }
        $output .='</h3>';
        if($from_vs === 'yes') {
            $output .= '
         <div class="container">
            <article class="sixteen columns">
                 <div class="vc_row wpb_row vc_row-fluid">
                    <div class="wpb_column vc_column_container vc_col-sm-12">
                        <div class="vc_column-inner">
                            <div class="wpb_wrapper">';
        } else {
            $output .= ' <div class="container">
                <article class="sixteen columns">';
        }
       
    } else {
        $output .='
            <h3 class="centered-headline">'.$title;
                   if(!empty($url)) { 
                        $output .=' <a href="'.$url.'"><span>'.$subtitle.'</span></a>'; 
                    } else {
                        $output .=' <span>'.$subtitle.'</span>'; 
                    }
        $output .='</h3>';
    }

 return $output;
}?>