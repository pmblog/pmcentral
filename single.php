<?php get_header(); ?>	
	<div id="content" class="page archive single">
		<div class="aligner">			
			<div class="col3 sidebar">
				<div  class="cats-list">
					<ul>
					<?phpwp_list_categories(
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
				<div class="post">
					<h1><?php the_title(); ?></h1>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						
						<div class="post-meta">
							<div class="date">
								<i class="icon-calendar"></i>
								<?= date_i18n('j M, Y', strtotime(get_the_date())); ?>
							</div>
							<div class="cats">
								<i class="icon-folder-close"></i>
								<?php$cats = wp_get_post_terms(get_the_ID(), 'category'); ?>
								<?php$i=0; foreach($cats as $cat): $i++; ?>
									<?phpif ($i>1) echo '| '; ?><a href="/<?= $cat->slug; ?>"><?= $cat->name; ?></a>
								<?phpendforeach; ?>
							</div>
						</div>
						<div class="text">
							<?php the_content(); ?>
						</div>						
					<?php endwhile; endif; ?>
				</div>
			</div>
		</div>	
	</div>
<?php get_sidebar(); ?>	
<?php get_footer(); ?>