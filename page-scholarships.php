<?php
/**
 * The scholarships template file
 * To use this file you just need to go into the wordpress dashboard and create
 * a page with the url /scholarships
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
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
    </div>

    <?php
    $search = new \CRMConnector\Scholarships\ScholarshipSearch();
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
    ?>




</main>

<?php get_footer(); ?>
