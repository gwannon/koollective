<?php

/**
 * Plugin Name: koollective
 * Description: Plugins de Wordpress para eventos Koollective
 * Version:     1.0
 * Author:      Gwannon
 * Author URI:  https://github.com/gwannon/
 * License:     GNU General Public License v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: koollective
 *
 * PHP 8.2
 * WordPress 6.9
 */

/* 
 *
 * TODO:
 * 
 * Diseño de formulario                              | RESPUESTA ALBERTO
 * Diseño grid                                       | RESPUESTA ALBERTO
 * 
 * Chequear algoritmo DNI/NIE                        | RESPUESTA CLIENTE
 * Texto email usuario (inscrito o lista de espera)  | RESPUESTA CLIENTE
 * ¿Las lista de espera cuenta como inscripción?     | RESPUESTA CLIENTE
 *
 */

//flush_rewrite_rules(true);

define ("INSCRIPTION_PAGE_ID", get_option("_koollective_inscription_page_id"));
define ("INSCRIPTION_ADMIN_EMAIL", get_option("_koollective_admin_email"));

//Cargamos librerias
include_once(dirname(__FILE__)."/custom_posts/custom_posts.php");
include_once(dirname(__FILE__)."/custom_posts/jornada.php");
include_once(dirname(__FILE__)."/custom_posts/actividad.php");
include_once(dirname(__FILE__)."/custom_posts/local.php");
include_once(dirname(__FILE__)."/custom_posts/taxonomies.php");
include_once(dirname(__FILE__)."/admin.php");

