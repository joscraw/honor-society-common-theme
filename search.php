<?php get_header(); ?>

<?php

    $search_refer = $_GET['site_section'];

    if($search_refer === 'scholarships')
    {
        load_template(TEMPLATEPATH . '/scholarship-search.php');
    }

?>



<?php get_footer(); ?>