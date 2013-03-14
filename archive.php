<?php get_header(); ?>	
	<div id="content" class="page archive" >
		<div class="aligner">
			<?
			$thisCat = get_category(get_query_var('cat'),false);
			
			echo '<h1>'.$thisCat->name.'</h1>';
			
			?>
			
			<div class="col3 sidebar">
				<div  class="cats-list">
					<ul>
					<?php wp_list_categories(
						array(
							'orderby'            => 'name',
							'order'              => 'ASC',
							'style'              => 'list',
							'show_count'         => 0,
							'hide_empty'         => 1,
							'use_desc_for_title' => 1,
							'hierarchical'       => true,
							'title_li'           => ''
						)
					); ?>
					</ul>
				</div>
			</div>
			<div class="col9 last">		
				<?php
				
				if (have_posts()) : while (have_posts()) : the_post(); ?>
					<div class="post">
						<h2><a href="<?php the_permalink(); ?>" title=""><?php the_title(); ?></a></h2>
						<div class="post-meta">
							<div class="date">
								<i class="icon-calendar"></i>
								<?= date_i18n('j M, Y', strtotime(get_the_date())); ?>
							</div>
							<div class="cats">
								<i class="icon-folder-close"></i>
								<?php $cats = wp_get_post_terms(get_the_ID(), 'category'); ?>
								<?php $i=0; foreach($cats as $cat): $i++; ?>
									<?php if ($i>1) echo '| '; ?><a href="/<?= $cat->slug; ?>"><?= $cat->name; ?></a>
								<?php endforeach; ?>
							</div>

						</div>
						<div class="clear"></div>
											
						<?php the_post_thumbnail('archive-posts'); ?>
						<div class="text">
							<?php the_field('excerpt'); ?>
						</div>
						<a href="<?php the_permalink(); ?>" class="more">Узнать больше</a>
						<div class="clear"></div>
					</div>					
				<?php endwhile; endif; ?>
			</div>
		</div>
	</div>
<?php // get_sidebar(); ?>	
<?php get_footer(); ?>