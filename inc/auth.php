<?php

function get_page_by_template_filename( $filename ) {
    $page_with_template = get_pages( array (
        'post_type' => 'page',
        'meta_key' => '_wp_page_template',
        'meta_value' => $filename,
        'posts_per_page' => 1
    ));

    return $page_with_template;
}

function get_permalink_by_template_filename( $filename ) {

    $page_with_template = get_page_by_template_filename( $filename );

    if( !empty( $page_with_template ) ) {
        return get_permalink( $page_with_template[0]->ID );
    }

    return null;
}

/*
 * Intercept students to the sign up page
 * @todo not working on non post pages like /events/list
*/
add_action( 'template_redirect', 'nscs_student_signup_middleware', 1 );
function nscs_student_signup_middleware(){

    global $post;
    // Force users to sign up page if page is protected
    if ( $post && get_post_meta( $post->ID, '_page-protected', true ) === "yes" && !is_user_logged_in() ) {

        $login_page = get_page_by_template_filename( 'template-student-login.php' );

        if( !empty( $login_page ) ) {
            wp_redirect( get_permalink( $login_page[0]->ID ) );
            exit;
        }
    }
}

/*
 * Intercept students on the profile page
*/
/*add_action( 'template_redirect', 'nscs_student_profile_page_middleware', 1 );*/
function nscs_student_profile_page_middleware(){

    global $post;
    if ( $post && get_post_meta( $post->ID, '_page-protected', true ) === 'no') {
        return;
    }

    $template_basename = basename( get_page_template() );
    if($template_basename !== "template-student-profile.php") {
        return;
    }

    // we already have middleware for if the user is not logged in
    if (!is_user_logged_in() ) {
    return;
    }

    $contact_search = new \CRMConnector\Database\ContactSearch();
    $user_id = get_current_user_id();
    $contacts = $contact_search->get_post_from_args([
        'key' => 'portal_user',
        'value' => $user_id,
        'compare' => '=',
    ]);

    if(!empty($contacts) && $contacts[0]->ID) {
        return;
    }

    $portal_page = get_page_by_template_filename( 'template-member-portal.php' );
    if( !empty( $portal_page ) ) {
        $str = urlencode("type=error&message=To access the student profile page you must have an associated contact record in the crm");
        wp_redirect( get_permalink( $portal_page[0]->ID ) . "?$str" );
        exit;
    }
}

add_action( 'template_redirect', 'nscs_contact_chapter_association_middleware', 2 );
function nscs_contact_chapter_association_middleware(){

    global $CRMConnectorPlugin;
    $template_basename = basename( get_page_template() );

    if(!is_user_logged_in()) {
        return;
    }

    if($template_basename === 'template-contact-chapter-association.php') {
        return;
    }

    if(is_admin()) {
        return;
    }

    // If a chapter or contact record is associated
    if (!empty($CRMConnectorPlugin->data['associated_contact']->ID) && !empty($CRMConnectorPlugin->data['associated_contact']->chapter->ID)){
        return;
    }

    // go ahead and dynamically create a contact for the administrator if no contact record exists
    if($CRMConnectorPlugin->data['is_system_administrator'] && empty($CRMConnectorPlugin->data['associated_contact']->ID)) {

        $post_id = wp_insert_post([
            "post_title"    =>  $CRMConnectorPlugin->data['current_user_first_name'] . ' ' . $CRMConnectorPlugin->data['current_user_last_name'],
            "post_type"     =>  'contacts',
            "post_status"   =>  'publish',
        ], true);

        if(update_post_meta($post_id, 'email', $CRMConnectorPlugin->data['current_user_email'])) {
            do_action('save_post', $post_id, get_post($post_id), true);
        }

        if(update_post_meta($post_id, 'first_name', $CRMConnectorPlugin->data['current_user_first_name'])) {
            do_action('save_post', $post_id, get_post($post_id), true);
        }

        if(update_post_meta($post_id, 'last_name', $CRMConnectorPlugin->data['current_user_last_name'])) {
            do_action('save_post', $post_id, get_post($post_id), true);
        }

        if(update_post_meta($post_id, 'full_name', $CRMConnectorPlugin->data['current_user_first_name'] . ' ' . $CRMConnectorPlugin->data['current_user_last_name'])) {
            do_action('save_post', $post_id, get_post($post_id), true);
        }

        if(update_post_meta($post_id, 'portal_user', $CRMConnectorPlugin->data['current_user_id'])) {
            do_action('save_post', $post_id, get_post($post_id), true);
        }
    }

    $contact_chapter_association = get_page_by_template_filename( 'template-contact-chapter-association.php' );

    if( !empty( $contact_chapter_association ) ) {
        wp_redirect( get_permalink( $contact_chapter_association[0]->ID ) );
        exit;
    }
}

