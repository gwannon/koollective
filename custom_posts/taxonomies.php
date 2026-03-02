<?php

//Ciudad -------------------------
add_action( 'init', 'koollective_ciudad_create_type' );
function koollective_ciudad_create_type() {
	$labels = array(
		'name'              => __( 'Ciudades', 'koollective' ),
		'singular_name'     => __( 'Ciudad', 'koollective' ),
		'search_items'      => __( 'Buscar ciudad', 'koollective' ),
		'all_items'         => __( 'Todas las ciudades', 'koollective' ),
		'parent_item'       => __( 'Ciudad superior', 'koollective' ),
		'parent_item_colon' => __( 'Ciudad superior,', 'koollective' ).":",
		'edit_item'         => __( 'Editar ciudad', 'koollective' ),
		'update_item'       => __( 'Actualizar ciudad', 'koollective' ),
		'add_new_item'      => __( 'Añadir ciudad', 'koollective' ),
		'new_item_name'     => __( 'Nuevo ciudad', 'koollective' ),
		'menu_name'         => __( 'Ciudades', 'koollective' ),
	);
	$args = array(
		'labels' 		    => $labels,
		'hierarchical' 	    => true,
		'public'		    => true,
		'query_var'		    => true,
		'show_in_nav_menus' => true,
		'has_archive'       => true,
    'rewrite'           =>  array( 'slug' => 'ciudades', 'with_front' => false, 'hierarchical' => true),
    'publicly_queryable'=> true
	);
	register_taxonomy( 'ciudad', array('local'), $args );
}

