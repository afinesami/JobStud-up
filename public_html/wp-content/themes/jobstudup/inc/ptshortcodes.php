<?php
// Extend Purethemes.net Shortcodes plugin
function workscout_shortcodes_list( $pt_shortcodes ) {

    $ptsc_icons = workscout_icons_list();
    $ptsc_orderby = array(
        'none' => 'none' ,
        'count' => 'count' ,
        'ID' => 'ID' ,
        'author' => 'author' ,
        'title' => 'title' ,
        'name' => 'name' ,
        'date' => 'date' ,
        'modified' => 'modified' ,
        'parent' => 'parent' ,
        'rand' => 'rand' ,
        'comment_count' => 'comment_count' ,
        );

    $ptsc_limit = array();
    for ($i=0; $i < 25 ; $i++) {
       $ptsc_limit[$i] = $i;
    }

    $ptsc_order = array(
        'ASC' => 'from lowest to highest values (1, 2, 3; a, b, c)' ,
        'DESC' => 'from highest to lowest values (3, 2, 1; c, b, a)' ,
        );

    $ptsc_places = array(
        'none' => 'None' , 'first' => 'First' , 'last' => 'Last' , 'center' => 'Center'
    );

    $ptsc_width = array(
        'one' => 'One' ,
        'two' => 'Two' ,
        'three' => 'Three' ,
        'four' => 'Four' ,
        'five' => 'Five' ,
        'six' => 'Six' ,
        'seven' => 'Seven' ,
        'eight' => 'Eight' ,
        'nine' => 'Nine' ,
        'ten' => 'Ten' ,
        'eleven' => 'Eleven' ,
        'twelve' => 'Twelve' ,
        'thirteen' => 'Thirteen' ,
        'fourteen' => 'Fourteen' ,
        'fifteen' => 'Fifteen' ,
        'sixteen' => 'Sixteen' ,
    );

    $ptsc_perc = array();
    for ($i=0; $i < 101 ; $i=$i+5) {
        $ptsc_perc[$i] = $i."%";
    }

    $ptsc_target = array(
        '' => 'default',
        '_blank' => '_blank',
        '_self' => '_self', 
        '_parent' => '_parent',
        '_top' => '_top', 
        );


    $ptsc_socials = array(
        'twitter' => 'Twitter',
        'wordpress' => 'WordPress',
        'facebook' => 'Facebook',
        'linkedin' => 'LinkedIN',
        'steam' => 'Steam',
        'tumblr' => 'Tumblr',
        'github' => 'GitHub',
        'delicious' => 'Delicious',
        'instagram' => 'Instagram',
        'xing' => 'Xing',
        'amazon'=> 'Amazon',
        'dropbox'=> 'Dropbox',
        'paypal'=> 'PayPal',
        'lastfm' => 'LastFM',
        'gplus' => 'Google Plus',
        'yahoo' => 'Yahoo',
        'pinterest' => 'Pinterest',
        'dribbble' => 'Dribbble',
        'flickr' => 'Flickr',
        'reddit' => 'Reddit',
        'vimeo' => 'Vimeo',
        'spotify' => 'Spotify',
        'rss' => 'RSS',
        'youtube' => 'YouTube',
        'blogger' => 'Blogger',
        'appstore' => 'AppStore',
        'evernote' => 'Evernote',
        'digg' => 'Digg',
        'forrst' => 'Forrst',
        'fivehundredpx' => '500px',
        'stumbleupon' => 'StumbleUpon',
        'dribbble' => 'Dribbble'
    );

    /* set arrays for shortcodes form */
    $workscout_pt_shortcodes = array(

        'spacer' =>array(
            'label'         => 'Spacer', 
            'has_content'   => false,
            'params'        => array(
                    'class' => array(
                        'type' => 'text',
                        'label' => 'Custom class (optional)',
                        'std' => '',
                    )
                )
            ),
        'icon' => array(
            'label' => 'Icon',
            'has_content' => false,
            'params' => array(
                'icon' => array(
                    'type' => 'select',
                    'label' => 'Icon',
                    'desc' => 'Select the icn name',
                    'options' => $ptsc_icons,
                    'std' => '',
                ),
            )
        ),
        'highlight' => array(
            'label' => 'Highlighted text',
            'has_content' => true,
            'params' => array(
                'content' => array(
                    'type' => 'textarea',
                    'label' => 'Content',
                    'std' => '',
                    ),
                'style' => array(
                    'type' => 'select',
                    'label' => 'Color',
                    'desc' => 'Select color for highlighted text',
                    'options' => array(
                        'gray' => 'Gray',
                        'light' => 'Light',
                        'color' => 'Curent Main Color'
                    ),
                    'std' => '',
                ),
            )
        ),        
        'popup' => array(
            'label' => 'Popup box',
            'has_content' => true,
            'params' => array(
                'content' => array(
                    'type' => 'textarea',
                    'label' => 'Popup content',
                    'std' => '',
                    ),
                'buttontext' => array(
                    'type' => 'text',
                    'label' => 'Button label',
                    'desc' => 'Text displayed on button',
                    'std' => 'Open Popup',
                ),
                'title' => array(
                    'type' => 'text',
                    'label' => 'Title of modal box',
                    'std' => ' Modal popup',
                ),
            )
        ),
        /*TODO - list shortcode*/
        'box_job_categories' => array(
            'label' => 'Jobs Categories Grid',
            'has_content' => false,
            'params' => array(
                'hide_empty' => array(
                    'type' => 'select',
                    'label' => 'Hide empty',
                    'desc' => ' Whether to not return empty job categories.',
                    'options' => array(
                        '0' => 'Show empty categories',
                        '1' => 'Do not show empty categories',
                    ),
                    'std' => '0',
                ),
                'orderby' => array(
                    'type' => 'select',
                    'label' => 'Orderby',
                    'options' => $ptsc_orderby,
                    'std' => 'count',
                ),
                'order' => array(
                    'type' => 'select',
                    'label' => 'Order',
                    'options' => $ptsc_order,
                    'std' => 'DESC',
                ),
                'number' => array(
                    'type' => 'text',
                    'label' => 'Number of items to display',
                    'desc' => 'Select the number of items to display',
                    'std' => '8'
                ),                
                'browse_link' => array(
                    'type'  => 'text',
                    'label' => 'URL to categories page',
                    'desc'  => 'Link to page with all categories ',
                    'std' => '',
                ),
                'include' => array(
                    'type'  => 'text',
                    'label' => 'Include categories',
                    'desc'  => 'Put IDs of job categories, separate using coma',
                    'std' => '',
                ),                
                'exclude' => array(
                    'type'  => 'text',
                    'label' => 'Exclude categories',
                    'desc'  => 'Put IDs of job categories, separate using coma',
                    'std' => '',
                ),                
                'child_of' => array(
                    'type'  => 'text',
                    'label' => 'Child of',
                    'desc'  => 'ID of parent category if you want to display just child categories of specific term',
                    'std' => '',
                ),
            )
        ),
        'box_resume_categories' => array(
            'label' => 'Resume Categories Grid',
            'has_content' => false,
            'params' => array(
                'hide_empty' => array(
                    'type' => 'select',
                    'label' => 'Hide empty',
                    'desc' => ' Whether to not return empty resume categories.',
                    'options' => array(
                        '0' => 'Show empty categories',
                        '1' => 'Do not show empty categories',
                    ),
                    'std' => '0',
                ),
                'orderby' => array(
                    'type' => 'select',
                    'label' => 'Orderby',
                    'options' => $ptsc_orderby,
                    'std' => 'count',
                ),
                'order' => array(
                    'type' => 'select',
                    'label' => 'Order',
                    'options' => $ptsc_order,
                    'std' => 'DESC',
                ),
                'number' => array(
                    'type' => 'text',
                    'label' => 'Number of items to display',
                    'desc' => 'Select the number of items to display',
                    'std' => '8'
                ),                
                'browse_link' => array(
                    'type'  => 'text',
                    'label' => 'URL to categories page',
                    'desc'  => 'Link to page with all categories ',
                    'std' => '',
                ),
                'include' => array(
                    'type'  => 'text',
                    'label' => 'Include categories',
                    'desc'  => 'Put IDs of resume categories, separate using coma',
                    'std' => '',
                ),                
                'exclude' => array(
                    'type'  => 'text',
                    'label' => 'Exclude categories',
                    'desc'  => 'Put IDs of resume categories, separate using coma',
                    'std' => '',
                ),                
                'child_of' => array(
                    'type'  => 'text',
                    'label' => 'Child of',
                    'desc'  => 'ID of parent category if you want to display just child categories of specific term',
                    'std' => '',
                ),
            )
        ),
        'headline' => array(
            'label' => 'Headline (styled header)',
            'has_content' => true,
            'params' => array(
                'content' => array(
                    'type' => 'textarea',
                    'label' => 'Content',
                    'std' => '',
                    ),
                'margintop' => array(
                    'type' => 'text',
                    'label' => 'Top margin',
                    'desc' => 'Put just a number, it will be added in px',
                    'std' => '',
                ),
                'marginbottom' => array(
                    'type' => 'text',
                    'label' => 'Bottom margin',
                    'desc' => 'Put just a number, it will be added in px',
                    'std' => '30',
                ),
                'clearfix' => array(
                    'type' => 'select',
                    'label' => 'Add clearfix after headline?',
                    'desc' => 'It should be added by default',
                    'options' => array(
                        '1' => 'Yes, please',
                        '0' => 'No, thanks',
                    ),
                    'std' => '1',
                ),
                'type' => array(
                    'type' => 'select',
                    'label' => 'Header tag (h1..h6)',
                    'desc' => '',
                    'options' => array(
                        'h1' => 'h1',
                        'h2' => 'h2',
                        'h3' => 'h3',
                        'h4' => 'h4',
                        'h5' => 'h5',
                        'h6' => 'h6',
                        
                    ),
                    'std' => 'h3',
                ),
                )
            ),
        'jobs' => array(
            'label' => 'Jobs',
            'has_content' => false,
            'params' => array(
                'per_page' => array(
                    'type' => 'text',
                    'label' => 'Number of items to display',
                    'desc' => 'Select the number of items to display',
                    'std' => '12'
                ),
                'orderby' => array(
                    'type' => 'select',
                    'label' => 'Orderby',
                    'options' => $ptsc_orderby,
                    'std' => 'featured',
                ),
                'order' => array(
                    'type' => 'select',
                    'label' => 'Order',
                    'options' => $ptsc_order,
                    'std' => '',
                ),
                'show_filters' => array(
                    'type' => 'select',
                    'label' => 'Show filters',
                    'desc' => '',
                    'options' => array(
                        'false' => 'Hide',
                        'true' => 'Show',
                    ),
                    'std' => 'false',
                ),                
                'show_categories' => array(
                    'type' => 'select',
                    'label' => 'Show categories',
                    'desc' => '',
                    'options' => array(
                        'false' => 'Hide',
                        'true' => 'Show',
                    ),
                    'std' => 'false',
                ),                
                'show_pagination' => array(
                    'type' => 'select',
                    'label' => 'Show pagination',
                    'desc' => '',
                    'options' => array(
                        'false' => 'Hide',
                        'true' => 'Show',
                    ),
                    'std' => 'false',
                ),                
                'show_more' => array(
                    'type' => 'select',
                    'label' => 'Show "more" link',
                    'desc' => '',
                    'options' => array(
                        'false' => 'Hide',
                        'true' => 'Show',
                    ),
                    'std' => 'false',
                ),                
                'show_description' => array(
                    'type' => 'select',
                    'label' => 'Show job description on the list',
                    'desc' => '',
                    'options' => array(
                        'false' => 'Hide',
                        'true' => 'Show',
                    ),
                    'std' => 'false',
                ),                
                'categories' => array(
                    'type' => 'text',
                    'label' => 'Pre-select Job Categories',
                    'desc' => 'Separate by coma',
                    'std' => '',
                ),                
                'job_types' => array(
                    'type' => 'text',
                    'label' => 'Pre-select Job Types',
                    'desc' => 'Separate by coma',
                    'std' => '',
                ),
                'featured' => array(
                    'type' => 'select',
                    'label' => 'How to show featured jobs',
                    'desc' => '',
                    'options' => array(
                        'null' => 'Show both',
                        'false' => 'Hide featured',
                        'true' => 'Show only featured',
                    ),
                    'std' => 'false',
                ),  
                'show_description' => array(
                    'type' => 'select',
                    'label' => 'Show job description on the list',
                    'desc' => '',
                    'options' => array(
                        'false' => 'False',
                        'true' => 'True',
                    ),
                    'std' => 'false',
                ), 
                'filled' => array(
                    'type' => 'select',
                    'label' => 'Filled jobs',
                    'desc' => '',
                    'options' => array(
                        'null' => 'Show both',
                        'false' => 'Hide only filled jobs',
                        'true' => 'Show only filled jobs',
                    ),
                    'std' => 'false',
                ),   
                'keywords' => array(
                    'type' => 'text',
                    'label' => 'Pre-select keyword',
                    'desc' => '',
                    'std' => '',
                ), 
                )
            ), 
        'resumes' => array(
            'label' => 'Resumes',
            'has_content' => false,
            'params' => array(
                'per_page' => array(
                    'type' => 'text',
                    'label' => 'Number of items to display',
                    'desc' => 'Select the number of items to display',
                    'std' => '12'
                ),
                'orderby' => array(
                    'type' => 'select',
                    'label' => 'Orderby',
                    'options' => $ptsc_orderby,
                    'std' => '',
                ),
                'order' => array(
                    'type' => 'select',
                    'label' => 'Order',
                    'options' => $ptsc_order,
                    'std' => '',
                ),
                'show_filters' => array(
                    'type' => 'select',
                    'label' => 'Show filters',
                    'desc' => '',
                    'options' => array(
                        'false' => 'False',
                        'true' => 'True',
                    ),
                    'std' => 'false',
                ),                
                'show_categories' => array(
                    'type' => 'select',
                    'label' => 'Show categories',
                    'desc' => '',
                    'options' => array(
                        'false' => 'False',
                        'true' => 'True',
                    ),
                    'std' => 'false',
                ),                
                'show_pagination' => array(
                    'type' => 'select',
                    'label' => 'Show pagination',
                    'desc' => '',
                    'options' => array(
                        'false' => 'False',
                        'true' => 'True',
                    ),
                    'std' => 'false',
                ),                
                'show_more' => array(
                    'type' => 'select',
                    'label' => 'Show "more" link',
                    'desc' => '',
                    'options' => array(
                        'false' => 'False',
                        'true' => 'True',
                    ),
                    'std' => 'false',
                ),                
               
                'categories' => array(
                    'type' => 'text',
                    'label' => 'Pre-select categories',
                    'desc' => 'Separate by coma',
                    'std' => '',
                ),                

                'featured' => array(
                    'type' => 'select',
                    'label' => 'How to show featured jobs',
                    'desc' => '',
                    'options' => array(
                        'null' => 'Show both',
                        'false' => 'Hide featured',
                        'true' => 'Show only featured',
                    ),
                    'std' => 'false',
                ),  
            )
        ), 
        'simple_resumes' => array(
            'label' => 'Simple Resumes',
            'has_content' => false,
            'params' => array(
                'per_page' => array(
                    'type' => 'text',
                    'label' => 'Number of items to display',
                    'desc' => 'Select the number of items to display',
                    'std' => '12'
                ),
                'orderby' => array(
                    'type' => 'select',
                    'label' => 'Orderby',
                    'options' => $ptsc_orderby,
                    'std' => '',
                ),
                'order' => array(
                    'type' => 'select',
                    'label' => 'Order',
                    'options' => $ptsc_order,
                    'std' => '',
                ),
                               
                'show_more' => array(
                    'type' => 'select',
                    'label' => 'Show "more" link',
                    'desc' => '',
                    'options' => array(
                        'false' => 'False',
                        'true' => 'True',
                    ),
                    'std' => 'false',
                ),                
               
                'categories' => array(
                    'type' => 'text',
                    'label' => 'Pre-select categories',
                    'desc' => 'Separate by coma',
                    'std' => '',
                ),                

                'featured' => array(
                    'type' => 'select',
                    'label' => 'How to show featured jobs',
                    'desc' => '',
                    'options' => array(
                        'null' => 'Show both',
                        'false' => 'Hide featured',
                        'true' => 'Show only featured',
                    ),
                    'std' => 'false',
                ),  
            )
        ),        
        'spotlight_jobs' => array(
            'label' => 'Spotlight Jobs',
            'has_content' => false,
            'params' => array(
                'title' => array(
                    'type' => 'text',
                    'label' => 'Title',
                    'desc' => 'Title of section',
                    'std' => '',
                ),  
                'per_page' => array(
                    'type' => 'text',
                    'label' => 'Number of items to display',
                    'desc' => 'Select the number of items to display',
                    'std' => '12'
                ),
                'orderby' => array(
                    'type' => 'select',
                    'label' => 'Orderby',
                    'options' => $ptsc_orderby,
                    'std' => '',
                ),
                'order' => array(
                    'type' => 'select',
                    'label' => 'Order',
                    'options' => $ptsc_order,
                    'std' => '',
                ),
                'featured' => array(
                    'type' => 'select',
                    'label' => 'How to show featured jobs',
                    'desc' => '',
                    'options' => array(
                        'null' => 'Show both',
                        'false' => 'Hide featured',
                        'true' => 'Show only featured',
                    ),
                    'std' => 'false',
                ),  
                'categories' => array(
                    'type' => 'text',
                    'label' => 'Pre-select categories',
                    'desc' => 'Separate by coma',
                    'std' => '',
                ),                
                'job_types' => array(
                    'type' => 'text',
                    'label' => 'Pre-select Job Types',
                    'desc' => 'Separate by coma',
                    'std' => '',
                ),
                'filled' => array(
                    'type' => 'select',
                    'label' => 'Filled jobs',
                    'desc' => '',
                    'options' => array(
                        'null' => 'Show both',
                        'false' => 'Hide only filled jobs',
                        'true' => 'Show only filled jobs',
                    ),
                    'std' => 'false',
                ), 
            )
        ),
        'spotlight_resumes' => array(
            'label' => 'Spotlight Resumes',
            'has_content' => false,
            'params' => array(
                'title' => array(
                    'type' => 'text',
                    'label' => 'Title',
                    'desc' => 'Title of section',
                    'std' => '',
                ),  
                'per_page' => array(
                    'type' => 'text',
                    'label' => 'Number of items to display',
                    'desc' => 'Select the number of items to display',
                    'std' => '12'
                ),
                'orderby' => array(
                    'type' => 'select',
                    'label' => 'Orderby',
                    'options' => $ptsc_orderby,
                    'std' => '',
                ),
                'order' => array(
                    'type' => 'select',
                    'label' => 'Order',
                    'options' => $ptsc_order,
                    'std' => '',
                ),
                              
               
                'categories' => array(
                    'type' => 'text',
                    'label' => 'Pre-select categories',
                    'desc' => 'Separate by coma',
                    'std' => '',
                ),                

                'featured' => array(
                    'type' => 'select',
                    'label' => 'How to show featured jobs',
                    'desc' => '',
                    'options' => array(
                        'null' => 'Show both',
                        'false' => 'Hide featured',
                        'true' => 'Show only featured',
                    ),
                    'std' => 'false',
                ),  
               

            )
        ),
        'testimonials_wide' => array(
            'label' => 'Testimonials Wide',
            'has_content' => false,
            'params' => array(
                'per_page' => array(
                    'type' => 'text',
                    'label' => 'Number of items to display',
                    'desc' => 'Select the number of items to display',
                    'std' => '12'
                ),
                'orderby' => array(
                    'type' => 'select',
                    'label' => 'Orderby',
                    'options' => $ptsc_orderby,
                    'std' => '',
                ),
                'order' => array(
                    'type' => 'select',
                    'label' => 'Order',
                    'options' => $ptsc_order,
                    'std' => '',
                ),
                'exclude_posts' => array(
                    'type' => 'text',
                    'label' => 'Exclude posts from the list',
                    'desc' => 'Separate IDs by coma',
                    'std' => '',
                ),                 
                'include_posts' => array(
                    'type' => 'text',
                    'label' => 'Include posts from the list',
                    'desc' => 'Separate IDs by coma',
                    'std' => '',
                ),                
                'background' => array(
                    'type' => 'text',
                    'label' => 'URL to background image',
                    'desc' => 'Use image of minimum size 1920x530',
                    'std' => '',
                ),                
            )
        ),
        'actionbox' => array(
            'label' => 'Action box',
            'has_content' => false,
            'params' => array(
                'wide' => array(
                    'type' => 'select',
                    'label' => 'Full width or page width',
                    'desc' => '',
                    'options' => array(
                        'false' => 'Container width',
                        'true' => 'Full window width',
                    ),
                    'std' => 'false',
                ),
                'title' => array(
                    'type' => 'text',
                    'label' => 'Title',
                    'desc' => 'Title of box',
                    'std' => '',
                ), 
                'url' => array(
                    'type' => 'text',
                    'label' => 'URL',
                    'desc' => 'Button\'s url',
                    'std' => '',
                ),                 
                'buttontext' => array(
                    'type' => 'text',
                    'label' => 'Label',
                    'desc' => 'Button\'s label',
                    'std' => '',
                ), 
            )
        ),
        'centered_headline' => array(
            'label' => 'Headline box',
            'has_content' => false,
            'params' => array(
                'wide' => array(
                    'type' => 'select',
                    'label' => 'Full width or page width',
                    'desc' => '',
                    'options' => array(
                        'false' => 'Hide only filled jobs',
                        'true' => 'Show only filled jobs',
                    ),
                    'std' => 'false',
                ),
                'title' => array(
                    'type' => 'text',
                    'label' => 'Title',
                    'desc' => 'Title of box',
                    'std' => '',
                ),                 
                'subtitle' => array(
                    'type' => 'text',
                    'label' => 'Title',
                    'desc' => 'Title of box',
                    'std' => '',
                ), 
                'url' => array(
                    'type' => 'text',
                    'label' => 'URL',
                    'desc' => 'Button\'s url',
                    'std' => '',
                ),                 
            )
        ),
        'clients_carousel' => array(
            'label' => 'Clients carousel',
            'has_content' => true,
            'params' => array(
                'wide' => array(
                    'type' => 'select',
                    'label' => 'Select width of carousel',
                    'desc' => '',
                    'options' => $ptsc_width,
                    'std' => 'false',
                ),                
                'wide' => array(
                    'type' => 'select',
                    'label' => 'Position',
                    'desc' => '',
                    'options' => $ptsc_places,
                    'std' => 'false',
                ),
                'content' => array(
                    'type' => 'textarea',
                    'label' => 'Content',
                    'desc' => 'Put standard UL list with images links',
                    'std' => '',
                ),           
            )
        ),
        'column' => array(
            'label' => 'Column',
            'has_content' => false,
            'params' => array(
                'place' => array(
                    'type' => 'select',
                    'label' => 'Placement',
                    'desc' => 'If the columns is already in a container, you need to select place in the row it takes',
                    'options' => $ptsc_places,
                    'std' => '',
                ),
                'width' => array(
                    'type' => 'select',
                    'label' => 'Width',
                    'desc' => 'Select the width of column',
                    'options' => $ptsc_width,
                    'std' => 'four'
                ),
                'custom_class' => array(
                    'type' => 'text',
                    'label' => 'Custom class (optional)',
                    'std' => '',
                )
            )
        ),
        'latest_from_blog' => array(
            'label' => 'Recent work',
            'has_content' => false,
            'params' => array(
                'limit' => array(
                    'type' => 'select',
                    'label' => 'Limit',
                    'desc' => 'Select the number of items to display',
                    'options' => $ptsc_limit,
                    'std' => '12'
                ),              
                'columns' => array(
                    'type' => 'select',
                    'label' => 'Columns',
                    'desc' => 'Select the number of items to display',
                    'options' => array(
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                    ),
                    'std' => '3'
                ),
                'orderby' => array(
                    'type' => 'select',
                    'label' => 'Orderby',
                    'options' => $ptsc_orderby,
                    'std' => '',
                ),
                'order' => array(
                    'type' => 'select',
                    'label' => 'Order',
                    'options' => $ptsc_order,
                    'std' => '',
                ),
                'categories' => array(
                    'type' => 'text',
                    'label' => 'Categories (optional)',
                    'desc' => 'ID\'s of posts categories, separated by coma',
                    'std' => '',
                ),                
                'tags' => array(
                    'type' => 'text',
                    'label' => 'Tags (optional)',
                    'desc' => 'ID\'s of posts categories, separated by coma',
                    'std' => '',
                ),
               'exclude_posts' => array(
                    'type' => 'text',
                    'label' => 'Posts to exclude',
                    'desc' => 'ID\'s of posts to exclude from list, separated by coma',
                    'std' => '',
                ),
               'masonry' => array(
                    'type' => 'select',
                    'label' => 'Use Isotope Masonry on posts',
                    'desc' => '',
                    'options' => array(
                        ' ' => 'Don\'t use',
                        'true' => 'Use',
                    ),
                    'std' => '',
                ),
               'show_author' => array(
                    'type' => 'select',
                    'label' => 'Show author of posts',
                    'desc' => '',
                    'options' => array(
                        ''     => 'Hide',
                        'true'  => 'Show',
                    ),
                    'std' => '',
                ),               
               'show_date' => array(
                    'type' => 'select',
                    'label' => 'Show date of posts',
                    'desc' => '',
                    'options' => array(
                        ''     => 'Hide',
                        'true'  => 'Show',
                    ),
                    'std' => '',
                ),
                'place' => array(
                    'type' => 'select',
                    'label' => 'Placement',
                    'desc' => 'If the columns is already in a container, you need to select place in the row it takes',
                    'options' => $ptsc_places,
                    'std' => '',
                ),
                'width' => array(
                    'type' => 'select',
                    'label' => 'Width',
                    'desc' => 'Select the width of column',
                    'options' => $ptsc_width,
                    'std' => 'sixteen'
                ),
                'limit_words' => array(
                    'type' => 'text',
                    'label' => 'Limit words (optional)',
                    'desc' => 'Number of words of post content',
                    'std' => '15',
                ), 
            )
        ),
        'jobs_categories' => array(
            'label' => 'Jobs Categories List',
            'has_content' => false,
            'params' => array(
                'type' => array(
                    'type' => 'select',
                    'label' => 'Type of content',
                    'desc' => ' Whether to not return empty job categories.',
                    'options' => array(
                        'all' => 'Show all categories in one list',
                        'group_by_parent' => 'Each section shows childrens of each parent category',
                        'parent' => 'Categories of choosed parent',
                        'only_parents' => 'Only categories of choosed parent',
                    ),
                    'std' => 'all',
                ),
                'hide_empty' => array(
                    'type' => 'select',
                    'label' => 'Hide empty',
                    'desc' => ' Whether to not return empty job categories.',
                    'options' => array(
                        '0' => 'Show empty categories',
                        '1' => 'Do not show empty categories',
                    ),
                    'std' => '0',
                ),
                'orderby' => array(
                    'type' => 'select',
                    'label' => 'Orderby',
                    'options' => $ptsc_orderby,
                    'std' => 'count',
                ),
                'title' => array(
                    'type' => 'text',
                    'label' => 'Title',
                    'desc' => 'Title is used if type is set to all',
                    'std' => 'Web, Software & IT',
                ),     
               
                'number' => array(
                    'type' => 'text',
                    'label' => 'Number of items to display',
                    'desc' => 'Select the number of items to display',
                    'std' => '99'
                ),                
                'wide' => array(
                    'type' => 'select',
                    'label' => 'Full width or page width',
                    'desc' => '',
                    'options' => array(
                        ' ' => 'Standard width',
                        'yes' => 'Full window width',
                    ),
                    'std' => 'yes',
                ),        
                'parent_id' => array(
                    'type'  => 'text',
                    'label' => 'Parent id',
                    'desc'  => 'ID of parent category if you want to display just child categories of specific term',
                    'std' => '',
                ),
            )
        ),
        'resume_categories' => array(
            'label' => 'Resume Categories List',
            'has_content' => false,
            'params' => array(
                'type' => array(
                    'type' => 'select',
                    'label' => 'Type of content',
                    'desc' => ' Whether to not return empty resume categories.',
                    'options' => array(
                        'all' => 'Show all categories in one list',
                        'group_by_parents' => 'Each section shows childrens of each parent category',
                        'parent' => 'Categories of choosed parent',
                    ),
                    'std' => 'all',
                ),
                'hide_empty' => array(
                    'type' => 'select',
                    'label' => 'Hide empty',
                    'desc' => ' Whether to not return empty resume categories.',
                    'options' => array(
                        '0' => 'Show empty categories',
                        '1' => 'Do not show empty categories',
                    ),
                    'std' => '0',
                ),
                'orderby' => array(
                    'type' => 'select',
                    'label' => 'Orderby',
                    'options' => $ptsc_orderby,
                    'std' => 'count',
                ),
                'title' => array(
                    'type' => 'text',
                    'label' => 'Title',
                    'desc' => 'Title is used if type is set to all',
                    'std' => 'Web, Software & IT',
                ),     
               
                'number' => array(
                    'type' => 'text',
                    'label' => 'Number of items to display',
                    'desc' => 'Select the number of items to display',
                    'std' => '99'
                ),                
                'wide' => array(
                    'type' => 'select',
                    'label' => 'Full width or page width',
                    'desc' => '',
                    'options' => array(
                        ' ' => 'Standard width',
                        'yes' => 'Full window width',
                    ),
                    'std' => 'yes',
                ),        
                'parent_id' => array(
                    'type'  => 'text',
                    'label' => 'Parent id',
                    'desc'  => 'ID of parent category if you want to display just child categories of specific term',
                    'std' => '',
                ),
            )
        ),
        'box' => array(
            'label' => 'Alert box',
            'has_content' => true,
            'params' => array(
                
                'type' => array(
                    'type' => 'select',
                    'label' => 'Type of box',
                    'options' => array(
                        'success' => 'Success',
                        'error' => 'Error',
                        'warning' => 'Warning',
                        'notice' => 'Notice',
                    ),
                    'std' => '',
                ), 
                'content' => array(
                    'type' => 'textarea',
                    'label' => 'Content',
                    'std' => '',
                ),
            )
        ),        
        'infobanner' => array(
            'label' => 'Info banner',
            'has_content' => true,
            'params' => array(
                'title' => array(
                    'type' => 'text',
                    'label' => 'Title',
                    'desc' => 'Title',
                    'std' => 'Perfect Template for Your Own Job Board',
                ), 
                'url' => array(
                    'type' => 'text',
                    'label' => 'URL',
                    'desc' => 'Buttons link',
                    'std' => '',
                ),
                'target' => array(
                    'type' => 'select',
                    'label' => 'URL',
                    'desc' => 'Link target',
                    'options' => $ptsc_target,
                    'std' => '',
                ),
                'buttontext' => array(
                    'type' => 'text',
                    'label' => 'Buttons label',
                    'desc' => 'Text displayed on the button',
                    'std' => 'Get This Theme',
                ),
                'content' => array(
                    'type' => 'textarea',
                    'label' => 'Content',
                    'std' => '',
                ),
            )
        ),
    'counterbox' => array(
        'label' => 'Counter box',
        'wrapper' => 'counters',
        'has_content' => false,
        'params' => array(
            'title' => array(
                'type' => 'text',
                'label' => 'Title',
                'desc' => 'Set title',
                'std' => 'Resumes Posted',
            ),
            'type' => array(
                'type' => 'select',
                'label' => 'Get automatic value of',
                'desc' => 'Ignore the next "number" attribute if this is set to something else then "custom"',
                'options' => array(
                    '' => 'Custom',
                    'jobs' => 'Jobs',
                    'resumes' => 'Resumes',
                    'posts' => 'Posts',
                    'members' => 'Members',
                    'candidates' => 'Candidates',
                    'employers' => 'Employers',
                   ),
                'std' => ''
            ),
            'value' => array(
                'type' => 'text',
                'label' => 'Number to animate',
                'desc' => '',
                'std' => '',
            ),
            'scale' => array(
                'type' => 'text',
                'label' => 'Scale',
                'desc' => 'k,mln, % etc',
                'std' => '',
            ),
            'width' => array(
                'type' => 'select',
                'label' => 'Width',
                'options' => $ptsc_width,
                'std' => 'one-third'
            ),
        )
    ),

    'pricing_table' => array(
        'label' => 'Pricing Table',
        'has_content' => true,
        'params' => array(
            'place' => array(
                'type' => 'select',
                'label' => 'Placement',
                'desc' => 'Place in the row',
                'options' => $ptsc_places,
                'std' => '',
            ),
            'width' => array(
                'type' => 'select',
                'label' => 'Width',
                'desc' => 'Select the width for table',
                'options' => $ptsc_width,
                'std' => 'four'
            ),
            'type' => array(
                'type' => 'select',
                'label' => 'Table style',
                'desc' => 'Set style table',
                'options' => array(
                   'color-1' => '1',
                   'color-2' => '2'
                   ),
                'std' => ''
            ),
            'color' => array(
                'type' => 'colorpicker',
                'label' => 'Custom color for table',
                'desc' => '',
                'std' => '',
            ),
            'title' => array(
                'type' => 'text',
                'label' => 'Title',
                'desc' => 'Set title',
                'std' => '',
            ),
            'currency' => array(
                'type' => 'text',
                'label' => 'Currency',
                'desc' => 'Set currenct ($)',
                'std' => '$'
            ),
            'price' => array(
                'type' => 'text',
                'label' => 'Price',
                'desc' => 'Set price (just number)',
                'std' => '',
            ),
            'discounted' => array(
                'type' => 'text',
                'label' => 'Discount Price',
                'desc' => 'Optional. Set price (just number)',
                'std' => '',
            ),
            'per' => array(
                'type' => 'text',
                'label' => 'Per',
                'std' => 'per'
            ),
            'buttonstyle' => array(
                'type' => 'select',
                'label' => 'Button style',
                'desc' => 'Set style of "sign up" button',
                'options' => array(
                   'light' => 'Light',
                   'color' => 'Color'
                   ),
                'std' => ''
            ),
            'buttonlink' => array(
                'type' => 'text',
                'label' => 'URL',
                'desc' => 'Set URL for "sign up" button',
                'std' => ''
            ),
            'buttontext' => array(
                'type' => 'text',
                'label' => 'Button label',
                'desc' => 'Set label for "sign up" button (leave empty to hide button)',
                'std' => 'Sign up'
            ),
            'content' => array(
                'type' => 'textarea',
                'label' => 'Content',
                'desc' => 'Best way is to use HTML list',
                'std' => ''
            ),
        )
    ),
    'pricing_woo_tables' => array(
        'label' => 'Pricing Table WooCommerce',
        'has_content' => true,
        'params' => array(

            'type' => array(
                'type' => 'select',
                'label' => 'Table style',
                'desc' => 'Set style table',
                'options' => array(
                   'color-1' => '1',
                   'color-2' => '2'
                   ),
                'std' => ''
            ),
        )
    ),


   /* 'list' => array(
        'label' => 'List',
        'has_content' => true,
        'params' => array(
            'type' => array(
                'type' => 'select',
                'label' => 'List style',
                'desc' => 'Set title',
                'options' => array(
                    '1' => 'Check',
                    '2' => 'Arrow',
                    '3' => 'Check with background',
                    '4' => 'Arrow with background',
                ),
                'std' => ''
            ),
            'color' => array(
                'type' => 'select',
                'label' => 'Colored icons?',
                'desc' => '',
                'options' => array(
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'std' => ''
            ),
             'content' => array(
                'type' => 'textarea',
                'label' => 'Content',
                'std' => ''
            ),
        )
    ),*/
    
    
);
$pt_shortcodes = array_merge($pt_shortcodes, $workscout_pt_shortcodes);
return $pt_shortcodes;
}


function workscout_add_shortcodes() {
    add_filter( 'ptsc_shortcodes', 'workscout_shortcodes_list' );
}
add_action( 'init', 'workscout_add_shortcodes' ); ?>