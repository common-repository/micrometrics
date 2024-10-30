<?php
/*
Plugin Name: 		MicroMetrics
Plugin URI: 		https://micrometrics.es
Description: 		Este plugin agrega de forma fácil y rápida el código de seguimiento de MicroMetrics a tu sitio web y te permite registrar eventos.
Version: 			1.3.2
Author: 			Brandalismo
Author URI: 		https://www.brandalismo.es
Text Domain:		micrometrics
License: 			GPL-2.0+
*/

// ACTIVAR PLUGIN
register_activation_hook(__FILE__, 'micrometrics_es_install');
function micrometrics_es_install() {
    $options 		= array(
    	'dnt'		=> '0',
    	'e404'		=> '0',
    	'eclic'		=> '0',
    	'esearch'	=> '0',
        'event' 	=> array(
			array(
				'0' => '',
				'1' => '',
				'2'	=> '',
				'3' => '',
				'4'	=> ''
			)
		)
    );
	if(!get_option('micrometrics_es_options')) {
		update_option('micrometrics_es_options', $options);
	}
}

// INICIAR PLUGIN
add_action('plugins_loaded', 'micrometrics_es_setup');
function micrometrics_es_setup() {
	include_once dirname(__FILE__).'/micrometrics-public.php';
	include_once dirname(__FILE__).'/micrometrics-admin.php';
	add_action('wp_head', 'micrometrics_es_load_script');
	add_action('wp_footer', 'micrometrics_es_load_events');
	add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'micrometrics_es_settings_link');
	load_plugin_textdomain( 'micrometrics', false, dirname(plugin_basename(__FILE__)).'/languages/' );
}

// CARGAR ENLACE PLUGINS
function micrometrics_es_settings_link($links) { 
	$settings_link 	= '<a href="admin.php?page=micrometrics-general">'.esc_html__('Ajustes','micrometrics').'</a>'; 
	array_unshift($links, $settings_link); 
	return $links; 
}

// CARGAR MENU ADMIN

add_action('admin_menu', 'micrometrics_es_admin_menu');
function micrometrics_es_admin_menu() {	
	add_menu_page('MicroMetrics','MicroMetrics','manage_options', 'micrometrics-general', 'micrometrics_es_configuration', 'dashicons-chart-bar', 100);
	add_submenu_page('micrometrics-general', __('General','micrometrics'), __('General','micrometrics'), 'manage_options', 'micrometrics-general' , 'micrometrics_es_configuration' );
	add_submenu_page('micrometrics-general',__('Eventos','micrometrics'), __('Eventos','micrometrics'), 'manage_options', 'micrometrics-events' , 'micrometrics_es_configuration' );
}

// CARGAR OPCIONES ADMIN
add_action('admin_init', 'micrometrics_es_admin_init');
function micrometrics_es_admin_init() {
	register_setting('micrometrics_es_options','micrometrics_es_options','micrometrics_es_validate');
}