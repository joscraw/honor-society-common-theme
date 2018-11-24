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
            <h1>Woah, hold on!</h1>
            <p>To use the portal you must belong to a chapter!</p>
        </div>
    </div>

    <br>
    <br>

    <?php if($CRMConnectorPlugin->data['is_system_administrator']) : ?>
        <?php
        $chapter_search = new \CRMConnector\Database\ChapterSearch();
        $chapters = $chapter_search->get_all();
        if(count($chapters) === 0) : ?>
            <p>A chapter must be created on the backend before you can be assigned to one</p>
        <?php else: ?>
            <p>Select a chapter to join and explore as!</p>
            <form id="nscs-contact-chapter-association-form">
                <div class="nscs-auth__message"></div>
                <div class="input-group">
                    <label for="chapter">Select Chapter To Join</label>
                    <select name="chapter" required>
                        <option value="" selected="selected" data-i="0">- Select -</option>
                        <?php
                        foreach($chapters as $chapter) : ?>
                            <option value="<?php echo $chapter->ID; ?>"><?php echo get_post_meta($chapter->ID, 'account_name', true); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <input type="hidden" name="action" value="contact_chapter_association" />
                <?php wp_nonce_field( 'contact_chapter_association', 'nonce' ); ?>

                <div class="input-group">
                    <input type="submit" value="Join Chapter">
                </div>

            </form>
        <?php endif; ?>
    <?php else: ?>
        <p>You have not been assigned to a Contact/Chapter. Please contact customer support.</p>
    <?php endif; ?>


</main>

<?php get_footer(); ?>

<script type="text/javascript">

    var nscsContactChapterAssociationFormSubmitting = false;

    jQuery(document).ready(function($) {

        $( "#nscs-contact-chapter-association-form" ).submit(function( e ) {

            debugger;
            e.preventDefault();

            if ( !nscsContactChapterAssociationFormSubmitting ) {

                nscsContactChapterAssociationFormSubmitting = true;
                $('#nscs-contact-chapter-association-form input[type=submit]').addClass('loading');

                var ContactChapterAssociationForm = new FormData(this);

                $.ajax({
                    type   : "POST",
                    url    : "<?php echo admin_url( 'admin-ajax.php' ) ?>",
                    data   : ContactChapterAssociationForm,
                    cache:false,
                    contentType: false,
                    processData: false,
                    error: function() {
                        $('.nscs-auth__message').html('There was an issue processing the form, please refresh the page and try again.')
                    },
                    success: function(data) {

                        debugger;
                        data = JSON.parse(data);

                        if( !!data.success ) {
                            window.location = data.redirect_url;
                        } else {
                            $('.nscs-auth__message').html(data.message);
                        }
                    },
                    complete: function() {
                        debugger;
                        nscsContactChapterAssociationFormSubmitting = false;
                        $('#nscs-auth__registration-form input[type=submit]').removeClass('loading');
                    }
                });
            }
            return false;
        });
    });
</script>
