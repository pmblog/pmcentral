<!DOCTYPE HTML>
<html lang="ru-RU">
<head>
	<meta charset="UTF-8">
	<title>Project Management Central</title>
	<link rel="stylesheet" href="http://necolas.github.com/normalize.css/2.1.0/normalize.css">
	<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'template_directory' ); ?>/css/screen.css">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div class="header">
		<div class="aligner row-fluid">
			<div class="logo col6">
				<a href="/">
					<img src="<?php bloginfo( 'template_directory' ); ?>/img/logo.png">
				</a>				
			</div>
			<div class="col6 last header-interface">
				<div class="search-form">
					<?php get_search_form(); ?>
				</div>
				<div class="social">
					<img src="<?php bloginfo( 'template_directory' ); ?>/img/social.png">
				</div>
				<div class="welcome-message">
					<p>Добро пожаловать на PM-блог.  <a href="#">Войдите</a> или <a href="#">Зарегистрируйтесь</a></p>
				</div>
			</div>
			<div class="clear"></div>
		</div>		
	</div>
	<div class="main-menu">
		<div class="aligner">
			<?php 
				wp_nav_menu( array(
					'theme_location'  => 'main-menu',
					'container'       => ''
					) )
			?>
			
		</div>
	</div>