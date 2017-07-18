<?php

/**
 * Plugin Name: FB Cache Cleaner
 * Description: This plugin will force the cache of Facebook's OG when a post or page is saved or updated.
 * Version: 2.0.2
 * Author: Michelangelo Scotto di Gregorio
 * Text Domain: fcc
 */
 
# Protection
defined('ABSPATH') or die('No script kiddies please!');

# Setup
register_activation_hook(__FILE__, 'fcc_install');
register_deactivation_hook(__FILE__, 'fcc_delete');
function fcc_install(){
	add_option('fcc_page', '1');
	add_option('fcc_post', '1');
}
function fcc_delete(){
	delete_option('fcc_page');
	delete_option('fcc_post');
}

# cURL request
function sendPOST($url){
	$post_data = 'id='.urlencode($url).'&amp;scrape=true';
	
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
	$res = curl_exec($ch);
	curl_close($ch);
	
		return $res;
}

# Post change status
function wpPostChange($post_id){
	
	if(wp_is_post_revision($post_id)){
		return;
	}
	
	$post_url = get_permalink($post_id);
	$post_inf = get_post_status($post_id);
	$post_typ = get_post_type($post_id);
	
	if($post_inf == 'publish' && (get_option('fcc_'.$post_typ) == 1)){
		sendPOST($post_url);
	}
}

# Menu
function fcc_menu(){
	add_options_page('FB Cache Cleaner v2', 'FB Cache Cleaner', 'manage_options', 'fcc-home', 'fcc_dashboard');
}
function add_plg_lnk($links){
	$link = array('<a href="'.admin_url('options-general.php?page=fcc-home').'">Impostazioni</a>');
		return array_merge($links, $link);
}

# Dashboard
function fcc_dashboard(){
	$pag = filter_input(INPUT_GET, 'option', FILTER_SANITIZE_STRING);
	if($pag == 'del_all'){
		include("del_all.inc.php");
	}else{
		include('dashboard.inc.php');
	}
}

# Multilanguage
function fcc_plg_i18n() {
  load_plugin_textdomain('fcc', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

# Add action to wordpress
add_action('save_post', 'wpPostChange');
add_action('admin_menu', 'fcc_menu');
add_action('init', 'fcc_plg_i18n');
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'add_plg_lnk');

?>