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
*/
add_action( 'template_redirect', 'nscs_student_signup_middleware', 1 );
function nscs_student_signup_middleware(){

    global $post;

    // Force users to sign up page if page is protected
    if ( get_post_meta( $post->ID, '_page-protected', true ) === "yes" && !is_user_logged_in() ) {

        $login_page = get_page_by_template_filename( 'template-student-login.php' );

        if( !empty( $login_page ) ) {
            wp_redirect( get_permalink( $login_page[0]->ID ) );
            exit;
        }
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