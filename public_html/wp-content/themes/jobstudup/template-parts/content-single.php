<article id="post-<?php the_ID(); ?>" <?php post_class('post-container'); ?>>
  
  <?php 
  if ( ! post_password_required() ) { 
      if(has_post_thumbnail()) { ?>
      <div class="post-img">
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail();  ?><div class="hover-icon"></div></a>
      </div>
      <?php } 
  }?>

  <section class="post-content">

    <a href="<?php the_permalink(); ?>"><h1 class="post-title"><?php the_title(); ?></h1></a>
   
    <div class="meta-tags">
      <?php workscout_posted_on(); ?>
    </div>
    <div class="clearfix"></div>
    <div class="margin-bottom-25"></div>
    
    <?php the_content(); ?>
    
  </section>

  <?php 
            $share_options = Kirki::get_option( 'workscout', 'pp_post_share' );
            
            if(!empty($share_options)) {
                $id = $post->ID;
                  $title = urlencode($post->post_title);
                  $url =  urlencode( get_permalink($id) );
                  $summary = urlencode(workscout_string_limit_words($post->post_excerpt,20));
                  $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'medium' );
                  $imageurl = urlencode($thumb[0]);
              ?>
              <ul class="share-post margin-top-35">
                <?php if (in_array("facebook", $share_options)) { ?><li><?php echo '<a target="_blank" class="facebook-share" href="https://www.facebook.com/sharer/sharer.php?u=' . $url . '">Facebook</a>'; ?></li><?php } ?>
                <?php if (in_array("twitter", $share_options)) { ?><li><?php echo '<a target="_blank" class="twitter-share" href="https://twitter.com/share?url=' . $url . '&amp;text=' . esc_attr($summary ). '" title="' . __( 'Twitter', 'workscout' ) . '">Twitter</a>'; ?></li><?php } ?>
                <?php if (in_array("google-plus", $share_options)) { ?><li><?php echo '<a target="_blank" class="google-plus-share" href="https://plus.google.com/share?url=' . $url . '&amp;title="' . esc_attr($title) . '" onclick=\'javascript:window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;\'>Google Plus</a>'; ?></li><?php } ?>
                <?php if (in_array("pinterest", $share_options)) { ?><li><?php echo '<a target="_blank"  class="pinterest-share" href="http://pinterest.com/pin/create/button/?url=' . $url . '&amp;description=' . esc_attr($summary) . '&media=' . esc_attr($imageurl) . '" onclick="window.open(this.href); return false;">Pinterest</a>'; ?></li><?php } ?>
                  <?php if (in_array("linkedin", $share_options)) { ?><li><?php echo '<a target="_blank"  class="linkedin-share" href="https://www.linkedin.com/cws/share?url=' . $url . '">LinkedIn</a>'; ?></li><?php } ?>

                <!-- <li><a href="#add-review" class="rate-recipe">Add Review</a></li> -->
              </ul>
            <?php } ?>
          <div class="clearfix"></div>

</article>