<?php
/**
 * Template Name: Scholarships
 */

get_header(); ?>

<main class="main-content">

    <div class="breadcrumb">
        <div class="breadcrumb-icon">
            <img src="<?php echo get_template_directory_uri() . '/assets/images/hat_icon.png'; ?>">
        </div>

        <div class="breadcrumb-title">
            <h1>Scholarships</h1>
        </div>

        <div class="search-form search-form--scholarships">
            <?php // get_search_form(); ?>
            <form role="search" method="get" id="" action="">
                <div class="search-wrap">
                    <label class="screen-reader-text" for="search">Search for:</label>
                    <input type="search" placeholder="Search…" name="search" id="search-input" value="">
                    <input class="screen-reader-text" type="submit" id="search-submit" value="Search">
                </div>
            </form>
        </div>
    </div>

    <?php
    $search = new \CRMConnector\Database\ScholarshipSearch();
    $query = $search->getAllScholarships();
    while($query->have_posts()):
    $query->the_post();
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
    if (function_exists("pagination")) {
        pagination($query->max_num_pages);
    }
    wp_reset_query();
    ?>




</main>

<?php get_footer(); ?>
