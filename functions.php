<?php


/**
 * Enable ACF 5 early access
 * Requires at least version ACF 4.4.12 to work
 */
use CRMConnector\CreateMediaFile;

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

    global $CRMConnectorPlugin;

    $query->query_vars['posts_per_page'] = 10;

    if(!empty($CRMConnectorPlugin->data['chapter_id'])) {
        $query->query_vars['meta_query'][] = array(
            array(
                'key' => 'chapter',
                'value' => $CRMConnectorPlugin->data['chapter_id'],
                'compare' => 'LIKE',
            ),
        );
    }

}, 10, 1 );

/*
 * Student Sign up Form Submission
 */
function nscs_ajax_save_student_profile() {

    check_ajax_referer( 'student_profile', 'nonce' );

    $contact    = $_POST["contact"];
    $first_name = $_POST["first_name"];
    $last_name 	= $_POST["last_name"];
    $email 		= $_POST["email"];
    $password 	= $_POST["password"];
    $gender 	= $_POST["gender"];
    $ethnicity 	= $_POST["ethnicity"];
    $age 	    = $_POST["age"];
    $date_of_birth 	= $_POST["date_of_birth"];
    $non_traditional_student = $_POST['non_traditional_student'];
    $first_to_go_to_college = $_POST['first_to_go_to_college'];
    $veteran = $_POST['veteran'];
    $previous_school = $_POST['previous_school'];
    $other_honor_societies = $_POST['other_honor_societies'];
    $parent_first_name = $_POST['parent_first_name'];
    $parent_last_name = $_POST['parent_last_name'];
    $parent_email = $_POST['parent_email'];
    $parent_2_first_name = $_POST['parent_2_first_name'];
    $parent_2_last_name = $_POST['parent_2_last_name'];
    $parent_2_email = $_POST['parent_2_email'];
    $non_traditional_student_reason = $_POST['non_traditional_student_reason'];
    $scholar_connection_newsletter_emails = $_POST['scholar_connection_newsletter_emails'];
    $chapter_emails = $_POST['chapter_emails'];
    $scholarship_emails = $_POST['scholarship_emails'];
    $opt_out = $_POST['opt_out'];
    $email_opt_out = $_POST['email_opt_out'];
    $do_not_mail = $_POST['do_not_mail'];
    $do_not_call = $_POST['do_not_call'];

    new CreateMediaFile($_FILES['profile_picture'], 'profile_picture', $contact);

    if ( username_exists( $email ) || get_user_by( 'email', $email ) ) {
        $already_existing_user = get_user_by( 'email', $email );
        if($already_existing_user->ID !== get_current_user_id()) {
            echo json_encode(array(
                "success" => false,
                "message" => "The email '$email' is already in use"
            ));
            die();
        }
    }

    update_post_meta($contact, 'first_name', $first_name);
    update_post_meta($contact, 'last_name', $last_name);
    update_post_meta($contact, 'email', $email);
    update_post_meta($contact, 'gender', $gender);
    update_post_meta($contact, 'ethnic_identity', $ethnicity);
    update_post_meta($contact, 'age', $age);
    update_field('birthdate', $date_of_birth, $contact);
    update_field('first_generation_student', $first_to_go_to_college, $contact);
    update_field('non-traditional_student', $non_traditional_student, $contact);
    update_field('non-traditional_student_reason', $non_traditional_student_reason, $contact);
    update_field('veteran', $veteran, $contact);
    update_field('previous_school', $previous_school, $contact);
    update_field('other_honor_societies', $other_honor_societies, $contact);
    update_field('parent_first_name', $parent_first_name, $contact);
    update_field('parent_last_name', $parent_last_name, $contact);
    update_field('parent_email', $parent_email, $contact);
    update_field('parent_2_first_name', $parent_2_first_name, $contact);
    update_field('parent_2_last_name', $parent_2_last_name, $contact);
    update_field('parent_2_email', $parent_2_email, $contact);
    update_field('opt_out', $opt_out, $contact);
    update_field('email_opt_out', $email_opt_out, $contact);
    update_field('do_not_call', $do_not_call, $contact);
    update_field('do_not_mail', $do_not_mail, $contact);
    update_field('email_scholar_connection_enewsletter', $scholar_connection_newsletter_emails, $contact);
    update_field('email_chapter_emails', $chapter_emails, $contact);
    update_field('email_scholarships', $scholarship_emails, $contact);

    $user_info = array(
        'ID'            => get_current_user_id(),
        'user_login'  	=> $email,
        'user_email' 	=> $email,
        'first_name'	=> $first_name,
        'last_name'		=> $last_name,
    );

    if(!empty($password)) {
       $user_info['user_pass'] = $password;
    }

    wp_update_user($user_info);

    echo json_encode(array(
        "success" => true,
        "message" => "Profile successfully updated"
    ));

    die();
}
add_action('wp_ajax_student_profile', 'nscs_ajax_save_student_profile');



function nscs_ajax_change_contact_chapter_association() {

    check_ajax_referer('contact_chapter_association', 'nonce');

    global $CRMConnectorPlugin;
    $chapter    = $_POST["chapter"];
    update_post_meta($CRMConnectorPlugin->data['contact_id'], 'account_name', $chapter);
    $chapter_name = get_post_meta($chapter, 'account_name', true);


    $redirect_url = '/';
    $portal= get_page_by_template_filename( 'template-member-portal.php' );
    if( !empty( $portal ) ) {
        $str = sprintf('type=success&message=Chapter successfully joined. You are now inside the %s portal', $chapter_name);
        $redirect_url = get_permalink( $portal[0]->ID ) . "?$str";
    }

    echo json_encode(array(
        "success" => true,
        "message" => sprintf('Chapter successfully joined. You are now inside the %s portal', $chapter_name),
        "redirect_url" => $redirect_url
    ));

    die();
}
add_action('wp_ajax_contact_chapter_association', 'nscs_ajax_change_contact_chapter_association');