<?php
/**
 * WorkScout Theme Customizer.
 *
 * @package WorkScout
 */


Kirki::add_config( 'workscout', array(
    'capability'    => 'edit_theme_options',
    'option_type'   => 'option',
    'option_name'   => 'workscout',
    'disable_output'   => false,
) );



/**
 * Customizer additions.
 */

require get_template_directory() . '/inc/customizer/header.php';
require get_template_directory() . '/inc/customizer/jobs.php';
require get_template_directory() . '/inc/customizer/resumes.php';
require get_template_directory() . '/inc/customizer/homesearch.php';
require get_template_directory() . '/inc/customizer/maps.php';
require get_template_directory() . '/inc/customizer/colors.php';
require get_template_directory() . '/inc/customizer/layout.php';

require get_template_directory() . '/inc/customizer/blog.php';
require get_template_directory() . '/inc/customizer/shop.php';
require get_template_directory() . '/inc/customizer/footer.php';
require get_template_directory() . '/inc/customizer/typography.php';
require get_template_directory() . '/inc/customizer/contact.php';


require get_template_directory() . '/inc/customizer/title_tagline.php';
/*section blog*/


/*


Max Zoom In Level
Max Zoom Out Level*/

add_action('wp_head', 'workscout_stylesheet_content');


function workscout_generate_typo_css($typo){
    if($typo){
        $wpv_ot_default_fonts = array('arial','georgia','helvetica','palatino','tahoma','times','trebuchet','verdana');        
        $ot_google_fonts = get_theme_mod( 'ot_google_fonts', array() );
        foreach ($typo as  $key => $value) {
            if(isset($value) && !empty($value)) {
                if($key=='font-color') { $key = "color"; }
                if($key=='font-family') { 
                    if ( ! in_array( $value, $wpv_ot_default_fonts ) ) {
                        $value = $ot_google_fonts[$value]['family']; } 
                    }
                echo $key.":".$value.";";
                
            }
        }
    }
}

function workscout_generate_bg_css($typo){
    if($typo){
        foreach ($typo as  $key => $value) {
            if(isset($value) && !empty($value)) {
                if($key=='background-image') $value = "url('".$value."')";
                return esc_attr($key).":".$value.";";
            }
        }
    }
}




