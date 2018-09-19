<?php
/**
 * Template Name: Careers
 */



if(is_user_logged_in())
{
    $user = wp_get_current_user();
    $access_token = get_user_meta($user->data->ID, 'access_token', true);


    wp_redirect('https://www.giftedhire.com/home?access_token=' . $access_token);
}

