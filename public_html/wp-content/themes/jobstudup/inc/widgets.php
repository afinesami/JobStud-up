<?php

/**
 * Custom widgets for workscout theme
 *
 *
 * @package workscout
 * @since workscout 1.0
 */


add_action('widgets_init', 'workscout_load_widgets'); // Loads widgets here
function workscout_load_widgets() {
    register_widget('workscout_tabbed');
}

class workscout_tabbed extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'workscout-tabbed', 'description' => 'Tabbed widget for post and comments');
        $control_ops = array('width' => 300, 'height' => 350);
        parent::__construct('workscout_tabbed', 'WorkScout Tabbed Widget', $widget_ops, $control_ops);
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
        $recent = $instance['recent'];
        $popular = $instance['popular'];
        $comments = $instance['comments'];
        $recenttitle = empty($instance['recenttitle']) ? 'Recent' : $instance['recenttitle'];
        $populartitle = empty($instance['populartitle']) ? 'Popular' : $instance['populartitle'];
        $commentstitle = empty($instance['commentstitle']) ? 'Comments' : $instance['commentstitle'];
        $number = $instance['number'];
        $allowed_tags = wp_kses_allowed_html( 'post' );
        echo wp_kses($before_widget,$allowed_tags);
        ?>

        <ul class="tabs-nav blog">
            <?php if(!empty($recent)) { ?><li class="active"><a href="#tab1" title="Recent Posts"><?php echo wp_kses($recenttitle,$allowed_tags); ?></a></li><?php } ?>
            <?php if(!empty($popular)) { ?><li><a href="#tab2" title="Popular Posts"><?php echo wp_kses($populartitle,$allowed_tags); ?></a></li><?php } ?>
            <?php if(!empty($comments)) { ?><li><a href="#tab3" title="Recent Comments"><?php echo wp_kses($commentstitle,$allowed_tags); ?></a></li><?php } ?>
        </ul>
        <!-- Tabs Content -->
        <div class="tabs-container">
         <?php if(!empty($recent)) { ?>
         <div class="tab-content" id="tab1">
             <!-- Recent Posts -->
             <ul class="widget-tabs">
                <?php echo self::showLatest($posts = $number); ?>
            </ul>
        </div>
        <?php } ?>
        <?php if(!empty($popular)) { ?>
        <div class="tab-content" id="tab2">
            <!-- Popular Posts -->
            <ul class="widget-tabs">
               <?php echo self::showLatest($posts = $number, $orderby = "comment_count"); ?>
           </ul>
       </div>
       <?php } ?>

       <?php if(!empty($comments)) { ?>
       <div class="tab-content" id="tab3">
           <!-- Recent Comments -->
           <ul class="widget-tabs comments">
               <?php echo self::showLatestComments($posts = $number); ?>
           </ul>
       </div>
       <?php } ?>
   </div>


   <?php
   echo wp_kses($after_widget,$allowed_tags);
}


function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['recent'] = strip_tags($new_instance['recent']);
    $instance['popular'] = strip_tags($new_instance['popular']);
    $instance['comments'] = strip_tags($new_instance['comments']);
    $instance['recenttitle'] = strip_tags($new_instance['recenttitle']);
    $instance['populartitle'] = strip_tags($new_instance['populartitle']);
    $instance['commentstitle'] = strip_tags($new_instance['commentstitle']);
    $instance['number'] = strip_tags($new_instance['number']);
    return $instance;
}

