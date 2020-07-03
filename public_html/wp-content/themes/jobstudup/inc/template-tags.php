<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WorkScout
 */

if ( ! function_exists( 'workscout_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function workscout_posted_on() {
	echo '<div class="entry-meta">';

	if(is_single()) {
	    $metas =  Kirki::get_option( 'workscout', 'pp_meta_single' );
	    if (in_array("author", $metas)) {
	        echo '<span itemscope itemtype="http://data-vocabulary.org/Person">';
	        echo esc_html__('By','workscout'). ' <a class="author-link" itemprop="url" rel="author" href="'.esc_url(get_author_posts_url(get_the_author_meta('ID' ))).'">'; the_author_meta('display_name'); echo'</a>';
	        echo '</span>';
	    }
	    if (in_array("date", $metas)) {
		    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() )
			);

		    echo '<span>'.$time_string.'</span>';
		    
		}
	    if (in_array("cat", $metas)) {
	      if(has_category()) { echo '<span>'; the_category(', '); echo '</span>'; }
	    }
	    if (in_array("tags", $metas)) {
	      if(has_tag()) { echo '<span>'; the_tags('',', '); echo '</span>'; }
	    }
	    if (in_array("com", $metas)) {
	      echo '<span>'; comments_popup_link( esc_html__('With 0 comments','workscout'), esc_html__('With 1 comment','workscout'), esc_html__('With % comments','workscout'), 'comments-link', esc_html__('Comments are off','workscout')); echo '</span>';
	    }
  	} else {
	    $metas =  Kirki::get_option( 'workscout', 'pp_blog_meta' );

	   if (in_array("author", $metas)) {
	      echo '<span itemscope itemtype="http://data-vocabulary.org/Person">';
	      if (in_array("author", $metas)) {
	        echo esc_html__('By','workscout'). ' <a class="author-link" itemprop="url" rel="author" href="'.esc_url(get_author_posts_url(get_the_author_meta('ID' ))).'">'; the_author_meta('display_name'); echo'</a>';
	      }
	      echo '</span>';
	    }
	    if (in_array("date", $metas)) {
		    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() )
			);

		    echo '<span>'.$time_string.'</span>';
		    
		}
	    if (in_array("cat", $metas)) {
	      if(has_category()) { echo '<span>'; the_category(', '); echo '</span>'; }
	    }
	    if (in_array("tags", $metas)) {
	      if(has_tag()) { echo '<span>'; the_tags('',', '); echo '</span>'; }
	    }
	    if (in_array("com", $metas)) {
	      echo '<span>'; comments_popup_link( esc_html__('With 0 comments','workscout'), esc_html__('With 1 comment','workscout'), esc_html__('With % comments','workscout'), 'comments-link', esc_html__('Comments are off','workscout')); echo '</span>';
	    }
  	}
	echo "</div>";
}
endif;

