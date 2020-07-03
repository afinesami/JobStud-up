<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
if ( ! post_password_required() ) {
    $gallery = get_post_meta($post->ID, '_format_gallery', TRUE);
    preg_match( '/ids=\'(.*?)\'/', $gallery, $matches );
      if ( isset( $matches[1] ) ) {
        // Found the IDs in the shortcode
         $ids = explode( ',', $matches[1] );
      } else {  
        // The string is only IDs
        $ids = ! empty( $gallery ) && $gallery != '' ? explode( ',', $gallery ) : array();
      }
      echo '<div class="basic-slider royalSlider rsDefault">';
    foreach ($ids as $imageid) { ?>
          <?php   $image_link = wp_get_attachment_url( $imageid );
                  if ( ! $image_link )
                     continue;
                  $image          = wp_get_attachment_image_src( $imageid, 'large');
                  $imageRSthumb   = wp_get_attachment_image_src( $imageid, 'workscout-small-thumb' );
                  $image_title    = esc_attr( get_the_title( $imageid ) ); ?>
                  <a href="<?php echo esc_url($image[0]); ?>" class="mfp-gallery"  title="<?php echo esc_attr($image_title); ?>"><img class="rsImg" src="<?php echo esc_url($image[0]); ?>"  data-rsTmb="<?php echo esc_attr($imageRSthumb[0]); ?>" /></a>
          <?php ?>
    <?php } //eof for each?>
   </div>
<?php } //eof password protected ?>
 
  <section class="post-content">

    <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
   
    <div class="meta-tags">
      <?php workscout_posted_on(); ?>
    </div>
    
    <?php the_excerpt(); ?>

    <a href="<?php the_permalink(); ?>" class="button read-more"><?php esc_html_e('Read More','workscout') ?></a>

  </section>

</article>