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
        <?php while ( $my_query->have_posts() ) { $my_query->the_post(); $post_id = get_the_id(); ?>
            <div style="--bgimage: url(<?php echo wp_get_attachment_image_url(get_post_thumbnail_id($post_id), 'medium'); ?>);">
                <div>
                  <h2><?php the_title(); ?></h2>
                  <?php the_content(); ?>
                  <p><?php echo get_post_meta($post_id, "_jornada_fechainicio", true); ?></p>
                  <p><?php echo get_post_meta($post_id, "_jornada_fechafin", true); ?></p>
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


