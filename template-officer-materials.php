<?php
/**
 * Template Name: Officer Materials
 */

get_header(); ?>

<main class="main-content">

    <div class="breadcrumb">

        <div class="breadcrumb-icon">
            <img src="<?php echo get_template_directory_uri() . '/assets/images/officer-hq.png'; ?>">
        </div>

        <div class="breadcrumb-title">
            <h1><?php echo the_title(); ?></h1>
        </div>

        <div class="search-form search-form--officer-materials">
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
    $contact_search = new \CRMConnector\Database\ContactSearch();
    $contact = $contact_search->get_from_portal_user_id(get_current_user_id());
    $chapter = get_post_meta($contact[0]->ID, 'account_name', true);
    $search = new \CRMConnector\Database\OfficerMaterialSearch();
    $query = $search->getAllByChapter($chapter);
    while($query->have_posts()):
        $query->the_post();
        $material_type = get_field('material_type');
        ?>
        <div class="officer-materials-container">
            <div class="officer-materials-container-header">
                <div>
                    <h2><?php echo the_title(); ?></h2>
                </div>
                <!--<a href="<?php /*the_field('apply_url'); */?>" class="button">APPLY</a>-->
            </div>
            <div class="officer-materials-container-body">
                <?php if ($material_type === 'URL'): ?>
                    <h4><?php the_field('url_name'); ?> </h4>
                    <p><?php the_field('url_description'); ?> </p>
                    <a href="<?php the_field('url'); ?>" target="_blank">Click/Tap to Visit URL</a>
                <?php endif; ?>
                <?php if ($material_type === 'File'): ?>
                    <h4><?php the_field('file_name'); ?> </h4>
                    <p><?php the_field('file_description'); ?> </p>
                    <a href="<?php the_field('file'); ?>" download>Click/Tap to Download File</a>
                <?php endif; ?>
                <?php if ($material_type === 'Image'): ?>
                    <h4><?php the_field('image_name'); ?> </h4>
                    <p><?php the_field('image_description'); ?> </p>
                    <img src="<?php echo !empty(get_field('image')['sizes']['thumbnail']) ? get_field('image')['sizes']['thumbnail'] : ''; ?>" alt="<?php the_field('image_description'); ?>">
                <?php endif; ?>
            </div>
            <div class="officer-materials-container-footer">
                <!--Last Date: --><?php /*the_field('last_date'); */?>
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