/*
 * Intercept students to the registration within the member portal
*/
add_action( 'template_redirect', 'nscs_student_registration_middleware', 2 );
function nscs_student_registration_middleware(){

    $current_user = wp_get_current_user();
    $template_basename = basename( get_page_template() );

    if ( $template_basename !== "template-member-portal.php" &&
        is_user_logged_in() &&
        !current_user_can('administrator') &&
        get_user_meta($current_user->ID, 'registered', true) !== "1" ) {

        $member_portal = get_page_by_template_filename( 'template-member-portal.php' );

        if( !empty( $member_portal ) ) {
            wp_redirect( get_permalink( $member_portal[0]->ID ) );
            exit;
        }
    }
}

/*
 * Adds special body classes for specific page conditions
 */
add_filter( 'body_class', 'nscs_body_classes' );
function nscs_body_classes( $classes ) {

    $current_user = wp_get_current_user();

    $classes[] = get_user_meta( $current_user->ID, 'registered', true ) === "1" ? "nscs_user_registered" : "nscs_user_unregistered";

    return $classes;
}

/*
 * Student Sign up Form Submission
 */
function nscs_ajax_create_student(){

    check_ajax_referer( 'student_signup', 'nonce' );

    $first_name = $_POST["first_name"];
    $last_name 	= $_POST["last_name"];
    $email 		= $_POST["email"];
    $password 	= $_POST["password"];

    // Check if a user email already exists
    if ( username_exists( $email ) || get_user_by( 'email', $email ) ) {
        echo json_encode( array(
            'error' => "The email `${email}` is already in use."
        ));
    } else if ( !in_array( $email, get_meta_values('email', 'contacts' ) ) ) {
        echo json_encode( array(
            'error' => "Email `${email}` is not an authorized email within our system.  Please register for entry <a href=\"https://nscs.org/self-nomination\">here</a>"
        ));
    } else {

        $new_student_id = wp_insert_user( array(
            'user_login'  	=> $email,
            'user_email' 	=> $email,
            'user_pass'   	=> $password,
            'first_name'	=> $first_name,
            'last_name'		=> $last_name,
            'role'			=> 'student'
        ));

        if ( !is_wp_error( $new_student_id ) ) {

            // Set the user to contact
            $contact = get_posts( array(
                'post_type' => 'contacts',
                'meta_key'  => 'email',
                'meta_value' => $email

            ));

            if( ! empty( $contact ) ) {
                update_field('portal_user', $new_student_id, $contact[0]->ID);
            }


            wp_signon( array(
                'user_login' => $email,
                'user_password' => $password,
                'remember' => false
            ), false );

            echo json_encode( array(
                'error' => false
            ));
        } else {
            echo json_encode( array(
                'error' => $new_student_id->get_error_message()
            ));
        }
    }
    die();
}
add_action('wp_ajax_student_signup', 'nscs_ajax_create_student');
add_action('wp_ajax_nopriv_student_signup', 'nscs_ajax_create_student');

/*
 * Student Login Submission
 */
function nscs_ajax_login() {

    check_ajax_referer( 'student_login', 'nonce' );

    $info = array();
    $info['user_login'] = $_POST['email'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );

    if ( is_wp_error( $user_signon ) ) {
        die( json_encode( array(
            'error' => $user_signon->get_error_message()
        )));
    }

    die('{}');
}
add_action('wp_ajax_student_login', 'nscs_ajax_login');
add_action('wp_ajax_nopriv_student_login', 'nscs_ajax_login');
