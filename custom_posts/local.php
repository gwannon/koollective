<?php 

// Local -----------------------------
// ------------------------------------------------
add_action( 'init', 'koollective_local_create_post_type' );
function koollective_local_create_post_type() {
	$labels = array(
		'name'               => __( 'Locales', 'koollective' ),
		'singular_name'      => __( 'Local', 'koollective' ),
		'add_new'            => __( 'Añadir nuevo', 'koollective' ),
		'add_new_item'       => __( 'Añadir nuevo local', 'koollective' ),
		'edit_item'          => __( 'Editar local', 'koollective' ),
		'new_item'           => __( 'Nuevo local', 'koollective' ),
		'all_items'          => __( 'Todos los locales', 'koollective' ),
		'view_item'          => __( 'Ver local', 'koollective' ),
		'search_items'       => __( 'Buscar local', 'koollective' ),
		'not_found'          => __( 'Aliado no encontrado', 'koollective' ),
		'not_found_in_trash' => __( 'Aliado no encontrado en la papelera', 'koollective' ),
		'menu_name'          => __( 'Locales', 'koollective' ),
	);
	$args = array(
		'labels'        => $labels,
		'description'   => __( 'Añadir nuevo local', 'koollective' ),
		'public'        => false,
		'show_ui'       => true,
		'menu_position' => 300,
		'query_var' 	=> true,
		'supports'      => array( 'title', /*'editor',*/ 'thumbnail' /*, 'page-attributes'*/ ),
		'rewrite'	    => false,
		'query_var'	    => true,
		'has_archive' 	=> false,
		'hierarchical'	=> true,
	);
	register_post_type( 'local', $args );
}

function koollective_local_add_custom_fields() {
  add_meta_box(
    'box_local', // $id
    __('Datos local', 'koollective'), // $title 
    'koollective_show_custom_fields', // $callback
    'local', // $page
    'normal', // $context
    'high'); // $priority
}
add_action('add_meta_boxes', 'koollective_local_add_custom_fields');
add_action('save_post', 'koollective_save_custom_fields' );

//CAMPOS personalizados ---------------------------
// ------------------------------------------------
function koollective_get_local_custom_fields() {
	//global $post;
	$fields = [
    'direccion' => [
      'titulo' => __( 'Dirección', 'koollective' ), 'tipo' => 'textarea'
    ],
    'linkgooglemap' => [
      'titulo' => __( 'URL a Google Maps', 'koollective' ), 'tipo' => 'link', 'placeholder' =>  __( 'https://dominio.com', 'koollective' ) 
		],
    /*'mapa' => [
      'titulo' => __( 'Mapa', 'koollective' ), 'tipo' => 'map',
		],*/
  ];

	return $fields;
}

//Columnas, filtros y ordenaciones ---------------
// ------------------------------------------------
function koollective_local_set_custom_edit_columns($columns) {
	$columns['ciudad'] = __( 'Línea de investigación', 'koollective');
	$columns['relacionlocal'] = __( 'Tipo de relación', 'koollective');
 	$columns['imagen'] = __( 'Imagen', 'koollective');
  	//unset($columns['date']);
  	return $columns;
}

function koollective_local_custom_column( $column ) {
  global $post;
  if ($column == 'ciudad') {
    $terms = get_the_terms( $post->ID, 'ciudad'); 
	if(is_array($terms)) {
		$sorted_terms = sort_terms_hierarchically( $terms );
		$string = array();
		foreach($sorted_terms as $term) {
		$string[] = $term->name;
		}
		if(count($string) > 0) echo implode (", ", $string);
	}
  } else  if ($column == 'relacionlocal') {
    $terms = get_the_terms( $post->ID, 'relacionlocal'); 
	if(is_array($terms)) {
		$sorted_terms = sort_terms_hierarchically( $terms );
		$string = array();
		foreach($sorted_terms as $term) {
		$string[] = $term->name;
		}
		if(count($string) > 0) echo implode (", ", $string);
	}
  } else if ($column == 'imagen') {
		if(has_post_thumbnail($post->ID)) echo "<img src='".get_the_post_thumbnail_url($post->ID, 'thumbnail')."' alt='' style='width: 150px; height: 150px;' />";
  }
}

function koollective_local_post_by_ciudad_taxonomy() {
	global $typenow;
	$post_type = 'local'; // change to your post type
	$taxonomy  = 'ciudad'; // change to your taxonomy
	if ($typenow == $post_type) {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		// $info_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories(array(
			'hierarchical' 		=> 1,
			'show_option_all' => __( 'Mostrar todas las lineas de investigación', 'koollective' ),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => false,
		));
	};
}

function koollective_local_ciudad_id_to_term_in_query($query) {
	global $pagenow;
	$post_type = 'local'; // change to your post type
	$taxonomy  = 'ciudad'; // change to your taxonomy
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}

if ( is_admin() && 'edit.php' == $pagenow && isset($_GET['post_type']) && 'local' == $_GET['post_type'] ) {
	add_filter( 'manage_edit-local_columns', 'koollective_local_set_custom_edit_columns' ); //Metemos columnas
	add_action( 'manage_local_posts_custom_column' , 'koollective_local_custom_column'); //Metemos columnas
	add_action( 'restrict_manage_posts', 'koollective_local_post_by_ciudad_taxonomy' ); //Añadimos filtro línea de investigación
	add_filter( 'parse_query', 'koollective_local_ciudad_id_to_term_in_query' ); //Añadimos filtro línea de investigación
	add_filter( 'months_dropdown_results', '__return_empty_array' ); //Quitamos el filtro de fechas en el admin
}
