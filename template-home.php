<?php
/**
 * Template Name: Homepage
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
            <a href="#"><span>CHAPTER NETWORK</span></a>
        </div>
        <div class="tab">
            <div class="tab-icon">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/tab-calendar.png'; ?>">
            </div>
            <a href="/events/list"><span>CHAPTER EVENTS</span></a>
        </div>
        <div class="tab">
            <div class="tab-icon">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/tab-cart.png'; ?>">
            </div>
            <a href="#"><span>MEMBER STORE</span></a>
        </div>
        <div class="tab">
            <div class="tab-icon">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/tab-grad-hat.png'; ?>">
            </div>
            <a href="/scholarships"><span>SCHOLARSHIPS</span></a>
        </div>
        <div class="tab">
            <div class="tab-icon">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/tab-career.png'; ?>">
            </div>
            <a href="#"><span>CHAPTER</span></a>
        </div>
        <div class="tab">
            <div class="tab-icon">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/tab-person.png'; ?>">
            </div>
            <a href="#"><span>OFFICER HQ</span></a>
        </div>
    </div>
</div>


<?php get_footer(); ?>
