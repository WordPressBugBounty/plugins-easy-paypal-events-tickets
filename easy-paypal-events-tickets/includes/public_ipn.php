<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// paypal post
//add_action('admin_post_add_wpeevent_button_ipn', 'wpplugin_wpeevent_button_ipn');
//add_action('admin_post_nopriv_add_wpeevent_button_ipn', 'wpplugin_wpeevent_button_ipn');

add_action( 'init', 'wpplugin_wpeevent_button_ipn' );

function wpplugin_wpeevent_button_ipn() {

	if ( isset($_GET['action']) && $_GET['action'] == 'add_wpeevent_button_ipn' ) {

	$options = get_option('wpeevent_settingsoptions');
	foreach ($options as $k => $v ) { $value[$k] = $v; }
	
	if ($value['mode'] == "1") {
		define("USE_SANDBOX", 1);
	} else {
		define("USE_SANDBOX", 0);
	}

	$raw_post_data = file_get_contents('php://input');
	$raw_post_array = explode('&', $raw_post_data);
	$myPost = array();
	foreach ($raw_post_array as $keyval) {
		$keyval = explode ('=', $keyval);
		if (count($keyval) == 2)
			$myPost[$keyval[0]] = urldecode($keyval[1]);
	}

	$req = 'cmd=_notify-validate';
	if(function_exists('get_magic_quotes_gpc')) {
		$get_magic_quotes_exists = true;
	}
	foreach ($myPost as $key => $value) {
		if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
			$value = urlencode(stripslashes($value));
		} else {
			$value = urlencode($value);
		}
		$req .= "&$key=$value";
	}

	if(USE_SANDBOX == true) {
		$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
	} else {
		$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
	}

    $args = array(
        'timeout'   => 30,
        'headers'   => array(
            'connection'    => 'close'
        ),
        'body'      => $req
    );
    $res = wp_safe_remote_post($paypal_url, $args);

    if (is_wp_error($res) || empty($res['body'])) {
        exit;
    } else {
    }

    $res = $res['body'];

	if (strcmp ($res, "VERIFIED") == 0) {

		// assign posted variables to local variables
		$txn_id = 					sanitize_text_field($_POST['txn_id']);
		$custom = 					sanitize_text_field($_POST['custom']);
		
		// expode custom value array
		$custom_array = explode("|", $custom);
		
		// get first value
		$custom = intval($custom_array[0]);
		
		
		// reduce inventory quantity
		
		// if setting to turn on decrement inventory is on
        //$inventory == "0";
		if (isset($inventory) && $inventory == "1") {
			// remove first and last value from array
			array_shift($custom_array);
			array_pop($custom_array);
			
			$count_array = count($custom_array);
			
			$counter = "0";
			$counter_alpha = "a";
			
			while ($counter < $count_array) {
				
				// get old quantity
				$wpeevent_button_qty = intval(get_post_meta($custom,"wpeevent_button_qty_$counter_alpha",true));
				if (!$wpeevent_button_qty) { $wpeevent_button_qty = 0; }
				
				$counter++;
				$qty_sold = $custom_array[$counter];
				
				$new_qty = $wpeevent_button_qty - $qty_sold;
				
				if ($new_qty < 0) {
					$new_qty = "0";
				}
				update_post_meta($custom,"wpeevent_button_qty_$counter_alpha",$new_qty);
				
				$counter++;
				$counter_alpha++;
			}
		}
		
		
		
		
		// lookup post author to save ipn as based on author of button
		$post_id_data = 		get_post($custom); 
		$post_id_author = 		$post_id_data->post_author;
		
		// save responce to db
		
		// make sure txt id isset, if payment is recurring paypal will post successful ipn separately and that should not be logged
		if (!empty($txn_id)) {
			
			// assign posted variables to local variables
			
			$item_name_1 = 			sanitize_text_field($_POST['item_name1']);
			$item_price_1 = 		sanitize_text_field($_POST['mc_gross_1']);
			$item_qty_1 = 			sanitize_text_field($_POST['quantity1']);				
			$payment_status = 		sanitize_text_field($_POST['payment_status']);
			$payment_amount = 		sanitize_text_field($_POST['mc_gross']);
			$payment_currency = 	sanitize_text_field($_POST['mc_currency']);
			$payer_email = 			sanitize_email($_POST['payer_email']);
			$fee = 					sanitize_text_field($_POST['mc_fee']);
			
			$ipn_post = array(
				'post_title'    => $item_name_1,
				'post_status'   => 'publish',
				'post_author'   => $post_id_author,
				'post_type'     => 'wpplugin_event'
			);
			
			// left here as a debugging tool
			//$payment_status = file_get_contents("php://input");
			
			
			
			
			
			// before inserting into db and sending emails, make sure we havnt already processed this txn id before		
			$meta_key = 'wpeevent_button_txn_id';

			// Query posts with the specific meta value
			$args = array(
				'post_type' => 'wpplugin_event', // Replace with your post type
				'meta_query' => array(
					array(
						'key' => $meta_key,
						'value' => $txn_id,
						'compare' => '='
					)
				)
			);

			$query = new WP_Query($args);

			if ($query->have_posts()) {
				while ($query->have_posts()) {
					$query->the_post();
					$post_id = get_the_ID();
					
					// txn id found, exit since it's already in db
					exit;
				}
				wp_reset_postdata();
			}
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			// event name
			$event_name_data = get_post($custom);
			$event_name = $event_name_data->post_title;
			
			$post_id = wp_insert_post($ipn_post);
			update_post_meta($post_id, 'wpeevent_button_payment_status', $payment_status);
			update_post_meta($post_id, 'wpeevent_button_payment_amount', $payment_amount);
			update_post_meta($post_id, 'wpeevent_button_payment_currency', $payment_currency);
			update_post_meta($post_id, 'wpeevent_button_txn_id', $txn_id);
			update_post_meta($post_id, 'wpeevent_button_payer_email', $payer_email);
			update_post_meta($post_id, 'wpeevent_button_event_name', $event_name);
			update_post_meta($post_id, 'wpeevent_button_custom', $custom);
			
			// generate qr code
			$post_data = get_post($post_id);
			$post_date = $post_data->post_date;
			$hash = md5($post_date);
			$qr_url = get_admin_url() . "admin-post.php?action=add_wpeevent_button_qr&order=$custom|$post_id|$hash";
			$qr_url = urlencode($qr_url);
			$qr_code = "<img src='https://quickchart.io/chart?cht=qr&chs=150x150&chl=$qr_url&choe=UTF-8' />";
			
			// item name
			update_post_meta($post_id, 'wpeevent_button_item_name_1', $item_name_1);
			$item_name_2 = 			sanitize_text_field($_POST['item_name2']);
			if ($item_name_2) {
				update_post_meta($post_id, 'wpeevent_button_item_name_2', $item_name_2);
			}
			$item_name_3 = 			sanitize_text_field($_POST['item_name3']);
			if ($item_name_3) {
				update_post_meta($post_id, 'wpeevent_button_item_name_3', $item_name_3);
			}
			
			// item qty
			update_post_meta($post_id, 'wpeevent_button_item_qty_1', $item_qty_1);
			$item_qty_2 = 			intval($_POST['quantity2']);
			if ($item_qty_2) {
				update_post_meta($post_id, 'wpeevent_button_item_qty_2', $item_qty_2);
			}
			$item_qty_3 = 			intval($_POST['quantity3']);
			if ($item_qty_3) {
				update_post_meta($post_id, 'wpeevent_button_item_qty_3', $item_qty_3);
			}
			
			// item price
			update_post_meta($post_id, 'wpeevent_button_item_price_1', $item_price_1);
			$item_price_2 = 			intval($_POST['mc_gross_2']);
			if ($item_price_2) {
				update_post_meta($post_id, 'wpeevent_button_item_price_2', $item_price_2);
			}
			$item_price_3 = 			intval($_POST['mc_gross_3']);
			if ($item_price_3) {
				update_post_meta($post_id, 'wpeevent_button_item_price_3', $item_price_3);
			}
			
			// item number
			$item_number_1 = 			sanitize_text_field($_POST['item_number1']);
			if ($item_number_1) {
				update_post_meta($post_id, 'wpeevent_button_item_number_1', $item_number_1);
			}
			$item_number_2 = 			sanitize_text_field($_POST['item_number2']);
			if ($item_number_2) {
				update_post_meta($post_id, 'wpeevent_button_item_number_2', $item_number_2);
			}
			$item_number_3 = 			sanitize_text_field($_POST['item_number3']);
			if ($item_number_3) {
				update_post_meta($post_id, 'wpeevent_button_item_number_3', $item_number_3);
			}

            // pre count for border seperator
            for( $i = 0; $i<20; $i++ ) {
                if (get_post_meta($post_id,"wpeevent_button_item_name_$i",true)) {
                    $count  = $i;
                }
            }

            $out = "<table width='400px'>";
            for( $i = 0; $i<20; $i++ ) {
                if (get_post_meta($post_id,"wpeevent_button_item_name_$i",true)) {
                    $out .= "<td colspan='3' style='border-top:1px dashed #888;'></td></tr><tr><td width='30px'>";
                    $out .= "#" . esc_html($i) . " </td><td width='120px'>";
                    $out .= esc_html(get_post_meta($custom,'wpeevent_button_h_name',true)); $out .= "</td><td>"; $out .= esc_html(get_post_meta($post_id,"wpeevent_button_item_name_$i",true)); $out .= "</td></tr><tr><td></td><td>";
                    $out .= esc_html(get_post_meta($custom,'wpeevent_button_h_title',true)); $out .= "</td><td>"; $out .= esc_html(get_post_meta($post_id,"wpeevent_button_item_qty_$i",true)); $out .="</td></tr><tr><td></td><td>";
                    $out .= esc_html(get_post_meta($custom,'wpeevent_button_h_price',true)); $out .= "</td><td>"; $amount = esc_html(get_post_meta($post_id,"wpeevent_button_item_price_$i",true)); $out .= number_format((float)$amount, 2, '.', '');
                    if ($count == $i) {
                        $out .= "</td></tr><tr><td colspan='3' style='border-top:1px dashed #888;'>";
                    } else {
                        $out .= "</td></tr><tr><td>";
                    }
                    $out .= "</td></tr><tr>";
                }
            }
            $out .= "</tr></table>";

            $item_name = $out;

			// send emails
			$send_admin_email = "1";
			$send_customer_email = "1";
			include_once ('private_emails.php');
		}
		
	} else if (strcmp ($res, "INVALID") == 0) {
	}

}
}