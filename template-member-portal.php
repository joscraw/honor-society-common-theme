<?php
/**
 * Template Name: Member Portal
 **/

    if( !is_user_logged_in() ) {
        die();
    }

    get_header();

    $current_user = wp_get_current_user();

    if( get_user_meta( $current_user->ID, 'registered', true ) !== "1" ) {
        include('inc/registration.php');
    } else {
        include('inc/home.php');
    }

    get_footer();

?>