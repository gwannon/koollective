<?php

//ADMIN -------------------------------------------
// ------------------------------------------------

add_action( 'admin_menu', 'koollective_admin_menu');
function koollective_admin_menu() {
	add_options_page( __('Jornadas', 'koollective'), __('Jornadas', 'koollective'), 'manage_options', 'koollective_admin_menu', 'koollective_admin_page_settings');
}

function koollective_admin_page_settings() { 
	//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
	if(isset($_REQUEST['send']) && $_REQUEST['send'] != '') {
		update_option('_koollective_inscription_page_id', $_POST['_koollective_inscription_page_id']);
		update_option('_koollective_admin_email', $_POST['_koollective_admin_email']);
    ?><p style="border: 1px solid green; color: green; text-align: center;"><?php _e("¡Datos guardados!", 'koollective'); ?></p><?php
	} ?>
	<form method="post">
		<h1><?php _e("Jornadas", 'koollective'); ?></h1>
		<table width="100%">
			<tr>
				<th align="left" width="100"><?php _e("ID Página de inscripción", 'koollective'); ?>:</th>
				<td><input type="text" style="width: 100%;" name="_koollective_inscription_page_id" value="<?php echo get_option("_koollective_inscription_page_id"); ?>" /></td>
			</tr>
      <tr>
				<th align="left" width="100"><?php _e("Email de aviso (separados por comas)", 'koollective'); ?>:</th>
				<td><input type="text" style="width: 100%;" name="_koollective_admin_email" value="<?php echo get_option("_koollective_admin_email"); ?>" /></td>
			</tr>
		</table>
		<input type="submit" name="send" class="button button-primary" value="<?php _e("Guardar", 'koollective'); ?>" />
	</form>
	<?php
}