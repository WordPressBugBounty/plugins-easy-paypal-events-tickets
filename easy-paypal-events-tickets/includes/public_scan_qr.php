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

    // decrypt
    $piece = explode("|", $order);
    $custom = $piece[0];
    $post_id = $piece[1];
    $hash = $piece[2];

    $post_data = get_post($post_id);
    $post_date = $post_data->post_date;

    $realhash = md5($post_date);

    if ($hash == $realhash || $hash == 'test') {

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

        <?php
        if ($hash == 'test') {
            echo "<h1><center>This test is working correctly!</center></h1>";
            echo "<h4><center>For real orders, the below details will be filled in.</center></h4>";
            echo "<br><br>";
        }
        ?>

        <b>Transaction</b></td></tr><tr><td>
        <?php
        $txn_id = get_post_meta($post_id,'wpeevent_button_txn_id',true);
        ?>
        PayPal Txn ID: </td><td><a target="_blank" href="https://www.paypal.com/us/cgi-bin/webscr?cmd=_view-a-trans&id=<?php echo esc_attr($txn_id); ?>"><?php echo esc_html($txn_id); ?></a></td></tr><tr><td>
        Order Date: </td><td><?php echo esc_html($post_date); ?></td></tr><tr><td>
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

        echo $out;
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