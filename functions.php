<?php


/**
 * Enable ACF 5 early access
 * Requires at least version ACF 4.4.12 to work
 */
define('ACF_EARLY_ACCESS', '5');

include( dirname( __FILE__ ) . '/inc/woocommerce-dynamic-payment.php');
include(dirname(__FILE__) . '/inc/auth.php');
include(dirname(__FILE__) . '/inc/helpers.php');

add_action('wp_enqueue_scripts', function()
{

    wp_enqueue_script( 'nscs-mask', get_theme_file_uri( '/assets/js/mask.js' ), array( 'jquery' ), '2.1.2', true );
    wp_enqueue_script( 'stripe-v3', 'https://js.stripe.com/v3/', array(), '3.0', true );
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

/*
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
        $search = new \CRMConnector\Database\EventSearch();

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

}, 10, 1);*/

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

add_theme_support( 'menus' );

function register_theme_menus () {
    register_nav_menus( [
        'primary-menu' => _( 'Primary Menu' )
    ] );
}

add_action( 'init', 'register_theme_menus' );


add_filter( 'tribe_events_list_show_date_headers', function() {
    return false;
});

// Ensure only events that a part of a chapter a user belongs to show
// If the user is an admin then show all events
add_action( 'tribe_events_pre_get_posts', function($query) {

    $user = wp_get_current_user();
    $current_user_roles = $user->roles;
    $current_user_id = get_current_user_id();
    $all_chapter_roles = ['administrator', 'honor_society_admin'];
    $limited_chapter_roles = ['student', 'chapter_adviser', 'chapter_officer'];

    $all_chapter_roles = array_filter($all_chapter_roles, function($role) use($current_user_roles) {
        return in_array($role, $current_user_roles);
    });

    $limited_chapter_roles = array_filter($limited_chapter_roles, function($role) use($current_user_roles) {
        return in_array($role, $current_user_roles);
    });

    if(!empty($all_chapter_roles)) {
        // noop
        $name = "Josh";
    }

    if(!empty($limited_chapter_roles)) {
        $posts = get_posts([
            'post_type' => 'contacts',
            'posts_per_page' => 1,
            'meta_query' => array(
                array(
                    'key' => 'portal_user',
                    'value' => $current_user_id,
                    'compare' => '=',
                ),
            ),
        ]);

        if( !empty($posts) ) {
            $chapter_id = get_post_meta($posts[0]->ID, 'account_name', true);

            $query->query_vars['posts_per_page'] = 10;
            $query->query_vars['meta_query'][] = array(
                array(
                    'key' => 'chapter',
                    'value' => $chapter_id,
                    'compare' => 'LIKE',
                ),
            );
        }
    }

}, 10, 1 );