add_shortcode('kollective_jornadas', function ($atts) {
  ob_start(); ?>
  <div class="gridjornadas">
    <h1><?php _e("Jornadas", 'koollective'); ?></h1>
    <?php $args = [
        'post_type' => 'jornada',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'suppress_filters' => false,
        'meta_key' => '_jornada_fechainicio',
        'orderby' => 'meta_value',
        'meta_type' => 'DATE',
        'order' => 'ASC',
        'meta_query' => [
          [
            'key' => '_jornada_fechafin',
            'value' => date('Y/m/d'),
            'compare' => '>=',
            'type' => 'DATE'
          ]
        ]
      ];
      $my_query = new WP_Query( $args ); ?>
    <p><?php printf(__("%d jornadas", 'koollective'), $my_query->found_posts); ?></p>
    <div>
      <?php if ( $my_query->have_posts() ) { ?>
        <?php while ( $my_query->have_posts() ) { $my_query->the_post(); $post_id = get_the_id(); 
            $local = get_post(get_post_meta($post_id, "_jornada_local", true)); ?>
            <div style="--bgimage: url(<?php echo wp_get_attachment_image_url(get_post_thumbnail_id($post_id), 'medium'); ?>);">
                <div>
                  <h2><?php the_title(); ?></h2>
                  <?php the_content(); ?>
                  <p><?php echo get_post_meta($post_id, "_jornada_fechainicio", true); ?></p>
                  <p><?php echo get_post_meta($post_id, "_jornada_fechafin", true); ?></p>
                  <p><a href='<?php echo get_post_meta($local->ID, "_local_linkgooglemap", true); ?>' target="_blank"><?php echo $local->post_title; ?></a></p>
                  <p><?php echo get_post_meta($local->ID, "_local_direccion", true); ?></p>
                </div>
                <div><?php
                  $args = [
                    'post_type' => 'actividad',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'suppress_filters' => false,
                    'meta_key' => '_actividad_fechahora',
                    'orderby' => 'meta_value',
                    'meta_type' => 'DATE',
                    'order' => 'ASC',
                    'meta_query' => [
                      [
                        'key' => '_actividad_jornada',
                        'value' => $post_id,
                        'compare' => '='
                      ]
                    ]
                  ];

                  $actividades = get_posts($args);
                  if(count($actividades) > 0) { ?>
                  <h3><?php _e("Actividades", 'koollective'); ?></h3>
                  <?php foreach($actividades as $actividad) { ?>
                    <div style="--bgimage: url(<?php echo wp_get_attachment_image_url(get_post_thumbnail_id($actividad->ID), 'medium'); ?>);">
                      <h4><?php echo $actividad->post_title; ?></h4>
                      <p><?php $fecha = get_post_meta($actividad->ID, "_actividad_fechahora", true); echo str_replace("T", " - ", $fecha); ?></p>
                      <?php echo apply_filters("the_content", get_post_meta($actividad->ID, "_actividad_resumen", true)); ?>
                      <?php if(strtotime("now") < strtotime($fecha)) { ?>
                        <a href="<?php echo get_the_permalink(INSCRIPTION_PAGE_ID); ?>?actividad=<?php echo $actividad->ID; ?>"><?php _e("Inscribirse", 'koollective'); ?></a>
                      <?php } ?>
                    </div>
                <?php } } ?></div>
            </div>
        <?php } ?>
      <?php } ?>
    </div>
  </div>
  <style>
    .gridjornadas {
      width: 100%;
    }

    .gridjornadas > div {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .gridjornadas > div > div {
      background-color: #cecece;
      padding: 20px 20px 20px 200px;
      position: relative;
      width: 100%;
      display: flex;
      gap: 10px;
      align-items: flex-start;
    }

    .gridjornadas > div > div:after {
      content: "";
      position: absolute;
      width: 180px;
      height: 100%;
      top: 0px;
      left: 0px;
      background: white var(--bgimage) center center no-repeat;
      background-size: cover;
    }

    .gridjornadas > div > div > div {
      display: flex;
      gap: 10px;
      width: 50%;
    }

    .gridjornadas > div > div > div:nth-of-type(1) {
      flex-wrap: wrap;
    }

    .gridjornadas > div > div > div:nth-of-type(2) {
      flex-wrap: wrap;
    }

    .gridjornadas > div > div > div:nth-of-type(2) > h3 {
      width: 100%;
      border-bottom: 1px solid black;
    }

    .gridjornadas > div > div > div:nth-of-type(2) > div {
      background-color: white;
      padding: 200px 10px 10px 10px;
      position: relative;
      width: calc(50% - 25px);
    }

    .gridjornadas > div > div > div:nth-of-type(2) > div:after {
      content: "";
      position: absolute;
      width: 100%;
      height: 190px;
      top: 0px;
      left: 0px;
      background: white var(--bgimage) center center no-repeat;
      background-size: cover;
    }
  </style>
  <?php return ob_get_clean(); // fin del nivel actual de buffer
});

add_shortcode('kollective_inscripcion', function ($atts) {
  ob_start(); 
  if(isset($_REQUEST['actividad']) && is_numeric($_REQUEST['actividad'])) { 
    $actividad = get_post($_REQUEST['actividad']); ?>
    <h2><?php echo $actividad->post_title; ?></h2>
    <p><?php $fecha = get_post_meta($actividad->ID, "_actividad_fechahora", true); echo str_replace("T", " - ", $fecha); ?></p>
    <?php echo apply_filters("the_content", get_post_meta($actividad->ID, "_actividad_resumen", true)); ?>
    <?php echo apply_filters("the_content", $actividad->post_content); ?>
    <?php if(strtotime("now") >= strtotime($fecha)) { return ob_get_clean(); } // inscripción cerrada ?>
    <?php $waitlist = false; if(kollective_is_waitlist($actividad)) { $waitlist = true; ?>
      <p style="border: 1px solid red; background-color: #fcbebe; padding: 20px;">
        <?php _e("El numero de asistentes está completo. Si te inscribes en esta actividad, entrarás en la lista de espera. Si se liberá espacio, nos pondremos en contacto contigo para avisarte.", 'koollective'); ?>
      </p>
    <?php } ?>
    <?php $form = [];
    foreach($_REQUEST as $key => $value) {
      if(is_array($value)) {
        $form[$key] = $value;
      } else $form[$key] = trim(strip_tags($value));
    }
    unset($form['inscripcion']);

    if(count($form) > 1) {
      $errors = [];

      //Errores
      if($form['nombre'] == '') {
        $errors[] = __("Debes de rellenar el campo «Nombre».", 'koollective');
      }

      if($form['apellidos'] == '') {
        $errors[] = __("Debes de rellenar el campo «Apellidos».", 'koollective');
      }

      if($form['dni'] == '') {
        $errors[] = __("Debes de rellenar el campo «DNI».", 'koollective');
      } else if (!preg_match('/^[0-9]{8}[A-Z]$/', $form['dni'])) {
        $errors[] = __("El «DNI» no tiene el formato adecuado. Solo deben ser 8 números y una letra en mayúsculas.", 'koollective');
      }
    
      if($form['email'] == '') {
        $errors[] = __("Debes de rellenar el campo «Email».", 'koollective');
      } else if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = __("El «Email» no tiene el formato adecuado.", 'koollective');
      }
    
      if($form['telefono'] == '') {
        $errors[] = __("Debes de rellenar el campo «Teléfono».", 'koollective');
      } else if (!preg_match("/^[0-9]{9}$/" ,$form['telefono'])) {
        $errors[] = __("El «Teléfono» no tiene el formato adecuado. Solo deben ser 9 números, sin letras, ni espacios, ni simbolos.", 'koollective');
      }

      if($form['codigopostal'] == '') {
        $errors[] = __("Debes de rellenar el campo «Código postal».", 'koollective');
      } else if (!preg_match("/^[0-9]{5}$/" ,$form['codigopostal'])) {
        $errors[] = __("El «Código postal» no tiene el formato adecuado. Solo deben ser 5 números.", 'koollective');
      } 
    
      if($form['ciudad'] == '') {
        $errors[] = __("Debes de rellenar el campo «Ciudad».", 'koollective');
      } 

      if($form['comoconocioevento'] == '') {
        $errors[] = __("Debes de rellenar el campo «¿Cómo conoció el evento?».", 'koollective');
      } 

      if($form['hasparticipadootroevento'] == '') {
        $errors[] = __("Debes de rellenar el campo «¿Ha participado en otros eventos?».", 'koollective');
      }

      if($form['aceptopoliticaprivacidad'] == '') {
        $errors[] = __("Debes aceptar la política de privacidad.", 'koollective');
      } 
      
      if(count($errors) > 0) { ?>
        <p style="border: 1px solid red; background-color: #cecece; padding: 20px;">
          <?php echo implode("<br/>", $errors); ?>
        </p>
      <?php } else {
        if(!kollective_is_inscripted($form, $actividad)) {
          if(kollective_can_inscript($form['dni'], $actividad)) { //Miramos si se puede inscribirse o no
            if(kollective_inscript($form, $actividad)) { ?>
                <p style="border: 1px solid green; background-color: #a8fa98; padding: 20px;">
                  <?php if($waitlist) { ?>
                    <?php _e("Estás inscrito en la lista de espera de esta actividad. Recibirás un email de confirmación con los datos de la actividad.", 'koollective'); ?>
                  <?php } else { ?>
                    <?php _e("Estás inscrito en esta actividad. Recibirás un email de confirmación con los datos de la actividad.", 'koollective'); ?>
                  <?php } ?>
                </p>
              <?php //Mandamos emails
              kollective_send_admin_email($form, $actividad);
              if($waitlist) kollective_send_waitllist_user_email($form, $actividad);
              else kollective_send_user_email($form, $actividad);
              $form = kollective_reset_form($form);
            }
          } else { $form = kollective_reset_form($form); ?>
            <p style="border: 1px solid red; background-color: #fcbebe; padding: 20px;">
              <?php _e("Lo sentimos, has superado el limite de actividades a las que te puedes apuntar de esta jornada.", 'koollective'); ?>
            </p>
          <?php }
        } else { $form = kollective_reset_form($form); ?>
            <p style="border: 1px solid red; background-color: #fcbebe; padding: 20px;">
              <?php _e("Lo sentimos, ya estás inscrito en esta actividad con anterioridad. Revisa tu correo para encontrar tu confirmación. Puede que esté en la carpeta de SPAM.", 'koollective'); ?>
            </p>
        <?php }
      }
    } ?>
    <form id="forminscripcion" method="post">
      <input type="hidden" name="actividad" value="<?= $form['actividad']; ?>" />
      <label>
        <?php _e("Nombre", 'koollective'); ?> *
        <input type="text" name="nombre" value="<?=(isset($form['nombre']) ? $form['nombre'] : "") ?>" placeholder="<?php _e("Introduce tu nombre", 'koollective'); ?>" required />
      </label>
      <label>
        <?php _e("Apellidos", 'koollective'); ?> *
        <input type="text" name="apellidos" value="<?=(isset($form['apellidos']) ? $form['apellidos'] : "") ?>" placeholder="<?php _e("Introduce tus apellidos", 'koollective'); ?>" required />
      </label>
      <label>
        <?php _e("DNI", 'koollective'); ?> *
        <input type="text" name="dni" value="<?=(isset($form['dni']) ? $form['dni'] : "") ?>" placeholder="<?php _e("Introduce tu DNI con letra", 'koollective'); ?>" maxlength="9" required />
      </label>
      <label>
        <?php _e("Email", 'koollective'); ?> *
        <input type="email" name="email" value="<?=(isset($form['email']) ? $form['email'] : "") ?>" placeholder="<?php _e("Introduce tu email", 'koollective'); ?>" required />
      </label>
      <label>
        <?php _e("Teléfono", 'koollective'); ?> *
        <input type="text" name="telefono" value="<?=(isset($form['telefono']) ? $form['telefono'] : "") ?>" placeholder="<?php _e("Introduce tu telefono", 'koollective'); ?>" maxlength="9" required />
      </label>
      <label>
        <?php _e("Fecha de nacimiento", 'koollective'); ?>
        <input type="date" name="fechanacimiento" value="<?=(isset($form['fechanacimiento']) ? $form['fechanacimiento'] : "") ?>" />
      </label>
      <label>
        <?php _e("Dirección", 'koollective'); ?>
        <input type="text" name="direccion" value="<?=(isset($form['direccion']) ? $form['direccion'] : "") ?>" placeholder="<?php _e("Introduce tu dirección", 'koollective'); ?>" />
      </label>
      <label>
        <?php _e("Código postal", 'koollective'); ?> *
        <input type="text" name="codigopostal" value="<?=(isset($form['codigopostal']) ? $form['codigopostal'] : "") ?>" placeholder="<?php _e("Introduce tu código postal", 'koollective'); ?>" maxlength="5" required />
      </label>
      <label>
        <?php _e("Cíudad", 'koollective'); ?> *
        <input type="text" name="ciudad" value="<?=(isset($form['ciudad']) ? $form['ciudad'] : "") ?>" placeholder="<?php _e("Introduce tu ciudad", 'koollective'); ?>" required />
      </label>
      <label>
        <?php _e("¿Cómo conoció el evento?", 'koollective'); ?> *
        <textarea name="comoconocioevento" placeholder="<?php _e("Máximo 120 caracteres.", 'koollective'); ?>" maxlength="120" required><?=(isset($form['comoconocioevento']) ? $form['comoconocioevento'] : "") ?></textarea>
      </label>
      <label>
        <?php _e("¿Ha participado en otros eventos?", 'koollective'); ?><br/>
        <label><input type="radio" name="hasparticipadootroevento" value="Sí" checked="checked" /> <?php _e("Sí", 'koollective'); ?></label><br/>
        <label><input type="radio" name="hasparticipadootroevento" value="No" /> <?php _e("No", 'koollective'); ?></label>
      </label>
      <label>
        <?php _e("¿En qué tienda Koopera compras habitualmente?", 'koollective'); ?> *
        <input type="text" name="tiendacompras" value="<?=(isset($form['ciudad']) ? $form['ciudad'] : "") ?>" placeholder="<?php _e("Introduce el nombre de la tienda", 'koollective'); ?>" required />
      </label>
      <div class="doble">
        <?php _e("¿Qué te interesa más de nuestras actividades?", 'koollective'); ?><br/>
        <label><input type="checkbox" name="interes[]" value="Moda sostenible"<?=(isset($form['interes']) && in_array("Moda sostenible", $form['interes']) ? " checked='checked'" : "") ?> /> <?php _e("Moda sostenible", 'koollective'); ?></label><br/>
        <label><input type="checkbox" name="interes[]" value="Economía circular"<?=(isset($form['interes']) && in_array("Economía circular", $form['interes']) ? " checked='checked'" : "") ?> /> <?php _e("Economía circular", 'koollective'); ?></label><br/>
        <label><input type="checkbox" name="interes[]" value="Eventos / encuentros"<?=(isset($form['interes']) && in_array("Eventos / encuentros", $form['interes']) ? " checked='checked'" : "") ?> /> <?php _e("Eventos / encuentros", 'koollective'); ?></label><br/>
        <label><input type="checkbox" name="interes[]" value="Talleres / formación"<?=(isset($form['interes']) && in_array("Talleres / formación", $form['interes']) ? " checked='checked'" : "") ?> /> <?php _e("Talleres / formación", 'koollective'); ?></label><br/>
        <label><input type="checkbox" name="interes[]" value="Segunda mano / vintage"<?=(isset($form['interes']) && in_array("Segunda mano / vintage", $form['interes']) ? " checked='checked'" : "") ?> /> <?php _e("Segunda mano / vintage", 'koollective'); ?></label> 
      </div>
      <label>        
        <input type="checkbox" name="aceptorecibirinformacion"<?=(isset($form['aceptorecibirinformacion']) ? " checked='checked'" : "") ?> value="Acepto recibir información" />
        <?php _e("Acepto recibir información sobre actividades, eventos y novedades de Koopera.", 'koollective'); ?>
      </label>
      <div>
        <?php _e("¿Cómo prefieres recibir información?", 'koollective'); ?><br/>
        <label><input type="checkbox" name="metodorecibirinformacion[]" value="Email"<?=(isset($form['metodorecibirinformacion']) && in_array("Email", $form['metodorecibirinformacion']) ? " checked='checked'" : "") ?> /> <?php _e("Email", 'koollective'); ?></label><br/>
        <label><input type="checkbox" name="metodorecibirinformacion[]" value="WhatsApp"<?=(isset($form['metodorecibirinformacion']) && in_array("WhatsApp", $form['metodorecibirinformacion']) ? " checked='checked'" : "") ?> /> <?php _e("WhatsApp", 'koollective'); ?></label><br/>
        <label><input type="checkbox" name="metodorecibirinformacion[]" value="SMS"<?=(isset($form['metodorecibirinformacion']) && in_array("SMS", $form['metodorecibirinformacion']) ? " checked='checked'" : "") ?> /> <?php _e("SMS", 'koollective'); ?></label>
      </div>
      <div class="doble">       
        <label><input type="checkbox" name="aceptopoliticaprivacidad" value="Acepto la política de privacidad." required />
        <?php _e("Acepto la política de privacidad.", 'koollective'); ?></label>
      </div>
      <button type="submit" name="inscripcion"><?php _e("Inscribirse", 'koollective'); ?></button>
    </form>
    <style>
      #forminscripcion {
        max-width: 800px;
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
      }

      #forminscripcion > label,
      #forminscripcion > div {
        display: block;
        width: calc(50% - 10px);
      }

      #forminscripcion > div.doble {
        width: 100%;
      }

      #forminscripcion > label > *:is(input[type=text],input[type=date],input[type=email],textarea) {
        width: 100%;
      }

      #forminscripcion > button {
        width: 100%;
      }
    </style>
  <?php }
  return ob_get_clean(); // fin del nivel actual de buffer
});

