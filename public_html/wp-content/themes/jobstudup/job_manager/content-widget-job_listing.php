<li <?php job_listing_class(); ?>>
	<a href="<?php the_job_permalink(); ?>">
		<div class="position">
			<h3><?php the_title(); ?></h3>
			<?php if ( isset( $show_logo ) && $show_logo ) { ?>
				<div class="image">
					<?php the_company_logo(); ?>
				</div>
			<?php } ?>
		</div>
		<ul class="meta">
			<li class="location"><i class="fa fa-map-marker"></i> <?php ws_job_location( false ); ?></li>
			<li class="company"><i class="fa fa-building-o"></i> <?php the_company_name(); ?></li>
			<?php if ( get_option( 'job_manager_enable_types' ) ) { ?>
			<li class="job-type <?php echo wpjm_get_the_job_types() ? sanitize_title( wpjm_get_the_job_types()->slug ) : ''; ?>"><i class="fa fa-filter"></i> <?php wpjm_the_job_types(); ?></li>
			<?php } ?>
		</ul>
	</a>
</li>