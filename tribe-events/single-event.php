<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = get_the_ID();

?>

<!-- Event header -->
<div id="tribe-events-header" class="single-event-header" <?php tribe_events_the_header_attributes() ?>>
    <!-- Navigation -->
    <nav class="tribe-events-nav-pagination" aria-label="<?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?>">
        <ul class="tribe-events-sub-nav">
            <li class="single-event-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
            <li class="single-event-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
        </ul>
        <!-- .tribe-events-sub-nav -->
    </nav>
</div>

<div>
    <?php the_title( '<h1 class="tribe-events-single-event-title">', '</h1>' ); ?>
</div>

<div class="single-event-description">
    <?php the_content(); ?>
</div>

<div id="tribe-events-content" class="tribe-events-single">

    <div class="single-event-left-column">

        <h3>Location</h3>
        <div class="single-event-map"><?php tribe_get_template_part( 'modules/meta/map' ); ?></div>

        <?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>

    </div>
    <div class="single-event-right-column">
        <h3>Date and Time</h3>
        <div class="single-event-calendar"><?php echo do_shortcode('[tribe_mini_calendar]'); ?></div>
    </div>

</div><!-- #tribe-events-content -->


<div id="tribe-events-footer">
    <!-- Navigation -->
    <nav class="tribe-events-nav-pagination" aria-label="<?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?>">
        <ul class="tribe-events-sub-nav">
            <li class="single-event-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
            <li class="single-event-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
        </ul>
        <!-- .tribe-events-sub-nav -->
    </nav>
</div>



