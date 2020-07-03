<?php

class envato_content_import extends WP_Import
{
	function check()
	{
		//you can add any extra custom functions after the importing of demo coment is done
		$this->attach_template_to_page('All Projects Full Width','template-projects-full-width.php')
		return true;
	}

	/**
	 * Attaches the specified template to the page identified by the specified name.
	 *
	 * @params    $page_name        The name of the page to attach the template.
	 * @params    $template_path    The template's filename (assumes .php' is specified)
	 *
	 * @returns   -1 if the page does not exist; otherwise, the ID of the page.
	 */
	function attach_template_to_page( $page_name, $template_file_name ) {

	    // Look for the page by the specified title. Set the ID to -1 if it doesn't exist.
	    // Otherwise, set it to the page's ID.
	    $page = get_page_by_title( $page_name, OBJECT, 'page' );
	    $page_id = null == $page ? -1 : $page->ID;

	    // Only attach the template if the page exists
	    if( -1 != $page_id ) {
	        update_post_meta( $page_id, '_wp_page_template', $template_file_name );
	    } // end if

	    return $page_id;

	} // end attach_template_to_page
}