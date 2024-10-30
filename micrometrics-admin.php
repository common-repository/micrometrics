<?php
if(!defined('ABSPATH')) {
	exit;
}

// CARGAR OPCIONES
function micrometrics_es_configuration() {
	$active_page 	= isset($_GET['page']) ? $_GET['page'] : 'micrometrics-general';
	$options 		= get_option('micrometrics_es_options');
	
	$dnt			= $options['dnt'];
	$e404			= $options['e404'];
	$eclic			= $options['eclic'];
	$esearch		= $options['esearch'];
	$events			= $options['event'];
	?>
	<div class="wrap">	
		<h1 class="wp-heading-inline"><?php esc_html_e('MicroMetrics','micrometrics'); ?></h1>
		<a href="https://micrometrics.es/documentacion/wordpress/" target="_blank"><?php esc_html_e('Documentación','micrometrics'); ?></a>
		<hr class="wp-header-end">
		<h2 class="nav-tab-wrapper">
			<a href="?page=micrometrics-general" class="nav-tab <?php echo $active_page == 'micrometrics-general' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('General','micrometrics'); ?></a>
			<a href="?page=micrometrics-events" class="nav-tab <?php echo $active_page == 'micrometrics-events' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Eventos','micrometrics'); ?></a>
		</h2>
		<form method="post" action="options.php">
			<?php 
			settings_fields('micrometrics_es_options');
			if($active_page == 'micrometrics-general') { 
			?>
			<table class="form-table">
      			<tbody>
      				<tr>
						<th scope="row"><?php esc_html_e('Do Not Track','micrometrics'); ?></th>
						<td>
							<fieldset>
								<label for="dnt">
									<select name="micrometrics_es_options[dnt]" id='dnt'>
										<option value="1" <?php echo selected($dnt, '1'); ?>><?php esc_html_e('Activado','micrometrics'); ?></option>
										<option value="0" <?php echo selected($dnt, '0'); ?>><?php esc_html_e('Apagado','micrometrics'); ?></option>
									</select>
									<?php esc_html_e('Respeta la decisión del usuario de no ser rastreado.','micrometrics'); ?> 
									<a href="https://micrometrics.es/documentacion/script/" target="_blank"><?php esc_html_e('Más información','micrometrics'); ?></a>
								</label>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e('Errores 404','micrometrics'); ?></th>
						<td>
							<fieldset>
								<label for="e404">
									<select name="micrometrics_es_options[e404]" id='e404'>
										<option value="1" <?php echo selected($e404, '1'); ?>><?php esc_html_e('Activado','micrometrics'); ?></option>
										<option value="0" <?php echo selected($e404, '0'); ?>><?php esc_html_e('Apagado','micrometrics'); ?></option>
									</select>
									<?php esc_html_e('Registra automáticamente un evento cada vez que se produce un error 404.','micrometrics'); ?> 
									<a href="https://micrometrics.es/blog/como-corregir-las-paginas-de-error-404-en-tu-sitio-web/" target="_blank"><?php esc_html_e('Más información','micrometrics'); ?></a>
								</label>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e('Clics salientes','micrometrics'); ?></th>
						<td>
							<fieldset>
								<label for="eclic">
									<select name="micrometrics_es_options[eclic]" id='eclic'>
										<option value="1" <?php echo selected($eclic, '1'); ?>><?php esc_html_e('Activado','micrometrics'); ?></option>
										<option value="0" <?php echo selected($eclic, '0'); ?>><?php esc_html_e('Apagado','micrometrics'); ?></option>
									</select>
									<?php esc_html_e('Registra automáticamente un evento cada vez que se produce un clic en un enlace saliente.','micrometrics'); ?> 
									<a href="https://micrometrics.es/blog/como-realizar-un-seguimiento-de-los-clics-en-enlaces-salientes/" target="_blank"><?php esc_html_e('Más información','micrometrics'); ?></a>
								</label>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e('Búsquedas','micrometrics'); ?></th>
						<td>
							<fieldset>
								<label for="esearch">
									<select name="micrometrics_es_options[esearch]" id='esearch'>
										<option value="1" <?php echo selected($esearch, '1'); ?>><?php esc_html_e('Activado','micrometrics'); ?></option>
										<option value="0" <?php echo selected($esearch, '0'); ?>><?php esc_html_e('Apagado','micrometrics'); ?></option>
									</select>
									<?php esc_html_e('Registra automáticamente un evento cada vez que se realiza una búsqueda.','micrometrics'); ?> 
									<a href="https://micrometrics.es/blog/como-realizar-un-seguimiento-de-las-busquedas-internas/" target="_blank"><?php esc_html_e('Más información','micrometrics'); ?></a>
								</label>
							</fieldset>
						</td>
					</tr>	
				</tbody>
			</table>
			<?php 
			} 
			if($active_page == 'micrometrics-events') { 
			?>
			<input name='micrometrics_es_options[dnt]' type='hidden' value='<?php echo $dnt; ?>' />
			<input name='micrometrics_es_options[e404]' type='hidden' value='<?php echo $e404; ?>' />
			<input name='micrometrics_es_options[eclic]' type='hidden' value='<?php echo $eclic; ?>' />
			<button type="button" onclick="addItem();" class="page-title-action" style="margin:20px 0 0 0"><?php esc_html_e('Añadir nuevo evento','micrometrics'); ?></button>
			<table class="wp-list-table widefat fixed striped posts" style="margin:20px 0">
				<thead>
					<th width="18%" scope="col" class="manage-column"><strong><?php esc_html_e('Selector','micrometrics'); ?></strong></th>
					<th width="18%" scope="col" class="manage-column"><strong><?php esc_html_e('Atributo','micrometrics'); ?></strong></th>
					<th width="18%" scope="col" class="manage-column"><strong><?php esc_html_e('Nombre','micrometrics'); ?></strong></th>
					<th width="18%" scope="col" class="manage-column"><strong><?php esc_html_e('Valor (Opcional)','micrometrics'); ?></strong></th>
					<th width="18%" scope="col" class="manage-column"><strong><?php esc_html_e('Moneda (Opcional)','micrometrics'); ?></strong></th>
					<th width="10%" scope="col" class="manage-column"><strong><?php esc_html_e('Eliminar','micrometrics'); ?></strong></th>
				</thead>
				<tbody id="tbody"></tbody>
			</table>
			<table class="wp-list-table widefat fixed striped posts" style="margin:20px 0">
				<?php 
				$k = -1;
				foreach($events as $event){
					$k++;
					if($k == 0){
						$required = '';
					} else {
						$required = 'aria-required="true" aria-invalid="false" required';
					}
					echo '<tr>';
					echo '<td width="18%"><select name="micrometrics_es_options[event]['.$k.'][0]" style="width:100%">';
					echo '<option value="class" '.selected(sanitize_text_field($event[0]), 'class').'>class</option>';
					echo '<option value="id" '.selected(sanitize_text_field($event[0]), 'id').'>id</option></select></td>';
					echo '<td width="18%"><input name="micrometrics_es_options[event]['.$k.'][1]" value="'.sanitize_text_field($event[1]).'" type="text" maxlength="50" style="width:100%" '.$required.'/></td>';
					echo '<td width="18%"><input name="micrometrics_es_options[event]['.$k.'][2]" value="'.sanitize_text_field($event[2]).'" type="text" maxlength="50" style="width:100%" '.$required.'/></td>';
					echo '<td width="18%"><input name="micrometrics_es_options[event]['.$k.'][3]" value="'.sanitize_text_field($event[3]).'" type="text" maxlength="10" pattern="[0-9.]+" style="width:100%" /></td>';
					echo '<td width="18%"><select name="micrometrics_es_options[event]['.$k.'][4]" style="width:100%">';
					echo '<option value="EUR" '.selected(sanitize_text_field($event[4]), 'EUR').'>EUR</option>';
					echo '<option value="GBP" '.selected(sanitize_text_field($event[4]), 'GBP').'>GBP</option>';
					echo '<option value="USD" '.selected(sanitize_text_field($event[4]), 'USD').'>USD</option></select></td>';
					if(count($events) == $k+1){
						echo '<td width="10%"><button type="button" class="button" onclick="deleteRow(this);">'.__('Eliminar', 'micrometrics').'</button></td>';
					} else {
						echo '<td width="10%"><button type="button" class="button" onclick="deleteRow(this);" disabled>'.__('Eliminar', 'micrometrics').'</button></td>';
					}
					echo '</tr>';
				} 
				?>
			</table>
			<?php } ?>
			<input id="submit" class="button button-primary" type="submit" name="submit" value="<?php esc_html_e('Guardar cambios','micrometrics'); ?>" />
		</form>
	</div>
	<script type="text/javascript">	
	var event 			= <?php echo count($events)-1; ?>;
	function addItem() {
		event++;
		var html 		= '<tr>';
			html 		+= '<td width="18%"><select name="micrometrics_es_options[event]['+event+'][0]" style="width:100%"><option value="class">class</option><option value="id">id</option></select></td>';
			html 		+= '<td width="18%"><input name="micrometrics_es_options[event]['+event+'][1]" value="" type="text" maxlength="50" aria-required="true" aria-invalid="false" style="width:100%" required /></td>';
			html 		+= '<td width="18%"><input name="micrometrics_es_options[event]['+event+'][2]" value="" type="text" maxlength="50" aria-required="true" aria-invalid="false" style="width:100%" required /></td>';
			html 		+= '<td width="18%"><input name="micrometrics_es_options[event]['+event+'][3]" value="" type="text" maxlength="10" pattern="[0-9.]+" style="width:100%" /></td>';
			html 		+= '<td width="18%"><select name="micrometrics_es_options[event]['+event+'][4]" style="width:100%"><option value="EUR">EUR</option><option value="GBP">GBP</option><option value="USD">USD</option></select></td>';
			html 		+= '<td width="10%"><button type="button" class="button" onclick="deleteRow(this);"><?php esc_html_e("Eliminar", "micrometrics"); ?></button></td>';
			html 		+= '</tr>';
		var row 		= document.getElementById('tbody').insertRow();
		row.innerHTML 	= html;
	}
 
	function deleteRow(button) {
		button.parentElement.parentElement.remove();
	}
	</script>
	<?php
}

// GUARDAR OPCIONES
function micrometrics_es_validate($form){
	$options 			= get_option('micrometrics_es_options');
	$updated 			= $options;
	if(is_array($form) && array_key_exists('event', $form)) {
		$updated['event'] = array();
		for ($i = 0, $j = 0; $i < count($form['event']); $i++){
			if(isset($form['event'][$i][0])){
				$updated['event'][$j] = $form['event'][$i];
				$j++;
			}
		}
	}
	$updated['dnt'] 	= $form['dnt'];
	$updated['e404'] 	= $form['e404'];
	$updated['eclic'] 	= $form['eclic'];
	$updated['esearch'] = $form['esearch'];
	return $updated;
}
