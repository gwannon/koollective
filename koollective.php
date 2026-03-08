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

//flush_rewrite_rules(true);

define ("INSCRIPTION_PAGE_ID", 54);

//Cargamos librerias
include_once(dirname(__FILE__)."/custom_posts/custom_posts.php");
include_once(dirname(__FILE__)."/custom_posts/jornada.php");
include_once(dirname(__FILE__)."/custom_posts/actividad.php");
include_once(dirname(__FILE__)."/custom_posts/local.php");
include_once(dirname(__FILE__)."/custom_posts/taxonomies.php");


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
                <div>
                  
                  <?php
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
                        <p><?php echo get_post_meta($actividad->ID, "_actividad_fechahora", true); ?></p>
                        <?php echo apply_filters("the_content", get_post_meta($actividad->ID, "_actividad_resumen", true)); ?>
                        <a href="<?php echo get_the_permalink(INSCRIPTION_PAGE_ID); ?>?actividad=<?php echo $actividad->ID; ?>"><?php _e("Inscribirse", 'koollective'); ?></a>
                      </div>
                  <?php } } ?>
                </div>
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
    $actividad = get_post($_REQUEST['actividad']); 
    
    /* TODO
      * Chequear que haya espacios libres, sino sacar mensaje de que entran en lista de espera.
      * Chequear que no haya pasado
    */
    
    ?>
    <h2><?php echo $actividad->post_title; ?></h2>
    <p><?php echo get_post_meta($actividad->ID, "_actividad_fechahora", true); ?></p>
    <?php echo apply_filters("the_content", get_post_meta($actividad->ID, "_actividad_resumen", true)); ?>
    <?php echo apply_filters("the_content", $actividad->post_content); ?>
    <form id="forminscripcion">
      <label>
        <?php _e("Nombre", 'koollective'); ?> *
        <input type="text" name="nombre" value="" placeholder="<?php _e("Introduce tu nombre", 'koollective'); ?>" required />
      </label>
      <label>
        <?php _e("Apellidos", 'koollective'); ?> *
        <input type="text" name="apellidos" value="" placeholder="<?php _e("Introduce tus apellidos", 'koollective'); ?>" required />
      </label>
      <label>
        <?php _e("DNI", 'koollective'); ?> *
        <input type="text" name="dni" value="" placeholder="<?php _e("Introduce tus DNI con letra", 'koollective'); ?>" maxlength="9" required />
      </label>
      <label>
        <?php _e("Email", 'koollective'); ?> *
        <input type="email" name="email" value="" placeholder="<?php _e("Introduce tu email", 'koollective'); ?>" required />
      </label>
      <label>
        <?php _e("Teléfono", 'koollective'); ?> *
        <input type="text" name="telefono" value="" placeholder="<?php _e("Introduce tu telefono", 'koollective'); ?>" maxlength="9" required />
      </label>
      <label>
        <?php _e("Fecha de nacimiento", 'koollective'); ?>
        <input type="date" name="fechanacimiento" value="" />
      </label>
      <label>
        <?php _e("Dirección", 'koollective'); ?>
        <input type="text" name="direccion" value="" placeholder="<?php _e("Introduce tu dirección", 'koollective'); ?>" />
      </label>
      <label>
        <?php _e("Código postal", 'koollective'); ?> *
        <input type="text" name="codigopostal" value="" placeholder="<?php _e("Introduce tu código postal", 'koollective'); ?>" maxlength="5" required />
      </label>
      <label>
        <?php _e("Cíudad", 'koollective'); ?> *
        <input type="text" name="ciudad" value="" placeholder="<?php _e("Introduce tu ciudad", 'koollective'); ?>" required />
      </label>
      <label>
        <?php _e("¿Cómo conoció el evento?", 'koollective'); ?> *
        <textarea name="comoconocioevento" placeholder="<?php _e("Máximo 120 caracteres.", 'koollective'); ?>" maxlength="10" required></textarea>
      </label>
      <label>
        <?php _e("¿Ha participado en otros eventos?", 'koollective'); ?><br/>
        <input type="radio" name="hasparticipadootroevento" value="Sí" checked="checked" /> Sí <br/>
        <input type="radio" name="hasparticipadootroevento" value="No" /> No
      </label>
      <label>
        <?php _e("¿En qué tienda Koopera compras habitualmente?", 'koollective'); ?> *
        <input type="text" name="tiendacompras" value="" placeholder="<?php _e("Introduce el nombre de la tienda", 'koollective'); ?>" required />
      </label>
      <label class="doble">
        <?php _e("¿Qué te interesa más de nuestras actividades?", 'koollective'); ?><br/>
        <input type="checkbox" name="interes" value="Moda sostenible" /> Moda sostenible<br/>
        <input type="checkbox" name="interes" value="Economía circular" /> Economía circular<br/>
        <input type="checkbox" name="interes" value="Eventos / encuentros" /> Eventos / encuentros<br/>
        <input type="checkbox" name="interes" value="Talleres / formación" /> Talleres / formación<br/>
        <input type="checkbox" name="interes" value="Segunda mano / vintage" /> Segunda mano / vintage    
      </label>
      <label>        
        <input type="checkbox" name="aceptorecibirinformacion" value="Acepto recibir información" />
        <?php _e("Acepto recibir información sobre actividades, eventos y novedades de Koopera.", 'koollective'); ?>
      </label>
      <label>
        <?php _e("¿Cómo prefieres recibir información?", 'koollective'); ?><br/>
        <input type="checkbox" name="interes" value="Email" /> Email<br/>
        <input type="checkbox" name="interes" value="WhatsApp" /> WhatsApp<br/>
        <input type="checkbox" name="interes" value="SMS" /> SMS
      </label>
      <button type="submit" name="inscripcion"><?php _e("Inscribirse", 'koollective'); ?></button>
    </form>
    <style>
      #forminscripcion {
        max-width: 600px;
        border: 1px solid red;
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
      }

      #forminscripcion > label {
        display: block;
        width: calc(50% - 10px);
      }

      #forminscripcion > label.doble {
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