function form($instance) {
    $instance = wp_parse_args((array) $instance, array('title' => ''));
    $title = strip_tags($instance['title']);
    $recent = $instance['recent'];
    $popular = $instance['popular'];
    $comments = $instance['comments'];
    $recenttitle = empty($instance['recenttitle']) ? 'Recent' : $instance['recenttitle'];
    $populartitle = empty($instance['populartitle']) ? 'Popular' : $instance['populartitle'];
    $commentstitle = empty($instance['commentstitle']) ? 'Comments' : $instance['commentstitle'];

    $number = esc_attr($instance['number']);
    ?>
    <p>Set tabs to display:</p>
    <p>
        <input id="<?php echo esc_attr($this->get_field_id('recent')); ?>" name="<?php echo esc_attr($this->get_field_name('recent')); ?>" type="checkbox" value="1" <?php checked( '1', $recent ); ?>/>
        <label for="<?php echo esc_attr($this->get_field_id('recent')); ?>"><?php esc_html_e('Recent posts','workscout'); ?></label>
    </p>
    <p>
        <label for="<?php echo esc_attr($this->get_field_id('recenttitle')); ?>"><?php esc_html_e('Recent posts Title','workscout'); ?></label>
        <input id="<?php echo esc_attr($this->get_field_id('recenttitle')); ?>" name="<?php echo esc_attr($this->get_field_name('recenttitle')); ?>" type="text" value="<?php echo esc_attr($recenttitle); ?>" />
    </p>
    <p>
        <input id="<?php echo esc_attr($this->get_field_id('popular')); ?>" name="<?php echo esc_attr($this->get_field_name('popular')); ?>" type="checkbox" value="1" <?php checked( '1', $popular ); ?>/>
        <label for="<?php echo esc_attr($this->get_field_id('popular')); ?>"><?php esc_html_e('Popular posts','workscout'); ?></label>
    </p>
    <p>
        <label for="<?php echo esc_attr($this->get_field_id('populartitle')); ?>"><?php esc_html_e('Popular posts Title','workscout'); ?></label>
        <input id="<?php echo esc_attr($this->get_field_id('populartitle')); ?>" name="<?php echo esc_attr($this->get_field_name('populartitle')); ?>" type="text" value="<?php echo esc_attr($populartitle); ?>" />
    </p>
    <p>
        <input id="<?php echo esc_attr($this->get_field_id('comments')); ?>" name="<?php echo esc_attr($this->get_field_name('comments')); ?>" type="checkbox" value="1" <?php checked( '1', $comments ); ?>/>
        <label for="<?php echo esc_attr($this->get_field_id('comments')); ?>"><?php esc_html_e('Latest comments','workscout'); ?></label>
    </p>
    <p>
        <label for="<?php echo esc_attr($this->get_field_id('commentstitle')); ?>"><?php esc_html_e('Latest comments Title','workscout'); ?></label>
        <input id="<?php echo esc_attr($this->get_field_id('commentstitle')); ?>" name="<?php echo esc_attr($this->get_field_name('commentstitle')); ?>" type="text" value="<?php echo esc_attr($commentstitle); ?>" />
    </p>

    <label>Set number of items to display
        <select id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>">
            <?php for ($i=1; $i < 10; $i++) { ?>
            <option <?php if ($number == $i) echo 'selected'; ?> value="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></option>
            <?php } ?>
        </select>
    </label>
    <?php
}

    /**
         * Display Latest posts
         */
    static function showLatest( $posts = 3, $orderby = 'post_date' ) {
        global $post;
        $latest = get_posts(
            array(
                'suppress_filters' => false,
                'ignore_sticky_posts' => 1,
                'orderby' => $orderby,
                'order' => 'desc',
                'numberposts' => $posts )
            );

        ob_start();

        $date_format = get_option('date_format');
        foreach($latest as $post) :
            setup_postdata($post);
        ?>

        <!-- Post #1 -->
        <li>
            <?php if ( has_post_thumbnail() ) { ?>
            <div class="widget-thumb">
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('workscout-small-thumb'); ?></a>
            </div>
            <?php } ?>

            <div class="widget-text">
                <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                <span><?php echo get_the_date(); ?></span>
            </div>
            <div class="clearfix"></div>
        </li>

        <?php endforeach;
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }

    static function showLatestComments( $posts = 3 ) {
        global $post;

        $comments = get_comments( apply_filters( 'widget_comments_args', array( 'number' => $posts, 'status' => 'approve', 'post_status' => 'publish' ) ) );

        ob_start();

        if ( $comments ) {
                // Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
            $post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
            _prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );
            $allowed_tags = wp_kses_allowed_html( 'post' );
            
            foreach ( (array) $comments as $comment) { ?>
            <li>
                <div class="widget-thumb">
                    <a href="<?php echo esc_url( get_comment_link($comment->comment_ID) ); ?>">
                        <?php echo get_avatar( $comment->comment_author_email, 100 ); ?>
                    </a>
                </div>

                <div class="widget-text">
                    <span><?php echo wp_kses($comment->comment_author,$allowed_tags); ?> on:</span>
                    <h5><a href="<?php echo esc_url( get_comment_link($comment->comment_ID) ); ?>"><?php echo wp_kses($comment->post_title,$allowed_tags); ?></a></h5>
                </div>
                <div class="clearfix"></div>
            </li>
            <?php

        }
    }
    $contents = ob_get_contents();
    ob_end_clean();
    return $contents;
}

    /**
     * Display most commented posts
     */
} //eof tabbed



?>