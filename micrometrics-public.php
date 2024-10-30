<?php
if(!defined('ABSPATH')) {
	exit;
}

// CARGAR CÓDIGO SEGUIMIENTO
function micrometrics_es_load_script() {
	$options 				= get_option('micrometrics_es_options');
    $dnt 					= $options['dnt']; 
    if($dnt == 1) {
    	$data_dnt			= 'true';
    } else {
    	$data_dnt			= 'false';
    }
	wp_print_script_tag(
		array(
			'data-host'		=> 'https://cdn.micrometrics.es',
			'data-dnt'		=> $data_dnt,
			'src' 			=> 'https://cdn.micrometrics.es/js/script.js',
			'id' 			=> 'ZwSg9rf6GA',
			'defer' 		=> true,
			'async'			=> true
		)
	);
}

// CARGAR EVENTOS
function micrometrics_es_load_events() {
	$options 				= get_option('micrometrics_es_options');
    $events 				= $options['event']; 
    $e404 					= $options['e404'];
    $eclic 					= $options['eclic'];
    $esearch 				= $options['esearch'];
    $data					= ''; 
     // CARGAR EVENTOS
    if(!empty($events[0][0]) || $eclic == 1 || ($e404 == 1 && is_404()) || ($esearch == 1 && is_search() && get_search_query())){
    	$data					.= "<!-- MICROMETRICS EVENTS -->".PHP_EOL;
		$data					.= "<script type='text/javascript'>".PHP_EOL;
		// CARGAR EVENTOS MANUALES
		if(!empty($events[0][0])){
			$data				.= "window.addEventListener('load', (event) => {".PHP_EOL;
			foreach($events as $event){
				if(!empty($event[1])){
					if($event[0] == 'class'){ 
						$data	.= "document.querySelectorAll('.".$event[1]."').forEach(item => { item.addEventListener('click', event => {".PHP_EOL;
					} else {
						$data	.= "document.getElementById('".$event[1]."').addEventListener('click', function() {".PHP_EOL;
					}
					if(empty($event[3])){
						$data	.= "pa.track({name: '".$event[2]."'});".PHP_EOL;
					} else {
						$data	.= "pa.track({name: '".$event[2]."', value: ".$event[3].", unit: '".$event[4]."'});".PHP_EOL;
					}
					if($event[0] == 'class'){ 
						$data	.= "});".PHP_EOL;
					}
					$data		.= "});".PHP_EOL;
				}
			}
			$data				.= "});".PHP_EOL;
		}
		// CARGAR EVENTO CLIC SALIENTES
		if($e404 == 1 && is_404()) {
			$data				.= "window.addEventListener('load', (event) => {".PHP_EOL;
			$data				.= "pa.track({name: '404 ' + document.location.pathname});".PHP_EOL;
			$data				.= "});".PHP_EOL;
		}
		// CARGAR EVENTO BÚSQUEDAS
		if($esearch == 1 && is_search() && get_search_query()) {
			$data				.= "window.addEventListener('load', (event) => {".PHP_EOL;
			$data				.= "const urlParam = new URLSearchParams(window.location.search);".PHP_EOL;
			$data				.= "pa.track({name: 'search ' + urlParam.get('s')});".PHP_EOL;
			$data				.= "});".PHP_EOL;
		}
		// CARGAR EVENTO CLIC SALIENTES
		if($eclic == 1) {
			$data				.= "document.addEventListener('click', function (event){".PHP_EOL;
			$data				.= "if(event.target && event.target.href && event.target.host && event.target.host !== location.host){".PHP_EOL;
			$data				.= "pa.track({name: 'click ' + event.target.hostname + event.target.pathname});".PHP_EOL;
			$data				.= "}".PHP_EOL;
			$data				.= "});".PHP_EOL;
		}
	
		$data					.= "</script>".PHP_EOL;
		$data					.= "<!-- MICROMETRICS EVENTS -->".PHP_EOL;
	}
	echo $data;
}