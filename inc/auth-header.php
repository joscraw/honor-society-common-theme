<div class="nscs-auth-header">
    <div class="nscs-auth-header__logo">
        <a href="<?php echo get_home_url() ?>">
            <img src="<?php echo get_bloginfo('template_url') ?>/assets/images/logo.svg" alt="nscs logo">
        </a>
    </div>
    <h1 class="nscs-auth-header__title">
        <?php echo isset($auth_title) ? $auth_title : get_the_title() ?>
    </h1>
</div>
