<?php
/**
 * Template Name: Chapter Network
 */

get_header(); ?>

<main class="main-content">

    <div class="breadcrumb clearfix">
        <div class="breadcrumb-icon">
            <img src="<?php echo get_template_directory_uri() . '/assets/images/chapter_people.png'; ?>">
        </div>

        <div class="breadcrumb-title">
            <h1>Chapter Network</h1>
        </div>

        <div class="search-form search-form--contacts">
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

    <br>
    <br>
    <h2>Members</h2>
    <div class="contacts-container">
        <?php
        global $CRMConnectorPlugin;
        $search = new \CRMConnector\Database\ContactSearch();
        $query = $search->wp_query_get_all_from_chapter($CRMConnectorPlugin->data['chapter_id']);
        while($query->have_posts()):
            $query->the_post();
            ?>
            

            <div class="contact-container">
                <div class="contact-container-header"></div>
                <div class="contact-container-body">
                    <?php $profile_picture = get_field('profile_picture', get_the_ID()); ?>
                    <?php if(!empty($profile_picture)): ?>
                        <img style="border-radius: 50%" src="<?php echo $profile_picture['sizes']['thumbnail']; ?>">
                    <?php else: ?>
                        <img style="border-radius: 50%" width="150" height="131" src="<?php echo get_template_directory_uri() . '/assets/images/default-avatar.jpg'; ?>">
                    <?php endif; ?>
                    <div class="student_name">
                        <?php echo get_field('full_name', get_the_ID()); ?>
                    </div>
                    <?php /*the_field('scholarships_description'); */?>
                </div>
                <div class="contact-container-footer">
                    <!--Last Date: --><?php /*the_field('last_date'); */?>
                </div>
            </div>

            <?php
        endwhile;
        ?>
    </div>
    <br>
    <br>

    <?php
    if (function_exists("pagination")) {
        pagination($query->max_num_pages);
    }
    wp_reset_query();
    ?>

</main>

<?php get_footer(); ?>
