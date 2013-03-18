<?php get_header(); ?>

<div class="aligner">

	<?php
		$main_post_id = false;
		$args = array(
			'posts_per_page' => 1,
			'post__in'  => get_option( 'sticky_posts' ),
			'ignore_sticky_posts' => 1
		);
		$query = new WP_Query( $args );
		while ($query->have_posts()): $query->the_post();

			the_title(  );
			the_excerpt();

		endwhile;
		wp_reset_query();

	?>
</div>
	
<?php get_footer(); ?>
