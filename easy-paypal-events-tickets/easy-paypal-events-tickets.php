<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
Plugin Name: Easy PayPal Events
Plugin URI: https://wpplugin.org/downloads/easy-paypal-events-pro/
Description: A simple and easy way to sell tickets for events.
Tags: PayPal, Events, Tickets, PayPal Buttons, eCommerce
Author: Scott Paterson
Author URI: https://wpplugin.org
License: GPL2
Version: 1.2.2
*/

/*  Copyright 2014-2024 Scott Paterson

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//// variables
// plugin function 	  = wpeevent
// shortcode 		  = wpeevent
// event post type	  = wpplugin_event
// button post type	  = wpplugin_evt_button
$plugin_basename = plugin_basename(__FILE__);


//// plugin functions
wpeevent_wpeasyevents::init_wpeeventwpeasyevents();

class wpeevent_wpeasyevents {
	public static function init_wpeeventwpeasyevents() {
	register_deactivation_hook( __FILE__, array( __CLASS__, "wpeevent_deactivate" ));
	register_uninstall_hook( __FILE__, array( __CLASS__, "wpeevent_uninstall" ));
	
	$admin_email = get_option( 'admin_email' );

	$wpeevent_settingsoptions = array(
		'currency'    				=> '25'
		,'language'    				=> '3'
		,'liveaccount'    			=> ''
		,'sandboxaccount'    		=> ''
		,'mode'    					=> '2'
		,'show_currency'    		=> '0'
		,'size'    					=> '2'
		,'opens'    				=> '2'
		,'no_note'    				=> '1'
		,'no_shipping'    			=> '1'
		,'admin_email_template'		=> 'You have received an order from {payer_email} <br /><br /> You Sold: <br /> {sold_table} <br /> Payment Total - {txn_total} <br /> PayPal ID: {txn_id}'
		,'customer_email_template'	=> 'Thank you for your purchase. Your order is now complete. <br /><br /> <strong>Your ticket details:</strong><br /> {sold_table} <br /> <strong>Payment Total</strong> - {txn_total} <br /> <strong> QR Code:</strong> - {qr_code}'
		,'admin_subject'			=> 'New Customer Order - #{order_num}'
		,'customer_subject'			=> 'Order Complete - #{order_num}'
		,'cancel'    				=> ''
		,'return'    				=> ''
		,'note'    					=> '1'
		,'upload_image'    			=> ''
		,'send_admin_email'			=> '1'
		,'admin_from'				=> 'WordPress'
		,'admin_email'				=> $admin_email
		,'admin_cc_email'			=> ''
		,'send_customer_email'		=> '1'
	);

	add_option("wpeevent_settingsoptions", $wpeevent_settingsoptions);
	}
	
	static function wpeevent_deactivate() {
		delete_option("wpeevent_notice_shown");
	}

	static function wpeevent_uninstall() {
	}
}

//// plugin includes

// private settings page
include_once ('includes/private_functions.php');

// private button inserter
include_once ('includes/private_button_inserter.php');

// private orders page
include_once ('includes/private_orders.php');

// private buttons page
include_once ('includes/private_buttons.php');

// private settings page
include_once ('includes/private_settings.php');

// public shortcode
include_once ('includes/public_shortcode.php');

// private filters
include_once ('includes/private_filters.php');

// public redirect
include_once ('includes/public_redirect.php');

// public ipn
include_once ('includes/public_ipn.php');

// public qr
include_once ('includes/public_scan_qr.php');

?>