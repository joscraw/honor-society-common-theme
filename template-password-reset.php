<?php
/**
 * Template Name: Password Reset
 **/

get_header(); ?>

    <div class="nscs-auth nscs-auth-container">

        <div class="nscs-auth__bg"></div>

        <div class="nscs-auth__content">
            
            <?php include('inc/auth-header.php') ?>
<!--
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
                    <input type="password" name="password" id="password" placeholder="********" required
                        pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" 
                        title="Password must be at least 8 characters and contain an uppercase, lowercase, number, and special character.">
                </div>

                <div class="input-group">
                    <p>Not Registered? <a href="/sign-up">Sign Up Here.</a></p>
                </div>

                <div class="input-group">
                    <input type="submit" value="Login">
                </div>

                <input type="hidden" name="action" value="student_login" />
                <?php /*wp_nonce_field( 'student_login', 'nonce' ); */?>

            </form>-->
        </div>

    </div>

<?php
get_footer();
?>