function workscout_stylesheet_content() { 

$maincolor = Kirki::get_option( 'workscout', 'pp_main_color' ); 
$mapheight = Kirki::get_option( 'workscout', 'pp_map_height', '400px' ); 
$logo_height = Kirki::get_option( 'workscout', 'pp_retina_logo_height',65 ); 
$markercolor =  Kirki::get_option( 'workscout', 'pp_maps_marker_color', '#808080' );  


$map_provider = get_option( 'workscout_map_provider');
if($map_provider == "none"): $mapheight='20px'; endif; ?>

<style type="text/css">

.old-header .current-menu-item > a,a.button.gray.app-link.opened,ul.float-right li a:hover,.old-header .menu ul li.sfHover a.sf-with-ul,.old-header .menu ul li a:hover,a.menu-trigger:hover,
.old-header .current-menu-parent a,#jPanelMenu-menu li a:hover,.search-container button,.upload-btn,button,input[type="button"],input[type="submit"],a.button,.upload-btn:hover,#titlebar.photo-bg a.button.white:hover,a.button.dark:hover,#backtotop a:hover,.mfp-close:hover,.woocommerce-MyAccount-navigation li.is-active a,.woocommerce-MyAccount-navigation li.current-menu-item a,.tabs-nav li.active a, .tabs-nav-o li.active a,.accordion h3.active-acc,.highlight.color, .plan.color-2 .plan-price,.plan.color-2 a.button,.tp-leftarrow:hover,.tp-rightarrow:hover,
.pagination ul li a.current-page,.woocommerce-pagination .current,.pagination .current,.pagination ul li a:hover,.pagination-next-prev ul li a:hover,
.infobox,.load_more_resumes,.job-manager-pagination .current,.hover-icon,.comment-by a.reply:hover,.chosen-container .chosen-results li.highlighted,
.chosen-container-multi .chosen-choices li.search-choice,.list-search button,.checkboxes input[type=checkbox]:checked + label:before, .double-bounce1, .double-bounce2,
.widget_range_filter .ui-state-default,.tagcloud a:hover,.filter_by_tag_cloud a.active,.filter_by_tag_cloud a:hover,#wp-calendar tbody td#today,.footer-widget .tagcloud a:hover,.nav-links a:hover, .icon-box.rounded i:after, #mapnav-buttons a:hover,
.dashboard-list-box .button.gray:hover,
.dashboard-list-box-static .button,
.select2-container--default .select2-selection--multiple .select2-selection__choice,
#footer-new .footer-widget.widget_nav_menu li a:before,
.message-reply button,
.account-type input.account-type-radio:checked ~ label,
.mm-menu em.mm-counter,
.comment-by a.comment-reply-link:hover,#jPanelMenu-menu .current-menu-item > a, .button.color,.intro-search-button .button { background-color: <?php echo esc_attr($maincolor); ?>; }
.account-type input.account-type-radio ~ label:hover {
    color: <?php echo esc_attr($maincolor); ?>;
    background-color: rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>, 0.1);
}
a,table td.title a:hover,table.manage-table td.action a:hover,#breadcrumbs ul li a:hover,#titlebar span.icons a:hover,.counter-box i,
.counter,#popular-categories li a i,.single-resume .resume_description.styled-list ul li:before,.list-1 li:before,.dropcap,.resume-titlebar span a:hover i,.resume-spotlight h4, .resumes-content h4,.job-overview ul li i,
.company-info span a:hover,.infobox a:hover,.meta-tags span a:hover,.widget-text h5 a:hover,.app-content .info span ,.app-content .info ul li a:hover,
table td.job_title a:hover,table.manage-table td.action a:hover,.job-spotlight span a:hover,.widget_rss li:before,.widget_rss li a:hover,
.widget_categories li:before,.widget-out-title_categories li:before,.widget_archive li:before,.widget-out-title_archive li:before,
.widget_recent_entries li:before,.widget-out-title_recent_entries li:before,.categories li:before,.widget_meta li:before,.widget_recent_comments li:before,
.widget_nav_menu li:before,.widget_pages li:before,.widget_categories li a:hover,.widget-out-title_categories li a:hover,.widget_archive li a:hover,
.widget-out-title_archive li a:hover,.widget_recent_entries li a:hover,.widget-out-title_recent_entries li a:hover,.categories li a:hover,
.widget_meta li a:hover,#wp-calendar tbody td a,.widget_nav_menu li a:hover,.widget_pages li a:hover,.resume-title a:hover, .company-letters a:hover, .companies-overview li li a:hover,.icon-box.rounded i, .icon-box i,
#titlebar .company-titlebar span a:hover, .adv-search-btn a , .new-category-box .category-box-icon, body .new-header #navigation > ul > li:hover > a, body .new-header #navigation > ul > li > a:hover, body .new-header #navigation > ul > li > a.current, body .new-header #navigation > ul > li:hover > a,
body .new-header #navigation > ul > li > a:hover,
.dashboard-nav ul li.active-submenu a, .dashboard-nav ul li:hover a, .dashboard-nav ul li.active a,

.new-header .transparent-header #navigation > ul li:hover ul li:hover a:after,
.new-header .transparent-header #navigation > ul li:hover a:after,
.new-header .transparent-header #navigation > ul li a.current:after,
.account-type input.account-type-radio ~ label:hover i,
.transparent-header .login-register-buttons a:hover, .login-register-buttons a:hover,
body .new-header #navigation > ul > li > a.current, .new-header #navigation ul li:hover a:after, .new-header #navigation ul li a.current:after { color:  <?php echo esc_attr($maincolor); ?>; }
.dashboard-nav ul li.active-submenu, .dashboard-nav ul li.active, .dashboard-nav ul li:hover,
.icon-box.rounded i { border-color: <?php echo esc_attr($maincolor); ?>; }

.resumes li a:before,.resumes-list li a:before,.job-list li a:before,table.manage-table tr:before {	-webkit-box-shadow: 0px 1px 0px 0px rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>,0.7);	-moz-box-shadow: 0px 1px 0px 0px rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>,0.7);	box-shadow: 0px 1px 0px 0px rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>,0.7);}
#popular-categories li a:before {-webkit-box-shadow: 0px 0px 0px 1px rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>,0.7);-moz-box-shadow: 0px 0px 0px 1px rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>,0.7);box-shadow: 0px 0px 0px 1px rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>,0.7);}
table.manage-table tr:hover td,.resumes li:hover,.job-list li:hover { border-color: rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>,0.7); }
.dashboard-nav ul li.active-submenu, .dashboard-nav ul li.active, .dashboard-nav ul li:hover,
table.manage-table tr:hover td,.resumes li:hover,.job-list li:hover, #popular-categories li a:hover { background-color: rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>,0.05); }

.new-category-box:hover {
    background: <?php echo esc_attr($maincolor); ?>;
    box-shadow: 0 4px 12px rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>, 0.35);
}
a.load_more_jobs.button,
.button.send-message-to-owner,
.resume-template-default .button.send-message-to-owner,
.browse-all-cat-btn a{
    box-shadow: 0 4px 12px rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>, 0.25);
}

