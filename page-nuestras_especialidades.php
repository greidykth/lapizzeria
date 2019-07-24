<?php  
/*
* Template Name: Especialidades
*/

get_header(); ?>

	
	<?php while(have_posts()): the_post(); ?>


		<div class="hero" style="background-image:url(<?php echo get_the_post_thumbnail_url(); ?>);">
			<div class="contenido-hero">
				<div class="texto-hero">
					<?php the_title('<h1>', '</h1>'); ?>
				</div>
			</div>
		</div>


		<div class="principal contenedor">
			<main class="texto-centrado contenido-paginas">
				<?php the_content(); ?>
			</main>
		</div>
	<?php endwhile; ?>

	<div class="nuestras-especialidades contenedor">
		<a class="titulo" onclick="ver('Pizzas')" style="text-decoration: none;"><h3 class="texto-rojo">Pizzas <i id="Pizzas_icon" class="fa fa-plus" style="font-size: 50%; vertical-align: middle"></i></h3></a>
		<div class="contenedor-grid especialidad" id="Pizzas">
		<?php
			$args=array(
				'post_type' => 'especialidades',
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC',
				'category_name' => 'Pizza'
			);
			$pizzas = new WP_Query($args);
			while($pizzas->have_posts()): $pizzas->the_post();
		?>
		<div class="columnas2-4">
			<?php the_post_thumbnail('especialidades'); ?>
			<div class="texto-especialidad">
				<h4><?php the_title(); ?> <span>$<?php the_field('precio'); ?></span> </h4>
				<?php the_content() ?>
			</div> <!--.texto-especialidad-->
		</div>
		<?php endwhile; wp_reset_postdata(); ?>		
	</div><!--.contenedor-grid-->

	<a class="titulo" onclick="ver('Otros')" style="text-decoration: none;"><h3 class="texto-rojo">Otros <i id="Otros_icon" class="fa fa-plus" style="font-size: 50%; vertical-align: middle"></i></h3></a>
	<div class="contenedor-grid especialidad" id="Otros">
		<?php
			$args=array(
				'post_type' => 'especialidades',
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC',
				'category_name' => 'Otros'
			);
			$otros = new WP_Query($args);
			while($otros->have_posts()): $otros->the_post();
		?>
		<div class="columnas2-4">
			<?php the_post_thumbnail('especialidades'); ?>
			<div class="texto-especialidad">
				<h4><?php the_title(); ?> <span>$<?php the_field('precio'); ?></span> </h4>
				<?php the_content() ?>
			</div> <!--.texto-especialidad-->
		</div>
		<?php endwhile; wp_reset_postdata(); ?>	

	</div><!--.contenedor-grid-->

	<a class="titulo" onclick="ver('Entradas')" style="text-decoration: none;"><h3 class="texto-rojo">Entradas <i id="Entradas_icon" class="fa fa-plus" style="font-size: 50%; vertical-align: middle"></i></h3></a>
	<div class="contenedor-grid especialidad" id="Entradas">
		<?php
			$args=array(
				'post_type' => 'especialidades',
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC',
				'category_name' => 'Entradas'
			);
			$entradas = new WP_Query($args);
			while($entradas->have_posts()): $entradas->the_post();
		?>
		<div class="columnas2-4">
			<?php the_post_thumbnail('especialidades'); ?>
			<div class="texto-especialidad">
				<h4><?php the_title(); ?> <span>$<?php the_field('precio'); ?></span> </h4>
				<?php the_content() ?>
			</div> <!--.texto-especialidad-->
		</div>
		<?php endwhile; wp_reset_postdata(); ?>	

	</div><!--.contenedor-grid-->

	<a class="titulo" onclick="ver('Bebidas')" style="text-decoration: none;"><h3 class="texto-rojo">Bebidas <i id="Bebidas_icon" class="fa fa-plus" style="font-size: 50%; vertical-align: middle"></i></h3></a>
	<div class="contenedor-grid especialidad" id="Bebidas">
		<?php
			$args=array(
				'post_type' => 'especialidades',
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC',
				'category_name' => 'Bebidas'
			);
			$bebidas = new WP_Query($args);
			while($bebidas->have_posts()): $bebidas->the_post();
		?>
		<div class="columnas2-4">
			<?php the_post_thumbnail('especialidades'); ?>
			<div class="texto-especialidad">
				<h4><?php the_title(); ?> <span>$<?php the_field('precio'); ?></span> </h4>
				<?php the_content() ?>
			</div> <!--.texto-especialidad-->
		</div>
		<?php endwhile; wp_reset_postdata(); ?>	

	</div><!--.contenedor-grid-->
	</div><!--.nuestras-especialidades-->

	<script type="text/javascript">
	function ver(categoria) {
		if($("#"+categoria).is(":visible")){
			$("#"+categoria).hide('slow');
			$( "#"+categoria +'_icon' ).removeClass( "fa fa-minus" ).addClass( "fa fa-plus" );
		}else{
			$("#"+categoria).show('slow');
			$( "#"+categoria +'_icon' ).removeClass( "fa fa-plus" ).addClass( "fa fa-minus" );
			$('html, body').animate({
		        scrollTop: $("#"+categoria+"_icon").offset().top - 40
		    }, 'slow');
		}
	}
	</script>
<?php get_footer();?>