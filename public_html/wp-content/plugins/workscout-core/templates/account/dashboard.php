<?php 
$current_user = wp_get_current_user();	
$user_post_count = count_user_posts( $current_user->ID , 'job_listings' ); 
$roles = $current_user->roles;
$role = array_shift( $roles ); 



?>


<!-- Content -->
<div class="row">
	
	<?php if(in_array($role,array('administrator','admin','employer'))) : ?>
	<!-- Item -->

		<div class="col-lg-3 col-md-6">
			<div class="dashboard-stat color-1">
				<div class="dashboard-stat-content">
					<h4><?php $user_post_count = count_user_posts( $current_user->ID , 'job_listing' ); echo $user_post_count; ?></h4> 
					<span><?php esc_html_e('Active Job Listings','workscout_core'); ?></span>
				</div>
				<div class="dashboard-stat-icon"><i class="ln ln-icon-File-Link"></i></div>
			</div>
		</div>
	<?php else : ?>
		<!-- Item -->
		<?php if(class_exists('WP_Resume_Manager')) : ?>
		<div class="col-lg-3 col-md-6">
			<div class="dashboard-stat color-1">
				<div class="dashboard-stat-content">
					<h4><?php $user_post_count = count_user_posts( $current_user->ID , 'resume' ); echo $user_post_count; ?></h4> 
					<span><?php esc_html_e('Active Resumes','workscout_core'); ?></span>
				</div>
				<div class="dashboard-stat-icon"><i class="ln ln-icon-File-Link"></i></div>
			</div>
		</div>
		<?php endif; ?>
	<?php endif; ?>


	<?php if(in_array($role,array('administrator','admin','employer'))) : ?>
	<?php $total_views = get_user_meta( $current_user->ID, 'workscout_total_jobs_views', true );
	if(!$total_views){
		$total_views = 0;
	} ?>
	<!-- Item -->
	<div class="col-lg-3 col-md-6">
		<div class="dashboard-stat color-2">
			<div class="dashboard-stat-content"><h4><?php echo esc_html($total_views); ?></h4> <span><?php esc_html_e('Total Jobs Views','workscout_core'); ?></span></div>
			<div class="dashboard-stat-icon"><i class="ln ln-icon-Bar-Chart"></i></div>
		</div>
	</div>
	<?php else : ?>

	<?php if(class_exists('WP_Resume_Manager')) : ?>
		<?php $total_views = get_user_meta( $current_user->ID, 'workscout_total_resumes_views', true );
		if(!$total_views){
			$total_views = 0;
		} ?>
		<!-- Item -->
		<div class="col-lg-3 col-md-6">
			<div class="dashboard-stat color-2">
				<div class="dashboard-stat-content"><h4><?php echo esc_html($total_views); ?></h4> <span><?php esc_html_e('
				Resumes Views','workscout_core'); ?></span></div>
				<div class="dashboard-stat-icon"><i class="ln ln-icon-Bar-Chart"></i></div>
			</div>
		</div>
		<?php endif; ?>	

	<?php endif; ?>	
	<?php if(class_exists('WP_Job_Manager_Applications')):  ?>
	<div class="col-lg-3 col-md-6">
				<div class="dashboard-stat color-3">
					<div class="dashboard-stat-content">
						<h4 class="counter">
							<?php 

							if($role == 'employer' || $role == 'administrator') {

								$args = array(
								  'author'        =>  $current_user->ID, 
								  'post_type'       =>  'job_listing',
								  'orderby'       =>  'post_date',
								  'order'         =>  'ASC',
								  'posts_per_page' => -1, // no limit
								  'fields'        => 'ids',
								);
								$current_user_jobs = get_posts( $args );
								$total_apps = 0;
								foreach ($current_user_jobs as $id) {
									$total_apps = $total_apps + get_job_application_count($id);
								} 
								echo $total_apps;

							} 
							if($role == 'candidate' ){
								

								$user_post_count = workscout_count_user_applications( $current_user->ID  ); 

								echo $user_post_count; 
							}
							?>
						</h4> 
						<span>
						<?php 
							if($role == 'candidate' ){
								esc_html_e('Your Applications','workscout_core');
							} else {
								esc_html_e('Total Applications','workscout_core');
							} ?>
							
						</span></div>
					<div class="dashboard-stat-icon"><i class="ln ln-icon-Business-ManWoman"></i></div>
				</div>
			</div>
	<?php endif; ?>

	<!-- Item -->
	<?php 
	if( class_exists('WP_Job_Manager_Bookmarks') ) :
	if($role == 'employer' || $role == 'administrator') {
		$total_bookmarks = workscout_count_all_user_jobs_bookmarks($current_user->ID); 
	} else {
		$total_bookmarks = workscout_count_all_user_bookmarks($current_user->ID); 
	}?>
	<div class="col-lg-3 col-md-6">
		<div class="dashboard-stat color-4">
			<div class="dashboard-stat-content"><h4><?php echo esc_html($total_bookmarks); ?></h4> <span>
				
				<?php 
					if($role == 'candidate' ){
						esc_html_e('Bookmarks','workscout_core');
					} else {
						esc_html_e('Times Bookmarked','workscout_core');
					} ?>
					
			</span></div>
			<div class="dashboard-stat-icon"><i class="im im-icon-Heart"></i></div>
		</div>
	</div>
	<?php endif; ?>
</div>


<div class="row">

	<!-- Recent Activity -->
	<div class="col-lg-6 col-md-12">
		<div class="dashboard-list-box with-icons margin-top-20" style="position: relative;">
			<h4><?php esc_html_e('Recent Activities','workscout_core'); ?></h4>
<?php
			global $wpdb;

			$current_user = wp_get_current_user();	 
			$user_id = $current_user->ID;

			$rowcount = $wpdb->get_var(
			
			'SELECT COUNT(*) FROM '.$wpdb->prefix.'workscout_core_activity_log
					WHERE related_to_id = '.$user_id.'
					ORDER BY  log_time DESC'
			
			);
			if($rowcount>0) : ?>
			<a href="#" id="workscout-clear-activities" class="clear-all-activities" data-nonce="<?php echo wp_create_nonce( 'delete_activities' ); ?>"><?php esc_html_e('Clear All','workscout_core') ?></a>
			<?php endif; ?>
			<?php echo do_shortcode( '[workscout_activities]' ); ?>		
		
	</div>
	<?php if(class_exists('WC_Paid_Listings')): ?>
	<!-- Invoices -->
	<div class="col-lg-6 col-md-12">
		<div class="dashboard-list-box invoices with-icons margin-top-20">
			<?php if($role == 'candidate' ){ ?>
			<h4><?php esc_html_e('Your Resume Packages','workscout_core') ?></h4>
			<?php } else { ?>
			<h4><?php esc_html_e('Your Listing Packages','workscout_core') ?></h4>
			<?php } ?>
			<ul class="products user-packages">
					<?php 
					if(function_exists('wc_paid_listings_get_user_packages')) :
					$user_packages = wc_paid_listings_get_user_packages( get_current_user_id() );
					
					if($user_packages) :
						foreach ( $user_packages as $key => $package ) :
							$package = wc_paid_listings_get_package( $package );
							?>
							<li class="user-job-package">
							<i class="list-box-icon fa fa-shopping-cart"></i>
							<strong><?php echo $package->get_title(); ?></strong>
							<p>
								<?php
								if ( $package->get_limit() ) {
									printf( _n( 'You have %1$s listings posted out of %2$d', 'You have %1$s listings posted out of %2$d', $package->get_count(), 'workscout_core' ), $package->get_count(), $package->get_limit() );
								} else {
									printf( _n( 'You have %s listings posted', 'You have %s listings posted', $package->get_count(), 'workscout_core' ), $package->get_count() );
								}

								if ( $package->get_duration() ) {
									printf( ', ' . _n( 'listed for %s day', 'listed for %s days', $package->get_duration(), 'workscout_core' ), $package->get_duration() );
								}

								$checked = 0;
							?>
							</p>

						</li>
						<?php endforeach;
						else : ?>
							<li class="no-icon"><?php esc_html_e("You don't have any packages yet.",'workscout_core'); ?></li>
						<?php endif; ?>
					<?php endif; ?>
				</ul>
		</div>
	</div>
	<?php endif; ?>
</div>