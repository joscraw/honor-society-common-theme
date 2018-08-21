<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Title of the document</title>

    <link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('stylesheet_directory'); ?>/assets/css/login.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.css" />

</head>

<body>


<div class="main-content">

   <!-- <img src="<?php /*echo get_template_directory_uri() . '/assets/images/rectangle.png'; */?>">
    <img src="<?php /*echo get_template_directory_uri() . '/assets/images/student.png'; */?>">-->
    <div class="login-container">
        <div class="login-form">
            <img src="<?php echo get_template_directory_uri() . '/assets/images/main-logo.png'; ?>">
            <h1>LOGIN TO YOUR ALL-NEW MEMBER PORTAL</h1>
            <?php wp_login_form( array('redirect' => home_url()) ); ?>
        </div>
        <div>

        </div>
    </div>

</div>

</body>

</html>

