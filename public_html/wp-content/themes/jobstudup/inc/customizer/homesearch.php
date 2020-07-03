<?php

Kirki::add_panel( 'homesearch_panel', array(
    'priority'    => 21,
    'title'       => __( 'Home Search Options', 'workscout' ),
    'description' => __( 'Options for Page with Job/Resume Search', 'workscout'  ),
) );



require get_template_directory() . '/inc/customizer/jobs_home.php';
require get_template_directory() . '/inc/customizer/resume_home.php';

?>