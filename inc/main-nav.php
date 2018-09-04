<?php
global $crm_single_sign_on_link;
?>


<nav class="main-nav">
    <ul>
        <li><a href="<?php echo get_home_url();?>">Home</a></li>
        <li><a href="/events/list">Chapter Events</a></li>
        <li><?php echo $crm_single_sign_on_link("https://www.giftedhire.com/home", "Career"); ?></li>
        <li><a href="/scholarships">Scholarships</a></li>
    </ul>
</nav>