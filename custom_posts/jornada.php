<?php 

// Jornada ----------------------------------------
// ------------------------------------------------
add_action( 'init', 'koollective_jornada_create_post_type' );
function koollective_jornada_create_post_type() {
	$labels = array(
		'name'               => __( 'Jornadas', 'koollective' ),
		'singular_name'      => __( 'Jornada', 'koollective' ),
		'add_new'            => __( 'Añadir nueva', 'koollective' ),
		'add_new_item'       => __( 'Añadir nueva jornada', 'koollective' ),
		'edit_item'          => __( 'Editar jornada', 'koollective' ),
		'new_item'           => __( 'Nueva jornada', 'koollective' ),
		'all_items'          => __( 'Todas los jornadas', 'koollective' ),
		'view_item'          => __( 'Ver jornada', 'koollective' ),
		'search_items'       => __( 'Buscar jornada', 'koollective' ),
		'not_found'          => __( 'Jornada no encontrada', 'koollective' ),
		'not_found_in_trash' => __( 'Jornada no encontrada en la papelera', 'koollective' ),
		'menu_name'          => __( 'Jornadas', 'koollective' ),
	);
	$args = array(
		'labels'        => $labels,
		'description'   => __( 'Añadir nueva jornada', 'koollective' ),
		'public'        => true,
		'menu_position' => 200,
		'query_var' 	=> true,
		'supports'      => array( 'title', 'editor', 'thumbnail', /*'excerpt',*/ 'revisions' /*, 'page-attributes'*/ ),
		'rewrite'	    => array( 'slug' => 'jornadas', 'with_front' => false),
		'query_var'	    => true,
		'has_archive' 	=> false,
		'hierarchical'	=> true,
	);
	register_post_type( 'jornada', $args );
}

function koollective_jornada_add_custom_fields() {
  add_meta_box(
    'box_jornada', // $id
    __('Datos jornada', 'koollective'), // $title 
    'koollective_show_custom_fields', // $callback
    'jornada', // $page
    'normal', // $context
    'high'); // $priority
}
add_action('add_meta_boxes', 'koollective_jornada_add_custom_fields');
add_action('save_post', 'koollective_save_custom_fields' );

//CAMPOS personalizados ---------------------------
// ------------------------------------------------

function koollective_get_jornada_locales() {
  $locales = [];
  $args = [
    'post_type' => 'local',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'order' => 'ASC',
    'orderby' => 'title',
    //'suppress_filters' => false,
  ]; 
  $posts = get_posts($args);
  foreach($posts as $post) {
    $locales[$post->ID] =  $post->post_title;
  }
  return $locales;
}


function koollective_get_jornada_custom_fields() {
	$fields = [
    'fechainicio' => [
      'titulo' => __( 'Fecha de inicio', 'koollective' ), 'tipo' => 'date'
		],
    'fechafin' => [
      'titulo' => __( 'Fecha de fin', 'koollective' ), 'tipo' => 'date'
		],
    'local' => [
      'titulo' => __( 'Local', 'koollective' ), 'tipo' => 'select', 'valores' =>  koollective_get_jornada_locales()
		],
    'maxinscripciones' => [
      'titulo' => __( 'Máximas inscripciones permitidas', 'koollective' ), 'tipo' => 'number', 
		],
  ];
	return $fields;
}

//Columnas, filtros y ordenaciones ---------------
// ------------------------------------------------
function koollective_jornada_set_custom_edit_columns($columns) {
  $columns['fechainicio'] = __( 'Fecha de inicio', 'koollective');
  $columns['fechafin'] = __( 'Fecha de fin', 'koollective');
	$columns['local'] = __( 'Local', 'koollective');
	$columns['actividades'] = __( 'Actividades', 'koollective');
  $columns['imagen'] = __( 'Imagen', 'koollective');
  unset($columns['date']);
  return $columns;
}

function koollective_jornada_custom_column( $column ) {
  global $post;
  if ($column == 'local') {
  
  } else if ($column == 'actividades') {
  
  } else if ($column == 'fechainicio') {
    echo get_post_meta($post->ID, "_jornada_fechainicio", true);
  } else if ($column == 'fechafin') {
    echo get_post_meta($post->ID, "_jornada_fechafin", true);
  } else if ($column == 'imagen') {
		if(has_post_thumbnail($post->ID)) echo "<img src='".get_the_post_thumbnail_url($post->ID, 'thumbnail')."' alt='' style='width: 150px; height: 150px;' />";
  }
}

if ( is_admin() && 'edit.php' == $pagenow && isset($_GET['post_type']) && 'jornada' == $_GET['post_type'] ) {
	add_filter( 'manage_edit-jornada_columns', 'koollective_jornada_set_custom_edit_columns' ); //Metemos columnas
	add_action( 'manage_jornada_posts_custom_column' , 'koollective_jornada_custom_column'); //Metemos columnas
	add_filter( 'months_dropdown_results', '__return_empty_array' ); //Quitamos el filtro de fechas en el admin
}
