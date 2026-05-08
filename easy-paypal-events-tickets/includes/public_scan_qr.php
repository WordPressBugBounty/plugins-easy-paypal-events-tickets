<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// qr post
//add_action('admin_post_add_wpeevent_button_qr', 'wpplugin_wpeevent_button_qr');
//add_action('admin_post_nopriv_add_wpeevent_button_qr', 'wpplugin_wpeevent_button_qr');

add_action( 'init', 'wpplugin_wpeevent_button_qr' );

function wpplugin_wpeevent_button_qr() {

	if ( isset($_GET['action']) && $_GET['action'] == 'add_wpeevent_button_qr' ) {

    // get order post id details
    $order = sanitize_text_field($_GET['order']);

    // Validate order parameter format
    if (empty($order) || substr_count($order, '|') !== 2) {
        wp_die('Invalid order format', 'Invalid Request', array('response' => 400));
    }

    // decrypt
    $piece = explode("|", $order);
    $custom_raw = sanitize_text_field($piece[0]);
    $post_id_raw = sanitize_text_field($piece[1]);
    $hash = sanitize_text_field($piece[2]);

    // Check if this is a test mode request with valid nonce
    $is_test_mode = false;
    if ($post_id_raw === 'test') {
        // For test mode, verify against the static test hash
        $expected_test_hash = md5('wpeevent_test_mode_' . wp_salt());
        if (hash_equals($expected_test_hash, $hash)) {
            $is_test_mode = true;
        } else {
            wp_die('Invalid test hash', 'Invalid Request', array('response' => 403));
        }
    }
    
    // Only convert to int if not in test mode
    if (!$is_test_mode) {
        $custom = absint($custom_raw);
    }

    if ($is_test_mode) {
        // Display test order information - no real data accessed
        ?>
        <!DOCTYPE html>
        <html lang="en-US">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>
        <body>
        <table><tr><td>
        
        <h1><center>This test is working correctly!</center></h1>
        <h4><center>For real orders, the below details will be filled in.</center></h4>
        <br><br>
        
        <b>Transaction</b></td></tr><tr><td>
        PayPal Txn ID: </td><td><a target="_blank" href="https://www.paypal.com/us/cgi-bin/webscr?cmd=_view-a-trans&id=9XS549502E280412S">9XS549502E280412S</a></td></tr><tr><td>
        Order Date: </td><td><?php echo esc_html(current_time('mysql')); ?></td></tr><tr><td>
        Order Status: </td><td>Completed</td></tr><tr><td>
        Total Amount: </td><td>50.00</td></tr><tr><td>

        <br /></td><td></td></tr><tr><td>
        <b>Ticket</b></td></tr><tr><td>
        eTicket Already Scanned: </td><td>No</td></tr><tr><td>

        <br /></td><td></td></tr><tr><td>
        <b>Event</b></td></tr><tr><td>
        Event Name: </td><td>Test Event Name</td></tr><tr><td>

        <br /></td><td></td></tr><tr><td>
        <b>Items</b></td></tr><tr>
        <td colspan='3' style='border-top:1px dashed #888;'></td></tr><tr><td width='30px'>
        #1 </td><td width='120px'>Name:</td><td>test</td></tr><tr><td></td><td>Quantity:</td><td>1</td></tr><tr><td></td><td>Price:</td><td>2.21</td></tr><tr><td></td></tr><tr>
        <td colspan='3' style='border-top:1px dashed #888;'></td></tr><tr><td width='30px'>
        #2 </td><td width='120px'>Name:</td><td>test2</td></tr><tr><td></td><td>Quantity:</td><td>2</td></tr><tr><td></td><td>Price:</td><td>2.00</td></tr><tr><td></td></tr><tr>
        <td colspan='3' style='border-top:1px dashed #888;'></td></tr><tr><td width='30px'>
        #3 </td><td width='120px'>Name:</td><td>test3</td></tr><tr><td></td><td>Quantity:</td><td>3</td></tr><tr><td></td><td>Price:</td><td>12.00</td></tr><tr><td colspan='3' style='border-top:1px dashed #888;'></td></tr><tr>
        </tr></table>
        </body>
        </html>
        <?php
        exit;
    }
    
    $post_id = absint($post_id_raw);

    // Validate post ID
    if ($post_id <= 0) {
        wp_die('Invalid order ID', 'Invalid Request', array('response' => 400));
    }

    $post_data = get_post($post_id);
    
    // Verify post exists and is an order
    if (!$post_data || $post_data->post_type !== 'wpplugin_event') {
        wp_die('Order not found', 'Invalid Request', array('response' => 404));
    }

    // Get the secure token stored with this order
    $secure_token = get_post_meta($post_id, 'wpeevent_button_qr_token', true);
    
    if (empty($secure_token)) {
        wp_die('Invalid order - security token not found', 'Invalid Request', array('response' => 403));
    }

    // Generate the expected hash using the stored token
    $expected_hash = hash_hmac('sha256', $post_id . '|' . $custom, $secure_token);

    // Verify hash matches using strict comparison
    if (hash_equals($expected_hash, $hash)) {

        // display information about order
        ?>
        <!DOCTYPE html>
        <html lang="en-US">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>
        <body>
        <table><tr><td>

        <b>Transaction</b></td></tr><tr><td>
        <?php
        $txn_id = get_post_meta($post_id,'wpeevent_button_txn_id',true);
        ?>
        PayPal Txn ID: </td><td><a target="_blank" href="https://www.paypal.com/us/cgi-bin/webscr?cmd=_view-a-trans&id=<?php echo esc_attr($txn_id); ?>"><?php echo esc_html($txn_id); ?></a></td></tr><tr><td>
        Order Date: </td><td><?php echo esc_html($post_data->post_date); ?></td></tr><tr><td>
        Order Status: </td><td><?php echo esc_html(get_post_meta($post_id,'wpeevent_button_payment_status',true)); ?></td></tr><tr><td>
        Total Amount: </td><td><?php echo esc_html(get_post_meta($post_id,'wpeevent_button_payment_amount',true)); ?></td></tr><tr><td>

        <br /></td><td></td></tr><tr><td>
        <b>Ticket</b></td></tr><tr><td>
        eTicket Already Scanned: </td><td><?php	if (get_post_meta($post_id,'wpeevent_button_scanned',true) == "1") { echo "Yes"; } else { echo "No"; } ?></td></tr><tr><td>

        <br /></td><td></td></tr><tr><td>
        <b>Event</b></td></tr><tr><td>
        Event Name: </td><td><?php echo esc_html(get_post_meta($post_id,'wpeevent_button_event_name',true)); ?></td></tr><tr><td>

        <br /></td><td></td></tr><tr><td>
        <b>Items</b></td></tr><tr>

        <?php
        // pre count for border seperator
        for( $i = 0; $i<20; $i++ ) {
            if (get_post_meta($post_id,"wpeevent_button_item_name_$i",true)) {
                $count  = $i;
            }
        }

        $custom = intval(get_post_meta($post_id,'wpeevent_button_custom',true));

        $out = "";
        for( $i = 0; $i<20; $i++ ) {
            if (esc_attr(get_post_meta($post_id,"wpeevent_button_item_name_$i",true))) {
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

        echo wp_kses_post($out);
        ?>

        </tr><tr><td></td>

        </tr></table>
        </body>
        </html>
        <?php

        // update order scanned status
        update_post_meta($post_id, 'wpeevent_button_scanned','1');

        exit;

    } else {

        echo "Invalid hash or order deleted";

        exit;

    }
	
}
}
?>