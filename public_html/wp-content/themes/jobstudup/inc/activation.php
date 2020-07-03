<?php 

register_activation_hook( __FILE__, 'workscout_welcome_activate' );

function workscout_welcome_activate() {
  set_transient( '_workscout_welcome_activation_redirect', true, 30 );
}

add_action( 'admin_init', 'workscout_welcome_do_activation_redirect' );
function workscout_welcome_do_activation_redirect() {
  // Bail if no activation redirect
    if ( ! get_transient( '_workscout_welcome_activation_redirect' ) ) {
    return;
  }

  // Delete the redirect transient
  delete_transient( '_workscout_welcome_activation_redirect' );

  // Bail if activating from network, or bulk
  if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
    return;
  }

  // Redirect to WorkScout about page
  wp_safe_redirect( add_query_arg( array( 'page' => 'workscout-screen-about' ), admin_url( 'index.php' ) ) );

}

add_action( 'admin_enqueue_scripts', 'workscout_welcome_enqueue_styles' );

function workscout_welcome_enqueue_styles() {
    $screen = get_current_screen();

    if ( 'dashboard_page_workscout-welcome-screen' != $screen->id ) {
      return;
    }

    wp_enqueue_style( 'welcome-css', get_template_directory_uri() . '/css/admin.css' );
  }

add_action('admin_menu', 'workscout_welcome_pages');

function workscout_welcome_pages() {
  add_dashboard_page(
    'Welcome To WorkScout',
    'Welcome To WorkScout',
    'read',
    'workscout-welcome-screen',
    'workscout_welcome_content'
  );
}

function workscout_welcome_content() {
  ?>
  <div class="wrap welcome-wrap">
    
    <h1>Welcome to WorkScout!</h1>
      <div class="about-text">
        <div class="wp-badge um-badge">Version <?php $my_theme = wp_get_theme(); echo $my_theme->get( 'Version' ); ?></div>
        <p><strong>WorkScout</strong> is a fully functioning job board Theme for <strong>WordPress</strong> developed with the popular free <strong>WordPress Plugin WP Job Manager</strong>.</p>

        <p>It integrates beautifully and simply and can be extended with a few extensions and Plugins so that you can build your very own feature rich job marketplace!</p>

      </div>

      <h2>Getting Started</h2>
      <p>You'll find the <strong>documenation</strong> and start guide <a href="http://purethemes.helpscoutdocs.com/category/4-1-getting-started">here</a>. Please follow it if you want to re-create the demo content.<p>
      <p>If you want the same content as the demo page, you need to buy also some additional plugins, WorkScout is based on <strong>WP Job Manager</strong> and it's add-ons. The free version of <strong>WP Job Manager</strong> allows for listing jobs and job submissions, If you want to have resumes, application, bookmarks, job alerts and other features you can see on a demo, the best way would be to buy the <strong><a href="https://wpjobmanager.com/add-ons/bundle/?ref=7&campaign=theme">Core Add-on Bundle</a></strong>
      </p>
      <p>For theme related support request contact me please via <a href="http://themeforest.net/item/workscout-job-board-wordpress-theme/13591801/support">Support page</a></p>
      <p> The WP Job Manager plugin and its add-ons are handled by <a href="https://wpjobmanager.com/support/?ref=7&campaign=theme">WPJM support</a>.</p>
      <a target="_blank" href="http://purethemes.helpscoutdocs.com/category/4-1-getting-started" class="button">View Documentation</a>
  </div>  
  <?php
}

add_action( 'admin_head', 'workscout_welcome_remove_menus' );

function workscout_welcome_remove_menus() {
    remove_submenu_page( 'index.php', 'workscout-welcome-screen' );
}