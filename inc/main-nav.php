<nav class="main-nav">
    <?php wp_nav_menu( array(
        'theme_location' => 'primary-menu'
    ) ); ?>
    <?php /*wp_nav_menu( array(
        'menu' => 'right-primary-menu'
    ) ); */?>

    <div class="hamburger-menu-icon"><a href="javascript:void(0)"><img width="30" height="30" src="<?php echo get_template_directory_uri() . '/assets/images/menu-icon.png'; ?>"></a></div>
</nav>



<script type="text/javascript">
    jQuery(document).ready(function($) {

        $(".hamburger-menu-icon").click(function(){
             $(".menu-primary-menu-container").toggleClass('menu-active');
            $(".main-content").toggleClass('menu-active');
        });

    });
</script>