<?php 
/**
* 
*/
class WorkScoutMaps 
{
	
	protected $plugin_slug = 'workscout-map';

	function __construct() {

		add_shortcode( 'workscout-map', array( $this, 'show_map' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		
		wp_register_script( $this->plugin_slug . '-script',  get_template_directory_uri() . '/js/workscout.big.map.min.js', array( 'jquery' ),'1.0', true );
	}

	public function show_map($atts){
		extract(shortcode_atts(array(
			'class' => '',
			'type' => 'job_listing',
			'height' => '450',
			), $atts));

	
		$query_args = array( 
			 	'post_type'              => $type,
        		'post_status'            => 'publish',
        		'posts_per_page'		 => -1,
			);

		
		$markers = array();
		// The Loop
		 $wp_query = new WP_Query( $query_args );
   		if ( $wp_query->have_posts() ):
			$i = 0;
			while( $wp_query->have_posts() ) : 
				$wp_query->the_post(); 
				
				$lat = $wp_query->post->geolocation_lat;
				$id = $wp_query->post->ID;
					if (!empty($lat)) {
					    
						$title = get_the_title();
						$ibcontet = '';
						ob_start();

						
						if($type == 'resume'){ //type resume 
							?>
							<a href="<?php the_permalink(); ?>" class="job-listing">
							 	<div class="job-listing-details">
							 		<div class="job-listing-company-logo"><?php the_candidate_photo(); ?></div>
							    	<div class="job-listing-description">
							      		<h4 class="job-listing-company"><?php the_candidate_title( '', '' ); ?></h4>
							      		<h3 class="job-listing-title"><?php the_title(); ?></h3>
							      			<?php echo ws_get_candidate_skills($wp_query->post); ?>
							     			<?php 
							     				$rate = get_post_meta( $id, '_rate_min', true );
												$currency_position =  get_option('workscout_currency_position','before');

													if(!empty($rate)) { ?>
														<ul>
															<li>
																<i class="fa fa-money"></i> <?php 
																if( $currency_position == 'before' ) { 
									                                echo get_workscout_currency_symbol(); 
									                            } 
																echo get_post_meta( $id, '_rate_min', true ); 
																if( $currency_position == 'after' ) { 
									                                echo get_workscout_currency_symbol(); 
									                            }
																?> <?php esc_html_e('/ hour','workscout') ?>
															</li>
														</ul>
													<?php } ?>
									</div>
							 	</div>
							</a>

						<?php } else { //type job

							?>
							 <?php $job_meta = Kirki::get_option( 'workscout','pp_meta_job_list',array('company','location','rate','salary') ); ?>
						<a href="<?php the_permalink(); ?>" class="job-listing">
				        	<div class="job-listing-details">
				        		<div class="job-listing-company-logo"><?php the_company_logo('medium'); ?></div>
				            	<div class="job-listing-description">
									<?php if (in_array("company", $job_meta) && get_the_company_name()) { ?>
										<h4 class="job-listing-company"> <?php the_company_name();?></h4>
									<?php } ?>
				            		<h3 class="job-listing-title"><?php the_title(); ?></h3>
				             			<?php if ( get_option( 'job_manager_enable_types' ) ) { ?>
											<?php echo ws_get_job_types($wp_query->post); ?>
										<?php } ?>
				            		<ul>
				            				<?php
				            			$currency_position =  get_option('workscout_currency_position','before');
										$rate_min = get_post_meta($id, '_rate_min', true ); 
										if ( $rate_min  && in_array("rate", $job_meta)) { 
											$rate_max = get_post_meta($id, '_rate_max', true ); 
											 ?>
											<li class="ws-meta-rate">
												<i class="fa fa-money"></i> 
				                            	<?php 
				                                if( $currency_position == 'before' ) { 
				                                    echo get_workscout_currency_symbol(); 
				                                } 
				                                echo esc_html( $rate_min );
				                                if( $currency_position == 'after' ) { 
				                                    echo get_workscout_currency_symbol(); 
				                                }
				                                if(!empty($rate_max)) { 
				                                    echo '- '; 
				                                    if($currency_position == 'before' ) { 
				                                        echo get_workscout_currency_symbol(); 
				                                    } 
				                                    echo esc_html($rate_max); 
				                                    if( $currency_position == 'after' ) { 
				                                        echo get_workscout_currency_symbol(); 
				                                    }
				                                } ?> <?php esc_html_e('/ hour','workscout'); ?>
											</li>
										<?php } ?>

										<?php 
										$salary_min = get_post_meta($id, '_salary_min', true ); 
										if ( $salary_min  && in_array("salary", $job_meta) ) {
											$salary_max = get_post_meta($id, '_salary_max', true );  ?>
											<li class="ws-meta-salary">
												<i class="fa fa-money"></i>
												<?php 
				                                    if( $currency_position == 'before' ) { 
				                                        echo get_workscout_currency_symbol(); 
				                                    } 
				                                    echo esc_html( $salary_min );
				                                    if( $currency_position == 'after' ) { 
				                                                echo get_workscout_currency_symbol(); 
				                                    } ?> <?php 
				                                    if(!empty($salary_max)) { 
				                                        echo ' - ';
				                                        if( $currency_position == 'before' ) { 
				                                            echo get_workscout_currency_symbol(); 
				                                        } 
				                                        echo $salary_max; 
				                                        if( $currency_position == 'after' ) { 
				                                            echo get_workscout_currency_symbol(); 
				                                        }
				                                    } 
				                                ?>
											</li>
										<?php } ?>
				              		</ul>
				           		</div>
				        	</div>
				      	</a>
						
						<?php 
						}
						$ibcontet =  ob_get_clean();
						
						
						$mappoint = array(
							'ibcontent' => $ibcontet,
							'lat' =>  $lat,
							'lng' =>  $wp_query->post->geolocation_long,
							'id' => $i
							
							
						);

					    $markers[] = $mappoint;
					    $i++;
					
				}

			 endwhile;
	    
	    endif; 
    	wp_reset_postdata();

		
		wp_enqueue_script( $this->plugin_slug . '-script' );
		wp_localize_script( $this->plugin_slug . '-script', 'ws_big_map', $markers );

		$output = '';
		$output .= '<div id="map-container" class="'.esc_attr($class).'">';
		$output .= '	<div id="ws-map" >
					        <!-- map goes here -->
					    </div>
					    
					</div>';

		return $output;
		;
	}


	private function find_matching_location($haystack, $needle) {

	    foreach ($haystack as $index => $a) {

	        if ($a['lat'] == $needle['lat']
	                && $a['lng'] == $needle['lng']
	              ) {
	            return $index;
	        }
	    }
	    return null;
	}

}
new WorkScoutMaps();
?>