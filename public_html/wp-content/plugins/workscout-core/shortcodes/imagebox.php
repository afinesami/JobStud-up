<?php 
	
	/**
	* Headline shortcode
	* Usage: [iconbox title="Service Title" url="#" icon="37"] test [/headline]
	*/
	function workscout_imagebox( $atts, $content ) {
	  extract(shortcode_atts(array(
		    'category' 		=> '',/*it's region but it's too late to rename it */
		    'job_type' => '',
		    'featured' 		=> '',
		    'show_counter' 	=> '',
	        'background'	=> '',
		    'from_vs' 		=> 'no',
	    ), $atts));
 		if($from_vs=='yes') {
	    	$background = wp_get_attachment_url( $background );
		}
		
		if($category) {
			$term = get_term_by( 'id', $category, 'job_listing_region' );
			$url = get_term_link((int) $category,'job_listing_region');
		}
		if($job_type) {
			$term = get_term_by( 'id', $job_type, 'job_listing_type' );
			$url = get_term_link((int) $job_type,'job_listing_type');
		}
	
		if( is_wp_error( $term ) || $term == false)   {
			return;
		} 
		if( is_wp_error( $url ) || $url == false)   {
			return;
		} 
        ob_start(); ?>
		 <!-- Image Box -->
		<a href="<?php echo esc_url($url); ?>" class="img-box" data-background-image="<?php echo esc_attr($background); ?>">
			
			<?php if($featured) : ?>
			<!-- Badge -->
			<div class="listing-badges">
				<span class="featured"><?php esc_html_e('Featured','workscout') ?></span>
			</div>
			<?php endif; ?>

			<div class="img-box-content visible">
				<h4><?php echo $term->name; ?></h4>
				<?php if($show_counter) : ?><span><?php echo $term->count; ?> <?php esc_html_e('Jobs','workscout') ?></span> <?php endif; ?>
			</div>
		</a>


	    <?php
	    $output =  ob_get_clean() ;
       	return  $output ;
	}

?>