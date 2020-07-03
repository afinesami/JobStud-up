<?php

// This is the export file that writes json files
// Your build process should probably exclude this file from the final theme zip, but it doesn't really matter.

// Change line 100 where it has the hard coded: /../theme/images/stock/ path
// This is the path where media files are copied to during export.
// Change this to your theme folder images/stock/ path, whatever that may be.
// The importer will look for local 'images/stock/*.jpg' files during import.

// Also change the json export path near the bottom: theme/envato_setup/content/

echo 'test';
$default_content = array();
$post_types      = array( 'attachment', 'wpcf7_contact_form', 'post', 'page' );
foreach ( get_post_types() as $post_type ) {
	if ( ! in_array( $post_type, $post_types ) ) { // which post types to ignore.
		$post_types[] = $post_type;
	}
}
$categories = get_categories( array( 'type' => '' ) );
$taxonomies = get_taxonomies();
//              print_r($categories);
foreach ( $post_types as $post_type ) {
	if ( in_array( $post_type, array( 'revision', 'event', 'event-recurring' ) ) ) {
		continue;
	} // post types to ignore.
	$args                = array( 'post_type' => $post_type, 'posts_per_page' => - 1 );
	$args['post_status'] = array( 'publish', 'private', 'inherit' );
	if ( $post_type == 'attachment' ) {

	}
	$post_datas = get_posts( $args );
	if ( ! isset( $default_content[ $post_type ] ) ) {
		$default_content[ $post_type ] = array();
	}
	$object = get_post_type_object( $post_type );
	if ( $object && ! empty( $object->labels->singular_name ) ) {
		$type_title = $object->labels->name;
	} else {
		$type_title = ucwords( $post_type ) . 's';
	}

	foreach ( $post_datas as $post_data ) {
		$meta = get_post_meta( $post_data->ID, '', true );
		
		foreach ( $meta as $meta_key => $meta_val ) {
			if (
				// which keys to nuke all the time
				in_array( $meta_key, array( '_location_id' ) )
				||
				(
					// which keys we want to keep all the time, using strpos:
					strpos( $meta_key, 'pp_sidebar_layout' ) === false &&
					strpos( $meta_key, 'pp_page_titlebar' ) === false &&
					strpos( $meta_key, 'pp_sidebar_set' ) === false &&
					strpos( $meta_key, 'pp_' ) === false &&
					strpos( $meta_key, 'wpb_' ) === false &&
					strpos( $meta_key, 'dtbwp_' ) === false &&
					strpos( $meta_key, '_slider' ) === false &&
					// which post types we keep all meta values for:
					! in_array( $post_type, array(
						'nav_menu_item',
						'location',
						'project',
						'testimonials',
						'job_listing',
						'resume',
						'team',
						'services',
						'product',
						'wpcf7_contact_form',
					) ) &&
					// other meta keys we always want to keep:
					! in_array( $meta_key, array(
			
						'_wp_attached_file',
						'_thumbnail_id',
						'_gallery',		
						'_wp_page_template',						
					) )
				)
			) {
				unset( $meta[ $meta_key ] );
			} else {
				$meta[ $meta_key ] = maybe_unserialize( get_post_meta( $post_data->ID, $meta_key, true ) );
			}
		}
	
		// copy stock images into the images/stock/ folder for theme import.
		if ( $post_type == 'attachment' ) {
			$file = get_attached_file( $post_data->ID );
			if ( is_file( $file ) ) {
				if ( filesize( $file ) > 1500000 ) {
					$image = wp_get_image_editor( $file );
					if ( ! is_wp_error( $image ) ) {
						list( $width, $height, $type, $attr ) = getimagesize( $file );
						$image->resize( min( $width, 1200 ), null, false );
						$image->save( $file );
					}
				}
				$post_data->guid = wp_get_attachment_url( $post_data->ID );
				if ( is_dir( get_home_path() . '/wp-content/uploads/workscout/images/stock/' ) ) {
					copy( $file, get_home_path() . '/wp-content/uploads/workscout/images/stock/' . basename( $file ) );
				}
			}
			// fix for incorrect GUID when renaming files with the rename plugin, causes import to bust.

		}
		$terms = array();
		foreach ( $taxonomies as $taxonomy ) {
			$terms[ $taxonomy ] = wp_get_post_terms( $post_data->ID, $taxonomy, array( 'fields' => 'all' ) );
			/*if($terms[$taxonomy]){
				foreach($terms[$taxonomy] as $tax_id => $tax){
					if(!empty($tax->term_id)) {
						$terms[ $taxonomy ][ $tax_id ] -> meta = get_term_meta( $tax->term_id );
					}
				}
			}*/
		}
		$default_content[ $post_type ][] = array(
			'type_title'     => $type_title,
			'post_id'        => $post_data->ID,
			'post_title'     => $post_data->post_title,
			'post_status'    => $post_data->post_status,
			'post_name'      => $post_data->post_name,
			'post_content'   => $post_data->post_content,
			'post_excerpt'   => $post_data->post_excerpt,
			'post_parent'    => $post_data->post_parent,
			'menu_order'     => $post_data->menu_order,
			'post_date'      => $post_data->post_date,
			'post_date_gmt'  => $post_data->post_date_gmt,
			'guid'           => $post_data->guid,
			'post_mime_type' => $post_data->post_mime_type,
			'meta'           => $meta,
			'terms'          => $terms,
			//                          'other' => $post_data,
		);
	}
}
// put certain content at very end.
$nav = isset( $default_content['nav_menu_item'] ) ? $default_content['nav_menu_item'] : array();
if ( $nav ) {
	unset( $default_content['nav_menu_item'] );
	$default_content['nav_menu_item'] = $nav;
}
//              print_r($default_content);
//              exit;
// find the ID of our menu names so we can import them into default menu locations and also the widget positions below.
$menus    = get_terms( 'nav_menu' );

