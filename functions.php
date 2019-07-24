<?php 
//Añadir ReCaptcha

function lapizzeria_agregar_recaptcha() { ?>
	<script src="https://www.google.com/recaptcha/api.js" ></script>
<?php
}
add_action('wp_head', 'lapizzeria_agregar_recaptcha');
// Tablas personalizadas y otras funciones
require get_template_directory() . '/inc/database.php';

// Funciones para las reservaciones
require get_template_directory() . '/inc/reservaciones.php';

// Crear Funciones para el Template
require get_template_directory() . '/inc/opciones.php';

function lapizzeria_setup() {
	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');
	add_image_size('nosotros',437,291,true);
	add_image_size('especialidades',768,515,true);
	add_image_size('especialidades_portrait',435,526,true);

	update_option('thumbnail_size_w', 253);
	update_option('thumbnail_size_h', 164);
}
add_action('after_setup_theme', 'lapizzeria_setup');


function lapizzeria_custom_logo() {
	$logo = array(
		'height' =>220,
		'width' =>280
	);
	add_theme_support('custom-logo', $logo);
}
add_action( 'after_setup_theme', 'lapizzeria_custom_logo');

function lapizzeria_styles() {
	//Registrar los estilos
	wp_register_style('normalize', get_template_directory_uri() . '/css/normalize.css', array(), '8.0.1');
	wp_register_style('google_fonts','https://fonts.googleapis.com/css?family=Open+Sans|Raleway:400,700,900', array(), '1.0.0');
	wp_register_style('fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', array('normalize'), '4.7.0');
	wp_register_style('fluidboxcss', get_template_directory_uri() . '/css/fluidbox.min.css', array('normalize'), '4.7.0');
	wp_register_style('datetime-local', get_template_directory_uri() . '/css/datetime-local-polyfill.css', array('normalize'), '4.7.0');
	wp_register_style('style', get_template_directory_uri() . '/style.css', array('normalize'), '1.2');

	//Llamar los estilos
	wp_enqueue_style('normalize');
	wp_enqueue_style('fontawesome');
	wp_enqueue_style('fluidboxcss');
	wp_enqueue_style('datetime-local');
	wp_enqueue_style('style');

	// Registrar JS

	$apikey = esc_html(get_option('lapizzeria_gmap_apikey'));
	wp_register_script('maps', 'https://maps.googleapis.com/maps/api/js?key=' . $apikey . '&callback=initMap', array(), '', true);
	wp_register_script('scripts', get_template_directory_uri() . '/js/scripts.js', array(), '1.0.0', true);
	wp_register_script('fluidbox', get_template_directory_uri() . '/js/jquery.fluidbox.min.js', array(), '1.0.0', true);
	wp_register_script('datetime-local-polyfill', get_template_directory_uri() . '/js/datetime-local-polyfill.min.js', array(), '1.0.0', true);
	wp_register_script('modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js', array(), '2.8.3', true);

	wp_enqueue_script('maps');
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('datetime-local-polyfill');
	wp_enqueue_script('modernizr');
	wp_enqueue_script('scripts');
	wp_enqueue_script('fluidbox');


	//Pasar variables de PHP a JavaScript
	wp_localize_script(
		'scripts',
		'opciones',
		array(
			'latitud' => get_option('lapizzeria_gmap_latitud'),
			'longitud' => get_option('lapizzeria_gmap_longitud'),
			'zoom' => get_option('lapizzeria_gmap_zoom'),
		)
	);
}

add_action('wp_enqueue_scripts','lapizzeria_styles');

function lapizzeria_admin_scripts() {

	wp_enqueue_style('sweetalert', get_template_directory_uri() . '/css/sweetalert2.min.css');
	wp_enqueue_script('sweetalertjs', get_template_directory_uri() . '/js/sweetalert2.min.js', array('jquery'), '1.0', true);
	wp_enqueue_script('adminjs', get_template_directory_uri() . '/js/admin-ajax.js', array('jquery'), '1.0', true);
	
	// Pasar la URL de WP Ajax al adminjs
	wp_localize_script(
			'adminjs',
			'url_eliminar',
			array('ajaxurl' => admin_url('admin-ajax.php'))
	);
}
add_action('admin_enqueue_scripts', 'lapizzeria_admin_scripts');

//Agregar Async y Defer

function agregar_async_defer($tag, $handle){
	if('maps' !== $handle)
		return $tag;
	return str_replace(' src', ' async="async" defer="defer" src', $tag);
}
add_filter('script_loader_tag', 'agregar_async_defer', 10, 2 );

//Creación de menus
function lapizzeria_menus(){
	register_nav_menus(array(
		'header-menu' => __('Header-Menu', 'lapizzeria'),
		'social-menu' => __('Social-Menu', 'lapizzeria')
	));
}
add_action('init','lapizzeria_menus');


