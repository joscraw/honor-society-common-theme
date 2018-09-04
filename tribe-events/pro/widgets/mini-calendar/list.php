<?php
/**
 * Mini Calendar List Loop
 * This file sets up the structure for the list loop
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/pro/widgets/mini-calendar/list.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>

<?php

global $post;
$post = get_post($post->ID);
$search = new \CRMConnector\Events\EventSearch();
// Don't display the list underneath the calendar on the single event page
if($post && $post->post_type === 'tribe_events')
{
    return;
}

?>

<div class="tribe-mini-calendar-list-wrapper">
	<div class="tribe-events-loop">

		<?php while ( have_posts() ) : the_post(); ?>

            <?php
            if(!$search->is_logged_in_user_allowed_to_attend_event($post))
            {
                global $wp_query;
                $wp_query->reset_postdata();
                continue;
            }

            global $wp_query;
            $wp_query->reset_postdata();
            ?>

			<?php do_action( 'tribe_events_mini_cal_list_inside_before_loop' ); ?>

			<!-- Event  -->
			<div class="<?php tribe_events_event_classes() ?>">
				<?php tribe_get_template_part( 'pro/widgets/modules/single-event' ) ?>
			</div>

			<?php do_action( 'tribe_events_mini_cal_list_inside_after_loop' ); ?>
		<?php endwhile; ?>

	</div><!-- .tribe-events-loop -->
</div> <!-- .tribe-mini-calendar-list-wrapper -->
