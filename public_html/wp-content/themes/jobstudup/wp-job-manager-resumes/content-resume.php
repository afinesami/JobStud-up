<?php
$category = get_the_resume_category(); 
$resume_photo_style = Kirki::get_option( 'workscout','pp_resume_rounded_photos','off' );

if($resume_photo_style){
	$photo_class = "rounded";
} else {
	$photo_class = "square";
}

?>
<li <?php resume_class($photo_class); ?>  
data-longitude="<?php echo esc_attr( $post->geolocation_long ); ?>" 
data-latitude="<?php echo esc_attr( $post->geolocation_lat ); ?>" 
data-color="#333333"

data-image="<?php echo (get_the_candidate_photo( $post)) ?  get_the_candidate_photo( $post ) : apply_filters( 'resume_manager_default_candidate_photo',RESUME_MANAGER_PLUGIN_URL . '/assets/images/candidate.png'); ?>" 
data-title="<?php the_title(); ?>" 
data-profession="<?php the_candidate_title(); ?>"
data-location="<?php echo esc_html(get_the_candidate_location( $post )); ?>" 
data-rate="<?php echo esc_html(ws_get_candidate_rate( $post )); ?>" 
data-skills="<?php echo esc_html(ws_get_candidate_skills( $post )); ?>" 


>
	<a class="photo-<?php echo $photo_class?>" href="<?php the_permalink(); ?>">
		<?php the_candidate_photo(); ?>
		<div class="resumes-content">
			<h4><?php the_title(); ?> <?php the_candidate_title( '<span>', '</span> ' ); ?></h4>
			<span><i class="fa fa-map-marker"></i> <?php ws_candidate_location( false ); ?></span>
			<?php $rate = get_post_meta( $post->ID, '_rate_min', true );
			$currency_position =  get_option('workscout_currency_position','before');

			if(!empty($rate)) { ?>
				<span class="icons"><i class="fa fa-money"></i> 
				<?php 
					if( $currency_position == 'before' ) { 
                        echo get_workscout_currency_symbol(); 
                    }   
                    echo get_post_meta( $post->ID, '_rate_min', true ); 
                    if( $currency_position == 'after' ) { 
                        echo get_workscout_currency_symbol(); 
                    }   
                    ?> <?php esc_html_e('/ hour','workscout') ?></span>
			<?php } ?>
			<p><?php the_excerpt(); ?></p>

			<?php echo ws_get_candidate_skills($post); ?>
		</div>
	
	</a>
	<div class="clearfix"></div>
</li>