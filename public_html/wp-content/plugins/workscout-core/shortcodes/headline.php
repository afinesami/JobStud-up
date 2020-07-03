<?php


/**
* Headline shortcode
* Usage: [headline ] [/headline] // margin-down margin-both
*/
function workscout_headline( $atts, $content ) {
  extract(shortcode_atts(array(
    'margintop' => 0,
    'marginbottom' => 25,
    'clearfix' => 0,
    'font_container'=> '', 
    'subtitle'			=> '', 
    'url'			=> '', 
    'type'			=> 'h3', 
    ), $atts));

   $font_container_data = vc_parse_multi_attribute($font_container);
	
	  	if($font_container_data){
	  		$tag = (isset($font_container_data['tag'])) ? $font_container_data['tag'] : $type ;
	  		$style = 'style="';
	  		$style .= (isset($font_weight)) ? 'font-weight:'.$font_weight.';' : '' ;
	  		$style .= (isset($font_container_data['font_size'])) ? 'font-size:'.$font_container_data['font_size'].';' : '' ;
			$style .= (isset($font_container_data['text_align'])) ? 'text-align:'.$font_container_data['text_align'].';' : '' ;
			$style .= (isset($font_container_data['color'])) ? 'color:'.$font_container_data['color'].';' : '' ;
			$style .= (isset($font_container_data['line_height'])) ? 'line-height:'.$font_container_data['line_height'].';' : '' ;
			$style .= '"';
			
			
			if(!empty($url)){
				$link = vc_build_link( $url );
		        $a_href = $link['url'];
		        $a_title = $link['title'];
		        $a_target = $link['target'];
			}
			if($font_container_data['text_align'] == 'center') {
				$css_class = 'centered';
			} else {
				$css_class = '';
			}
			$output = '<' . $tag . ' ' . $style . ' class="'.$css_class.' headline margin-top-'.$margintop.' margin-bottom-'.$marginbottom.' ">';
			
			if(!empty($url)){
				$output .= '<a class="posts-category-link" href="'.$a_href.'" title="'.esc_attr( $a_title ).'" target="'.$a_target.'">';
			}

			$output .= do_shortcode( $content );
			if(!empty($subtitle)) {
				$output .= '<span class="margin-top:25px;">'.$subtitle.'</span>';
			}
			if(!empty($url)){
				$output .= '</a>';
			}
			$output .= '</' .  $tag . '>';
	  	} else {
			$output = '<'.$type.' class="margin-top-'.$margintop.' margin-bottom-'.$marginbottom.'">'.do_shortcode( $content ).'</'.$type.'>';
	  	}

  
    if($clearfix == 1) {   $output .= '<div class="clearfix"></div>';}
    return $output;
}

?>