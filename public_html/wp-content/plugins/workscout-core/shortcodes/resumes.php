<?php


function workscout_resumes( $atts ) {
    global $resume_manager;
    if ( !post_type_exists( 'resume' ) ) {
        return;
    }
        ob_start();
        wp_enqueue_script( 'workscout-wp-resume-manager-ajax-filters' );
        if ( ! resume_manager_user_can_browse_resumes() ) {
            get_job_manager_template_part( 'access-denied', 'browse-resumes', 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' );
            return ob_get_clean();
        }

        extract( $atts = shortcode_atts( apply_filters( 'resume_manager_output_resumes_defaults', array(
            'per_page'                  => get_option( 'resume_manager_per_page' ),
            'order'                     => 'DESC',
            'orderby'                   => 'featured',
            'show_filters'              => true,
            'show_categories'           => get_option( 'resume_manager_enable_categories' ),
            'categories'                => '',
            'featured'                  => null, // True to show only featured, false to hide featured, leave null to show both.
            'show_category_multiselect' => get_option( 'resume_manager_enable_default_category_multiselect', false ),
            'selected_category'         => '',
            'show_pagination'           => false,
            'show_more'                 => true,
        ) ), $atts ) );

        $categories = array_filter( array_map( 'trim', explode( ',', $categories ) ) );
        $keywords   = '';
        $location   = '';

        // String and bool handling
        $show_filters              = workscout_string_to_bool( $show_filters );
        $show_categories           = workscout_string_to_bool( $show_categories );
        $show_category_multiselect = workscout_string_to_bool( $show_category_multiselect );
        $show_more                 = workscout_string_to_bool( $show_more );
        $show_pagination           = workscout_string_to_bool( $show_pagination );

        if ( ! is_null( $featured ) ) {
            $featured = ( is_bool( $featured ) && $featured ) || in_array( $featured, array( '1', 'true', 'yes' ) ) ? true : false;
        }

        if ( ! empty( $_GET['search_keywords'] ) ) {
            $keywords = sanitize_text_field( $_GET['search_keywords'] );
        }

        if ( ! empty( $_GET['search_location'] ) ) {
            $location = sanitize_text_field( $_GET['search_location'] );
        }

        if ( ! empty( $_GET['search_category'] ) ) {
            $selected_category = sanitize_text_field( $_GET['search_category'] );
        }

        if ( $show_filters ) {

            get_job_manager_template( 'resume-filters.php', array( 'per_page' => $per_page, 'orderby' => $orderby, 'order' => $order, 'show_categories' => $show_categories, 'categories' => $categories, 'selected_category' => $selected_category, 'atts' => $atts, 'location' => $location, 'keywords' => $keywords, 'show_category_multiselect' => $show_category_multiselect ), 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' );

            get_job_manager_template( 'resumes-start.php', array(), 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' );
            get_job_manager_template( 'resumes-end.php', array(), 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' );

            if ( ! $show_pagination && $show_more ) {
                echo '<a class="load_more_resumes" href="#" style="display:none;"><strong>' . __( 'Load more resumes', 'wp-job-manager-resumes' ) . '</strong></a>';
            }

        } else {

            $resumes = get_resumes( apply_filters( 'resume_manager_output_resumes_args', array(
                'search_categories' => $categories,
                'orderby'           => $orderby,
                'order'             => $order,
                'categories'        => $categories,
                'search_keywords'   => $keywords,
                'search_location'   => $location,
                'posts_per_page'    => $per_page,
                'featured'          => $featured
            ) ) );

            if ( $resumes->have_posts() ) : ?>

                <?php get_job_manager_template( 'resumes-start.php', array(), 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>

                <?php while ( $resumes->have_posts() ) : $resumes->the_post(); ?>
                    <?php get_job_manager_template_part( 'content', 'resume', 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>
                <?php endwhile; ?>

                <?php get_job_manager_template( 'resumes-end.php', array(), 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>

                <?php if ( $resumes->found_posts > $per_page && $show_more ) : ?>

                    <?php wp_enqueue_script( 'wp-resume-manager-ajax-filters' ); ?>

                    <?php if ( $show_pagination ) : ?>
                        <?php echo get_job_listing_pagination( $resumes->max_num_pages ); ?>
                    <?php else : ?>
                        <a class="load_more_resumes" href="#"><strong><?php _e( 'Load more resumes', 'wp-job-manager-resumes' ); ?></strong></a>
                    <?php endif; ?>

                <?php endif; ?>

            <?php else :
                do_action( 'resume_manager_output_resumes_no_results' );
            endif;

            wp_reset_postdata();
        }

        $data_attributes_string = '';
        $data_attributes        = array(
            'location'        => $location,
            'keywords'        => $keywords,
            'show_filters'    => $show_filters ? 'true' : 'false',
            'show_pagination' => $show_pagination ? 'true' : 'false',
            'per_page'        => $per_page,
            'orderby'         => $orderby,
            'order'           => $order,
            'categories'      => implode( ',', $categories )
        );
        if ( ! is_null( $featured ) ) {
            $data_attributes[ 'featured' ] = $featured ? 'true' : 'false';
        }
        foreach ( $data_attributes as $key => $value ) {
            $data_attributes_string .= 'data-' . esc_attr( $key ) . '="' . esc_attr( $value ) . '" ';
        }

        return '<div class="resumes" ' . $data_attributes_string . '>' . ob_get_clean() . '</div>';
}
?>