<li <?php resume_class(); ?>>
	<a href="<?php the_resume_permalink(); ?>">
	
		<div class="candidate">
			<h3><?php the_title(); ?></h3>
		</div>
		
		<span class="candidate-title"><i class="fa fa-briefcase"></i> <?php the_candidate_title(); ?></span>
		<span class="candidate-location"><i class="fa fa-map-marker"></i> <?php ws_candidate_location( false ); ?></span>
		
	</a>
</li>