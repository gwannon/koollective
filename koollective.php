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
  <section id="listado">
    <?php $args = [
        'hide_empty' => 1,
      ];
      $ciudades = get_terms('ciudad', $args ); 
      foreach($ciudades as $ciudad) { if($ciudad->parent != 0) { $counter_actividades = 0; ?>
        <span id="<?php echo $ciudad->slug; ?>" class="py-4 ancla_fixed"></span>
        <div class="row sectionverde">
          <div class="col-9">
            <h2>PRÓXIMOS EVENTOS <?php echo strtoupper($ciudad->name); ?></h2>
          </div>
          <div class="col-3">
            <p class="m-0 "><a href="#<?php echo $ciudad->slug; ?>" class="showpastevents d-flex justify-content-end"><img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images/ico_anterior.png" alt="" aria-hidden="true"><span> Ver eventos<br>anteriores</span></a></p>
          </div>
        </div>
        <?php //Sacamos los locales de cada ciudad
          $args = [
            'post_type' => 'local',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'suppress_filters' => false,
            'tax_query' => [
              [
                'taxonomy' => 'ciudad',
                'field' => 'term_id', 
                'terms' => $ciudad->term_id,
              ]
            ]
          ];  
          $locales = get_posts($args);
          foreach($locales as $local) {
            //Sacamos las actividades de cada ciudad
            $args = [
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
                  'key' => '_jornada_local',
                  'value' => $local->ID,
                  'compare' => '='
                ]
              ]
            ];
            $jornadas = get_posts($args);
            foreach($jornadas as $jornada){ ?>
              <ul class="container experiencias <?php echo $ciudad->slug; ?>">
                <span id="<?php echo $jornada->post_name; ?>" class="ancla_fixed"></span>
                <?php //Sacamos las actividades de cada ciudad
                $args = [
                  'post_type' => 'actividad',
                  'posts_per_page' => -1,
                  'post_status' => 'publish',
                  'suppress_filters' => false,
                  'meta_key' => '_actividad_fechahora',
                  'orderby' => 'meta_value',
                  'meta_type' => 'DATE',
                  'order' => 'DESC',
                  'meta_query' => [
                    [
                      'key' => '_actividad_jornada',
                      'value' => $jornada->ID,
                      'compare' => '='
                    ]
                  ]
                ];
                $actividades = get_posts($args);
                foreach($actividades as $actividad) { $fecha = get_post_meta($actividad->ID, "_actividad_fechahora", true); 
                  if(strtotime("now") <= strtotime($fecha)) $counter_actividades++;?>
                  <li class="row <?php echo $ciudad->slug; ?> py-3<?php echo (strtotime("now") >= strtotime($fecha) ? " pastevent d-none" : "" ); ?>">
                    <div class="col-12  col-md-2  d-flex align-items-center flex-column justify-content-center pt-5 pt-md-0">
                      <span class="text-size50"><?php echo date("d", strtotime($fecha)); ?></span> <span class="text-size20 d-block mt-3"><?php _e(date("F", strtotime($fecha))); ?></span>
                      <p class="mt-5 white text-center"><?php echo $jornada->post_title; ?></p>
                    </div>
                    <div class="col-12 col-md-7">
                      <h3 class="fonttitulo"><?php echo $actividad->post_title; ?></h3>
                      <ul class="fechahora mb-4">
                        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images/hora.svg" class="white" alt=""><?php echo date("H:i", strtotime($fecha)); ?></li>
                        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images/localition.svg" alt="" class="white"><a href='<?php echo get_post_meta($local->ID, "_local_linkgooglemap", true); ?>' target="_blank"><?php echo $local->post_title; ?></a></li>
                      </ul>
                      <?php echo apply_filters("the_content", get_post_meta($actividad->ID, "_actividad_resumen", true)); ?>
                    </div>
                    <div class="col-12 col-md-3  d-flex  align-items-center  justify-content-center">
                      <?php if(strtotime("now") < strtotime($fecha) && get_post_meta($actividad->ID, "_actividad_estado_inscripcion", true) != "cerrada") { ?>
                      <p><a href="<?php echo get_the_permalink(INSCRIPTION_PAGE_ID); ?>?actividad=<?php echo $actividad->ID; ?>" class="btn btn_secondary mt-4 mt-md-0"><?php _e("INFORMACIÓN Y RESERVA", 'koollective'); ?></a></p>
                      <?php } ?>
                    </div>
                  </li>
                <?php } ?>  
              </ul>         
            <?php }
          } 
          if($counter_actividades == 0) { ?>
            <p style="margin-top: 3px;"><?php _e("No hay próximo eventos en esta ciudad.", 'koollective'); ?></p>
          <?php } 
      } } ?>
    </section>
    <script>
      jQuery(".showpastevents").click(function (e) {
        e.preventDefault();
        var ciudad = jQuery(this).attr("href").substring(1);
        if(jQuery("." +ciudad + ".experiencias .row.pastevent").hasClass("d-none")) {
          jQuery("." +ciudad + ".experiencias .row.pastevent").removeClass("d-none");
          jQuery(this).children("span").html("OCULTAR EVENTOS<br/>ANTERIORES");
        } else {
          jQuery("." +ciudad + ".experiencias .row.pastevent").addClass("d-none");
          jQuery(this).children("span").html("VER EVENTOS<br/>ANTERIORES");
        }
      });
    </script>
  <?php return ob_get_clean(); // fin del nivel actual de buffer
});




