if ( ! function_exists( 'workscout_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function workscout_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'workscout' ) );
		if ( $categories_list && workscout_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'workscout' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'workscout' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'workscout' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'workscout' ), esc_html__( '1 Comment', 'workscout' ), esc_html__( '% Comments', 'workscout' ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'workscout' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function workscout_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'workscout_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'workscout_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so workscout_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so workscout_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in workscout_categorized_blog.
 */
function workscout_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'workscout_categories' );
}
add_action( 'edit_category', 'workscout_category_transient_flusher' );
add_action( 'save_post',     'workscout_category_transient_flusher' );


if ( ! function_exists( 'workscout_posts_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function workscout_posts_navigation() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<div class="pagination-container">
		<nav class="pagination-next-prev" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'workscout' ); ?></h2>
			<div class="nav-links">
				<ul>
				<?php if ( get_next_posts_link() ) : ?>
				<li class="previous"><?php next_posts_link( esc_html__( 'Older posts', 'workscout' ) ); ?></li>
				<?php endif; ?>

				<?php if ( get_previous_posts_link() ) : ?>
				<li class="next"><?php previous_posts_link( esc_html__( 'Newer posts', 'workscout' ) ); ?></li>
				<?php endif; ?>
				</ul>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
	</div>
	<?php
}
endif;


if ( ! function_exists( 'workscout_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since astrum 1.0
 */
function workscout_comment( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;
  switch ( $comment->comment_type ) :
    case 'pingback' :
    case 'trackback' :
  ?>
  <li class="post pingback">
    <p><?php esc_html_e( 'Pingback:', 'workscout' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( '(Edit)', 'workscout' ), ' ' ); ?></p>
  <?php
      break;
    default :
      $allowed_tags = wp_kses_allowed_html( 'post' );
  ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
       <div id="comment-<?php comment_ID(); ?>" class="comment">
       <?php echo get_avatar( $comment, 70 ); ?>
       <div class="comment-content"><div class="arrow-comment"></div>
            <div class="comment-by"><?php printf( '<strong>%s</strong>', get_comment_author_link() ); ?>  <span class="date"> <?php printf( esc_html__( '%1$s at %2$s', 'workscout' ), get_comment_date(), get_comment_time() ); ?></span>
               <?php comment_reply_link( array_merge( $args, array( 'reply_text' => wp_kses(__('<i class="fa fa-reply"></i> Reply','workscout'), $allowed_tags ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div>
            <?php comment_text(); ?>

        </div>
        </div>
  <?php
      break;
  endswitch;
}
endif; // ends check for workscout_comment()


/**
 * Limits number of words from string
 *
 * @since astrum 1.0
 */
if ( ! function_exists( 'workscout_string_limit_words' ) ) :
	function workscout_string_limit_words($string, $word_limit) {
	    $words = explode(' ', $string, ($word_limit + 1));
	    if (count($words) > $word_limit) {
	        array_pop($words);
	        //add a ... at last article when more than limit word count
	        return implode(' ', $words) ;
	    } else {
	        //otherwise
	        return implode(' ', $words);
	    }
	}
endif;

if ( ! function_exists( 'workscout_get_excerpt' ) ) :
	function workscout_get_excerpt($string,$limit){
		$excerpt = substr($string, 0, $limit);
	
		return $excerpt;
}
endif;


add_filter( 'get_the_archive_title', 'workscout_archive_author_title' );

function workscout_archive_author_title( $title ) {
    if( is_author() ) {
         $title = sprintf( esc_html__( 'Author: %s','workscout' ), '<em>' . get_the_author() . '</em>' );
	}
    return $title;
}

 



/**
 * Display the classes for the body element.
 *
 * @since 2.8.0
 *
 * @param string|array $class One or more classes to add to the class list.
 */
function workscout_header_class( $class = '' ) {
	// Separates classes with a single space, collates classes for body element
	echo 'class="' . join( ' ', workscout_get_header_class( $class ) ) . '"';
}


function workscout_get_header_class( $class = '' ) {
	global $wp_query;

	$classes = array();

 	$classes[] = Kirki::get_option( 'workscout','pp_header_style', 'default' ); 

 	$sticky = Kirki::get_option( 'workscout','pp_sticky_header', false ); 
 	if($sticky) {
	 	$classes[] = 'sticky-header'; 
	}

	if( is_singular() ) {
		global $post;
    	$header_image = get_post_meta($post->ID, 'pp_job_header_bg', TRUE); 
    	if( !empty($header_image) ) {
    		$transparent_status = get_post_meta($post->ID, 'pp_transparent_header', TRUE); 	

    		if($transparent_status == 'on'){
    			$classes[] = 'transparent';
    		}
    	}
    }
	if( is_page_template( 'template-home.php' )  ) {
		if(Kirki::get_option( 'workscout','pp_transparent_header') ) {
			$classes[] = 'transparent';
		}
	}	
	
	if( is_page_template( 'template-home-resumes.php' )  ) {
		if(Kirki::get_option( 'workscout','pp_resume_home_transparent_header') ) {
			$classes[] = 'transparent';
		}
	}
	if( is_page_template( 'template-jobs.php' )  ) {
		if(Kirki::get_option( 'workscout','pp_jobs_transparent_header') ) {
			$classes[] = 'transparent';
		}
	}
	if ( is_post_type_archive('job_listing') ) {
		if(Kirki::get_option( 'workscout','pp_jobs_transparent_header') ) {
			$classes[] = 'transparent';
		}
	}
	if ( ! empty( $class ) ) {
		if ( !is_array( $class ) )
			$class = preg_split( '#\s+#', $class );
		$classes = array_merge( $classes, $class );
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}

	$classes = array_map( 'esc_attr', $classes );

	/**
	 * Filters the list of CSS body classes for the current post or page.
	 *
	 * @since 2.8.0
	 *
	 * @param array $classes An array of body classes.
	 * @param array $class   An array of additional classes added to the body.
	 */
	$classes = apply_filters( 'workscout_header_class', $classes, $class );

	return array_unique( $classes );
}


function workscout_get_search_header(){

	$output ='';
	$new_bannerbg = Kirki::get_option( 'workscout','pp_jobs_search_bg');  

	if(!empty($new_bannerbg)) { 
		$image_id = attachment_url_to_postid( $new_bannerbg );
		if( isset( $image_id ) ) {
		  $image  = wp_get_attachment_image_src($image_id,'full'); 
		}

		$output = 'style="background-image: url('.esc_attr($new_bannerbg).');" data-img-width="'.esc_attr($image[1]).'" data-img-height="'.esc_attr($image[2]).'" data-diff="300"';
	} else {
		global $post;
		$header_image = get_post_meta($post->ID, 'pp_job_header_bg', TRUE); 
		
		$image_id = attachment_url_to_postid( $header_image );
		if($header_image){
			$image  = wp_get_attachment_image_src($image_id,'full'); 
			$output = 'style="background-image: url('.esc_attr($header_image).');" data-img-width="'.esc_attr($image[1]).'" data-img-height="'.esc_attr($image[2]).'" data-diff="300"';	 
		}

	}
	return $output;
}

function workscout_get_new_search_header(){

	$output ='';
	$new_bannerbg = Kirki::get_option( 'workscout','pp_jobs_search_bg');  

	if(!empty($new_bannerbg)) { 
		$image_id = attachment_url_to_postid( $new_bannerbg );
		if( isset( $image_id ) ) {
		  $image  = wp_get_attachment_image_src($image_id,'full'); 
		}

		$output = 'data-background-image="'.esc_attr($new_bannerbg).'"';
	} else {
		global $post;
		$header_image = get_post_meta($post->ID, 'pp_job_header_bg', TRUE); 
		
		$image_id = attachment_url_to_postid( $header_image );
		if($header_image){
			$image  = wp_get_attachment_image_src($image_id,'full'); 
			$output = 'data-background-image="'.esc_attr($header_image).'"';	 
		}

	}
	return $output;
}

function workscout_get_resume_search_header(){

	$output ='';
	$new_bannerbg = Kirki::get_option( 'workscout','pp_resumes_search_bg');  

	if(!empty($new_bannerbg)) { 
		$image_id = attachment_url_to_postid( $new_bannerbg );
		if( isset( $image_id ) ) {
		  $image  = wp_get_attachment_image_src($image_id,'full'); 
		}

		$output = 'style="background-image: url('.esc_attr($new_bannerbg).');" data-img-width="'.esc_attr($image[1]).'" data-img-height="'.esc_attr($image[2]).'" data-diff="300"';
	} 
	return $output;
}

function workscout_get_new_resume_search_header(){

	$output ='';
	$new_bannerbg = Kirki::get_option( 'workscout','pp_resumes_search_bg');  

	if(!empty($new_bannerbg)) { 
		$image_id = attachment_url_to_postid( $new_bannerbg );
		if( isset( $image_id ) ) {
		  $image  = wp_get_attachment_image_src($image_id,'full'); 
		}

		$output = 'data-background-image="'.esc_attr($new_bannerbg).'"';
	} else {
		global $post;
		$header_image = get_post_meta($post->ID, 'pp_job_header_bg', TRUE); 
		
		$image_id = attachment_url_to_postid( $header_image );
		if($header_image){
			$image  = wp_get_attachment_image_src($image_id,'full'); 
			$output = 'data-background-image="'.esc_attr($header_image).'"';	 
		}

	}
	return $output;
}


add_action('wp_head', 'workscout_og_image');
function workscout_og_image(){
    if( is_singular('job_listing') ) {
        echo '<meta property="og:image" content="'. get_the_post_thumbnail_url(get_the_ID(),'full')   .'" />';
    }
}
