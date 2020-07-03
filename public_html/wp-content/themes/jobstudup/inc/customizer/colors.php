<?php 

	

	Kirki::add_field( 'workscout', array(
	    'type'        => 'color',
	    'settings'    => 'pp_main_color',
	    'label'       => esc_html__( 'Select main theme color', 'workscout' ),
	    'section'     => 'colors',
	    'default'     => '#26ae61',
	    'priority'    => 10,
	) );
 ?>