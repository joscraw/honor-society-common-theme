<?php
/**
 * Template Name: Student Login
 **/

get_header(); ?>

    <div class="nscs-auth nscs-auth-container">

        <div class="nscs-auth__bg"></div>

        <div class="nscs-auth__content">
            
            <?php include('inc/auth-header.php') ?>

            <form id="nscs-auth__login-form">

                <div class="nscs-auth__message"></div>

                <div class="input-group">
                    <label for="email">Enter email address</label>
                    <input type="text" name="email" id="email" placeholder="For e.g. “you@yourdomain.com”" required
                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                        title="A valid email is required.">
                </div>

                <div class="input-group">
                    <label for="last_name">Enter password</label>
                    <input type="password" name="password" id="password" placeholder="********" required>
                </div>

                <div class="input-group">
                    <input type="submit" value="Login">
                </div>

                <input type="hidden" name="action" value="student_login" />
                <?php wp_nonce_field( 'student_login', 'nonce' ); ?>

            </form>

            <script type="text/javascript">

                var nscsLoginFormSubmitting = false;

                jQuery(document).ready(function($) {

                    $( "#nscs-auth__login-form" ).submit(function( e ) {

                        e.preventDefault();

                        if ( !nscsLoginFormSubmitting ) {

                            nscsLoginFormSubmitting = true;

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
                                    nscsLoginFormSubmitting = false;
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