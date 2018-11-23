<?php
/**
 * Template Name: Student Profile
 */

get_header(); ?>

<?php
$contact_search = new \CRMConnector\Database\ContactSearch();
$user_id = get_current_user_id();
$contact = $contact_search->get_post_from_args([
    'key' => 'portal_user',
    'value' => $user_id,
    'compare' => '=',
]);
?>

<main class="main-content">

    <div class="breadcrumb clearfix">
        <div class="breadcrumb-icon">
            <img src="<?php echo get_template_directory_uri() . '/assets/images/hat_icon.png'; ?>">
        </div>

        <div class="breadcrumb-title">
            <h1>Student Profile</h1>
        </div>
    </div>

    <br>
    <br>

    <form id="nscs-student-profile-form">

        <input type="hidden" name="contact" value="<?php echo $contact[0]->ID;?>">

        <div class="nscs-auth__message"></div>


        <div class="personal-information">
            <div class="profile-sub-title">
                <h2>Student Information</h2>
            </div>

            <div class="input-group">
                <label for="first_name">Enter your first name</label>
                <input type="text" name="first_name" id="first_name" placeholder="For e.g. “Mark”" required value="<?php echo get_post_meta($contact[0]->ID, 'first_name', true); ?>">
            </div>

            <div class="input-group">
                <label for="last_name">Enter your last name</label>
                <input type="text" name="last_name" id="last_name" placeholder="For e.g. “Smith”" required value="<?php echo get_post_meta($contact[0]->ID, 'last_name', true); ?>">
            </div>

            <div class="input-group">
                <label for="email">Enter email address</label>
                <input type="text" name="email" id="email" placeholder="For e.g. “you@yourdomain.com”" required
                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                       title="A valid email is required." value="<?php echo get_post_meta($contact[0]->ID, 'email', true); ?>">
            </div>

            <div class="input-group">
                <label for="last_name">Enter password</label>
                <input type="password" name="password" id="password" placeholder="********"
                       pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                       title="Password must be at least 8 characters and contain an uppercase, lowercase, number, and special character." value="">
            </div>

            <?php $gender = get_post_meta($contact[0]->ID, 'gender', true); ?>
            <?php $ethnicity = get_post_meta($contact[0]->ID, 'ethnicity', true); ?>
            <div class="input-group">
                <label for="gender">Gender</label>
                <select name="gender">
                    <option value="" selected="selected" data-i="0">- Select -</option>
                    <option value="Female" <?php echo get_post_meta($contact[0]->ID, 'gender', true) == 'Female' ? 'selected' : ''; ?>>Female</option>
                    <option value="Male" <?php echo get_post_meta($contact[0]->ID, 'gender', true) == 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Non-Binary/Third Gender" <?php echo get_post_meta($contact[0]->ID, 'gender', true) == 'Non-Binary/Third Gender' ? 'selected' : ''; ?>>Non-Binary/Third Gender</option>
                    <option value="Prefer not to say" <?php echo get_post_meta($contact[0]->ID, 'gender', true) == 'Prefer not to say' ? 'selected' : ''; ?>>Prefer not to say</option>
                </select>
            </div>

            <div class="input-group">
                <label for="ethnicity">Ethnicity</label>
                <select name="ethnicity">
                    <option value="" selected="selected" data-i="0">- Select -</option>
                    <option value="African American/Black" <?php echo get_post_meta($contact[0]->ID, 'ethnicity', true) == 'African American/Black' ? 'selected' : ''; ?>>African American/Black</option>
                    <option value="American Indian/Alaska Native" <?php echo get_post_meta($contact[0]->ID, 'ethnicity', true) == 'American Indian/Alaska Native' ? 'selected' : ''; ?>>American Indian/Alaska Native</option>
                    <option value="Asian/Pacific Islander" <?php echo get_post_meta($contact[0]->ID, 'ethnicity', true) == 'Asian/Pacific Islander' ? 'selected' : ''; ?>>Asian/Pacific Islander</option>
                    <option value="Caucasian/White" <?php echo get_post_meta($contact[0]->ID, 'ethnicity', true) == 'Caucasian/White' ? 'selected' : ''; ?>>Caucasian/White</option>
                    <option value="Hispanic/Latino" <?php echo get_post_meta($contact[0]->ID, 'ethnicity', true) == 'Hispanic/Latino' ? 'selected' : ''; ?>>Hispanic/Latino</option></select>
            </div>

            <div class="input-group">
                <label for="age">Age</label>
                <input type="number" name="age" value="<?php echo get_post_meta($contact[0]->ID, 'age', true); ?>">
            </div>

            <div class="input-group">
                <label for="date_of_birth">Date Of Birth</label>
                <input type="date" name="date_of_birth" value="<?php echo get_field('birthdate', $contact[0]->ID); ?>">
            </div>

            <div class="input-group">
                <label for="profile_picture">Profile Picture</label>
                <input type="file" name="profile_picture">
                <h4>Current Profile Picture</h4>
                <?php $profile_picture = get_field('profile_picture', $contact[0]->ID); ?>
                <img src="<?php echo $profile_picture['sizes']['thumbnail']; ?>">
            </div>
        </div>

        <div class="survey">
            <div class="profile-sub-title">
                <h2>Survey</h2>
            </div>

            <div class="input-group">
                <label for="non_traditional_student">Do you consider yourself to be a non-traditional student?</label>
                <input type="radio" name="non_traditional_student" value="yes" <?php echo get_post_meta($contact[0]->ID, 'non-traditional_student', true) == 'yes' ? 'checked' : ''; ?>> Yes
                <input type="radio" name="non_traditional_student" value="no" <?php echo get_post_meta($contact[0]->ID, 'non-traditional_student', true) == 'no' ? 'checked' : ''; ?>> No
            </div>

            <div class="input-group" id="non_traditional_student_reason">
                <label for="non_traditional_student_reason">Non-Traditional Student Reason</label>
                <select name="non_traditional_student_reason">
                    <option value="" selected="selected" data-i="0">- Select -</option>
                    <option value="Attend Part-Time" <?php echo get_post_meta($contact[0]->ID, 'non-traditional_student_reason', true) == 'Attend Part-Time' ? 'selected' : ''; ?>>Attend Part-Time</option>
                    <option value="Financially Independent" <?php echo get_post_meta($contact[0]->ID, 'non-traditional_student_reason', true) == 'Financially Independent' ? 'selected' : ''; ?>>Financially Independent</option>
                    <option value="Work Full Time" <?php echo get_post_meta($contact[0]->ID, 'non-traditional_student_reason', true) == 'Work Full Time' ? 'selected' : ''; ?>>Work Full Time</option>
                </select>
            </div>

            <div class="input-group">
                <label for="first_to_go_to_college">Are you the first student in your family to go to college?</label>
                <input type="radio" name="first_to_go_to_college" value="yes" <?php echo get_post_meta($contact[0]->ID, 'first_generation_student', true) == 'yes' ? 'checked' : ''; ?>> Yes
                <input type="radio" name="first_to_go_to_college" value="no" <?php echo get_post_meta($contact[0]->ID, 'first_generation_student', true) == 'no' ? 'checked' : ''; ?>> No
            </div>

            <div class="input-group">
                <label for="veteran">Veteran?</label>
                <input type="radio" name="veteran" value="yes" <?php echo get_post_meta($contact[0]->ID, 'veteran', true) == 'yes' ? 'checked' : ''; ?>> Yes
                <input type="radio" name="veteran" value="no" <?php echo get_post_meta($contact[0]->ID, 'veteran', true) == 'no' ? 'checked' : ''; ?>> No
            </div>

            <div class="input-group">
                <label for="previous_school">Previous School</label>
                <input type="text" name="previous_school" value="<?php echo get_field('previous_school', $contact[0]->ID); ?>">
            </div>

            <div class="input-group">
                <label for="other_honor_societies">Are you a member of any other honor societies? (Select more than one, hold the Ctrl key.)</label>
                <select name="other_honor_societies[]" multiple>
                    <option value="Alpha Lambda Delta" <?php echo is_array(get_field('other_honor_societies', $contact[0]->ID)) && in_array('Alpha Lambda Delta', get_field('other_honor_societies', $contact[0]->ID)) ? 'selected' : ''; ?>>Alpha Lambda Delta</option>
                    <option value="Golden Key International Honor Society" <?php echo is_array(get_field('other_honor_societies', $contact[0]->ID)) && in_array('Golden Key International Honor Society', get_field('other_honor_societies', $contact[0]->ID)) ? 'selected' : ''; ?>>Golden Key International Honor Society</option>
                    <option value="National Society of Leadership and Success" <?php echo is_array(get_field('other_honor_societies', $contact[0]->ID)) && in_array('National Society of Leadership and Success', get_field('other_honor_societies', $contact[0]->ID)) ? 'selected' : ''; ?>>National Society of Leadership and Success</option>
                    <option value="Phi Theta Kappa" <?php echo is_array(get_field('other_honor_societies', $contact[0]->ID)) && in_array('Phi Theta Kappa', get_field('other_honor_societies', $contact[0]->ID)) ? 'selected' : ''; ?>>Phi Theta Kappa</option>
                    <option value="Society for College Leadership and Achievement" <?php echo is_array(get_field('other_honor_societies', $contact[0]->ID)) && in_array('Society for College Leadership and Achievement', get_field('other_honor_societies', $contact[0]->ID)) ? 'selected' : ''; ?>>Society for College Leadership and Achievement</option>
                </select>
            </div>
        </div>

        <div class="email-subscriptions">
            <div class="profile-sub-title">
                <h2>NSCS Subscription Preferences</h2>
                <p>You can receive emails on many different topics from the NSCS national office and you chapter officers. Please choose which types of emails your're interested in receiving from NSCS.</p>
            </div>

            <div class="input-group">
                <label for="do_not_mail">Opt out</label>
                <input type="radio" name="opt_out" value="yes" <?php echo get_post_meta($contact[0]->ID, 'opt_out', true) == 'yes' ? 'checked' : ''; ?>> Yes
                <input type="radio" name="opt_out" value="no" <?php echo get_post_meta($contact[0]->ID, 'opt_out', true) == 'no' ? 'checked' : ''; ?>> No
            </div>

            <div class="input-group">
                <label for="do_not_mail">Do not mail</label>
                <input type="radio" name="do_not_mail" value="yes" <?php echo get_post_meta($contact[0]->ID, 'do_not_mail', true) == 'yes' ? 'checked' : ''; ?>> Yes
                <input type="radio" name="do_not_mail" value="no" <?php echo get_post_meta($contact[0]->ID, 'do_not_mail', true) == 'no' ? 'checked' : ''; ?>> No
            </div>

            <div class="input-group">
                <label for="do_not_call">Do not call</label>
                <input type="radio" name="do_not_call" value="yes" <?php echo get_post_meta($contact[0]->ID, 'do_not_call', true) == 'yes' ? 'checked' : ''; ?>> Yes
                <input type="radio" name="do_not_call" value="no" <?php echo get_post_meta($contact[0]->ID, 'do_not_call', true) == 'no' ? 'checked' : ''; ?>> No
            </div>

            <div class="input-group">
                <label for="do_not_mail">Email opt out</label>
                <input type="radio" name="email_opt_out" value="yes" <?php echo get_post_meta($contact[0]->ID, 'email_opt_out', true) == 'yes' ? 'checked' : ''; ?>> Yes
                <input type="radio" name="email_opt_out" value="no" <?php echo get_post_meta($contact[0]->ID, 'email_opt_out', true) == 'no' ? 'checked' : ''; ?>> No
            </div>

            <div class="input-group">
                <label for="scholar_connection_newsletter_emails">Email - Scholar Connection E-Newsletter</label>
                <input type="radio" name="scholar_connection_newsletter_emails" value="yes" <?php echo get_post_meta($contact[0]->ID, 'email_scholar_connection_enewsletter', true) == 'yes' ? 'checked' : ''; ?>> Yes
                <input type="radio" name="scholar_connection_newsletter_emails" value="no" <?php echo get_post_meta($contact[0]->ID, 'email_scholar_connection_enewsletter', true) == 'no' ? 'checked' : ''; ?>> No
            </div>

            <div class="input-group">
                <label for="chapter_emails">Email - Chapter Emails</label>
                <input type="radio" name="chapter_emails" value="yes" <?php echo get_post_meta($contact[0]->ID, 'email_chapter_emails', true) == 'yes' ? 'checked' : ''; ?>> Yes
                <input type="radio" name="chapter_emails" value="no" <?php echo get_post_meta($contact[0]->ID, 'email_chapter_emails', true) == 'no' ? 'checked' : ''; ?>> No
            </div>

            <div class="input-group">
                <label for="scholarship_emails">Email - Scholarships</label>
                <input type="radio" name="scholarship_emails" value="yes" <?php echo get_post_meta($contact[0]->ID, 'email_scholarships', true) == 'yes' ? 'checked' : ''; ?>> Yes
                <input type="radio" name="scholarship_emails" value="no" <?php echo get_post_meta($contact[0]->ID, 'email_scholarships', true) == 'no' ? 'checked' : ''; ?>> No
            </div>
        </div>

        <div class="parent-guardian-information">
            <div class="profile-sub-title">
                <h2>Parent Guardian Information</h2>
            </div>

            <div class="input-group">
                <label for="previous_school">Parent First Name</label>
                <input type="text" name="parent_first_name" value="<?php echo get_field('parent_first_name', $contact[0]->ID); ?>">
            </div>

            <div class="input-group">
                <label for="previous_school">Parent Last Name</label>
                <input type="text" name="parent_last_name" value="<?php echo get_field('parent_last_name', $contact[0]->ID); ?>">
            </div>

            <div class="input-group">
                <label for="parent_email">Parent Email</label>
                <input id="parent_email" type="text" placeholder="For e.g. “you@yourdomain.com”"
                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                       title="A valid email is required." name="parent_email" value="<?php echo get_field('parent_email', $contact[0]->ID); ?>">
            </div>

            <div class="input-group">
                <label for="parent_2_first_name">Parent 2 First Name</label>
                <input type="text" name="parent_2_first_name" value="<?php echo get_field('parent_2_first_name', $contact[0]->ID); ?>">
            </div>

            <div class="input-group">
                <label for="parent_2_last_name">Parent 2 Last Name</label>
                <input type="text" name="parent_2_last_name" value="<?php echo get_field('parent_2_last_name', $contact[0]->ID); ?>">
            </div>

            <div class="input-group">
                <label for="parent_2_email">Parent 2 Email</label>
                <input id="parent_2_email" type="text" name="parent_2_email" placeholder="For e.g. “you@yourdomain.com”"
                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                       title="A valid email is required." value="<?php echo get_field('parent_2_email', $contact[0]->ID); ?>">
            </div>

        </div>

        <br>

        <div class="input-group">
            <input type="submit" value="Update Profile">
        </div>

        <input type="hidden" name="action" value="student_profile" />
        <?php wp_nonce_field( 'student_profile', 'nonce' ); ?>

    </form>

