<?php
/**
 * Template Name: Contact Chapter Association
 */

get_header(); ?>

<?php
global $CRMConnectorPlugin;
?>

<main class="main-content">

    <div class="breadcrumb clearfix">
        <div class="breadcrumb-icon">
            <img src="<?php echo get_template_directory_uri() . '/assets/images/hat_icon.png'; ?>">
        </div>

        <div class="breadcrumb-title">
            <h1>Contact/Chapter Association</h1>
        </div>
    </div>

    <br>
    <br>

    <?php if($CRMConnectorPlugin->data['is_system_administrator']) : ?>
        <form>
            <div class="input-group" id="chapter_assignment">
                <label for="chapter_assignment">Go ahead and select a chapter to explore!</label>
                <select name="chapter_assignment">
                    <option value="" selected="selected" data-i="0">- Select -</option>
                    <?php
                    $chapter_search = new \CRMConnector\Database\ChapterSearch();
                    $chapters = $chapter_search->get_all();
                    foreach($chapters as $chapter) : ?>
                        <option><?php echo get_post_meta($chapter->ID, 'account_name', true); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
        <?php else: ?>
        <p>An associated Contact/Chapter record has not been found for this user account. Please contact customer support.</p>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
