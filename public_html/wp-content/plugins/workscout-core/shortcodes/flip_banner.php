<?php 

	function workscout_flip_banner( $atts, $content ) {
		extract(shortcode_atts(array(
            'url'			=>	'',
            'background'	=>	'',
            'color'			=>	'#274abb',
            'opacity'		=>	'0.9',
            'text_visible'	=>	'',
            'text_hidden'	=>	'',
            'from_vs' 		=>	'no'
            ), $atts));

		if($from_vs=='yes') {
	    	$background = wp_get_attachment_url( $background );
		}
       	ob_start(); ?>

		<!-- Flip banner -->
		<a href="<?php echo esc_url($url); ?>" class="flip-banner parallax" data-background="<?php echo esc_attr($background); ?>" data-color="<?php echo esc_attr($color); ?>" data-color-opacity="<?php echo esc_attr($opacity); ?>" data-img-width="2500" data-img-height="1600">

			<div class="flip-banner-content">
				<h2 class="flip-visible"><?php echo esc_html($text_visible); ?></h2>
				<h2 class="flip-hidden"><?php echo esc_html($text_hidden); ?> <i class="fa fa-angle-right"></i></h2>
			</div>
		</a>
		<!-- Flip banner / End -->
 <?php
	    $output =  ob_get_clean() ;
       	return  $output ;
	}

?>