<?php

/**
* Headline shortcode
* Usage: [iconbox title="Service Title" url="#" icon="37"] test [/headline]
*/
    function workscout_iconbox( $atts, $content ) {
      extract(shortcode_atts(array(
            'title'         => 'Search For Jobs',
            'url'           => '',
            'icon'          => 'ln ln-icon-Search-onCloud',
            'type'          => 'rounded', // 'standard'
           
            'from_vs'       => 'no',
        ), $atts));
/*<div class="icon-box rounded alt">
                <i class="ln ln-icon-Search-onCloud"></i>
                <h4>Search For Jobs</h4>
                <p>Pellentesque habitant morbi tristique senectus netus ante et malesuada fames ac turpis egestas maximus neque.</p>
            </div>*/
        if( $type == 'rounded' ){
            $output = '<div class="icon-box rounded alt">';
        } else {
            $output = '<div class="icon-box alt">';
        }

        if($from_vs === "yes") { 
 
            if($url) {
                $link = vc_build_link( $url );
                $a_href = $link['url'];
                $a_title = $link['title'];
                $a_target = $link['target'];
                $output .= '<a href="'.esc_url( $a_href ).'" title="'.esc_attr( $a_title ).'" target="'.esc_attr($a_target).'">';
            }
            $output .= '<i class="'.esc_attr($icon).'"></i>';
            if($url) {
                $output .= '</a>';
            }
        } else {
            if($url) {
                $output .= '<a href="'.$url.'">';
            }
            $output .= '<i class="'.esc_attr($icon).'"></i>';
            if($url) {
                $output .= '</a>';
            }
        }
        if($url) {
            if($from_vs === 'yes') { 

                $link = vc_build_link( $url );
                $a_href = $link['url'];
                $a_title = $link['title'];
                $a_target = $link['target'];
                
                $output .= '<a href="'.esc_url( $a_href ).'" title="'.esc_attr( $a_title ).'" target="'.esc_attr($a_target).'"><h4>'.$title.'</h4></a>';
            } else {
                $output .= '<a href="'.$url.'"><h4>'.$title.'</h4></a>';
            }
        } else {
            $output .= '<h4>'.$title.'</h4>';
        }
        $output .= '<p>'.do_shortcode( $content ).'</p>';
        $output .= '</div>';
              
        
        return $output;
    }
    add_shortcode('iconbox', 'workscout_iconbox');
?>