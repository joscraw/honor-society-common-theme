<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage CRM Parent Theme
 * @since CRM Parent Theme 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <link href="https://fonts.googleapis.com/css?family=EB+Garamond" rel="stylesheet">

    <title><?php wp_title() ?></title>

    <!--[if lt IE 9]>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
    <![endif]-->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <header class="main-header">
        <div class="main-logo"><a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri() . '/assets/images/main_logo.png'; ?>"></a></div>
        <?php get_template_part( 'inc/main', 'nav' ); ?>
    </header>
