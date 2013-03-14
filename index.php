<?php get_header(); ?>
	<div class="content">
		<?php
			$main_post_id = false;
			$sticky = get_option( 'sticky_posts' );
			$args = array(
				'posts_per_page' => 1,
				'post__in'  => $sticky,
				'ignore_sticky_posts' => 1
			);
			query_posts( $args );
			if (count($sticky)>0)	$main_post_id = $sticky[0];
		?>

		<?php if ($main_post_id): ?>
			<div class="main-post">
				<div class="aligner">
					<?php echo get_the_post_thumbnail($main_post_id, $size = 'post-homepage'); ?>
					<div class="row-fluid">
						<div class="col2">User data</div>
						<div class="col10 last">
							<div class="meta">
								<a href="#">Новости</a>
							</div>
						</div>
					</div>
				</div>				
			</div>
		<?php endif ?>	
		<div class="aligner">
					
		</div>
	</div>
<?php get_footer(); ?>
