<?php

function koollective_get_custom_fields ($type) {
  if($type == 'jornada') return koollective_get_jornada_custom_fields();
  else if($type == 'actividad') return koollective_get_actividad_custom_fields();
  else if($type == 'local') return koollective_get_local_custom_fields();
  else return [];
}

function koollective_show_custom_fields() { //Show box
  global $post;
  $type = get_post_type($post->ID);
  $fields = koollective_get_custom_fields ($type); ?>
		<div>
      <?php foreach ($fields as $field => $datos) { ?>
        <?php if(!isset($datos['is']) || (isset($datos['is']) && has_term($datos['is']['id'], $datos['is']['taxonomy'], $post->ID))) { ?>
          <?php if($datos['tipo'] != 'separator' && $datos['tipo'] != 'inscritos') { ?><div style="width: calc(50% - 10px); float: left; padding: 5px;"><?php } else { ?><div style="width: calc(100% - 10px); float: left; padding: 5px;"><?php } ?>
            <?php if($datos['tipo'] == 'separator') { ?><h3 style="background-color: #000; color: #fff; padding: 5px; margin: 0px;"><?php echo $datos['titulo']; ?></h3><?php } else { ?><p><b><?php echo $datos['titulo']; ?></b></p><?php } ?>
            <?php if($datos['tipo'] == 'text') { ?>
              <input  type="text" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 100%;" name="_<?php echo $type; ?>_<?php echo $field; ?>" value="<?php echo str_replace('"', '\"', get_post_meta( $post->ID, '_'.$type.'_'.$field, true )); ?>"<?php echo (isset($datos['placeholder']) ? " placeholder='".$datos['placeholder']."'" : "" ); ?>/>
            <?php } else if($datos['tipo'] == 'link') { ?>
              <input  type="url" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 100%;" name="_<?php echo $type; ?>_<?php echo $field; ?>" value="<?php echo str_replace('"', '\"', get_post_meta( $post->ID, '_'.$type.'_'.$field, true )); ?>"<?php echo (isset($datos['placeholder']) ? " placeholder='".$datos['placeholder']."'" : "" ); ?>/>
            <?php } else if($datos['tipo'] == 'date') { ?>
              <input type="date" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 50%;" name="_<?php echo $type; ?>_<?php echo $field; ?>" value="<?php echo get_post_meta( $post->ID, '_'.$type.'_'.$field, true ); ?>" />
            <?php }  else if($datos['tipo'] == 'datetime') { ?>
              <input type="datetime-local" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 50%;" name="_<?php echo $type; ?>_<?php echo $field; ?>" value="<?php echo get_post_meta( $post->ID, '_'.$type.'_'.$field, true ); ?>" />
            <?php } else if($datos['tipo'] == 'number') { ?>
              <input type="number" step="1" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 50%;" name="_<?php echo $type; ?>_<?php echo $field; ?>" value="<?php echo get_post_meta( $post->ID, '_'.$type.'_'.$field, true ); ?>" />
            <?php } else if($datos['tipo'] == 'textarea') { ?>
              <?php $settings = array( 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => 5 ); ?>
              <?php wp_editor( get_post_meta( $post->ID, '_'.$type.'_'.$field, true ), '_'.$type.'_'.$field, $settings ); ?>
            <?php } else if ($datos['tipo'] == 'select') { ?>
              <select name="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 100%;">
                <?php foreach($datos['valores'] as $key => $value) { ?>
                  <option value="<?php echo $key; ?>"<?php if ($key == get_post_meta( $post->ID, '_'.$type.'_'.$field, true )) echo " selected='selected'"; ?>><?php echo $value; ?></option>
                <?php } ?>	
              </select>
            <?php } else if ($datos['tipo'] == 'inscritos') { ?>
              <?php $inscritos = get_post_meta($post->ID, '_'.$type.'_inscritos', true); ?>
              <div style="overflow: auto;">
                <table id="inscritos" border="0" cellpadding="10" width="100%">
                  <thead>
                    <tr>
                      <th><?php _e("#", 'koollective'); ?></th>
                      <th><?php _e("Nombre", 'koollective'); ?></th>
                      <th><?php _e("Apellidos", 'koollective'); ?></th>
                      <th><?php _e("DNI", 'koollective'); ?></th>
                      <th><?php _e("Email", 'koollective'); ?></th>
                      <th><?php _e("Teléfono", 'koollective'); ?></th>
                      <th><?php _e("Ciudad", 'koollective'); ?></th>
                      <th><?php _e("Borrar", 'koollective'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $counter = 1; if(is_array($inscritos) && count($inscritos) > 0) { foreach($inscritos as $inscrito) { unset($inscrito['actividad']); ?> 
                      <tr>
                        <th><?php echo $counter; ?></th>
                        <td><?php echo $inscrito['nombre']; ?></td>
                        <td><?php echo $inscrito['apellidos']; ?></td>
                        <td><?php echo $inscrito['dni']; ?></td>
                        <td><a hre="mailto:<?php echo $inscrito['email']; ?>"><?php echo $inscrito['email']; ?></a></td>
                        <td><a hre="tel:<?php echo $inscrito['telefono']; ?>"><?php echo $inscrito['telefono']; ?></a></td>
                        <td><?php echo $inscrito['ciudad']; ?></td>
                        <th><input type="checkbox" name="_<?php echo $type; ?>_inscritos_borrar[]" value="<?php echo $inscrito['dni']; ?>"></th>
                      </tr>
                      <?php if($counter == get_post_meta($post->ID, '_'.$type.'_maxinscripciones', true)) { ?>
                        <tr style="">
                          <td colspan="8" style="text-align: center; font-weight: 700; background-color: black; color: white;"><?php _e("Lista de espera", 'koollective'); ?></td>
                        </tr>
                      <?php } ?>
                    <?php $counter++; } } ?>
                  </tbody>
                </table>
              </div>
              <br/>
              <?php if(is_array($inscritos) && count($inscritos) > 0) { ?><a href="/wp-admin/admin-ajax.php?action=koollective-export&actividad=<?php echo $post->ID; ?>" target="_blank" class="button"><?php _e("Exportar a CSV", 'koollective'); ?></a><?php } else { ?><?php _e("No hay inscritos.", 'koollective'); ?><?php } ?>
              <style>
                table#inscritos thead tr th {
                  background-color: black;
                  color: white;
                }

                table#inscritos tbody tr:nth-of-type(odd) *:is(td, th) {
                  background-color: #cecece;
                }
              </style>
            <?php } ?>
          </div>
        <?php } ?>
      <?php } ?>
    <div style="clear: both;"></div>
	</div><?php
}

function koollective_save_custom_fields( $post_id ) { //Save changes
	global $wpdb;
  $type = get_post_type($post_id);
  $fields = koollective_get_custom_fields ($type);
	foreach ($fields as $field => $datos) {
		$label = '_'.$type.'_'.$field;
    if ($datos['tipo'] == 'inscritos') {
      $label2 = $label.'_borrar';
      if(isset($_POST[$label2]) && is_array($_POST[$label2]) && count($_POST[$label2]) > 0) {
        $newinscritos = [];
        $inscritos = get_post_meta($post_id, $label, true);
        //print_r($inscritos);
        foreach($inscritos as $inscrito) {
          if(!in_array($inscrito['dni'], $_POST[$label2])) $newinscritos[] = $inscrito;
        }
        update_post_meta($post_id, $label, $newinscritos);
        //print_r($newinscritos);
      }
    } else if (isset($_POST[$label])) update_post_meta( $post_id, $label, $_POST[$label]);
		else if (!isset($_POST[$label]) && $datos['tipo'] == 'checkbox') delete_post_meta( $post_id, $label);
    else if (!isset($_POST[$label]) && $datos['tipo'] == 'multiple') delete_post_meta( $post_id, $label);
	}
}
