<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, inicial-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="La Pizzeria">
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/apple-touch-icon.png">
	
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="theme-color" content="#a61206">
	<meta name="application-name" content="La Pizzeria">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/apple-touch-icon.png" sizes="192x192">

	<?php wp_head (); ?>
</head>
<body <?php body_class() ?>>

	<header class="encabezado-sitio">
		<div class="contenedor">
			<div class="logo">
				<a href="<?php echo esc_url(home_url('/'));  ?>">
					<?php 
						if(function_exists('the_custom_logo')) {
							the_custom_logo();
						}
					 ?>
				</a>
			</div><!-- .logo-->
			<div class="informacion-encabezado">
				<div class="redes-sociales">
					<?php $args = array(
						'theme_location' => 'social-menu',
						'container' => 'nav',
						'container_class' => 'sociales',
						'container_id' => 'sociales',
						'link_before' => '<span class="sr-text">',
						'link_after' => '</span>'
					);
					wp_nav_menu($args);
					?>
				</div><!-- .redes-sociales -->
				<div class="direccion">
					<p><?php echo esc_html( get_option('lapizzeria_direccion') ); ?></p>
					<p>Teléfono: <?php echo esc_html( get_option('lapizzeria_telefono') ); ?></p>
				</div>
			</div>

		</div><!-- .contenedor -->
	</header>

	<div class="menu-principal">
			<div class="mobile-menu">
				<a href="#" class="mobile">Menu <i class="fa fa-bars" aria-hidden="true"></i></a>
			</div>
	</div>
				
		<div class="contenedor navegacion">
			<?php 
				$args = array(
					'theme location' => 'header-menu',
					'container' => 'nav',
					'container_class' => 'menu-sitio'
				);
				wp_nav_menu( $args );

			 ?>
		</div>
