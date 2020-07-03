<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WorkScout
 */

?>
<!-- Footer
================================================== -->
<div class="margin-top-45"></div>

<div id="footer">
<!-- Main -->
	<div class="container">
		<?php 
		$footer_layout = Kirki::get_option( 'workscout', 'pp_footer_widgets' ); 
        $footer_layout_array = explode(',', $footer_layout); 
        $x = 0;
        foreach ($footer_layout_array as $value) {
            $x++;
             ?>
             <div class="<?php echo esc_attr(workscout_number_to_width($value)); ?> columns">
                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer'.$x)) : endif; ?>
            </div>
        <?php } ?>
	</div>

	<!-- Bottom -->
	<div class="container">
		<div class="footer-bottom">
			<div class="sixteen columns">
				
                <?php /* get the slider array */
                $footericons = get_option( 'pp_footericons', array() );
                if ( !empty( $footericons ) ) {
                    echo '<h4>'.esc_html__('Follow us','workscout').'</h4>';
                    echo '<ul class="social-icons">';
                    foreach( $footericons as $icon ) {
                        echo '<li><a target="_blank" class="' . $icon['icons_service'] . '" title="' . esc_attr($icon['title']) . '" href="' . esc_url($icon['icons_url']) . '"><i class="icon-' . $icon['icons_service'] . '"></i></a></li>';
                    }
                    echo '</ul>';
                }
                ?>
				
				<div class="copyrights"><?php $copyrights = Kirki::get_option( 'workscout', 'pp_copyrights' ); 
		        if (function_exists('icl_register_string')) {
		            icl_register_string('Copyrights in footer','copyfooter', $copyrights);
		            echo icl_t('Copyrights in footer','copyfooter', $copyrights);
		        } else {
		            echo wp_kses($copyrights,array('br' => array(),'em' => array(),'strong' => array(),'a' => array('href' => array(),'title' => array())));
		        } ?></div>
			</div>
		</div>
	</div>

</div>

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>
<div id="ajax_response"></div>
</div>
<!-- Wrapper / End -->

<?php if(( is_page_template('template-home.php') || is_page_template('template-home-resumes.php')) && get_option('pp_jobs_home_typed_status','enable') == 'enable') { 
    $typed = get_option('pp_jobs_home_typed_text','healthcare, automotive, sales & marketing, accounting & finance'); 
    $typed_array = explode(',',$typed);
    ?>
                        <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.9"></script>
                        <script>
                            console.log( <?php echo json_encode($typed_array); ?>);
                        var typed = new Typed('.typed-words', {
                        strings: <?php echo json_encode($typed_array); ?>,
                        typeSpeed: 80,
                        backSpeed: 80,
                        backDelay: 4000,
                        startDelay: 1000,
                        loop: true,
                        showCursor: true
                        });
                        </script>
                    <?php } ?>

<?php wp_footer(); ?>

</body>
</html>
