<?php
/**
 * Template Name: Chapter Update
 */

get_header(); ?>

    <main class="nscs-chapter-update__container">
        <div class="input-group">
            <label for="subject">Subject</label>
            <input type="text" name="subject" id="subject" placeholder="e.g. Report for month of July" required>
        </div>

        <div class="input-group">
            <label for="message">Message</label>
            <textarea name="message" placeholder="e.g. Hey There,"></textarea>
            <!--<input type="text" name="subject" id="subject" placeholder="Event Update" required>-->
        </div>

        <div class="input-group">
            <input type="submit" class="nscs-chapter-update__button" value="Send Message">
        </div>
    </main>

<?php get_footer(); ?>