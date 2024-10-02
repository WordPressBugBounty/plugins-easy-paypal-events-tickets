<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// display activation notice
add_action('admin_notices', 'wpeevent_admin_notices');
function wpeevent_admin_notices() {
	if (!get_option('wpeevent_notice_shown')) {
		echo "<div class='updated'><p><a href='admin.php?page=wpeevent_settings'>Click here to view the plugin settings</a>.</p></div>";
		update_option("wpeevent_notice_shown", "true");
	}
}



// add paypal menu
add_action("admin_menu", "wpeevent_plugin_menu");
function wpeevent_plugin_menu() {
	global $plugin_dir_url;
	
	add_menu_page("PayPal Events", "PayPal Events", "manage_options", "wpeevent_menu", "wpeevent_plugin_orders",'dashicons-cart','28.5');
	
	add_submenu_page("wpeevent_menu", "Orders", "Orders", "manage_options", "wpeevent_menu", "wpeevent_plugin_orders");
	
	add_submenu_page("wpeevent_menu", "Events", "Events", "manage_options", "wpeevent_buttons", "wpeevent_plugin_buttons");
	
	add_submenu_page("wpeevent_menu", "Settings", "Settings", "manage_options", "wpeevent_settings", "wpeevent_plugin_options");
}



function wpeevent_action_links($links) {

global $support_link, $edit_link, $settings_link;
   $links[] = '<a href="https://wordpress.org/support/plugin/easy-paypal-events" target="_blank">Support</a>';
   $links[] = '<a href="admin.php?page=wpeevent_settings">Settings</a>';
   return $links;
}

add_filter( 'plugin_action_links_' . $plugin_basename, 'wpeevent_action_links' );

