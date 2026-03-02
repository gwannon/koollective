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
          <?php if($datos['tipo'] != 'gallery' && $datos['tipo'] != 'separator' && $datos['tipo'] != 'links' && $datos['tipo'] != 'positions') { ?><div style="width: calc(50% - 10px); float: left; padding: 5px;"><?php } else { ?><div style="width: calc(100% - 10px); float: left; padding: 5px;"><?php } ?>
            <?php if($datos['tipo'] == 'separator') { ?><h3 style="background-color: #000; color: #fff; padding: 5px; margin: 0px;"><?php echo $datos['titulo']; ?></h3><?php } else { ?><p><b><?php echo $datos['titulo']; ?></b></p><?php } ?>
            <?php if($datos['tipo'] == 'text') { ?>
              <input  type="text" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 100%;" name="_<?php echo $type; ?>_<?php echo $field; ?>" value="<?php echo str_replace('"', '\"', get_post_meta( $post->ID, '_'.$type.'_'.$field, true )); ?>"<?php echo (isset($datos['placeholder']) ? " placeholder='".$datos['placeholder']."'" : "" ); ?>/>
            <?php } else if($datos['tipo'] == 'link') { ?>
              <input  type="url" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 100%;" name="_<?php echo $type; ?>_<?php echo $field; ?>" value="<?php echo str_replace('"', '\"', get_post_meta( $post->ID, '_'.$type.'_'.$field, true )); ?>"<?php echo (isset($datos['placeholder']) ? " placeholder='".$datos['placeholder']."'" : "" ); ?>/>
            <?php } else if($datos['tipo'] == 'date') { ?>
              <input type="date" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 50%;" name="_<?php echo $type; ?>_<?php echo $field; ?>" value="<?php echo get_post_meta( $post->ID, '_'.$type.'_'.$field, true ); ?>" />
            <?php }  else if($datos['tipo'] == 'datetime') { ?>
              <input type="datetime-local" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 50%;" name="_<?php echo $type; ?>_<?php echo $field; ?>" value="<?php echo get_post_meta( $post->ID, '_'.$type.'_'.$field, true ); ?>" />
            <?php }else if($datos['tipo'] == 'time') { ?>
              <input type="time" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 50%;" name="_<?php echo $type; ?>_<?php echo $field; ?>" value="<?php echo get_post_meta( $post->ID, '_'.$type.'_'.$field, true ); ?>" />
            <?php } else if($datos['tipo'] == 'number') { ?>
              <input type="number" step="1" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 50%;" name="_<?php echo $type; ?>_<?php echo $field; ?>" value="<?php echo get_post_meta( $post->ID, '_'.$type.'_'.$field, true ); ?>" />
            <?php } else if($datos['tipo'] == 'code' || $datos['tipo'] == 'simpletextarea') { ?>
              <textarea class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 100%;" rows="5" name="_<?php echo $type; ?>_<?php echo $field; ?>"<?php echo (isset($datos['placeholder']) ? " placeholder='".$datos['placeholder']."'" : "" ); ?>><?php echo get_post_meta( $post->ID, '_'.$type.'_'.$field, true ); ?></textarea>
            <?php } else if($datos['tipo'] == 'hidden') { ?>
              <input disabled="disabled" type="text" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 50%;" name="_<?php echo $type; ?>_<?php echo $field; ?>" value="<?php echo get_post_meta( $post->ID, '_'.$type.'_'.$field, true ); ?>" />
            <?php } else if($datos['tipo'] == 'image') { ?>
              <input type="text" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="input_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 80%;" name="_<?php echo $type; ?>_<?php echo $field; ?>" value='<?php echo get_post_meta( $post->ID, '_'.$type.'_'.$field, true ); ?>' />
              <a href="#" id="button_media_<?php echo $field; ?>" class="button insert-media add_media" data-editor="input_<?php echo $type; ?>_<?php echo $field; ?>" title="<?php _e("Añadir fichero", 'koollective'); ?>"><span class="wp-media-buttons-icon"></span> <?php _e("Añadir fichero", 'koollective'); ?></a>
              <script>
                jQuery(document).ready(function () {			
                  jQuery("#input_<?php echo $type; ?>_<?php echo $field; ?>").change(function() {
                    a_imgurlar = jQuery(this).val().match(/<a href=\"([^\"]+)\"/);
                    img_imgurlar = jQuery(this).val().match(/<img[^>]+src=\"([^\"]+)\"/);
                    if(img_imgurlar !==null ) jQuery(this).val(img_imgurlar[1]);
                    else  jQuery(this).val(a_imgurlar[1]);
                  });
                });
              </script>
            <?php } else if($datos['tipo'] == 'textarea') { ?>
              <?php $settings = array( 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => 5 ); ?>
              <?php wp_editor( get_post_meta( $post->ID, '_'.$type.'_'.$field, true ), '_'.$type.'_'.$field, $settings ); ?>
            <?php } else if ($datos['tipo'] == 'select') { ?>
              <select name="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 100%;">
                <?php foreach($datos['valores'] as $key => $value) { ?>
                  <option value="<?php echo $key; ?>"<?php if ($key == get_post_meta( $post->ID, '_'.$type.'_'.$field, true )) echo " selected='selected'"; ?>><?php echo $value; ?></option>
                <?php } ?>	
              </select>
            <?php } else if ($datos['tipo'] == 'multiple') {  ?>
              <select name="_<?php echo $type; ?>_<?php echo $field; ?>[]" multiple="multiple" style="width: 100%;">
                <?php foreach($datos['valores'] as $key => $value) { ?>
                  <option value="<?php echo $key; ?>"<?php if (in_array($key, get_post_meta( $post->ID, '_'.$type.'_'.$field, true ))) echo " selected='selected'"; ?>><?php echo $value; ?></option>
                <?php } ?>	
              </select>
            <?php } else if ($datos['tipo'] == 'checkbox') { ?>
              <?php $results = get_post_meta( $post->ID, '_'.$type.'_'.$field, true ); ?>
              <?php foreach($datos['valores'] as $key => $value) { ?>
                <input type="checkbox" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" name="_<?php echo $type; ?>_<?php echo $field; ?>[]" value="<?php echo $key; ?>" <?php if(is_array($results) && in_array($key, $results)) { echo "checked='checked'"; } ?> /> <?php echo $value; ?><br/>
              <?php } ?>
            <?php } ?>
          </div>
        <?php } ?>
      <?php } ?>
    <div style="clear: both;"></div>
	</div><?php
}

