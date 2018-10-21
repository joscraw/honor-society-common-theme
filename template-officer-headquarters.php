<?php
/**
 * Template Name: Officer Headquarters
 */

get_header(); ?>
    <main class="nscs-hq__container">
            <div class="tab">
                <a href="<?php echo admin_url('post-new.php?post_type=chapter_update'); ?>">Send Chapter Update Email</a>
            </div>
            <div class="tab">
                <a href="<?php echo admin_url('post-new.php?post_type=chapter_act_repo'); ?>">Send Chapter Activity Report</a>
            </div>
            <div class="tab">
                <a href="<?php echo admin_url('post-new.php?post_type=officer_materials'); ?>">Officer Materials</a>
            </div>
    </main>
<?php get_footer(); ?>