function kollective_can_inscript($dni, $actividad) {
  $jornada = get_post(get_post_meta($actividad->ID, "_actividad_jornada", true));
  $maxinscripciones = get_post_meta($jornada->ID, "_jornada_maxinscripciones", true);
  $inscripciones = 0;
  $args = [
    'post_type' => 'actividad',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'suppress_filters' => false,
    'meta_key' => '_actividad_fechahora',
    'orderby' => 'meta_value',
    'meta_type' => 'DATE',
    'order' => 'ASC',
    'meta_query' => [
      [
        'key' => '_actividad_jornada',
        'value' => $jornada->ID,
        'compare' => '='
      ]
    ]
  ];
  $actividades = get_posts($args);
  if(count($actividades) > 0) {
    foreach($actividades as $actividad) {
      $inscritos = get_post_meta($actividad->ID, "_actividad_inscritos", true);
      if(is_array($inscritos) && count($inscritos) > 0) {
        foreach($inscritos as $inscrito) {
          if($inscrito['dni'] == $dni) $inscripciones++;
        }
      }
    }
  }
  if($inscripciones >= $maxinscripciones) return false;
  else return true;
}

function kollective_is_inscripted($form, $actividad) {
  $inscritos = get_post_meta($actividad->ID, "_actividad_inscritos", true);
  if(is_array($inscritos) && count($inscritos) > 0) {
    foreach($inscritos as $inscrito) {
      if($inscrito['dni'] == $form['dni']) return true;
    }
  }
  return false;
}