function koollective_save_custom_fields( $post_id ) { //Save changes

  //print_pre($_REQUEST); die;
	global $wpdb;
  $type = get_post_type($post_id);
  $fields = koollective_get_custom_fields ($type);
	foreach ($fields as $field => $datos) {
		$label = '_'.$type.'_'.$field;
    if ($datos['tipo'] == 'tags') {
      delete_post_meta( $post_id, $label);
      $temp = explode("_", substr($label, 1));
      if(isset($_POST[$label]) && $_POST[$label] != '') {
        foreach(explode(",", $_POST[$label]) as $tag) {
          $args = [
              'post_type'      => $temp[1],
              'posts_per_page' => 1,
              'post_name__in'  => [$tag],
              'suppress_filters' => false,
          ];
          $q = get_posts( $args );
          add_post_meta($post_id, $label, $q[0]->ID);
        }
      }
    } else if ($datos['tipo'] == 'links') {
      $links = [];
      if(isset($_POST[$label]) && is_array($_POST[$label])) {
        foreach ($_POST[$label] as $link) {
          if ($link['link'] != '' && $link['text'] != '') $links[] = $link;
        }
      }
      update_post_meta( $post_id, $label, $links);
    } else if ($datos['tipo'] == 'positions') {
      $positions = [];
      //print_pre($_POST[$label]);
      if(isset($_POST[$label]) && is_array($_POST[$label])) {
        foreach ($_POST[$label] as $position) {
          if ($position['position'] != '' && $position['investigador'] != '') $positions[] = $position;
        }
      }
      //print_pre($positions); die;
      update_post_meta( $post_id, $label, $positions);
    } else if ($datos['tipo'] == 'gallery') {
      $images = [];
      if(isset($_POST[$label]) && is_array($_POST[$label])) {
        foreach ($_POST[$label] as $image_id) {
          if ($image_id > 0) $images[] = $image_id;
        }
      }
      update_post_meta( $post_id, $label, $images);
    } else if (isset($_POST[$label])) update_post_meta( $post_id, $label, $_POST[$label]);
		else if (!isset($_POST[$label]) && $datos['tipo'] == 'checkbox') delete_post_meta( $post_id, $label);
    else if (!isset($_POST[$label]) && $datos['tipo'] == 'multiple') delete_post_meta( $post_id, $label);
	}
}

// Libs ----------------------------------------
function sort_terms_hierarchically($terms) {
	usort($terms, "cmp");
	return $terms;
}

function cmp($a, $b) {
	return strcmp($a->parent, $b->parent);
}