$menu_ids = array();
foreach ( $menus as $menu ) {
	if ( $menu->name == 'All Pages Flat' ) {
		$menu_ids['primary'] = $menu->term_id;
	} 
}
// used for me to export my widget settings.
$widget_positions = get_option( 'sidebars_widgets' );
$widget_options   = array();
$my_options       = array();
foreach ( $widget_positions as $sidebar_name => $widgets ) {
	if ( is_array( $widgets ) ) {
		foreach ( $widgets as $widget_name ) {
			$widget_name_strip                    = preg_replace( '#-\d+$#', '', $widget_name );
			$widget_options[ $widget_name_strip ] = get_option( 'widget_' . $widget_name_strip );
		}
	}
}
// choose which custom options to load into defaults
$all_options = wp_load_alloptions();
//print_r($all_options);exit;
foreach ( $all_options as $name => $value ) {
	if ( stristr( $name, 'workscout_' ) ) {
		$my_options[ $name ] = maybe_unserialize( $value );
	}	
	
	if ( stristr( $name, '_widget_area_manager' ) ) {
		$my_options[ $name ] = $value;
	}

	//if ( stristr( $name, 'dbem_' ) !== false ) { $my_options[ $name ] = $value; }
	//                  if ( stristr( $name, 'woo' ) !== false ) { $my_options[ $name ] = $value; }
	if ( stristr( $name, 'dtbaker_featured_images' ) !== false ) {
		$my_options[ $name ] = $value;
	}
	if ( 'theme_mods_theme-workscout' === $name ) {
		$my_options[ $name ] = maybe_unserialize($value);
		unset($my_options[ $name ]['nav_menu_locations']);
	}
}
$my_options['dbem_credits']                        = 0;
$my_options['woocommerce_cart_redirect_after_add'] = 'yes';
$my_options['woocommerce_enable_ajax_add_to_cart'] = 'no';

$my_options                                        = $this->filter_options( $my_options );

if ( is_dir( get_home_path() . '/wp-content/uploads/workscout/' ) ) {
	echo "it exists";
	file_put_contents( get_home_path() . '/wp-content/uploads/workscout/default.json' , json_encode( $default_content ) );
	file_put_contents( get_home_path() . '/wp-content/uploads/workscout/widget_positions.json' , json_encode( $widget_positions ) );
	file_put_contents( get_home_path() . '/wp-content/uploads/workscout/widget_options.json' , json_encode( $widget_options ) );
	file_put_contents( get_home_path() . '/wp-content/uploads/workscout/menu.json' , json_encode( $menu_ids ) );
	file_put_contents( get_home_path() . '/wp-content/uploads/workscout/options.json' , json_encode( $my_options ) );
}

?>

	<h1>Export Done:</h1>
	<p>Export content has been placed into /theme/envato_setup/content/*.json files</p>
	<p>Stock images have been copied into /theme/images/stock/ for faster theme install.</p>