@keyframes markerAnimation {
    0%,100% {
        box-shadow: 0 0 0 6px rgba(<?php echo workscout_hex2rgb($markercolor, true) ?>,0.15);
    }
    50% {
        box-shadow: 0 0 0 8px rgba(<?php echo workscout_hex2rgb($markercolor, true) ?>,0.15);
    }
}


@keyframes clusterAnimation {
    0%,100% {
        box-shadow: 0 0 0 6px rgba(<?php echo workscout_hex2rgb($markercolor, true) ?>,0.15);
    }
    50% {
        box-shadow: 0 0 0 10px rgba(<?php echo workscout_hex2rgb($markercolor, true) ?>,0.15);
    }
}
.marker-cluster-small div, .marker-cluster-medium div, .marker-cluster-large div,
.marker-container,
.cluster-visible  { background-color: <?php echo esc_attr($markercolor); ?>; }
.marker-cluster div:before {
    border: 7px solid <?php echo esc_attr($markercolor); ?>;
    box-shadow: inset 0 0 0 4px <?php echo esc_attr($markercolor); ?>;
}

body #dashboard table.manage-table tr:hover td { 
  border-bottom: 1px solid <?php echo esc_attr($maincolor); ?>;
}
.select2-container--default .select2-results__option--highlighted[aria-selected],
.dashboard-nav ul li span.nav-tag,

body .wp-subscribe-wrap input.submit,
.adv-search-btn a:after,
.panel-dropdown.active > a,
body #dashboard table.manage-table tr td:before {
    background: <?php echo esc_attr($maincolor); ?>;
}

.mm-counter {
    background-color: <?php echo esc_attr($maincolor); ?>;
}


.resumes.alternative li:before,
.category-small-box:hover { background-color: <?php echo esc_attr($maincolor); ?>; }
.panel-dropdown > a:after,
.category-small-box i { color: <?php echo esc_attr($maincolor); ?>; }
.old-header .transparent #logo img,
#logo_nh img,
 #logo img {
    max-height: <?php echo $logo_height?>px;
}

#ws-map,
#search_map {
	height: <?php echo $mapheight; ?>;
}


<?php $ordering = Kirki::get_option( 'workscout', 'pp_shop_ordering' ); 
if($ordering) { ?>
	.woocommerce-ordering { display: none; }
	.woocommerce-result-count { display: none; }
<?php } ?>

<?php 
$rss = Kirki::get_option( 'workscout', 'pp_disable_rss', false ); 
if($rss) { ?>
.job_filters a.rss_link { display: none; }
<?php } ?>

<?php 
$breakpoint = Kirki::get_option( 'workscout', 'pp_alt_menu_width', false ); 
if($breakpoint) { ?>
@media (max-width: <?php echo $breakpoint; ?>px) {
.sticky-header.cloned { display: none;}
#titlebar.photo-bg.with-transparent-header.single {
    padding-top:200px !important;
}
}
<?php } ?>



<?php 
$woo_nav = Kirki::get_option( 'workscout', 'pp_hide_woo_nav', array() );
if(is_array($woo_nav)) {
$woo_output = '';

    if(in_array('dashboard', $woo_nav)) {
        $woo_output .= '
            .woocommerce-MyAccount-navigation-link--dashboard { display: none; }
        ';
    }
    if(in_array('orders', $woo_nav)) {
        $woo_output .= '
            .woocommerce-MyAccount-navigation-link--orders { display: none; }
        ';
    }   
    if(in_array('downloads', $woo_nav)) {
        $woo_output .= '
            .woocommerce-MyAccount-navigation-link--downloads { display: none; }
        ';
    }   
    if(in_array('addresses', $woo_nav)) {
        $woo_output .= '
            .woocommerce-MyAccount-navigation-link--edit-address { display: none; }
        ';
    }   
    if(in_array('account_details', $woo_nav)) {
        $woo_output .= '
            .woocommerce-MyAccount-navigation-link--edit-account { display: none; }
        ';
    }   
    if(in_array('logout', $woo_nav)) {
        $woo_output .= '
            .woocommerce-MyAccount-navigation-link--customer-logout { display: none; }
        ';
    }
    echo $woo_output;
}
 ?>
</style>

<?php }	



/**
 * Convert a hexa decimal color code to its RGB equivalent
 *
 * @param string $hexStr (hexadecimal color value)
 * @param boolean $returnAsString (if set true, returns the value separated by the separator character. Otherwise returns associative array)
 * @param string $seperator (to separate RGB values. Applicable only if second parameter is true.)
 * @return array or string (depending on second parameter. Returns False if invalid hex color value)
 */
function workscout_hex2rgb($hexStr, $returnAsString = false, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
}