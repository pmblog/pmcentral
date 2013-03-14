<?php get_header(); ?>	
	<div id="content" class="page">
		<div class="aligner">
			<?php while(have_posts()): the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>
		</div>		
	</div>
<?php get_footer(); ?>