function kollective_inscript($form, $actividad) {
  $inscritos = get_post_meta($actividad->ID, "_actividad_inscritos", true);
  if(is_array($inscritos) && count($inscritos) > 0) {
    $inscritos[] = $form;
  } else {
    $inscritos = [];
    $inscritos[] = $form;
  }
  update_post_meta($actividad->ID, "_actividad_inscritos", $inscritos);
  return true;
}

function kollective_reset_form($form) {
  $actividad = $form['actividad'];
  unset ($form);
  $form['actividad'] = $actividad;
  return $form;
}

function kollective_is_waitlist($actividad) {
  $maxinscripciones = get_post_meta($actividad->ID, "_actividad_maxinscripciones", true);
  $inscritos = get_post_meta($actividad->ID, "_actividad_inscritos", true);
  if(is_array($inscritos) && count($inscritos) >= $maxinscripciones) return true;
  else return false;
}

function kollective_send_admin_email($form, $actividad) { //TODO
  $headers = [
    'Content-Type: text/html; charset=UTF-8'
  ];
  $subject = "Nuevo inscrito en ".$actividad->post_title;
  $message = "<a href='".get_edit_post_link($actividad->ID)."'>".$actividad->post_title."</a><br/><br/><br/><ul>";
  foreach($form as $key => $value) {
    $message .="<li><b>".$key.":</b> ".(is_array($value) ? implode(", ", $value) : $value)."</li>";
  }
  $message .="</ul>";
  $emails = explode(",", INSCRIPTION_ADMIN_EMAIL);
  foreach($emails as $email) {
    wp_mail(trim($email), $subject, $message, $headers);
  }
}

