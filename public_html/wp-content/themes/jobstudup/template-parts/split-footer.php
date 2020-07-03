<!-- Footer -->
<div class="small-footer margin-top-15">
	<div class="small-footer-copyrights">
		<?php $copyrights = Kirki::get_option( 'workscout', 'pp_copyrights' ); 
                if (function_exists('icl_register_string')) {
                    icl_register_string('Copyrights in footer','copyfooter', $copyrights);
                    echo icl_t('Copyrights in footer','copyfooter', $copyrights);
                } else {
                    echo wp_kses($copyrights,array('br' => array(),'em' => array(),'strong' => array(),'a' => array('href' => array(),'title' => array())));
                } ?>
	</div>
	
		  <?php /* get the slider array */
            $footericons = get_option( 'pp_footericons', array() );
            if ( !empty( $footericons ) ) {
                
                echo '<ul class="footer-social-links">';
                foreach( $footericons as $icon ) {
                    echo '<li><a target="_blank" class="' . $icon['icons_service'] . '" title="' . esc_attr($icon['title']) . '" href="' . esc_url($icon['icons_url']) . '"><i class="icon-' . $icon['icons_service'] . '"></i></a></li>';
                }
                echo '</ul>';
            }
            ?>
	
	<div class="clearfix"></div>
</div>
<!-- Footer / End -->