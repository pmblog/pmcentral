<?php
/**
 * @package PMCentral
 * @subpackage Project Management Central
 * @since PMCentral 1.0
 */

get_header(); ?>

<div id="container">
      <div id="content">
          <?php
            get_template_part( 'loop', 'index' );
          ?>
      </div><!-- #content -->

<?php get_footer();

?>