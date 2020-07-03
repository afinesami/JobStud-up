<?php
/**
 * Template Name: Contact Page
 *
 * A page showing map below title.
 *
 *
 * @package WordPress
 * @subpackage workscout
 * @since workscout 1.0
 */


$header_old = Kirki::get_option('workscout','pp_old_header');
$header_type = (Kirki::get_option('workscout','pp_old_header') == true) ? 'old' : '' ;
$header_type = apply_filters('workscout_header_type',$header_type);
get_header($header_type); ?>

<?php $header_image = get_post_meta($post->ID, 'pp_job_header_bg', TRUE); 
if(!empty($header_image)) { ?>
    <?php $header_image = get_post_meta($post->ID, 'pp_job_header_bg', TRUE); 
              
            $transparent_status = get_post_meta($post->ID, 'pp_transparent_header', TRUE);  
            if($transparent_status == 'on'){ ?>
            <div id="titlebar" class="photo-bg single with-transparent-header" style="background: url('<?php echo esc_url($header_image); ?>')">
        <?php } else { ?>
            <div id="titlebar" class="photo-bg" style="background: url('<?php echo esc_url($header_image); ?>')">
        <?php } ?>
<?php } else { ?>
    <div id="titlebar" class="single">
<?php } ?>
    <div class="container">

        <div class="sixteen columns">
            <h1><?php the_title(); ?></h1>
            <?php if(function_exists('bcn_display')) { ?>
                <nav id="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
                    <ul>
                        <?php bcn_display_list(); ?>
                    </ul>
                </nav>
            <?php } ?>
        </div>
    </div>
</div>

<?php while (have_posts()) : the_post(); ?>
<!-- Content
================================================== -->
<!-- Container -->
<div class="container">
    <div class="sixteen columns">
        <?php   $map_points = Kirki::get_option( 'workscout','pp_new_contact_map', array()); 
        ?>
        <!-- Google Maps -->
        <section class="google-map-container">
            <div id="googlemaps" class="google-map google-map-full" data-maxzoom="<?php echo Kirki::get_option( 'workscout','pp_contact_zoom', 15);  ?>" data-mappoints="<?php echo esc_attr(json_encode($map_points));?> "></div>
        </section>
        <!-- Google Maps / End -->

    </div>
</div>
<!-- Container / End -->

<?php

$layout  = get_post_meta($post->ID, 'pp_sidebar_layout', true);
if(empty($layout)) { $layout = 'full-width'; }
$class = ($layout !="full-width") ? "eleven columns" : "sixteen columns " ;

?>

<div class="container <?php echo esc_attr($layout); ?>">
    <article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
        <div class="padding-right">
        <?php the_content(); ?>
            <?php
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'workscout' ),
                    'after'  => '</div>',
                ) );
            ?>

            <footer class="entry-footer">
                <?php edit_post_link( esc_html__( 'Edit', 'workscout' ), '<span class="edit-link">', '</span>' ); ?>
            </footer><!-- .entry-footer -->
    
            <?php
                if(get_option('pp_pagecomments','on') == 'on') {
                    
                    // If comments are open or we have at least one comment, load up the comment template
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                }
            ?>
            </div>
    </article>

    <?php if($layout !="full-width") { get_sidebar(); }?>

</div>
<?php endwhile; // End the loop. Whew.

get_footer();

?>