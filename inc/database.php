<?php

//Inicializa la creacion de las tablas nuevas
function lapizzeria_database(){
	//WPDB nos da los métodos para trabajar con tablas
	global $wpdb;
	//Agregamos una version 
	global $lapizzeria_dbversion;
	$lapizzeria_dbversion = '1.0';

	//Obtenemos el prefijo
	$tabla = $wpdb->prefix . 'reservaciones';

	//Obtenemos el collation de la instalacion
	$charset_collate = $wpdb->get_charset_collate();

	//Agregamos la estructura de la BD
	$sql = "CREATE TABLE $tabla (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		nombre varchar(58) NOT NULL,
		fecha datetime NOT NULL,
		correo varchar (58) DEFAULT '' NOT NULL,
		telefono varchar(10) NOT NULL,
		mensaje longtext NOT NULL,
		PRIMARY KEY (id)

) $charset_collate; ";

	// Se necesita dbDelta para ejecutar el SQL y está en la siguiente dirección
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	dbDelta($sql);

	//Agregamos la version de la BD para compararla con futuras actualizaciones
	add_option('lapizzeria_dbversion', $lapizzeria_dbversion);

// ACTUALIZAR EN CASO DE SER NECESARIO
	$version_actual = get_option('lapizzeria_dbversion');

	//Comparamos las dos versiones
	if($lapizzeria_dbversion != $version_actual){
		$tabla = $wpdb->prefix . 'reservaciones';

		//Aqui realizarias las actualizaciones
		$sql = "CREATE TABLE $tabla (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			nombre varchar(58) NOT NULL,
			fecha datetime NOT NULL,
			correo varchar (58) DEFAULT '' NOT NULL,
			telefono varchar(10) NOT NULL,
			mensaje longtext NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate; ";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		dbDelta($sql);
		//Actualizamos a la version actual en caso de que así sea
		update_option('lapizzeria_dbversion', $lapizzeria_dbversion);	
	}
}
add_action('after_setup_theme', 'lapizzeria_database');


// Funcion para comprobar que la version instalada es igual a la base de datos nueva
function lapizzeriadb_revisar(){
	global $lapizzeria_dbversion;
	if(get_site_option('lapizzeria_dbversion') != $lapizzeria_dbversion) {
		lapizzeria_database();
	}
}

add_action('plugins_loaded','lapizzeriadb_revisar');