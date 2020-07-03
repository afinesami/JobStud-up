<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php 
if ( ! post_password_required() ) { 
  $quote_content = get_post_meta($post->ID, '_format_quote_content', TRUE);
  $quote_source  = get_post_meta($post->ID, '_format_quote_source_url', TRUE);
  $quote_author  = get_post_meta($post->ID, '_format_quote_source_name', TRUE);
if(!empty($quote_content)) {
  $allowed_tags = wp_kses_allowed_html( 'post' );
        
  ?>
  <figure class="post-quote">
    <span class="icon"></span>
    <blockquote>
      <?php echo wp_kses($quote_content,$allowed_tags); ?>
      <?php if(!empty($quote_source)) { ?><a href="<?php echo get_post_meta($post->ID, '_format_quote_source_url', TRUE); ?>"> <?php } ?>
        <span>- <?php echo wp_kses($quote_author,$allowed_tags); ?></span>
      <?php if(!empty($quote_source)) { ?></a> <?php } ?>
    </blockquote>
  </figure>
<?php } 
} ?>
 
  <section class="post-content">

    <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
   
    <div class="meta-tags">
      <?php workscout_posted_on(); ?>
    </div>
    
    <?php the_excerpt(); ?>

    <a href="<?php the_permalink(); ?>" class="button read-more"><?php esc_html_e('Read More','workscout') ?></a>

  </section>

</article>