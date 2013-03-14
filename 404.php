<?php get_header(); ?>

            <!-- BEGIN .page-header -->
            <div class="page-header">
                <h1 class="page-title"><?php _e('Error 404 - Not Found', 'framework') ?></h1>
            <!-- END .page-header -->
            </div>

			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed">
			
				<!--BEGIN #post-0-->
				<div id="post-0" <?php post_class() ?>>
					
					<!--BEGIN .entry-content-->
					<div class="entry-content">
						<p><?php _e("Sorry, but you are looking for something that isn't here.", "framework") ?></p>
					<!--END .entry-content-->
					</div>
					
				<!--END #post-0-->
				</div>
				
			<!--END #primary .hfeed-->
			</div>
 
<?php get_sidebar(); ?>

<?php get_footer(); ?>