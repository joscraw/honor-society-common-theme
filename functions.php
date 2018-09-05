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

/* ------------------------------------ START LOGIN LOGIC ------------------------------------*/

/* Main redirection of the default login page */
function redirect_login_page() {
    $login_page  = home_url('/login/');
    $page_viewed = basename($_SERVER['REQUEST_URI']);

    if($page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
        wp_redirect($login_page);
        exit;
    }
}
add_action('init','redirect_login_page');

/* Where to go if a login failed */
function custom_login_failed() {
    $login_page  = home_url('/login/');
    wp_redirect($login_page . '?login=failed');
    exit;
}
add_action('wp_login_failed', 'custom_login_failed');

/* Where to go if any of the fields were empty */
function verify_user_pass($user, $username, $password) {
    $login_page  = home_url('/login/');
    if($username == "" || $password == "") {
        wp_redirect($login_page . "?login=empty");
        exit;
    }
}
add_filter('authenticate', 'verify_user_pass', 1, 3);

/* What to do on logout */
function logout_redirect() {
    $login_page  = home_url('/login/');
    wp_redirect($login_page . "?login=false");
    exit;
}
add_action('wp_logout','logout_redirect');


/* ------------------------------------ END LOGIN LOGIC ------------------------------------*/


add_filter('tribe_events_get_current_month_day', function($current_day){


    if(is_single())
    {
        global $post;

        $current_date_time_obj = new \DateTime($current_day['date']);
        $event_date_time_obj = new \DateTime($post->EventStartDate);

        $firstDate = $current_date_time_obj->format('Y-m-d');
        $secondDate = $event_date_time_obj->format('Y-m-d');

        // Let's only show events for the calendar widget
        if($firstDate !== $secondDate)
        {
        $current_day['total_events'] = "0";
        }
    }

    if($current_day['total_events'] > 0)
    {
        $search = new \CRMConnector\Events\EventSearch();

        $query = $current_day['events'];

        $posts = $query->get_posts();

        foreach($posts as $post)
        {
            if(!$search->is_logged_in_user_allowed_to_attend_event($post))
            {
                $current_day['total_events'] = 0;
            }
        }
    }

    return $current_day;

}, 10, 1);

/********* PAGINATION ***********/
function pagination($pages = '', $range = 4)
{
    $showitems = ($range * 2)+1;

    global $paged;
    if(empty($paged)) $paged = 1;

    if($pages == '')
    {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if(!$pages)
        {
            $pages = 1;
        }
    }

    if(1 != $pages)
    {
        echo "<div class=\"pagination\">";
        if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
        if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";

        for ($i=1; $i <= $pages; $i++)
        {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
            {
                echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
            }
        }

        if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";
        if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
        echo "</div>\n";
    }
}