add_action( 'init', 'lapizzeria_especialidades' );
function lapizzeria_especialidades() {
	$labels = array(
		'name'               => _x( 'Pizzas', 'lapizzeria' ),
		'singular_name'      => _x( 'Pizzas', 'post type singular name', 'lapizzeria' ),
		'menu_name'          => _x( 'Pizzas', 'admin menu', 'lapizzeria' ),
		'name_admin_bar'     => _x( 'Pizzas', 'add new on admin bar', 'lapizzeria' ),
		'add_new'            => _x( 'Add New', 'book', 'lapizzeria' ),
		'add_new_item'       => __( 'Add New Pizza', 'lapizzeria' ),
		'new_item'           => __( 'New Pizzas', 'lapizzeria' ),
		'edit_item'          => __( 'Edit Pizzas', 'lapizzeria' ),
		'view_item'          => __( 'View Pizzas', 'lapizzeria' ),
		'all_items'          => __( 'All Pizzas', 'lapizzeria' ),
		'search_items'       => __( 'Search Pizzas', 'lapizzeria' ),
		'parent_item_colon'  => __( 'Parent Pizzas:', 'lapizzeria' ),
		'not_found'          => __( 'No Pizzases found.', 'lapizzeria' ),
		'not_found_in_trash' => __( 'No Pizzases found in Trash.', 'lapizzeria' )
	);

	$args = array(
		'labels'             => $labels,
    'description'        => __( 'Description.', 'lapizzeria' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'especialidades' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 6,
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
    'taxonomies'          => array( 'category' ),
	);

	register_post_type( 'especialidades', $args );
}

//Widgets

function lapizzeria_widgets(){
	register_sidebar( array(
		'name' => 'Blog Sidebar',
		'id'   => 'blog_sidebar',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
}
add_action('widgets_init','lapizzeria_widgets');

/* Función para que la galería aparezca en la página de inicio
 A get_post_gallery() polyfill for Gutenberg
 *
 * @param string $gallery The current gallery html that may have already been found (through shortcodes).
 * @param int $post The post id.
 * @return string The gallery html.
 */
function bm_get_post_gallery( $gallery, $post ) {
	// Already found a gallery so lets quit.
	if ( $gallery ) {
		return $gallery;
	}
	// Check the post exists.
	$post = get_post( $post );
	if ( ! $post ) {
		return $gallery;
	}
	// Not using Gutenberg so let's quit.
	if ( ! function_exists( 'has_blocks' ) ) {
		return $gallery;
	}
	// Not using blocks so let's quit.
	if ( ! has_blocks( $post->post_content ) ) {
		return $gallery;
	}
	/**
	 * Search for gallery blocks and then, if found, return the html from the
	 * first gallery block.
	 *
	 * Thanks to Gabor for help with the regex:
	 * https://twitter.com/javorszky/status/1043785500564381696.
	 */
	$pattern = "/<!--\ wp:gallery.*-->([\s\S]*?)<!--\ \/wp:gallery -->/i";
	preg_match_all( $pattern, $post->post_content, $the_galleries );
	// Check a gallery was found and if so change the gallery html.
	if ( ! empty( $the_galleries[1] ) ) {
		$gallery = reset( $the_galleries[1] );
	}
	return $gallery;
}
add_filter( 'get_post_gallery', 'bm_get_post_gallery', 10, 2 );

/** Advanced Custom Fields**/

//define('ACF_LITE', 	true);
//include_once('advanced-custom-fields/acf.php');

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5cdf5be833577',
	'title' => 'Especialidades',
	'fields' => array(
		array(
			'key' => 'field_5cdf5d75fbc0a',
			'label' => 'Precio',
			'name' => 'precio',
			'type' => 'text',
			'instructions' => 'Añada un precio del platillo',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'especialidades',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5d02db445db2e',
	'title' => 'Inicio',
	'fields' => array(
		array(
			'key' => 'field_5d02db47789d2',
			'label' => 'Contenido',
			'name' => 'contenido',
			'type' => 'wysiwyg',
			'instructions' => 'Agregue la descripción',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
			'delay' => 0,
		),
		array(
			'key' => 'field_5d02db9b789d3',
			'label' => 'Imagen',
			'name' => 'imagen',
			'type' => 'image',
			'instructions' => 'Agregue la imagen',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'page',
				'operator' => '==',
				'value' => '6',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5cdcd7d606c33',
	'title' => 'Sobre Nosotros',
	'fields' => array(
		array(
			'key' => 'field_5cdcd8426a580',
			'label' => 'Imagen_1',
			'name' => 'imagen_1',
			'type' => 'image',
			'instructions' => 'Suba una imagen',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5cdcd9be6a584',
			'label' => 'Descripcion_1',
			'name' => 'descripcion_1',
			'type' => 'wysiwyg',
			'instructions' => 'Agregar la descrioción',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
			'delay' => 0,
		),
		array(
			'key' => 'field_5cdcd9696a582',
			'label' => 'Imagen_2',
			'name' => 'imagen_2',
			'type' => 'image',
			'instructions' => 'Suba una imagen',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5cdcda1e6a585',
			'label' => 'Descripcion_2',
			'name' => 'descripcion_2',
			'type' => 'wysiwyg',
			'instructions' => 'Agregar la descrioción',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
			'delay' => 0,
		),
		array(
			'key' => 'field_5cdcd9776a583',
			'label' => 'Imagen_3',
			'name' => 'imagen_3',
			'type' => 'image',
			'instructions' => 'Suba una imagen',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5cdcda276a586',
			'label' => 'Descripcion_3',
			'name' => 'descripcion_3',
			'type' => 'wysiwyg',
			'instructions' => 'Agregar la descrioción',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
			'delay' => 0,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'page',
				'operator' => '==',
				'value' => '13',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;
