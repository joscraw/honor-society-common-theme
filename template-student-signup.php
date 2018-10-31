<?php
/**
 * Template Name: Student Sign up
 **/

get_header(); ?>

    <div class="nscs-auth nscs-auth-container">

        <div class="nscs-auth__bg"></div>

        <div class="nscs-auth__content">

            <?php include('inc/auth-header.php') ?>

            <form id="nscs-auth__sign-up-form">

                <div class="nscs-auth__message"></div>

                <div class="input-group">
                    <label for="first_name">Enter your first name</label>
                    <input type="text" name="first_name" id="first_name" placeholder="For e.g. “Mark”" required>
                </div>

                <div class="input-group">
                    <label for="last_name">Enter your last name</label>
                    <input type="text" name="last_name" id="last_name" placeholder="For e.g. “Smith”" required>
                </div>

                <div class="input-group">
                    <label for="email">Enter email address</label>
                    <input type="text" name="email" id="email" placeholder="For e.g. “you@yourdomain.com”" required
                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                        title="A valid email is required.">
                </div>

                <div class="input-group">
                    <label for="last_name">Enter password</label>
                    <input type="password" name="password" id="password" placeholder="********" required
                        pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                        title="Password must be at least 8 characters and contain an uppercase, lowercase, number, and special character.">
                </div>

                <div class="input-group">
                    <input type="submit" value="Sign up">
                </div>

                <input type="hidden" name="action" value="student_signup" />
                <?php wp_nonce_field( 'student_signup', 'nonce' ); ?>

            </form>

            <script type="text/javascript">

                var nscsSignUpFormSubmitting = false;

                jQuery(document).ready(function($) {

                    $( "#nscs-auth__sign-up-form" ).submit(function( e ) {

                        e.preventDefault();

                        if ( !nscsSignUpFormSubmitting ) {

                            nscsSignUpFormSubmitting = true;
                            $('#nscs-auth__sign-up-form input[type=submit]').addClass('loading');

                            var SignUpForm = jQuery(this).serialize();
                            jQuery.ajax({
                                type   : "POST",
                                url    : "<?php echo admin_url( 'admin-ajax.php' ) ?>",
                                data   : SignUpForm,
                                error: function() {
                                    $('.nscs-auth__message').html('There was an issue processing the form, please refresh the page and try again.')
                                },
                                success: function(data) {

                                    data = JSON.parse(data);

                                    if( !!data.error ) {
                                        $('.nscs-auth__message').html(data.error);
                                    } else {
                                        window.location.href = "<?php echo get_permalink_by_template_filename( 'template-member-portal.php' ) ?>";
                                    }
                                },
                                complete: function() {
                                    nscsSignUpFormSubmitting = false;
                                    $('#nscs-auth__sign-up-form input[type=submit]').removeClass('loading');
                                }
                            });

                        }

                        return false;
                    });
                });
            </script>

        </div>

    </div>

<?php
get_footer();
?>
