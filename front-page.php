<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

<div class="main-content">

    <div class="top-content">
        <div class="homepage-moot-container">
            <a class="muut" href="https://muut.com/i/testcommunity44">testcommunity44</a> <script src="//cdn.muut.com/1/moot.min.js"></script>
            <!--<a class="muut" href="https://muut.com/i/testcommunity44/comments" type="dynamic">testcommunity44</a> <script src="//cdn.muut.com/1/moot.min.js"></script>-->
            <!--<span class="muut-messaging" data-forumname="testcommunity44">Messages</span> <script src="//cdn.muut.com/1/moot.min.js"></script>-->
        </div>
        <div class="homepage-calendar">
            <div class="single-event-calendar"><?php echo do_shortcode('[tribe_mini_calendar]'); ?></div>
        </div>
    </div>

</div>

<div class="bottom-content">
    <div class="main-content">
        <div class="tab">
            <div class="tab-icon">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/tab-people.png'; ?>">
            </div>
            <div class="tab-text">
                CHAPTER NETWORK
            </div>
        </div>
        <div class="tab">
            <div class="tab-icon">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/tab-calendar.png'; ?>">
            </div>
            <div class="tab-text">
                CHAPTER EVENTS
            </div>
        </div>
        <div class="tab">
            <div class="tab-icon">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/tab-cart.png'; ?>">
            </div>
            <div class="tab-text">
                MEMBER STORE
            </div>
        </div>
        <div class="tab">
            <div class="tab-icon">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/tab-grad-hat.png'; ?>">
            </div>
            <div class="tab-text">
                SCHOLARSHIPS
            </div>
        </div>
        <div class="tab">
            <div class="tab-icon">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/tab-career.png'; ?>">
            </div>
            <div class="tab-text">
                CHAPTER
            </div>
        </div>
        <div class="tab">
            <div class="tab-icon">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/tab-person.png'; ?>">
            </div>
            <div class="tab-text">
                OFFICER HQ
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
