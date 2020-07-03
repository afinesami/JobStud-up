<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WorkScout_Core_Search {

    /**
     * The single instance of WordPress_Plugin_Template_Settings.
     * @var     object
     * @access  private
     * @since   1.0.0
     */
    private static $_instance = null;

	public function __construct () {
		
		add_filter( 'job_manager_get_listings', array( $this,'workscout_filter_by_company'), 10, 2 );
		add_filter( 'job_manager_get_listings', array( $this,'workscout_filter_by_salary_field_query_args'), 10, 2 );
		add_filter( 'job_manager_get_listings', array( $this,'workscout_filter_by_rate_field_query_args'), 10, 2 );
		add_filter( 'job_manager_get_listings', array( $this,'workscout_filter_by_radius_query_args'), 10, 2 );

		add_filter( 'resume_manager_get_resumes', array( $this,'workscout_filter_by_skills_field_query_args'), 10, 2 );
		add_filter( 'resume_manager_get_resumes', array( $this,'workscout_resume_filter_by_rate_field_query_args'), 10, 2 );
		add_filter( 'resume_manager_get_resumes', array( $this,'workscout_filter_resumes_by_radius_query_args'), 10, 2 );

	}





	function workscout_filter_by_company( $query_args, $args ) {

		if ( isset( $_POST['form_data'] ) ) {
			parse_str( $_POST['form_data'], $form_data );
			if( isset( $form_data['company_field']) ) {
				$query_args['meta_query'][] = array(
				 	array(
		                'key'   => '_company_name',
		                'value' => $form_data['company_field'],
		                'compare' => '='
		            )
		        );
		        add_filter( 'job_manager_get_listings_custom_filter', '__return_true' );
			} else {
				add_filter( 'job_manager_get_listings_custom_filter', '__return_true' );
			}

		}
		return $query_args;

	}




	/**
	 * This code gets your posted field and modifies the job search query
	 */


	function workscout_filter_by_salary_field_query_args( $query_args, $args ) {
		if ( isset( $_POST['form_data'] ) ) {
			parse_str( $_POST['form_data'], $form_data );

			// If this is set, we are filtering by salary
			if( isset( $form_data['filter_by_salary_check']) ) {
				if ( ! empty( $form_data['filter_by_salary'] ) ) {
					$selected_range = sanitize_text_field( $form_data['filter_by_salary'] );
						
						$range = array_map( 'absint', explode( '-', $selected_range ) );
					 	$query_args['meta_query'][] = array(
						 	'relation' => 'OR',
						        array(
						            'relation' => 'OR',
						            array(
		                                'key' => '_salary_min',
		                                'value' => $range,
		                                'compare' => 'BETWEEN',
		                                'type' => 'NUMERIC',
		                            ),
		                            array(
		                                'key' => '_salary_max',
		                                'value' => $range,
		                                'compare' => 'BETWEEN',
		                                'type' => 'NUMERIC',
		                            ),
						 
						        ),
						        array(
						            'relation' => 'AND',
						            array(
		                                'key' => '_salary_min',
		                                'value' => $range[0],
		                                'compare' => '<=',
		                                'type' => 'NUMERIC',
		                            ),
		                            array(
		                                'key' => '_salary_max',
		                                'value' => $range[1],
		                                'compare' => '>=',
		                                'type' => 'NUMERIC',
		                            ),
						 
						        ),
				        );
				
					// This will show the 'reset' link
					add_filter( 'job_manager_get_listings_custom_filter', '__return_true' );
				}
			} else {
				add_filter( 'job_manager_get_listings_custom_filter', '__return_true' );
			}
		}
		return $query_args;

	}


	/**
	 * This code gets your posted field and modifies the job search query
	 */
	

	function workscout_filter_by_rate_field_query_args( $query_args, $args ) {
		if ( isset( $_POST['form_data'] ) ) {
			parse_str( $_POST['form_data'], $form_data );

			// If this is set, we are filtering by salary
			if( isset( $form_data['filter_by_rate_check'])) {
				if ( ! empty( $form_data['filter_by_rate'] ) ) {
					$selected_range = sanitize_text_field( $form_data['filter_by_rate'] );
				
						$range = array_map( 'absint', explode( '-', $selected_range ) );
					 	$query_args['meta_query'][] = array(
						 	'relation' => 'OR',
						        array(
						            'relation' => 'OR',
						            array(
		                                'key' => '_rate_min',
		                                'value' => $range,
		                                'compare' => 'BETWEEN',
		                                'type' => 'NUMERIC',
		                            ),
		                            array(
		                                'key' => '_rate_max',
		                                'value' => $range,
		                                'compare' => 'BETWEEN',
		                                'type' => 'NUMERIC',
		                            ),
						 
						        ),
						        array(
						            'relation' => 'AND',
						            array(
		                                'key' => '_rate_min',
		                                'value' => $range[0],
		                                'compare' => '<=',
		                                'type' => 'NUMERIC',
		                            ),
		                            array(
		                                'key' => '_rate_max',
		                                'value' => $range[1],
		                                'compare' => '>=',
		                                'type' => 'NUMERIC',
		                            ),
						 
						        ),
				        );
				

					// This will show the 'reset' link
					add_filter( 'job_manager_get_listings_custom_filter', '__return_true' );
				}
			}
		}
		return $query_args;

	}



	/**
	 * This code gets your posted field and modifies the job search query
	 */


	function workscout_filter_by_radius_query_args( $query_args, $args ) {
		if ( isset( $_POST['form_data'] ) ) {
			parse_str( $_POST['form_data'], $form_data );

			// If this is set, we are filtering by radius
			if( isset( $form_data['search_radius']) && !empty( $form_data['search_radius'] ) && isset($form_data['filter_by_radius_check'])) {
				
				if ( ! empty( $form_data['search_radius'] ) ) {
					$address = $form_data['search_location'];
					$radius = $form_data['search_radius'];
					$radius_type = get_option('workscout_radius_unit','km');
					if(!empty($address)) {
						$latlng = workscout_geocode($address);
						$nearbyposts = workscout_get_nearby_jobs($latlng[0], $latlng[1], $radius, $radius_type ); 
						workscout_array_sort_by_column($nearbyposts,'distance');

						$ids = array_unique(array_column($nearbyposts, 'post_id'));
						if(!empty($ids)) {
							$query_args['post__in'] = $ids;
							unset( $query_args['meta_query'][0]); //this should remove location search - needs further testing
						}
					}

					// This will show the 'reset' link
					add_filter( 'job_manager_get_listings_custom_filter', '__return_true' );
				}
			} else {
				add_filter( 'job_manager_get_listings_custom_filter', '__return_true' );
			}
		}

		return $query_args;
	}



	/**
	 * This code gets your posted field and modifies the job search query
	 */
	

	function workscout_filter_resumes_by_radius_query_args( $query_args, $args ) {
		if ( isset( $_POST['form_data'] ) ) {
			parse_str( $_POST['form_data'], $form_data );

			// If this is set, we are filtering by salary
		if( isset( $form_data['search_radius']) && !empty( $form_data['search_radius'] ) && isset($form_data['filter_by_radius_check'])) {
				if ( ! empty( $form_data['search_radius'] ) ) {
					$address = $form_data['search_location'];
					$radius = $form_data['search_radius'];
					$radius_type = get_option('workscout_radius_unit','km');
					if(!empty($address)) {

						$latlng = workscout_geocode($address);
						
						$nearbyposts = workscout_get_nearby_jobs($latlng[0], $latlng[1], $radius, $radius_type ); 
						workscout_array_sort_by_column($nearbyposts,'distance');

						$ids = array_unique(array_column($nearbyposts, 'post_id'));
						if(!empty($ids)) {
							$query_args['post__in'] = $ids;
							unset( $query_args['meta_query'][0]); //this should remove location search - needs further testing
						}
					}

					// This will show the 'reset' link
					add_filter( 'resume_manager_get_resumes_custom_filter', '__return_true' );
				}
			} else {
				add_filter( 'resume_manager_get_resumes_custom_filter', '__return_true' );
			}
		}

		return $query_args;
	}

	/**
	 * This code gets your posted field and modifies the job search query
	 */
	
	function workscout_resume_filter_by_rate_field_query_args( $query_args, $args ) {
		if ( isset( $_POST['form_data'] ) ) {
			parse_str( $_POST['form_data'], $form_data );

			// If this is set, we are filtering by salary
			if( isset( $form_data['filter_by_rate_check'])) {
				if ( ! empty( $form_data['filter_by_rate'] ) ) {
					$selected_range = sanitize_text_field( $form_data['filter_by_rate'] );
				
					 	$query_args['meta_query'][] = array(
							'key'     => '_rate_min',
							'value'   => array_map( 'absint', explode( '-', $selected_range ) ),
							'compare' => 'BETWEEN',
							'type'    => 'NUMERIC'
						);
				

					// This will show the 'reset' link
					add_filter( 'resume_manager_get_resumes_custom_filter', '__return_true' );
				}
			}
		}
		return $query_args;

	}


	/**
	 * This code gets your posted field and modifies the resume search query
	 */
	
	function workscout_filter_by_skills_field_query_args( $query_args, $args ) {
		if ( isset( $_POST['form_data'] ) ) {
			parse_str( $_POST['form_data'], $form_data );

			// If this is set, we are filtering by salary
			if( isset( $form_data['search_skills'])) {
				if ( ! empty( $form_data['search_skills'] ) ) {
						
						$field    = is_numeric( $form_data['search_skills'][0] ) ? 'term_id' : 'slug';
						$operator = 'all' === sizeof( $form_data['search_skills'] ) > 1 ? 'AND' : 'IN';
			
						$query_args['tax_query'][] = array(
							'taxonomy'         => 'resume_skill',
							'field'            => $field,
							'terms'            => array_values( $form_data['search_skills'] ),
							'include_children' => $operator !== 'AND' ,
							'operator'         => $operator
						);
					// This will show the 'reset' link
					add_filter( 'resume_manager_get_resumes_custom_filter', '__return_true' );
					
				}
			}
		}
		return $query_args;

	}



}