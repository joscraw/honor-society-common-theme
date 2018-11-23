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
                <?php
                $portal_page = get_page_by_template_filename( 'template-officer-materials.php' );
                if( !empty( $portal_page ) ) : ?>
                    <a href="<?php echo  get_permalink( $portal_page[0]->ID ); ?>">Officer Materials</a>
                <?php endif; ?>
            </div>
            <div class="tab">
                <?php
                $user = wp_get_current_user();
                $current_user_roles = ['chapter_officer', 'chapter_president', 'chapter_advisor', 'administrator'];
                $accessible_roles = (array) $user->roles;
                if($current_user_roles !== array_diff($current_user_roles, $accessible_roles)) : ?>
                    <a href="<?php echo admin_url('post-new.php?post_type=officer_material'); ?>">Create Officer Material</a>
                <?php endif; ?>
            </div>
    </main>
<?php get_footer(); ?>

