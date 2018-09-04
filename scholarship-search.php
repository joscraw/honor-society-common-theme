<main class="main-content">

    <div class="breadcrumb">
        <div class="breadcrumb-icon">
            <img src="<?php echo get_template_directory_uri() . '/assets/images/hat_icon.png'; ?>">
        </div>

        <div class="breadcrumb-title">
            <h1>Scholarships</h1>
        </div>

        <div class="search-form">
            <?php get_search_form(); ?>
        </div>
    </div>

    <?php

    global $wp_query;
    $total_results = $wp_query->found_posts;

    while(have_posts()):
        the_post();
        ?>
        <div class="scholarships-container">
            <div class="scholarships-container-header">
                <div>
                    <h2><?php echo the_title(); ?></h2>
                </div>
                <a href="<?php the_field('apply_url'); ?>" class="button">APPLY</a>
            </div>
            <div class="scholarships-container-body">
                <?php the_field('scholarships_description'); ?>
            </div>
            <div class="scholarships-container-footer">
                Last Date: <?php the_field('last_date'); ?>
            </div>
        </div>

        <?php
    endwhile;
    wp_reset_query();
    ?>
</main>