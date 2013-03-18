<?php get_header(); ?>	
	<div id="content" class="page">
		<div class="aligner">
			<?php while(have_posts()): the_post(); ?>


            <div class="row-fluid">
                <div class="col8 last">
                    <?php the_content(); ?>
                </div>
            <div class="col4 last">
                <?php get_sidebar(); ?>
            </div>
                <div class="clear"></div>
            </div>
			<?php endwhile; ?>
		</div>		
	</div>
<?php get_footer(); ?>