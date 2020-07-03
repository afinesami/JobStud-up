<?php
/**
 * Template loader for PW Sample Plugin.
 *
 * Only need to specify class listings here.
 *
 */
class WorkScout_Core_Template_Loader extends Gamajo_Template_Loader {
 
	/**
	 * Prefix for filter names.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $filter_prefix = 'workscout_core';
 
	/**
	 * Directory name where custom templates for this plugin should be found in the theme.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $theme_template_directory = 'workscout-core';
 
	/**
	 * Reference to the root directory path of this plugin.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $plugin_directory = WORKSCOUT_PLUGIN_DIR;

	/**
	   * Directory name where templates are found in this plugin.
	   *
	   * Can either be a defined constant, or a relative reference from where the subclass lives.
	   *
	   * e.g. 'templates' or 'includes/templates', etc.
	   *
	   * @since 1.1.0
	   *
	   * @var string
	   */
	  protected $plugin_template_directory = 'templates';
 	
}


?>