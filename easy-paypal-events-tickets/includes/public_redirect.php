<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//add_action('admin_post_add_wpeevent_button_redirect', 'wpeevent_button_redirect');
//add_action('admin_post_nopriv_add_wpeevent_button_redirect', 'wpeevent_button_redirect');

add_action( 'init', 'wpeevent_button_redirect' );

function wpeevent_button_redirect() {

	if ( isset($_GET['action']) && $_GET['action'] == 'add_wpeevent_button_redirect' ) {

?>
<!doctype html>
<html>
<head>
<title>Redirecting to Paypal...</title>
</head>
<body>
<form action='https://www.<?php echo esc_attr($_POST['path']); ?>.com/cgi-bin/webscr' method='post' name="wpeevent">
<input type='hidden' name='cmd' value='_cart' />
<input type='hidden' name='business' value='<?php echo esc_attr($_POST['business']); ?>' />
<input type='hidden' name='item_name' value='<?php echo esc_attr($_POST['item_name']); ?>' />
<input type='hidden' name='currency_code' value='<?php echo esc_attr($_POST['currency_code']); ?>' />
<input type='hidden' name='bn' value='WPPlugin_SP'>
<input type='hidden' name='notify_url' value='<?php echo esc_attr($_POST['notify_url']); ?>'>
<input type='hidden' name='lc' value='<?php echo esc_attr($_POST['lc']); ?>'>
<input type='hidden' name='cancel_return' value='<?php echo esc_attr($_POST['cancel_return']); ?>' />
<input type='hidden' name='return' value='<?php echo esc_attr($_POST['return']); ?>' />
<input type='hidden' name='no_shipping' value='<?php echo esc_attr($_POST['no_shipping']); ?>'>
<input type='hidden' name='no_note' value='<?php echo esc_attr($_POST['no_note']); ?>'>
<input type='hidden' name='upload' value='1' />

<?php


$number = "0";
$custom = "";


// a
if ($_POST['wpeevent_button_qty_a'] >= 1) {

	$number++;

	$item_name_1 = sanitize_text_field($_POST['item_name_1']);
	$amount_1 = sanitize_text_field($_POST['amount_1']);
	$id_1 = sanitize_text_field($_POST['id_1']);
	$quantity_1 = sanitize_text_field($_POST['wpeevent_button_qty_a']);
	echo "<input type='hidden' name='item_name_1' value='" . esc_attr($item_name_1) . "'>";
	echo "<input type='hidden' name='amount_1' value='" . esc_attr($amount_1) . "'>";
	echo "<input type='hidden' name='item_number_1' value='" . esc_attr($id_1) . "'>";
	echo "<input type='hidden' name='quantity_1' value='" . esc_attr($quantity_1) . "'>";
	
	$custom .= "1|$quantity_1|";
}

// b
if (!empty($_POST['wpeevent_button_qty_b']) && $_POST['wpeevent_button_qty_b'] >= 1) {

	$number++;

	$item_name_2 = sanitize_text_field($_POST['item_name_2']);
	$amount_2 = sanitize_text_field($_POST['amount_2']);
	$id_2 = sanitize_text_field($_POST['id_2']);
	$quantity_2 = sanitize_text_field($_POST['wpeevent_button_qty_b']);
	echo "<input type='hidden' name='item_name_$number' value='" . esc_attr($item_name_2) . "'>";
	echo "<input type='hidden' name='amount_$number' value='" . esc_attr($amount_2) . "'>";
	echo "<input type='hidden' name='item_number_$number' value='" . esc_attr($id_2) . "'>";
	echo "<input type='hidden' name='quantity_$number' value='" . esc_attr($quantity_2) . "'>";
	
	$custom .= "2|$quantity_2|";
}

// c
if (!empty($_POST['wpeevent_button_qty_c']) && $_POST['wpeevent_button_qty_c'] >= 1) {

	$number++;
	
	$item_name_3 = sanitize_text_field($_POST['item_name_3']);
	$amount_3 = sanitize_text_field($_POST['amount_3']);
	$id_3 = sanitize_text_field($_POST['id_3']);
	$quantity_3 = sanitize_text_field($_POST['wpeevent_button_qty_c']);
	echo "<input type='hidden' name='item_name_$number' value='" . esc_attr($item_name_3) . "'>";
	echo "<input type='hidden' name='amount_$number' value='" . esc_attr($amount_3) . "'>";
	echo "<input type='hidden' name='item_number_$number' value='" . esc_attr($id_3) . "'>";
	echo "<input type='hidden' name='quantity_$number' value='" . esc_attr($quantity_3) . "'>";
	
	$custom .= "3|$quantity_3|";
}

// d
if (!empty($_POST['wpeevent_button_qty_d']) && $_POST['wpeevent_button_qty_d'] >= 1) {

	$number++;

	$item_name_4 = sanitize_text_field($_POST['item_name_4']);
	$amount_4 = sanitize_text_field($_POST['amount_4']);
	$id_4= sanitize_text_field($_POST['id_4']);
	$quantity_4 = sanitize_text_field($_POST['wpeevent_button_qty_d']);
	echo "<input type='hidden' name='item_name_$number' value='" . esc_attr($item_name_4) . "'>";
	echo "<input type='hidden' name='amount_$number' value='" . esc_attr($amount_4) . "'>";
	echo "<input type='hidden' name='item_number_$number' value='" . esc_attr($id_4) . "'>";
	echo "<input type='hidden' name='quantity_$number' value='" . esc_attr($quantity_4) . "'>";
	
	$custom .= "4|$quantity_4|";
}

// e
if (!empty($_POST['wpeevent_button_qty_e']) && $_POST['wpeevent_button_qty_e'] >= 1) {

	$number++;

	$item_name_5 = sanitize_text_field($_POST['item_name_5']);
	$amount_5 = sanitize_text_field($_POST['amount_5']);
	$id_5 = sanitize_text_field($_POST['id_5']);
	$quantity_5 = sanitize_text_field($_POST['wpeevent_button_qty_e']);
	echo "<input type='hidden' name='item_name_$number' value='" . esc_attr($item_name_5) . "'>";
	echo "<input type='hidden' name='amount_$number' value='" . esc_attr($amount_5) . "'>";
	echo "<input type='hidden' name='item_number_$number' value='" . esc_attr($id_5) . "'>";
	echo "<input type='hidden' name='quantity_$number' value='" . esc_attr($quantity_5) . "'>";
	
	$custom .= "5|$quantity_5|";
}



$custom_a = sanitize_text_field($_POST['custom']);
$custom_done = $custom_a."|".$custom;



?>


<input type='hidden' name='custom' value='<?php echo esc_attr($custom_done); ?>' />

<img alt='' border='0' style='border:none;display:none;' src='https://www.paypal.com/$language/i/scr/pixel.gif' width='1' height='1'>
</form>
<script type="text/javascript">
document.wpeevent.submit();
</script>
</body>
</html>

<?php

exit;

}
}

?>