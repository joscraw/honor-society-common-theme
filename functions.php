<?php


/**
 * Enable ACF 5 early access
 * Requires at least version ACF 4.4.12 to work
 */
define('ACF_EARLY_ACCESS', '5');



add_action('wp_enqueue_scripts', function()
{
    wp_register_script('custom.js', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), "1.0", true);
    wp_enqueue_script('custom.js');

    wp_register_style( 'normalize.css', 'https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.css',false,"1.0",'all');
    wp_enqueue_style('normalize.css');

    wp_register_style( 'custom.css', get_template_directory_uri() . '/assets/css/custom.css',false,"1.0",'all');
    wp_enqueue_style('custom.css');

});


add_filter('tribe_events_pro_widget_calendar_stylesheet_url', function() {
    $styleUrl = get_template_directory_uri() . '/assets/css/custom-events-pro-widget-stylesheet.css';
    return $styleUrl;
});

/*add_filter( 'tribe_events_pre_get_posts', 'redirect_from_events' );

function redirect_from_events( $query ) {

    if ( is_user_logged_in() )
        return;

    if ( ! $query->is_main_query() || ! $query->get( 'eventDisplay' ) )
        return;

// Look for a page with a slug of "logged-in-users-only".
    $target_page = get_posts( array(
        'post_type' => 'page',
        'name' => 'logged-in-users-only'
    ) );

// Use the target page URL if found, else use the home page URL.
    if ( empty( $target_page ) ) {
        $url = get_home_url();
    } else {
        $target_page = current( $target_page );
        $url = get_permalink( $target_page->ID );
    }

// Redirect!
    wp_safe_redirect( $url );
    exit;
}*/

function my_custom_login()
{
    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/assets/css/login.css" />';
}
add_action('login_head', 'my_custom_login');