add_shortcode('kollective_inscripcion', function ($atts) {
  ob_start(); 
  if(isset($_REQUEST['actividad']) && is_numeric($_REQUEST['actividad'])) { 
    $actividad = get_post($_REQUEST['actividad']); 
    $fecha = get_post_meta($actividad->ID, "_actividad_fechahora", true);
    $jornada = get_post(get_post_meta($actividad->ID, "_actividad_jornada", true));
    $local = get_post(get_post_meta($jornada->ID, "_jornada_local", true)); ?>
      <section>
        <div class="container mt-5"></div>
        <div class="container experiencias">
          <div class="row">
            <span id="info" class="ancla_fixed" style="scroll-margin-top: 178px;"></span>
            <div class="col-12  col-md-2  d-flex align-items-center flex-column justify-content-center pt-5 pt-md-0 fechadata mb-5">
              <span class="text-size50"><?php echo date("d", strtotime($fecha)); ?></span> <span class="text-size20 d-block mt-3"><?php _e(date("F", strtotime($fecha))); ?></span>
              <p class="mt-5 white text-center"><?php echo $jornada->post_title; ?></p>
            </div>
            <div class="col-12 col-md-6 pl-4">
              <h1 class="fonttitulo"><?php echo $actividad->post_title; ?></h1>
                <ul class="fechahora mb-4">
                  <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images/hora.svg" class="white" alt=""><?php echo date("H:i", strtotime($fecha)); ?></li>
                  <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/koollective-nuevo/images/localition.svg" alt="" class="white"><a href='<?php echo get_post_meta($local->ID, "_local_linkgooglemap", true); ?>' target="_blank"><?php echo $local->post_title; ?></a></li>
                </ul>
                <?php echo apply_filters("the_content", $actividad->post_content); ?>
            </div>
            <div class="col-12  col-md-4">
              <?php if(has_post_thumbnail($actividad->ID)) { ?>
                <img src="<?php echo get_the_post_thumbnail_url($actividad->ID, 'large'); ?>" class="rounded d-block w-100 " alt="<?php echo $actividad->post_title; ?>">
              <?php } ?>
            </div>
          </div>
        </div>
      </section>
      <div id="viewform" style="min-height: 100px;"> </div>
    <?php if(strtotime("now") >= strtotime($fecha) || get_post_meta($actividad->ID, "_actividad_estado_inscripcion", true) == "cerrada") { return ob_get_clean(); } // inscripción cerrada ?>
    <div class="container mt-5">
      <div class="row">
        <div class="col-12  col-md-2  "></div>
        <div class="col-12  col-md-10 pl-4">
          <form id="forminscripcion" method="post" action="#viewform">
            <input type="hidden" name="actividad" value="47">
            <div class="row">
              <div class="col-12">
                <span id="formulario" class="py-2 ancla_fixed"></span>
                <h2>Formulario de inscripción</h2>






                <?php $waitlist = false; if(kollective_is_waitlist($actividad)) { $waitlist = true; ?>
                  <div class="alert alert-danger">
                    <div class="alert-icon">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                        </path>
                      </svg>
                    </div>
                    <div class="alert-content">
                      <p class="alert-title"><?php _e("El numero de asistentes está completo.", 'koollective'); ?></p>
                      <p class="alert-description"><?php _e("Si te inscribes en esta actividad, entrarás en la lista de espera. Si se liberá espacio, nos pondremos en contacto contigo para avisarte.", 'koollective'); ?></p>
                    </div>
                    <span class="closeButton" onclick="this.parentElement.style.display='none';">×</span>
                  </div>
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
                  } else if (!validDniCifNie($form['dni'])) {
                    $errors[] = __("El «DNI/NIE» no tiene el formato adecuado. Recuerda que las letras deben ser en mayúsculas.", 'koollective');
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
                    <div class="alert alert-danger">
                      <div class="alert-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                          </path>
                        </svg>
                      </div>
                      <div class="alert-content">
                        <p class="alert-title"><?php _e("Error", 'koollective'); ?></p>
                        <p class="alert-description"><?php echo implode("<br/>", $errors); ?></p>
                      </div>
                      <span class="closeButton" onclick="this.parentElement.style.display='none';">×</span>
                    </div>
                  <?php } else {
                    if(!kollective_is_inscripted($form, $actividad)) {
                      if(kollective_can_inscript($form['dni'], $actividad)) { //Miramos si se puede inscribirse o no
                        if(kollective_inscript($form, $actividad)) { ?>
                          <div class="alert alert-success">
                            <div class="alert-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z">
                                </path>
                              </svg>
                            </div>
                            <div class="alert-content">
                              <p class="alert-title"><?php _e("Inscripción correcta", 'koollective'); ?></p>
                              <p class="alert-description">
                                <?php if($waitlist) { ?>
                                  <?php _e("Estás inscrito en la lista de espera de esta actividad. Recibirás un email de confirmación con los datos de la actividad. Tan pronto se libere espacio, nos pondremos en contacto contigo para avisarte.", 'koollective'); ?>
                                <?php } else { ?>
                                  <?php _e("Estás inscrito en esta actividad. Recibirás un email de confirmación con los datos de la actividad.", 'koollective'); ?>
                                <?php } ?>
                              </p>
                            </div>
                            <span class="closeButton" onclick="this.parentElement.style.display='none';">×</span>
                          </div>
                          <?php //Mandamos emails
                          kollective_send_admin_email($form, $actividad);
                          if($waitlist) kollective_send_waitllist_user_email($form, $actividad);
                          else kollective_send_user_email($form, $actividad);
                          $form = kollective_reset_form($form);
                        }
                      } else { $form = kollective_reset_form($form); ?>
                        <div class="alert alert-danger">
                          <div class="alert-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                              </path>
                            </svg>
                          </div>
                          <div class="alert-content">
                            <p class="alert-title"><?php _e("Error", 'koollective'); ?></p>
                            <p class="alert-description"><?php _e("Lo sentimos, has superado el limite de actividades a las que te puedes apuntar de esta jornada.", 'koollective'); ?></p>
                          </div>
                          <span class="closeButton" onclick="this.parentElement.style.display='none';">×</span>
                        </div>
                      <?php }
                    } else { $form = kollective_reset_form($form); ?>
                      <div class="alert alert-danger">
                        <div class="alert-icon">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                            </path>
                          </svg>
                        </div>
                        <div class="alert-content">
                          <p class="alert-title"><?php _e("Error", 'koollective'); ?></p>
                          <p class="alert-description"><?php _e("Lo sentimos, ya estás inscrito en esta actividad con anterioridad. Revisa tu correo para encontrar tu confirmación. Puede que esté en la carpeta de SPAM.", 'koollective'); ?></p>
                        </div>
                        <span class="closeButton" onclick="this.parentElement.style.display='none';">×</span>
                      </div>
                    <?php }
                  }
                } ?>
              </div>
              <input type="hidden" name="actividad" value="<?= $form['actividad']; ?>" />
              <div class="col-12 col-md-4">
                <label>
                  <?php _e("Nombre", 'koollective'); ?> *
                  <input type="text" name="nombre" value="<?=(isset($form['nombre']) ? $form['nombre'] : "") ?>" placeholder="<?php _e("Introduce tu nombre", 'koollective'); ?>" required />
                </label>
              </div>
              <div class="col-12 col-md-4">
                <label>
                  <?php _e("Apellidos", 'koollective'); ?> *
                  <input type="text" name="apellidos" value="<?=(isset($form['apellidos']) ? $form['apellidos'] : "") ?>" placeholder="<?php _e("Introduce tus apellidos", 'koollective'); ?>" required />
                </label>
              </div>
              <div class="col-12 col-md-4">
                <label>
                  <?php _e("DNI/NIE", 'koollective'); ?> *
                  <input type="text" name="dni" value="<?=(isset($form['dni']) ? $form['dni'] : "") ?>" placeholder="<?php _e("Introduce tu DNI/NIE con letras mayúsculas", 'koollective'); ?>" maxlength="9" required />
                </label>
              </div>
              <div class="col-12 col-md-4">
                <label>
                  <?php _e("Email", 'koollective'); ?> *
                  <input type="email" name="email" value="<?=(isset($form['email']) ? $form['email'] : "") ?>" placeholder="<?php _e("Introduce tu email", 'koollective'); ?>" required />
                </label>
              </div>
              <div class="col-12 col-md-4">
                <label>
                  <?php _e("Teléfono", 'koollective'); ?> *
                  <input type="text" name="telefono" value="<?=(isset($form['telefono']) ? $form['telefono'] : "") ?>" placeholder="<?php _e("Introduce tu telefono", 'koollective'); ?>" maxlength="9" required />
                </label>
              </div>
              <div class="col-12 col-md-4">
                <label>
                  <?php _e("Fecha de nacimiento", 'koollective'); ?>
                  <input type="date" name="fechanacimiento" value="<?=(isset($form['fechanacimiento']) ? $form['fechanacimiento'] : "") ?>" />
                </label>
              </div>
              <div class="col-12 col-md-12">
                <label>
                  <?php _e("Dirección", 'koollective'); ?>
                  <input type="text" name="direccion" value="<?=(isset($form['direccion']) ? $form['direccion'] : "") ?>" placeholder="<?php _e("Introduce tu dirección", 'koollective'); ?>" />
                </label>
              </div>
              <div class="col-12 col-md-4">
                <label>
                  <?php _e("Código postal", 'koollective'); ?> *
                  <input type="text" name="codigopostal" value="<?=(isset($form['codigopostal']) ? $form['codigopostal'] : "") ?>" placeholder="<?php _e("Introduce tu código postal", 'koollective'); ?>" maxlength="5" required />
                </label>
              </div>
              <div class="col-12 col-md-8">
                <label>
                  <?php _e("Cíudad", 'koollective'); ?> *
                  <input type="text" name="ciudad" value="<?=(isset($form['ciudad']) ? $form['ciudad'] : "") ?>" placeholder="<?php _e("Introduce tu ciudad", 'koollective'); ?>" required />
                </label>
              </div>
              <div class="col-12 col-md-6">
                <label>
                  <?php _e("¿En qué tienda Koopera compras habitualmente?", 'koollective'); ?> *
                  <input type="text" name="tiendacompras" value="<?=(isset($form['ciudad']) ? $form['ciudad'] : "") ?>" placeholder="<?php _e("Introduce el nombre de la tienda", 'koollective'); ?>" required />
                </label>
              </div>
              <div class="col-12 col-md-6">
                <label>
                  <?php _e("¿Ha participado en otros eventos?", 'koollective'); ?>
                  <div class="py">
                    <label class="m-0"><input type="radio" class="option-input" name="hasparticipadootroevento" value="Sí" checked="checked" /> <?php _e("Sí", 'koollective'); ?></label>
                    <label class="m-0"><input type="radio" class="option-input" name="hasparticipadootroevento" value="No" /> <?php _e("No", 'koollective'); ?></label>
                  </div>
                </label>
              </div>
              <div class="col-12 col-md-6">
                <label>
                  <?php _e("¿Cómo conoció el evento?", 'koollective'); ?> *
                  <textarea name="comoconocioevento" placeholder="<?php _e("Máximo 120 caracteres.", 'koollective'); ?>" maxlength="120" required><?=(isset($form['comoconocioevento']) ? $form['comoconocioevento'] : "") ?></textarea>
                </label>
              </div>

              <div class="col-12 col-md-6">
                <label>
                  <?php _e("¿Qué te interesa más de nuestras actividades?", 'koollective'); ?><br/>
                  <div class="py flex-column">
                    <label class="m-0"><input type="checkbox" class="option-input" name="interes[]" value="Moda sostenible"<?=(isset($form['interes']) && in_array("Moda sostenible", $form['interes']) ? " checked='checked'" : "") ?> /> <?php _e("Moda sostenible", 'koollective'); ?></label>
                    <label class="m-0"><input type="checkbox" class="option-input" name="interes[]" value="Economía circular"<?=(isset($form['interes']) && in_array("Economía circular", $form['interes']) ? " checked='checked'" : "") ?> /> <?php _e("Economía circular", 'koollective'); ?></label>
                    <label class="m-0"><input type="checkbox" class="option-input" name="interes[]" value="Eventos / encuentros"<?=(isset($form['interes']) && in_array("Eventos / encuentros", $form['interes']) ? " checked='checked'" : "") ?> /> <?php _e("Eventos / encuentros", 'koollective'); ?></label>
                    <label class="m-0"><input type="checkbox" class="option-input" name="interes[]" value="Talleres / formación"<?=(isset($form['interes']) && in_array("Talleres / formación", $form['interes']) ? " checked='checked'" : "") ?> /> <?php _e("Talleres / formación", 'koollective'); ?></label>
                    <label class="m-0"><input type="checkbox" class="option-input" name="interes[]" value="Segunda mano / vintage"<?=(isset($form['interes']) && in_array("Segunda mano / vintage", $form['interes']) ? " checked='checked'" : "") ?> /> <?php _e("Segunda mano / vintage", 'koollective'); ?></label>
                </div>
              </label>
            </div>
            <div class="col-12">
              <label>        
                <input type="checkbox" class="option-input" name="aceptorecibirinformacion"<?=(isset($form['aceptorecibirinformacion']) ? " checked='checked'" : "") ?> value="Acepto recibir información" />
                <?php _e("Acepto recibir información sobre actividades, eventos y novedades de Koopera.", 'koollective'); ?>
              </label>
            </div>
            <div id="metodorecibirinformacion" class="col-12 col-md-6<?=(isset($form['aceptorecibirinformacion']) ? "" : " d-none") ?>">
              <label><?php _e("¿Cómo prefieres recibir información?", 'koollective'); ?>
                <div class="py flex-column">
                  <label class="m-0"><input type="checkbox" class="option-input" name="metodorecibirinformacion[]" value="Email"<?=(isset($form['metodorecibirinformacion']) && in_array("Email", $form['metodorecibirinformacion']) ? " checked='checked'" : "") ?> /> <?php _e("Email", 'koollective'); ?></label>
                  <label class="m-0"><input type="checkbox" class="option-input" name="metodorecibirinformacion[]" value="WhatsApp"<?=(isset($form['metodorecibirinformacion']) && in_array("WhatsApp", $form['metodorecibirinformacion']) ? " checked='checked'" : "") ?> /> <?php _e("WhatsApp", 'koollective'); ?></label>
                  <label class="m-0"><input type="checkbox" class="option-input" name="metodorecibirinformacion[]" value="SMS"<?=(isset($form['metodorecibirinformacion']) && in_array("SMS", $form['metodorecibirinformacion']) ? " checked='checked'" : "") ?> /> <?php _e("SMS", 'koollective'); ?></label>
                </div>
              </label>
            </div>
            <div class="col-12">       
              <label><input type="checkbox" class="option-input" name="aceptopoliticaprivacidad" value="Acepto la política de privacidad." required />
              <?php _e("Acepto la política de privacidad.", 'koollective'); ?></label>
            </div>
            <div class="col-12 pt-5 text-center">
              <button type="submit" name="inscripcion"><?php _e("Inscribirse", 'koollective'); ?></button>
            </div>
          </form>
        </div>
      </div>
    <script>
      jQuery('input[name="aceptorecibirinformacion"]').on('change', function() {
        if(jQuery(this).is(':checked')) {
          jQuery('#metodorecibirinformacion').removeClass('d-none');
        } else {
          jQuery('#metodorecibirinformacion').addClass('d-none');
        }
      });
    </script>
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


/**
 * Validar DNI (NIF), CIF, NIE
 *
 * @param string $dni Número de identificación
 *
 * @return bool Si es válido (true) o no (false)
 */
function validDniCifNie($dni) {
    $dni = strtoupper($dni); // Convertir a mayúsculas
    $letras = 'TRWAGMYFPDXBNJZSQVHLCKE';

    // Validar formato general
    if (!preg_match('/^[A-Z0-9]{9}$/', $dni)) {
        return false;
    }

    // Validar NIF estándar (8 números + 1 letra)
    if (preg_match('/^[0-9]{8}[A-Z]$/', $dni)) {
        $numero = substr($dni, 0, 8);
        $letra = substr($dni, -1);
        return $letra === $letras[$numero % 23];
    }

    // Validar NIE (X, Y, Z seguido de 7 números y una letra)
    if (preg_match('/^[XYZ][0-9]{7}[A-Z]$/', $dni)) {
        $numero = str_replace(['X', 'Y', 'Z'], ['0', '1', '2'], substr($dni, 0, 1)) . substr($dni, 1, 7);
        $letra = substr($dni, -1);
        return $letra === $letras[$numero % 23];
    }

    // Validar CIF (letra + 7 números + letra/número)
    /*if (preg_match('/^[ABCDEFGHJNPQRSUVW][0-9]{7}[A-Z0-9]$/', $dni)) {
        $sumaPar = 0;
        $sumaImpar = 0;

        for ($i = 1; $i <= 6; $i += 2) {
            $sumaPar += (int) $dni[$i];
        }

        for ($i = 0; $i <= 6; $i += 2) {
            $doble = (int) $dni[$i] * 2;
            $sumaImpar += $doble > 9 ? $doble - 9 : $doble;
        }

        $sumaTotal = $sumaPar + $sumaImpar;
        $control = (10 - ($sumaTotal % 10)) % 10;

        $controlEsperado = $dni[8];
        if (ctype_alpha($controlEsperado)) {
            return $controlEsperado === chr(64 + $control); // Letra como control
        } else {
            return $controlEsperado == $control; // Número como control
        }
    }*/

    // Validar NIE especial (T seguido de 8 caracteres)
    if (preg_match('/^T[0-9]{8}$/', $dni)) {
        return true; // Se acepta directamente
    }

    return false; // No cumple ningún formato válido
}