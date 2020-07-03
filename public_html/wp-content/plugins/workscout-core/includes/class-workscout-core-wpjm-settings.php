<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WorkScout_Core_WPJM_Settings {

    /**
     * The single instance of WordPress_Plugin_Template_Settings.
     * @var     object
     * @access  private
     * @since   1.0.0
     */
    private static $_instance = null;

	public function __construct () {
		add_filter( 'job_manager_settings', array( $this,'workscout_job_manager_settings') );
		add_filter( 'resume_manager_settings', array( $this,'workscout_resume_manager_settings') );
	}


/*
 * Adds Settings for Job Manager Options
 */


function workscout_job_manager_settings($settings = array()){
	$settings['job_listings'][1][] = array(
		'name'    => 'workscout_currency_setting',
		'std'     => 'USD',
		'label'   => 'Currency Symbol',
		'desc'    => 'Select the currency symbol that will be used in salary/rate fields',
		'type'    => 'select',
		'options' => array(
			'none' => esc_html__( 'Disable Currency Symbol', 'workscout_core' ),
			'USD' => esc_html__( 'US Dollars', 'workscout_core' ),
			'AED' => esc_html__( 'United Arab Emirates Dirham', 'workscout_core' ),
			'ARS' => esc_html__( 'Argentine Peso', 'workscout_core' ),
			'AUD' => esc_html__( 'Australian Dollars', 'workscout_core' ),
			'BDT' => esc_html__( 'Bangladeshi Taka', 'workscout_core' ),
			'BHD' => esc_html__( 'Bahraini Dinar', 'workscout_core' ),
			'BRL' => esc_html__( 'Brazilian Real', 'workscout_core' ),
			'BGN' => esc_html__( 'Bulgarian Lev', 'workscout_core' ),
			'CAD' => esc_html__( 'Canadian Dollars', 'workscout_core' ),
			'CLP' => esc_html__( 'Chilean Peso', 'workscout_core' ),
			'CNY' => esc_html__( 'Chinese Yuan', 'workscout_core' ),
			'COP' => esc_html__( 'Colombian Peso', 'workscout_core' ),
			'CZK' => esc_html__( 'Czech Koruna', 'workscout_core' ),
			'DKK' => esc_html__( 'Danish Krone', 'workscout_core' ),
			'DOP' => esc_html__( 'Dominican Peso', 'workscout_core' ),
			'EUR' => esc_html__( 'Euros', 'workscout_core' ),
			'HKD' => esc_html__( 'Hong Kong Dollar', 'workscout_core' ),
			'HRK' => esc_html__( 'Croatia kuna', 'workscout_core' ),
			'HUF' => esc_html__( 'Hungarian Forint', 'workscout_core' ),
			'ISK' => esc_html__( 'Icelandic krona', 'workscout_core' ),
			'IDR' => esc_html__( 'Indonesia Rupiah', 'workscout_core' ),
			'INR' => esc_html__( 'Indian Rupee', 'workscout_core' ),
			'NPR' => esc_html__( 'Nepali Rupee', 'workscout_core' ),
			'ILS' => esc_html__( 'Israeli Shekel', 'workscout_core' ),
			'JPY' => esc_html__( 'Japanese Yen', 'workscout_core' ),
			'KIP' => esc_html__( 'Lao Kip', 'workscout_core' ),
			'KRW' => esc_html__( 'South Korean Won', 'workscout_core' ),
			'LKR' => esc_html__( 'Sri Lankan Rupee', 'workscout_core' ),
			'MYR' => esc_html__( 'Malaysian Ringgits', 'workscout_core' ),
			'MXN' => esc_html__( 'Mexican Peso', 'workscout_core' ),
			'NGN' => esc_html__( 'Nigerian Naira', 'workscout_core' ),
			'NOK' => esc_html__( 'Norwegian Krone', 'workscout_core' ),
			'NZD' => esc_html__( 'New Zealand Dollar', 'workscout_core' ),
			'PYG' => esc_html__( 'Paraguayan Guaraní', 'workscout_core' ),
			'PHP' => esc_html__( 'Philippine Pesos', 'workscout_core' ),
			'PLN' => esc_html__( 'Polish Zloty', 'workscout_core' ),
			'GBP' => esc_html__( 'Pounds Sterling', 'workscout_core' ),
			'RON' => esc_html__( 'Romanian Leu', 'workscout_core' ),
			'RUB' => esc_html__( 'Russian Ruble', 'workscout_core' ),
			'SGD' => esc_html__( 'Singapore Dollar', 'workscout_core' ),
			'ZAR' => esc_html__( 'South African rand', 'workscout_core' ),
			'SEK' => esc_html__( 'Swedish Krona', 'workscout_core' ),
			'CHF' => esc_html__( 'Swiss Franc', 'workscout_core' ),
			'TWD' => esc_html__( 'Taiwan New Dollars', 'workscout_core' ),
			'THB' => esc_html__( 'Thai Baht', 'workscout_core' ),
			'TRY' => esc_html__( 'Turkish Lira', 'workscout_core' ),
			'UAH' => esc_html__( 'Ukrainian Hryvnia', 'workscout_core' ),
			'USD' => esc_html__( 'US Dollars', 'workscout_core' ),
			'VND' => esc_html__( 'Vietnamese Dong', 'workscout_core' ),
			'EGP' => esc_html__( 'Egyptian Pound', 'workscout_core' ),
			'ZMK' => esc_html__( 'Zambian Kwacha', 'workscout_core' )
		)
	);
	$settings['job_listings'][1][] = array(
		'name'    => 'workscout_currency_position',
		'std'     => 'before',
		'label'   => 'Currency Symbol positon',
		'desc'    => 'Select the positon of currency symbol (before/after number)',
		'type'    => 'select',
		'options' => array(
			'before' 	=> esc_html__( 'Before number', 'workscout_core' ),
			'after' 	=> esc_html__( 'After number', 'workscout_core' )
		)
	);
	$settings['job_listings'][1][] = array(
			'name' 		=> 'workscout_enable_hour_field',
			'std' 		=> '',
			'label' 	=> esc_html__( 'Enable Hours per week field', 'workscout_core' ),
			'cb_label'  => esc_html__( 'Enable Hours per week field', 'workscout_core' ),
			'desc'		=> esc_html__( 'Enabling this option will show a Hours per week field in Post a Job page.', 'workscout_core' ),
			'type'      => 'checkbox'
	);	
	$settings['job_listings'][1][] = array(
			'name' 		=> 'workscout_enable_filter_salary',
			'std' 		=> '',
			'label' 	=> esc_html__( '"Salaries" functionality', 'workscout_core' ),
			'cb_label'  => esc_html__( 'Enable filter option on Jobs page', 'workscout_core' ),
			'desc'		=> esc_html__( 'Enabling this option will show a salary range filter in sidebar on Jobs page and salary fields on Job posting.', 'workscout_core' ),
			'type'      => 'checkbox'
	);	
	$settings['job_listings'][1][] = array(
			'name' 		=> 'workscout_enable_filter_rate',
			'std' 		=> '',
			'label' 	=> esc_html__( '"Rates" functionality', 'workscout_core' ),
			'cb_label'  => esc_html__( 'Enable filter option on Jobs page', 'workscout_core' ),
			'desc'		=> esc_html__( 'Enabling this option will show a rate range filter in sidebar on Jobs page and rate fields on Job posting.', 'workscout_core' ),
			'type'      => 'checkbox'
	);	

	$settings['job_listings'][1][] = array(
			'name' 		=> 'workscout_enable_location_sidebar',
			'std' 		=> '1',
			'label' 	=> esc_html__( 'Location field on Jobs page', 'workscout_core' ),
			'cb_label'  => esc_html__( 'Show location search field on Jobs page sidebar', 'workscout_core' ),
			'desc'		=> esc_html__( 'Uncheck to hide', 'workscout_core' ),
			'type'      => 'checkbox'
	);	
	$settings['job_listings'][1][] = array(
			'name' 		=> 'workscout_enable_job_types_sidebar',
			'std' 		=> '1',
			'label' 	=> esc_html__( 'Job Types field on Jobs page', 'workscout_core' ),
			'cb_label'  => esc_html__( 'Show Job Types field on Jobs page sidebar', 'workscout_core' ),
			'desc'		=> esc_html__( 'Uncheck to hide', 'workscout_core' ),
			'type'      => 'checkbox'
	);	
	$settings['job_pages']['1'][] = array(
				'name'  => 'pp_bookmarks_page',
				'std'   => '',
				'label' => __( 'My Bookmarks Page', 'workscout_core' ),
				'desc'  => __( 'Select the page where you\'ve used the [my_bookmarks]  shortcode. This requires Bookmarks add-on', 'workscout_core' ),
				'type'  => 'page',
	);	
	if ( taxonomy_exists( "job_listing_tag" )) {
		$settings['job_listings'][1][] = array(
				'name' 		=> 'workscout_enable_job_tags_sidebar',
				'std' 		=> '1',
				'label' 	=> esc_html__( 'Job Tags filter on Jobs page', 'workscout_core' ),
				'cb_label'  => esc_html__( 'Show Job Tags filter on Jobs page sidebar', 'workscout_core' ),
				'desc'		=> esc_html__( 'Uncheck to hide', 'workscout_core' ),
				'type'      => 'checkbox'
		);
	}
	
	return $settings;
}

/*
 * Adds Settings for  Resumes Options
 */


function workscout_resume_manager_settings($settings = array()){
	$settings['resume_listings'][1][] = array(
			'name' 		=> 'workscout_enable_resume_filter_rate',
			'std' 		=> '',
			'label' 	=> esc_html__( 'Filter Resumes by Rate', 'workscout_core' ),
			'cb_label'  => esc_html__( 'Enable filter option on Resumes page', 'workscout_core' ),
			'desc'		=> esc_html__( 'Enabling this option will show a salary range filter in sidebar on Resumes page.', 'workscout_core' ),
			'type'      => 'checkbox'
	);

	$settings['resume_listings'][1][] = array(
			'name' 		=> 'workscout_enable_resume_comments',
			'std'        => '0',
			'label' 	=> esc_html__( 'Enable comments on Resumes', 'workscout_core' ),
			'cb_label'  => esc_html__( 'Enable comments on Resumes', 'workscout_core' ),
			'desc'		=> esc_html__( 'Check to enable comments section on Resumes.', 'workscout_core' ),
			'type'      => 'checkbox',
			'attributes' => array()
	);

	return $settings;
}





}