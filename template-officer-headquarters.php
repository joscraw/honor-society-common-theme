<?php
/**
 * Template Name: Officer Headquarters
 */

get_header(); ?>

<?php
global $CRMConnectorPlugin;
?>
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
                <?php if($CRMConnectorPlugin->data['is_chapter_leader'] || $CRMConnectorPlugin->data['is_system_administrator']) : ?>
                    <a href="<?php echo admin_url('post-new.php?post_type=officer_material'); ?>">Create Officer Material</a>
                <?php endif; ?>
            </div>
    </main>
<?php get_footer(); ?>

