<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 **/
?>
<div id="sidebar">

    <div id="events" class="widget-area">
        <ul class="xoxo">
            <?php
            if ( ! dynamic_sidebar( 'event-widget-area' ) ) : ?>
            <?php endif; // end primary widget area ?>
        </ul>
    </div><!-- #events .widget-area -->

    <div id="primary" class="widget-area" role="complementary">
        <ul class="xoxo">
            <?php
                if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : ?>
                <!-- li id="archives" class="widget-container">
                    <h3 class="widget-title">Archives</h3>
                    <ul><?php //wp_get_archives( 'type=monthly' ); ?></ul>
                </li-->

                <?php endif; // end primary widget area ?>
        </ul>
    </div><!-- #primary .widget-area -->

    <div id="secondary" class="widget-area" role="complementary">
        <ul class="xoxo">
            <?php
            if ( ! dynamic_sidebar( 'secondary-widget-area' ) ) : ?>
                <li id="meta" class="widget-container">
                    <h3 class="widget-title">Meta</h3>
                    <ul>
                        <?php wp_register(); ?>
                        <li><?php wp_loginout(); ?></li>
                        <?php wp_meta(); ?>
                    </ul>
                </li>
                <?php endif; // end secondary widget area ?>
        </ul>
    </div><!-- #primary .widget-area -->




</div> <!-- siderbar -->
