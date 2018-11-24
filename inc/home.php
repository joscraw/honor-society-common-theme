<?php
    if ( key_exists("extras", $_REQUEST ) && get_field('purchase_upgrades') ) {
        get_template_part('partials/content', 'upcharge' );
    }

?>

<div class="main-content">

    <div class="top-content">
        <div class="homepage-moot-container">
            <div class="bottom-content">
                <div class="main-content">
                    <div class="tab">
                        <div class="tab-icon">
                            <img src="<?php echo get_template_directory_uri() . '/assets/images/tab-people.png'; ?>">
                        </div>
                        <?php
                        $chapter_network_page = get_page_by_template_filename( 'template-chapter-network.php' );
                        if( !empty( $chapter_network_page ) ) : ?>
                            <a href="<?php echo  get_permalink( $chapter_network_page[0]->ID ); ?>"><span>CHAPTER NETWORK</span></a>
                        <?php endif; ?>
                    </div>
                    <div class="tab">
                        <div class="tab-icon">
                            <img src="<?php echo get_template_directory_uri() . '/assets/images/tab-calendar.png'; ?>">
                        </div>
                        <a href="/events/list"><span>CHAPTER EVENTS</span></a>
                    </div>
                    <div class="tab">
                        <div class="tab-icon">
                            <img src="<?php echo get_template_directory_uri() . '/assets/images/tab-cart.png'; ?>">
                        </div>
                        <a href="#"><span>MEMBER STORE</span></a>
                    </div>
                    <div class="tab">
                        <div class="tab-icon">
                            <img src="<?php echo get_template_directory_uri() . '/assets/images/tab-grad-hat.png'; ?>">
                        </div>
                        <a href="/scholarships"><span>SCHOLARSHIPS</span></a>
                    </div>
                    <div class="tab">
                        <div class="tab-icon">
                            <img src="<?php echo get_template_directory_uri() . '/assets/images/tab-career.png'; ?>">
                        </div>
                        <a href="#"><span>CHAPTER</span></a>
                    </div>
                    <div class="tab">
                        <div class="tab-icon">
                            <img src="<?php echo get_template_directory_uri() . '/assets/images/tab-person.png'; ?>">
                        </div>
                        <?php
                        $officer_hq_page = get_page_by_template_filename( 'template-officer-headquarters.php' );
                        if( !empty( $officer_hq_page ) ) : ?>
                            <a href="<?php echo  get_permalink( $officer_hq_page[0]->ID ); ?>"><span>OFFICER HQ</span></a>
                        <?php endif; ?>
                    </div>
                    <?php
                    global $CRMConnectorPlugin;
                    $contact_chapter_association = get_page_by_template_filename( 'template-contact-chapter-association.php' );
                    if( !empty( $contact_chapter_association ) ) :
                        $contact_chapter_association_url = get_permalink( $contact_chapter_association[0]->ID );
                        if($CRMConnectorPlugin->data['is_system_administrator']) : ?>
                            <div class="tab">
                                <div class="tab-icon">
                                    <img src="<?php echo get_template_directory_uri() . '/assets/images/tab-person.png'; ?>">
                                </div>
                                <a href="<?php echo $contact_chapter_association_url; ?>"><span>CHANGE CHAPTER</span></a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="homepage-calendar">
            <div class="single-event-calendar"><?php echo do_shortcode('[tribe_mini_calendar]'); ?></div>
        </div>
    </div>

</div>