function kollective_send_user_email($form, $actividad) { //TODO
  $headers = [
    'Content-Type: text/html; charset=UTF-8'
  ];
  $subject = sprintf(__("Te has inscrito en la actividad «%s»", 'koollective'), $actividad->post_title);
  $message = sprintf(__("Te has inscrito en la actividad «%s»", 'koollective'), $actividad->post_title);
  wp_mail($form['email'], $subject, $message, $headers);
}

function kollective_send_waitllist_user_email($form, $actividad) { //TODO
  $headers = [
    'Content-Type: text/html; charset=UTF-8'
  ];
  $subject = sprintf(__("Te has inscrito en la lista de espera de la actividad «%s»", 'koollective'), $actividad->post_title);
  $message = sprintf(__("Te has inscrito en la lista de espera de la actividad «%s»", 'koollective'), $actividad->post_title);
  wp_mail($form['email'], $subject, $message, $headers);
}

// ADMIN-AJAX exportar a csv
// /wp-admin/admin-ajax.php?action=koollective-export&actividad=[actividad_id]
add_action( 'wp_ajax_koollective-export', 'koollective_export_csv');

function koollective_export_csv() {
  if(isset($_REQUEST['actividad']) && is_numeric($_REQUEST['actividad'])) {
    $actividad = get_post($_REQUEST['actividad']);
    $maxinscripciones = get_post_meta($actividad->ID, '_actividad_maxinscripciones', true);
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=".$actividad->post_name."_".date("Y-m-d_His").".csv");
    $inscritos = get_post_meta($_REQUEST['actividad'], "_actividad_inscritos", true);
    $csv = "Nombre,Apellidos,DNI,Email,Teléfono,Fecha de nacimiento,Dirección,Código postal,Ciudad,¿Cómo conoció el evento?,¿Ha participado en otros eventos?,¿En qué tienda Koopera compras habitualmente?,¿Qué te interesa más de nuestras actividades?,\"Acepto recibir información sobre actividades, eventos y novedades de Koopera.\",¿Cómo prefieres recibir información?\n";
    $csv .= "INSCRITOS --------------------------------\n";
    $counter = 1;
    foreach($inscritos as $inscrito) {
      $csv .= '"'.addslashes($inscrito['nombre']).'",';
      $csv .= '"'.addslashes($inscrito['apellidos']).'",';
      $csv .= $inscrito['dni'].",";
      $csv .= $inscrito['email'].",";
      $csv .= $inscrito['telefono'].",";
      $csv .= (isset($inscrito['fechanacimiento']) ? $inscrito['fechanacimiento'] : "").",";
      $csv .= (isset($inscrito['direccion']) ? '"'.addslashes($inscrito['direccion']).'"' : "").",";
      $csv .= $inscrito['codigopostal'].",";
      $csv .= '"'.addslashes($inscrito['ciudad']).'",';
      $csv .= (isset($inscrito['comoconocioevento']) ? '"'.addslashes($inscrito['comoconocioevento']).'"' : "").",";
      $csv .= $inscrito['hasparticipadootroevento'].",";
      $csv .= '"'.addslashes($inscrito['tiendacompras']).'",';
      $csv .= (isset($inscrito['interes']) && is_array($inscrito['interes']) ? implode("|", $inscrito['interes']) : "").",";
      $csv .= (isset($inscrito['aceptorecibirinformacion']) ? $inscrito['aceptorecibirinformacion'] : "").",";
      $csv .= (isset($inscrito['metodorecibirinformacion']) && is_array($inscrito['metodorecibirinformacion']) ? implode("|", $inscrito['metodorecibirinformacion']) : "").",";
      $csv .= "\n";
      if($counter == $maxinscripciones) $csv .= "LISTA DE ESPERA --------------------------------\n";
      $counter++;
    }
    echo $csv;
    wp_die();
  }
}