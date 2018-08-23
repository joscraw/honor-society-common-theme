<?php
/**
 * List View Loop
 * This file sets up the structure for the list loop
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/loop.php
 *
 * @version 4.4
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
} ?>

<?php
global $post;
global $more;
$more = false;
?>

<div class="list-event-container">

    <?php

    global $crmConnectorFrontend;

    $current_user_id = $crmConnectorFrontend->data['current_user_id'];

    // the user is logged in
    if($current_user_id)
    {

        // FIRST LET'S GET THE CONTACT ID OF THE USER
        $args = [
            'post_type' => 'contacts',
            'posts_per_page' => 1,
            'meta_query'	=> array(
                array(
                    'key'	  	=> 'portal_user',
                    'value'	  	=> $current_user_id,
                    'compare' 	=> '=',
                ),
            ),
        ];

        $query = new WP_Query($args);

        if ( $query->have_posts() )
        {
            while ( $query->have_posts() ) {
                $query->the_post();
                $chapter_id = get_post_meta( get_the_ID(), 'account_name', true);
                break;
            }
        }

        wp_reset_postdata();


        if(isset($chapter_id))
        {
            $args = array(
                'post_status'=>'publish',
                'post_type'=>array(TribeEvents::POSTTYPE),
                'posts_per_page'=>10,
                'meta_query'	=> array(
                    array(
                        'key'	  	=> 'chapter',
                        'value'	  	=> $chapter_id,
                        'compare' 	=> '=',
                    ),
                )
            );

            $query = new WP_Query();
            $query->query($args);

            if ( $query->have_posts() )
            {
                while ( $query->have_posts() ) {
                    $query->the_post();
                    ?>


                    <?php do_action( 'tribe_events_inside_before_loop' ); ?>

                    <!-- Event  -->
                    <?php
                    $post_parent = '';
                    if ( $post->post_parent ) {
                        $post_parent = ' data-parent-post-id="' . absint( $post->post_parent ) . '"';
                    }
                    ?>
                    <div class="list-event" id="post-<?php the_ID() ?>" <?php echo $post_parent; ?>>
                        <?php

                        // Setup an array of venue details for use later in the template
                        $venue_details = tribe_get_venue_details();

                        // The address string via tribe_get_venue_details will often be populated even when there's
                        // no address, so let's get the address string on its own for a couple of checks below.
                        $venue_address = tribe_get_address();

                        // Venue
                        $has_venue_address = ( ! empty( $venue_details['address'] ) ) ? ' location' : '';

                        // Organizer
                        $organizer = tribe_get_organizer();

                        ?>

                        <div class="list-event-header">
                            <?php do_action( 'tribe_events_before_the_event_title' ) ?>
                            <div class="list-event-title">
                                <h3>
                                    <a class="list-event-url" href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
                                        <?php the_title() ?>
                                    </a>
                                </h3>
                            </div>
                            <!-- Event Cost -->
                            <?php if ( tribe_get_cost() ) : ?>
                                <div class="list-event-rsvp">
                                    <span class="ticket-cost"><?php echo tribe_get_cost( null, true ); ?></span>
                                    <?php
                                    /**
                                     * Runs after cost is displayed in list style views
                                     *
                                     * @since 4.5
                                     */
                                    do_action( 'tribe_events_inside_cost' )
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- event description -->
                        <div class="list-event-description">
                            <?php echo tribe_events_get_the_excerpt( null, wp_kses_allowed_html( 'post' ) ); ?>
                        </div><!-- .tribe-events-list-event-description -->

                        <div class="list-event-footer">
                            <div class="list-event-location">
                                <span>
                                    <img src="<?php echo get_template_directory_uri() . '/assets/images/location_icon.png'; ?>">
                                    <?php echo tribe_get_city() . ', ' .tribe_get_state(); ?>
                                </span>
                            </div>
                            <div class="list-event-date">
                           <span>
                               <?php echo (new DateTime($post->EventStartDate))->format("j M"); ?>
                           </span>
                            </div>
                            <div class="list-event-time">
                                <span>
                                 <img src="<?php echo get_template_directory_uri() . '/assets/images/time_icon.png'; ?>">
                                 <?php
                                 echo sprintf("%s - %s",
                                     (new DateTime($post->EventStartDate))->format("g:i A"),
                                     (new DateTime($post->EventEndDate))->format("g:i A")
                                 );
                                 ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            wp_reset_postdata();
        }






    }





    ?>

</div><!-- .tribe-events-loop -->