</main>

<?php get_footer(); ?>





<script type="text/javascript">

    var nscsStudentProfileFormSubmitting = false;

    jQuery(document).ready(function($) {

        if($('input[name="non_traditional_student"]:checked').val() === 'yes') {
            $('#non_traditional_student_reason').show();
        } else if($('input[name="non_traditional_student"]:checked').val() === 'no') {
            $('#non_traditional_student_reason').hide();
        } else {
            $('#non_traditional_student_reason').hide();
        }

        $('input[name="non_traditional_student"]').click(function(event) {

            if($(event.target).val() === 'yes') {
                $('#non_traditional_student_reason').show();
            }

            if($(event.target).val() === 'no') {
                $('#non_traditional_student_reason').hide();
            }

        });

        $('#password, #parent_email, #parent_2_email').change(function(e) {
            if($(e.target).val() === '') {
                $(e.target).prop('required',false);
            } else {
                $(e.target).prop('required',true);
            }
        });


        // Handle Form Submission
        $( "#nscs-student-profile-form" ).submit(function( e ) {

            debugger;
            e.preventDefault();

            if ( !nscsStudentProfileFormSubmitting ) {

                nscsStudentProfileFormSubmitting = true;
                $('#nscs-student-profile-form input[type=submit]').addClass('loading');

                // Create a form object we can actually use
                /*var StudentProfileForm = $(this).serialize();*/
                var StudentProfileForm = new FormData(this);

                var ProfileFormValues = {};
                $.each($(this).serializeArray(), function (i, field) {
                    ProfileFormValues[field.name] = field.value;
                });

                $.ajax({
                    type   : "POST",
                    url    : "<?php echo admin_url( 'admin-ajax.php' ) ?>",
                    data   : StudentProfileForm,
                    cache:false,
                    contentType: false,
                    processData: false,
                    error: function() {
                        $('.nscs-auth__message').html('There was an issue processing the form, please refresh the page and try again.')
                    },
                    success: function(data) {

                        data = JSON.parse(data);

                        if( !!data.success ) {
                            window.location = window.location.pathname + '?extras=true';
                        } else {
                            $('.nscs-auth__message').html(data.message);
                        }
                    },
                    complete: function() {
                        nscsPaymentFormSubmitting = false;
                        $('#nscs-auth__registration-form input[type=submit]').removeClass('loading');
                    }
                });
            }
            return false;
        });
    });
</script>
