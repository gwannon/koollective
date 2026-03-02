<?php 

// Actividad ----------------------------------------
// ------------------------------------------------
add_action( 'init', 'koollective_actividad_create_post_type' );
function koollective_actividad_create_post_type() {
	$labels = array(
		'name'               => __( 'Actividades', 'koollective' ),
		'singular_name'      => __( 'Actividad', 'koollective' ),
		'add_new'            => __( 'Añadir nueva', 'koollective' ),
		'add_new_item'       => __( 'Añadir nueva actividad', 'koollective' ),
		'edit_item'          => __( 'Editar actividad', 'koollective' ),
		'new_item'           => __( 'Nueva actividad', 'koollective' ),
		'all_items'          => __( 'Todas las actividades', 'koollective' ),
		'view_item'          => __( 'Ver actividad', 'koollective' ),
		'search_items'       => __( 'Buscar actividad', 'koollective' ),
		'not_found'          => __( 'Actividad no encontrada', 'koollective' ),
		'not_found_in_trash' => __( 'Actividad no encontrada en la papelera', 'koollective' ),
		'menu_name'          => __( 'Actividades', 'koollective' ),
	);
	$args = array(
		'labels'        => $labels,
		'description'   => __( 'Añadir nueva actividad', 'koollective' ),
		'public'        => true,
		'menu_position' => 100,
		'query_var' 	=> true,
		'supports'      => array( 'title', /*'excerpt',*/ 'editor', 'thumbnail', 'revisions' /*, 'page-attributes'*/ ),
		'rewrite'	    => array( 'slug' => 'actividades', 'with_front' => false),
		'query_var'	    => true,
		'has_archive' 	=> false,
		'hierarchical'	=> true,
	);
	register_post_type( 'actividad', $args );
}

function koollective_actividad_add_custom_fields() {
  add_meta_box(
    'box_actividad', // $id
    __('Datos actividad', 'koollective'), // $title 
    'koollective_show_custom_fields', // $callback
    'actividad', // $page
    'normal', // $context
    'high'); // $priority
}
add_action('add_meta_boxes', 'koollective_actividad_add_custom_fields');
add_action('save_post', 'koollective_save_custom_fields' );

//CAMPOS personalizados ---------------------------
// ------------------------------------------------

function koollective_get_actividad_jornadas() {
  $locales = [];
  $args = [
    'post_type' => 'jornada',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'order' => 'ASC',
    'orderby' => 'title',
    //'suppress_filters' => false,
  ]; 
  $posts = get_posts($args);
  foreach($posts as $post) {
    $locales[$post->ID] =  $post->post_title ." (".get_post_meta($post->ID, "_jornada_fechainicio", true).")";
  }
  return $locales;
}

function koollective_get_actividad_custom_fields() {
	//global $post;
	$fields = [
    'resumen' => [
        'titulo' => __( 'Resumen', 'koollective' ), 'tipo' => 'textarea'
    ],
    'fechahora' => [
            'titulo' => __( 'Fecha y hora', 'koollective' ), 'tipo' => 'datetime'
		],
    'jornada' => [
      'titulo' => __( 'Jornada', 'koollective' ), 'tipo' => 'select', 'valores' =>  koollective_get_actividad_jornadas()
		],
  ];
	return $fields;
}

//Columnas, filtros y ordenaciones ---------------
// ------------------------------------------------
function koollective_actividad_set_custom_edit_columns($columns) {
  $columns['fechahora'] = __( 'Fecha y hora', 'koollective');
	$columns['jornada'] = __( 'Jornada', 'koollective');
	$columns['local'] = __( 'Local', 'koollective');
  $columns['imagen'] = __( 'Imagen', 'koollective');
  unset($columns['date']);
  return $columns;
}

function koollective_actividad_custom_column( $column ) {
  global $post;
  if ($column == 'fechahora') {
     echo get_post_meta($post->ID, "_actividad_fechahora", true);
  } else if ($column == 'jornada') {

  } else if ($column == 'local') {

  } else if ($column == 'imagen') {
		if(has_post_thumbnail($post->ID)) echo "<img src='".get_the_post_thumbnail_url($post->ID, 'thumbnail')."' alt='' style='width: 150px; height: 150px;' />";
  }
}

if ( is_admin() && 'edit.php' == $pagenow && isset($_GET['post_type']) && 'actividad' == $_GET['post_type'] ) {
	add_filter( 'manage_edit-actividad_columns', 'koollective_actividad_set_custom_edit_columns' ); //Metemos columnas
	add_action( 'manage_actividad_posts_custom_column' , 'koollective_actividad_custom_column'); //Metemos columnas
	add_filter( 'months_dropdown_results', '__return_empty_array' ); //Quitamos el filtro de fechas en el admin
}
