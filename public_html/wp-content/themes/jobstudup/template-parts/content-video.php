<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php if ( ! post_password_required() ) { ?>
  <div class="embed">
    <?php
      $video = get_post_meta($post->ID, '_format_video_embed', true);
      if(wp_oembed_get($video)) { echo wp_oembed_get($video); } else {
        $allowed_tags = wp_kses_allowed_html( 'post' );
        echo wp_kses($video,$allowed_tags);
      }
    ?>
  </div>
  <?php } ?>
  <section class="post-content">

    <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
   
    <div class="meta-tags">
      <?php workscout_posted_on(); ?>
    </div>
    
    <?php the_excerpt(); ?>

    <a href="<?php the_permalink(); ?>" class="button read-more"><?php esc_html_e('Read More','workscout') ?></a>

  </section>

</article>