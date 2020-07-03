<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles taxonomy meta custom fields. Just used for job type.
 *
 * @package wp-job-manager
 * @since 1.28.0
 */
class WorkScout_WP_Job_Manager_Colors {
	/**
	 * The single instance of the class.
	 *
	 * @var self
	 * @since  1.28.0
	 */
	private static $_instance = null;

	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
	 *
	 * @since  1.28.0
	 * @static
	 * @return self Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * WP_Job_Manager_Taxonomy_Meta constructor.
	 */
	public function __construct() {
		
			add_action( 'job_listing_type_edit_form_fields', array( $this, 'display_color_field' ), 10, 2 );
			add_action( 'job_listing_type_add_form_fields', array( $this, 'add_form_display_color_field' ), 10 );

			add_action( 'edited_job_listing_type', array( $this, 'save_color_field' ), 10, 2 );
			add_action( 'created_job_listing_type', array( $this, 'save_color_field' ), 10, 2 );
			add_filter( 'manage_edit-job_listing_type_columns', array( $this, 'add_color_column' ) );
			add_filter( 'manage_job_listing_type_custom_column', array( $this, 'add_color_column_content' ), 10, 3 );
			
			add_action( 'admin_print_scripts', array( $this,'colorpicker_init_inline'), 20 );
			add_action( 'admin_enqueue_scripts', array( $this,'colorpicker_enqueue') );

			add_action( 'wp_head', array( $this, 'output_colors' ) );

	}

	/**
	 * Enqueue colorpicker styles and scripts.
	 * - https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
	 *
	 * @return void
	 */
	function colorpicker_enqueue( $taxonomy ) {

	    if( null !== ( $screen = get_current_screen() ) && 'edit-job_listing_type' !== $screen->id ) {
	        return;
	    }

	    // Colorpicker Scripts
	    wp_enqueue_script( 'wp-color-picker' );

	    // Colorpicker Styles
	    wp_enqueue_style( 'wp-color-picker' );

	}

	function colorpicker_init_inline() {

		 if( null !== ( $screen = get_current_screen() ) && 'edit-job_listing_type' !== $screen->id ) {
	        return;
	    }
	  ?>

	    <script>
	        jQuery( document ).ready( function( $ ) {

	            $( '.colorpicker' ).wpColorPicker();

	        } ); // End Document Ready JQuery
	    </script>

	  <?php

	}
	/**
	 * Set the employment type field when creating/updating a job type item.
	 *
	 * @param int $term_id Term ID.
	 * @param int $tt_id   Taxonomy type ID.
	 */
	public function save_color_field( $term_id, $tt_id ) {
		
		// Save term color if possible
	    if( isset( $_POST['color'] ) && ! empty( $_POST['color'] ) ) {
	        update_term_meta( $term_id, 'color', sanitize_hex_color_no_hash( $_POST['color'] ) );
	    } else {
	        delete_term_meta( $term_id, 'color' );
	    }
	}

	/**
	 * Add the option to select schema.org employmentType for job type on the edit meta field form.
	 *
	 * @param WP_Term $term     Term object.
	 * @param string  $taxonomy Taxonomy slug.
	 */
	public function display_color_field( $term, $taxonomy ) {
		
		
		$color = get_term_meta( $term->term_id, 'color', true );
    	$color = ( ! empty( $color ) ) ? "#{$color}" : '#ffffff';
		
			?>
			<tr class="form-field term-group-wrap">
			<th scope="row"><label for="feature-group"><?php _e( 'Color', 'workscout' ); ?></label></th>
			<td><input name="color" value="<?php echo $color; ?>" class="colorpicker" id="term-colorpicker" /></td>
			</tr><?php
		
	}

	/**
	 * Add the option to select schema.org employmentType for job type on the add meta field form.
	 *
	 * @param string       $taxonomy Taxonomy slug.
	 */
	public function add_form_display_color_field( $taxonomy ) {
		
			?>
			<div class="form-field term-group">
			<label for="feature-group"><?php _e( 'Color', 'wp-job-manager' ); ?></label>
			<input name="color" value="#ffffff" class="colorpicker" id="term-colorpicker" />
			</div><?php
		
	}

	/**
	 * Adds the Employment Type column when listing job type terms in WP Admin.
	 *
	 * @param array $columns
	 * @return array
	 */
	public function add_color_column( $columns ) {
		$columns['color'] = __( 'Color', 'wp-job-manager' );
		return $columns;
	}

	/**
	 * Adds the Employment Type column as a sortable column when listing job type terms in WP Admin.
	 *
	 * @param array $sortable
	 * @return array
	 */
	public function add_employment_type_column_sortable( $sortable ) {
		$sortable['color'] = 'color';
		return $sortable;
	}

	/**
	 * Adds the Employment Type column content when listing job type terms in WP Admin.
	 *
	 * @param string $content
	 * @param string $column_name
	 * @param int    $term_id
	 * @return string
	 */
	public function add_color_column_content( $content, $column_name, $term_id ) {
		if( 'color' !== $column_name ){
			return $content;
		}
		
		$term_id = absint( $term_id );
		$term_color = get_term_meta( $term_id, 'color', true );

		if ( ! empty( $term_color )  ) {
			$content .= "<span style='padding: 8px 15px; display: inline-block; background: #{$term_color}; border-radius: 5px;'></span>";
		}
		return $content;
	}

	public function output_colors() {
		$terms   = get_terms( 'job_listing_type', array( 'hide_empty' => false ) );

		echo "<style>\n";

		foreach ( $terms as $term ) {
			$color = get_term_meta( $term->term_id, 'color', true ); 
			if($color){
				$hexcolor = workscout_hex2rgb($color, true);

				echo "
				.job-spotlight span.{$term->slug}, 
				.map-box span.job-type.{$term->slug},
				.leaflet-popup-content span.job-type.{$term->slug},
				.new-layout.job_listings > li a span.job-type.{$term->slug} { 
					color: #{$color}; 
					border: 1px solid #{$color}; 
					background-color: rgba( {$hexcolor},0.07) 
				}";
				echo ".new-layout.job_listings > li a.job_listing_type-{$term->slug} { border-left: 4px solid #{$color} }";
				echo "span.{$term->slug} { background-color: #{$color}; }";
				echo ".marker-container.{$term->slug} { background-color: #{$color}; }";
				echo "@keyframes markerAnimation_{$term->slug} {0%,100% {box-shadow: 0 0 0 6px rgba({$hexcolor},0.15);}
				    50% {box-shadow: 0 0 0 8px rgba({$hexcolor},0.15);}}";
				echo ".marker-container.{$term->slug} {animation: markerAnimation_{$term->slug} 2.5s infinite;}";
			}
			$color = false;
			
			
		}

		echo "</style>\n";
	}
}

WorkScout_WP_Job_Manager_Colors::instance();