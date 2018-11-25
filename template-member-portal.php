<?php
/**
 * Template Name: Member Portal
 **/


    // update_user_meta( $current_user->ID, 'registered', 0 );

    if( !is_user_logged_in() ) {
        nscs_student_signup_middleware();
        die("Oops, something went wrong. Please contact support.");
    }

    get_header();

    $current_user = wp_get_current_user();

    if( get_user_meta( $current_user->ID, 'registered', true ) !== "1" ) {
        include('inc/registration.php');
    } else {
        include('inc/home.php');
    }

    get_footer();
