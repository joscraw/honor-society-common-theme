<?php


/**
 * Enable ACF 5 early access
 * Requires at least version ACF 4.4.12 to work
 */
define('ACF_EARLY_ACCESS', '5');



add_action('wp_enqueue_scripts', function()
{
    wp_register_script('custom.js', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), "1.0");
    wp_enqueue_script('custom.js');

    wp_register_style( 'normalize.css', 'https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.css',false,"1.0",'all');
    wp_enqueue_style('normalize.css');

    wp_register_style( 'custom.css', get_template_directory_uri() . '/assets/css/custom.css',false,"1.0",'all');
    wp_enqueue_style('custom.css');

});