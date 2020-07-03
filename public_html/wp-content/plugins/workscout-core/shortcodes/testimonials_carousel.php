<?php

/**
* Testimonials shortcode
* Usage: [testimonials_wide]
* Shows selected jobs in carousel
*/

function workscout_testimonials_carousel($atts) { 
    extract(shortcode_atts(array(
        'per_page'                  =>'4',
        'orderby'                   => 'date',
        'order'                     => 'DESC',
        'exclude_posts'             => '',
        'include_posts'             => '',
        'autoplay'                  => "off",
        'delay'                     => 5000,
        'background'                => '',
        'from_vs'                   => '',
        ), $atts));

    $randID = rand(1, 99);

    $args = array(
        'post_type' => array('testimonial'),
        'showposts' => $per_page,
        'orderby' => $orderby,
        'order' => $order,
    );
    if(!empty($exclude_posts)) {
        $exl = explode(",", $exclude_posts);
        $args['post__not_in'] = $exl;
    }
    if(!empty($include_posts)) {
        $inc = explode(",", $include_posts);
        $args['post__in'] = $inc;
    }
    $wp_query = new WP_Query( $args );
   
    if($from_vs === 'yes') {
        $bg_url = wp_get_attachment_url( $background );
    } else {
        $bg_url = $background;
    }

     
   ob_start(); ?>
      <?php $slick_autplay = ($autoplay == 'on') ? true : false ; ?>
<!-- Testimonials Carousel -->
	<?php if ( $wp_query->have_posts() ): ?>
	<div class="fullwidth-carousel-container margin-top-20">
		<div class="testimonial-carousel testimonials"  data-slick='{"autoplaySpeed": <?php echo $delay; ?>, "autoplay": <?php echo $slick_autplay; ?> }'>
			
			<?php   
				while( $wp_query->have_posts() ) : $wp_query->the_post(); 
			    	$id = $wp_query->post->ID;
                    $author = get_post_meta($id, 'pp_author', true);
                    $link = get_post_meta($id, 'pp_link', true);
                    $position = get_post_meta($id, 'pp_position', true); ?>
			<!-- Item -->
			<div class="fw-carousel-review">
			
				<div class="testimonial-box">
					<div class="testimonial"><?php the_content(); ?></div>
				</div>
				<div class="testimonial-author">
					<?php the_post_thumbnail(); ?>
					<h4><?php the_title(); ?> <?php  if(!empty($position)){ ?><span><?php echo $position; ?></span><?php } ?></h4>
				</div>
			</div>
			<?php  endwhile; ?>

			

		</div>
	</div>
    <?php 
     endif; 
  
    return ob_get_clean();
}?>