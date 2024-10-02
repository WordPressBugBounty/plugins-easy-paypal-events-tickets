<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

		if (isset($_POST['update'])) {
			
			$post_id = intval($_GET['product']);
			
			// check nonce for security
			$nonce = $_REQUEST['_wpnonce'];
			if ( ! wp_verify_nonce( $nonce, 'edit_'.$post_id ) ) {
				echo "Nonce verification failed.";
				exit;
			}
			
			if (!$post_id) {
				echo'<script>window.location="admin.php?page=wpeevent_buttons"; </script>';
				exit;
			}
			
			// Update data
			$my_post = array(
			'ID'           => $post_id,
			'post_title'   => sanitize_text_field($_POST['wpeevent_button_name'])
			);
			wp_update_post($my_post);

			$wpeevent_button_show = !empty($_POST['wpeevent_button_show']) ? sanitize_text_field($_POST['wpeevent_button_show']) : 0;
            update_post_meta($post_id, "wpeevent_button_show", $wpeevent_button_show);

			$wpeevent_button_border = !empty($_POST['wpeevent_button_border']) ? sanitize_text_field($_POST['wpeevent_button_border']) : 0;
            update_post_meta($post_id, "wpeevent_button_border", $wpeevent_button_border);

			$wpeevent_button_header = !empty($_POST['wpeevent_button_header']) ? sanitize_text_field($_POST['wpeevent_button_header']) : 0;
            update_post_meta($post_id, "wpeevent_button_header", $wpeevent_button_header);

			update_post_meta($post_id, 'wpeevent_button_pp_text', sanitize_text_field($_POST['wpeevent_button_pp_text']));
			
			update_post_meta($post_id, 'wpeevent_button_sold_out', sanitize_text_field($_POST['wpeevent_button_sold_out']));
			
			$wpeevent_button_currency =			intval($_POST['wpeevent_button_currency']);
			if (!$wpeevent_button_currency) { 	$wpeevent_button_currency = ""; }
			update_post_meta($post_id, 'wpeevent_button_currency', $wpeevent_button_currency);	
			
			$wpeevent_button_language =			intval($_POST['wpeevent_button_language']);
			if (!$wpeevent_button_language) { 	$wpeevent_button_language = ""; }
			update_post_meta($post_id, 'wpeevent_button_language', $wpeevent_button_language);	
			
			$wpeevent_button_buttonsize =			intval($_POST['wpeevent_button_buttonsize']);
			if (!$wpeevent_button_buttonsize && $wpeevent_button_buttonsize != "0") { 	$wpeevent_button_buttonsize = ""; }
			update_post_meta($post_id, 'wpeevent_button_buttonsize', $wpeevent_button_buttonsize);
			
			//update_post_meta($post_id, 'wpeevent_button_account', sanitize_text_field($_POST['wpeevent_button_account']));
			//update_post_meta($post_id, 'wpeevent_button_return', sanitize_text_field($_POST['wpeevent_button_return']));
			
			// name
			update_post_meta($post_id, 'wpeevent_button_name_a', sanitize_text_field($_POST['wpeevent_button_name_a']));
			update_post_meta($post_id, 'wpeevent_button_name_b', sanitize_text_field($_POST['wpeevent_button_name_b']));
			update_post_meta($post_id, 'wpeevent_button_name_c', sanitize_text_field($_POST['wpeevent_button_name_c']));
			//update_post_meta($post_id, 'wpeevent_button_name_d', sanitize_text_field($_POST['wpeevent_button_name_d']));
			//update_post_meta($post_id, 'wpeevent_button_name_e', sanitize_text_field($_POST['wpeevent_button_name_e']));
			
			// header names
			update_post_meta($post_id, 'wpeevent_button_h_title', sanitize_text_field($_POST['wpeevent_button_h_title']));
			update_post_meta($post_id, 'wpeevent_button_h_name', sanitize_text_field($_POST['wpeevent_button_h_name']));
			update_post_meta($post_id, 'wpeevent_button_h_price', sanitize_text_field($_POST['wpeevent_button_h_price']));
			update_post_meta($post_id, 'wpeevent_button_h_desc', sanitize_text_field($_POST['wpeevent_button_h_desc']));
			
			// price
			$wpeevent_button_price_a = sanitize_meta( 'currency_wpeevent', $_POST['wpeevent_button_price_a'], 'post' );
			update_post_meta($post_id, 'wpeevent_button_price_a', $wpeevent_button_price_a);
			$wpeevent_button_price_b = sanitize_meta( 'currency_wpeevent', $_POST['wpeevent_button_price_b'], 'post' );
			update_post_meta($post_id, 'wpeevent_button_price_b', $wpeevent_button_price_b);
			$wpeevent_button_price_c = sanitize_meta( 'currency_wpeevent', $_POST['wpeevent_button_price_c'], 'post' );
			update_post_meta($post_id, 'wpeevent_button_price_c', $wpeevent_button_price_c);
			//$wpeevent_button_price_d = sanitize_meta( 'currency_wpeevent', $_POST['wpeevent_button_price_d'], 'post' );
			//update_post_meta($post_id, 'wpeevent_button_price_d', $wpeevent_button_price_d);
			//$wpeevent_button_price_e = sanitize_meta( 'currency_wpeevent', $_POST['wpeevent_button_price_e'], 'post' );
			//update_post_meta($post_id, 'wpeevent_button_price_e', $wpeevent_button_price_e);
			
			// id - can be an alphanumeric value
			update_post_meta($post_id, 'wpeevent_button_id_a', sanitize_text_field($_POST['wpeevent_button_id_a']));
			update_post_meta($post_id, 'wpeevent_button_id_b', sanitize_text_field($_POST['wpeevent_button_id_b']));
			update_post_meta($post_id, 'wpeevent_button_id_c', sanitize_text_field($_POST['wpeevent_button_id_c']));
			//update_post_meta($post_id, 'wpeevent_button_id_d', sanitize_text_field($_POST['wpeevent_button_id_d']));
			//update_post_meta($post_id, 'wpeevent_button_id_e', sanitize_text_field($_POST['wpeevent_button_id_e']));
			
			// qty - internval
			
			$wpeevent_button_qty_a =	intval($_POST['wpeevent_button_qty_a']);
			if (!$wpeevent_button_qty_a) { $wpeevent_button_qty_a = ""; }
			update_post_meta($post_id, 'wpeevent_button_qty_a', $wpeevent_button_qty_a);
			
			$wpeevent_button_qty_b =	intval($_POST['wpeevent_button_qty_b']);
			if (!$wpeevent_button_qty_b) { $wpeevent_button_qty_b = ""; }
			update_post_meta($post_id, 'wpeevent_button_qty_b', $wpeevent_button_qty_b);
			
			$wpeevent_button_qty_c =	intval($_POST['wpeevent_button_qty_c']);
			if (!$wpeevent_button_qty_c) { $wpeevent_button_qty_c = ""; }
			update_post_meta($post_id, 'wpeevent_button_qty_c', $wpeevent_button_qty_c);
			
			//$wpeevent_button_qty_d =	intval($_POST['wpeevent_button_qty_d']);
			//if (!$wpeevent_button_qty_d) { $wpeevent_button_qty_d = ""; }
			//update_post_meta($post_id, 'wpeevent_button_qty_d', $wpeevent_button_qty_d);
			
			//$wpeevent_button_qty_e =	intval($_POST['wpeevent_button_qty_e']);
			//if (!$wpeevent_button_qty_e) { $wpeevent_button_qty_e = ""; }
			//update_post_meta($post_id, 'wpeevent_button_qty_e', $wpeevent_button_qty_e);
			
			// desc
			update_post_meta($post_id, 'wpeevent_button_desc_a', sanitize_text_field($_POST['wpeevent_button_desc_a']));
			update_post_meta($post_id, 'wpeevent_button_desc_b', sanitize_text_field($_POST['wpeevent_button_desc_b']));
			update_post_meta($post_id, 'wpeevent_button_desc_c', sanitize_text_field($_POST['wpeevent_button_desc_c']));
			//update_post_meta($post_id, 'wpeevent_button_desc_d', sanitize_text_field($_POST['wpeevent_button_desc_d']));
			//update_post_meta($post_id, 'wpeevent_button_desc_e', sanitize_text_field($_POST['wpeevent_button_desc_e']));
			
			// Check for errors
			$message = [];
			if (empty($_POST['wpeevent_button_name'])) {
				$message[] = "Event Name Field Required";
				$error = "1";
			}
			
			if (empty($_POST['wpeevent_button_name_a'])) {
				$message[] = "Event Menu 1 Name Field Required";
				$error = "1";
			}
			
			if (empty($_POST['wpeevent_button_price_a'])) {
				$message[] = "Event Menu 1 Price Field Required";
				$error = "1";
			}
			
			if (!empty($_POST['wpeevent_button_name_b']) || !empty($_POST['wpeevent_button_price_b']) || !empty($_POST['wpeevent_button_qty_b']) || !empty($_POST['wpeevent_button_desc_b'])) {
				if (empty($_POST['wpeevent_button_name_b'])) {
					$message[] = "Event Menu 2 Name Field Required";
					$error = "1";
				}
				
				if (empty($_POST['wpeevent_button_price_b'])) {
					$message[] = "Event Menu 2 Price Field Required";
					$error = "1";
				}
			}
			
			if (!empty($_POST['wpeevent_button_name_c']) || !empty($_POST['wpeevent_button_price_c']) || !empty($_POST['wpeevent_button_qty_c']) || !empty($_POST['wpeevent_button_desc_c'])) {
				if (empty($_POST['wpeevent_button_name_b'])) {
					$message[] = "Event Menu 2 Name Field Required";
					$error = "1";
				}
				
				if (empty($_POST['wpeevent_button_price_b'])) {
					$message[] = "Event Menu 2 Price Field Required";
					$error = "1";
				}
				if (empty($_POST['wpeevent_button_name_c'])) {
					$message[] = "Event Menu 3 Name Field Required";
					$error = "1";
				}
				
				if (empty($_POST['wpeevent_button_price_c'])) {
					$message[] = "Event Menu 3 Price Field Required";
					$error = "1";
				}
			}
			
			if (!isset($error)) {
			
				$message[] = "Saved";
			
			}
		}
		
		// check nonce for security
		$nonce = $_REQUEST['_wpnonce'];
		if ( ! wp_verify_nonce( $nonce, 'edit_'.$post_id ) ) {
			echo "Nonce verification failed.";
			exit;
		}
		
		?>
		
		<div style="width:98%;">
		
			<form method='post'>
			
				<?php
				$post_id = intval($_GET['product']);
				
				if (!$post_id) {
					echo'<script>window.location="admin.php?page=wpeevent_buttons"; </script>';
					exit;
				}
				
				$post_data = get_post($post_id);
				$title = $post_data->post_title;
				
				$siteurl = get_site_url();
				?>
				
				<table width="100%"><tr><td valign="bottom" width="85%">
					<br />
					<span style="font-size:20pt;">Edit Event</span>
					</td><td valign="bottom">
					<input type="submit" class="button-primary" style="font-size: 14px;height: 30px;float: right;" value="Save Event">
					</td><td valign="bottom">
					<a href="admin.php?page=wpeevent_buttons" class="button-secondary" style="font-size: 14px;height: 30px;float: right;">View All Events</a>
				</td></tr></table>
				
				<?php
				// error
				if (isset($error) && isset($message)) {
					foreach ($message as $messagea) {
						echo "<div class='error'><p>"; echo esc_html($messagea); echo"</p></div>";
					}
					
				}
				// saved
				if (!isset($error) && isset($message)) {
					foreach ($message as $messagea) {
						echo "<div class='updated'><p>"; echo esc_html($messagea); echo"</p></div>";
					}
				}
				?>
				
				<br />
				
				<div style="background-color:#fff;padding:8px;border: 1px solid #CCCCCC;"><br />
				
					<table><tr><td>
					
						<b>Shortcode</b> </td><td></td></td></td></tr><tr><td>
						Shortcode: </td><td><input type="text" readonly="true" value="<?php echo "[wpeevent id=" . esc_attr($post_id) . "]"; ?>"></td><td>Put this in a page, post, or <a target="_blank" href="https://wpplugin.org/documentation/?document=2314">in your theme</a>, to show the PayPal Event on your site. <br />You can also use the button inserter found above the page or post editor.</td></tr><tr><td>
						</td><td><br /></td></td></td></tr><tr><td>
						
						<b>Main</b> </td><td></td></td></td></tr><tr><td>
						Event Name: </td><td><input type="text" name="wpeevent_button_name" value="<?php echo esc_attr($title); ?>"></td><td> Required - The purpose of the Event. </td></tr><tr><td>
						
						<?php
						$wpeevent_button_show = get_post_meta($post_id, "wpeevent_button_show", true);
						?>
						
						Show Name: </td><td><input type="checkbox" name="wpeevent_button_show" value="1" <?php checked($wpeevent_button_show, '1'); ?>></td><td> Optional - Show the name of the event above the purchase box. </td></tr><tr><td>
						
						</td><td><br /></td></td></td></tr><tr><td>
						<b>Language & Currency</b> </td><td></td></td></td></tr><tr><td>
						
						</td><td><br /></td></td></td></tr><tr><td>
						Language: </td><td>
						<select name="wpeevent_button_language" style="width: 190px">
                            <?php $wpeevent_button_language = get_post_meta($post_id,'wpeevent_button_language',true); ?>
							<option <?php selected($wpeevent_button_language, '0'); ?> value="0">Default Language</option>
							<option <?php selected($wpeevent_button_language, '1'); ?> value="1">Danish</option>
							<option <?php selected($wpeevent_button_language, '2'); ?> value="2">Dutch</option>
							<option <?php selected($wpeevent_button_language, '3'); ?> value="3">English</option>
							<option <?php selected($wpeevent_button_language, '20'); ?> value="20">English - UK</option>
							<option <?php selected($wpeevent_button_language, '4'); ?> value="4">French</option>
							<option <?php selected($wpeevent_button_language, '5'); ?> value="5">German</option>
							<option <?php selected($wpeevent_button_language, '6'); ?> value="6">Hebrew</option>
							<option <?php selected($wpeevent_button_language, '7'); ?> value="7">Italian</option>
							<option <?php selected($wpeevent_button_language, '8'); ?> value="8">Japanese</option>
							<option <?php selected($wpeevent_button_language, '9'); ?> value="9">Norwgian</option>
							<option <?php selected($wpeevent_button_language, '10'); ?> value="10">Polish</option>
							<option <?php selected($wpeevent_button_language, '11'); ?> value="11">Portuguese</option>
							<option <?php selected($wpeevent_button_language, '12'); ?> value="12">Russian</option>
							<option <?php selected($wpeevent_button_language, '13'); ?> value="13">Spanish</option>
							<option <?php selected($wpeevent_button_language, '14'); ?> value="14">Swedish</option>
							<option <?php selected($wpeevent_button_language, '15'); ?> value="15">Simplified Chinese -China only</option>
							<option <?php selected($wpeevent_button_language, '16'); ?> value="16">Traditional Chinese - Hong Kong only</option>
							<option <?php selected($wpeevent_button_language, '17'); ?> value="17">Traditional Chinese - Taiwan only</option>
							<option <?php selected($wpeevent_button_language, '18'); ?> value="18">Turkish</option>
							<option <?php selected($wpeevent_button_language, '19'); ?> value="19">Thai</option>
						</select></td><td>Optional - Will override setttings page value.</td></td></td></tr><tr><td>
						

						Currency: </td><td>
						<select name="wpeevent_button_currency" style="width: 190px">
                            <?php $wpeevent_button_currency = get_post_meta($post_id,'wpeevent_button_currency',true); ?>
							<option <?php selected($wpeevent_button_currency, '0'); ?> value="0">Default Currency</option>
							<option <?php selected($wpeevent_button_currency, '1'); ?> value="1">Australian Dollar - AUD</option>
							<option <?php selected($wpeevent_button_currency, '2'); ?> value="2">Brazilian Real - BRL</option>
							<option <?php selected($wpeevent_button_currency, '3'); ?> value="3">Canadian Dollar - CAD</option>
							<option <?php selected($wpeevent_button_currency, '4'); ?> value="4">Czech Koruna - CZK</option>
							<option <?php selected($wpeevent_button_currency, '5'); ?> value="5">Danish Krone - DKK</option>
							<option <?php selected($wpeevent_button_currency, '6'); ?> value="6">Euro - EUR</option>
							<option <?php selected($wpeevent_button_currency, '7'); ?> value="7">Hong Kong Dollar - HKD</option>
							<option <?php selected($wpeevent_button_currency, '8'); ?> value="8">Hungarian Forint - HUF</option>
							<option <?php selected($wpeevent_button_currency, '9'); ?> value="9">Israeli New Sheqel - ILS</option>
							<option <?php selected($wpeevent_button_currency, '10'); ?> value="10">Japanese Yen - JPY</option>
							<option <?php selected($wpeevent_button_currency, '11'); ?> value="11">Malaysian Ringgit - MYR</option>
							<option <?php selected($wpeevent_button_currency, '12'); ?> value="12">Mexican Peso - MXN</option>
							<option <?php selected($wpeevent_button_currency, '13'); ?> value="13">Norwegian Krone - NOK</option>
							<option <?php selected($wpeevent_button_currency, '14'); ?> value="14">New Zealand Dollar - NZD</option>
							<option <?php selected($wpeevent_button_currency, '15'); ?> value="15">Philippine Peso - PHP</option>
							<option <?php selected($wpeevent_button_currency, '16'); ?> value="16">Polish Zloty - PLN</option>
							<option <?php selected($wpeevent_button_currency, '17'); ?> value="17">Pound Sterling - GBP</option>
							<option <?php selected($wpeevent_button_currency, '18'); ?> value="18">Russian Ruble - RUB</option>
							<option <?php selected($wpeevent_button_currency, '19'); ?> value="19">Singapore Dollar - SGD</option>
							<option <?php selected($wpeevent_button_currency, '20'); ?> value="20">Swedish Krona - SEK</option>
							<option <?php selected($wpeevent_button_currency, '21'); ?> value="21">Swiss Franc - CHF</option>
							<option <?php selected($wpeevent_button_currency, '22'); ?> value="22">Taiwan New Dollar - TWD</option>
							<option <?php selected($wpeevent_button_currency, '23'); ?> value="23">Thai Baht - THB</option>
							<option <?php selected($wpeevent_button_currency, '24'); ?> value="24">Turkish Lira - TRY</option>
							<option <?php selected($wpeevent_button_currency, '25'); ?> value="25">U.S. Dollar - USD</option>
						</select></td><td>Optional - Will override setttings page value.</td></td></td></tr><tr><td>
						
						</td><td><br /></td></td></td></tr><tr><td>
						<b>Other</b> </td><td></td></td></td></tr><tr><td>
						<!--
						PayPal Account: </td><td><input type="text" name="wpeevent_button_account" value="<?php //echo esc_attr(get_post_meta($post_id,'wpeevent_button_account',true)); ?>"></td><td> Optional - Will override setttings page value.</td></tr><tr><td>
						Return URL: </td><td><input type="text" name="wpeevent_button_return" value="<?php //echo esc_attr(get_post_meta($post_id,'wpeevent_button_return',true)); ?>"></td><td> Optional - Will override setttings page value. <br />Example: <?php //echo esc_url($siteurl); ?>/thankyou</td></tr><tr><td>
						-->
						Button Size: </td><td>
						<select name="wpeevent_button_buttonsize" style="width:190px;">
                            <?php $wpeevent_button_buttonsize = get_post_meta($post_id,'wpeevent_button_buttonsize',true); ?>
							<option value="0" <?php selected($wpeevent_button_buttonsize, '0'); ?>>Default Button</option>
							<option value="1" <?php selected($wpeevent_button_buttonsize, '1'); ?>>Small Buy Now</option>
							<option value="2" <?php selected($wpeevent_button_buttonsize, '2'); ?>>Big Buy Now</option>
							<option value="3" <?php selected($wpeevent_button_buttonsize, '3'); ?>>Big Buy Now with Credit Cards</option>
							<option value="4" <?php selected($wpeevent_button_buttonsize, '4'); ?>>Small Pay Now</option>
							<option value="5" <?php selected($wpeevent_button_buttonsize, '5'); ?>>Big Pay Now</option>
							<option value="6" <?php selected($wpeevent_button_buttonsize, '6'); ?>>Big Pay Now</option>
							<option value="7" <?php selected($wpeevent_button_buttonsize, '7'); ?>>Gold (English only)</option>
							
							<!--
							<option value="8" <?php selected($wpeevent_button_buttonsize, '8'); ?>>Custom</option>
							-->
						</select></td><td> Optional - Will override setttings page value.</td></tr><tr><td>
						
						<?php
						$wpeevent_button_border = get_post_meta($post_id, "wpeevent_button_border", true);
						?>
						
						Show Border: </td><td><input type="checkbox" name="wpeevent_button_border" value="1" <?php checked($wpeevent_button_border, '1'); ?>></td><td> Optional - Show a border around the purchase box cells. </td></tr><tr><td>
						
						<?php
						$pp_test = get_post_meta($post_id,'wpeevent_button_pp_text',true);
						
						if (empty($pp_test)) { $pp_test = "Your eTicket will be emailed after payment to your PayPal email address."; }
						?>
						
						PayPal email text: </td><td><input type="input" name="wpeevent_button_pp_text" value="<?php echo esc_attr($pp_test); ?>"></td><td> Required - Default: Your eTicket will be emailed after <br />payment to your PayPal email address. </td></tr><tr><td>
						
						<?php
						$sold_out = get_post_meta($post_id,'wpeevent_button_sold_out',true);
						
						if (empty($sold_out)) { $sold_out = "Sold Out"; }
						?>
						
						Sold out text: </td><td><input type="input" name="wpeevent_button_sold_out" value="<?php echo esc_attr($sold_out); ?>"></td><td> Required - Default: Sold Out </td></tr><tr><td>
						
						
						</td><td><br /></td></td></td></tr><tr><td>
						<b>Event Menu</b><br /><br /></td></tr><tr><td>
						
						<?php
						$wpeevent_button_header = get_post_meta($post_id, "wpeevent_button_header", true);
						?>
						
						Show Column Header: </td><td><input type="checkbox" name="wpeevent_button_header" value="1" <?php checked($wpeevent_button_header, '1'); ?>></td><td> Optional - Show the column header above the event purchase box. </td>
						
						
						</td><td></td></td></td></tr><tr><td colspan="3">
						
						<br />
						
						<?php
						
						$h_title = get_post_meta($post_id,'wpeevent_button_h_title',true);
						$h_name = get_post_meta($post_id,'wpeevent_button_h_name',true);
						$h_price = get_post_meta($post_id,'wpeevent_button_h_price',true);
						$h_desc = get_post_meta($post_id,'wpeevent_button_h_desc',true);
						
						if (empty($h_title)) { $h_title = "Quantity:"; }
						if (empty($h_name))  { $h_name = "Name:"; }
						if (empty($h_price)) { $h_price = "Price:"; }
						if (empty($h_desc))  { $h_desc = "Description:"; }
						
						?>
						
						<table><tr>
						<td>Column Header Names: </td></tr>
						<tr><td>Purchase Title: </td><td><input type="text" name="wpeevent_button_h_title" value="<?php echo esc_attr($h_title); ?>" style="width:94px;"></td>
						<td>Name Title: </td><td><input type="text" name="wpeevent_button_h_name" value="<?php echo esc_attr($h_name); ?>" style="width:94px;"></td>
						<td>Price Title: </td><td><input type="text" name="wpeevent_button_h_price" value="<?php echo esc_attr($h_price); ?>" style="width:94px;"></td>
						<td>Description Title: 	</td><td><input type="text" name="wpeevent_button_h_desc" value="<?php echo esc_attr($h_desc); ?>" style="width:94px;"></td>
						</tr></table>
						
						<br />
						
						Event Ticket Types: </td><td></td></td></td></tr><tr><td colspan="3">
							<table style="width:920px;"><tr><td>
								1 - Name: </td><td><input type="text" name="wpeevent_button_name_a" value="<?php echo esc_attr(get_post_meta($post_id,'wpeevent_button_name_a',true)); ?>" style="width:94px;">
								Price: <input style="width:57px;" type="text" name="wpeevent_button_price_a" value="<?php echo esc_attr(get_post_meta($post_id,'wpeevent_button_price_a',true)); ?>">
								ID: <input style="width:45px;" type="text" name="wpeevent_button_id_a" value="<?php echo esc_attr(get_post_meta($post_id,'wpeevent_button_id_a',true)); ?>">
								Quantity: <input style="width:45px;" type="text" name="wpeevent_button_qty_a" value="<?php echo esc_attr(get_post_meta($post_id,'wpeevent_button_qty_a',true)); ?>">
								Description: <input style="width:200px;" type="text" name="wpeevent_button_desc_a" value="<?php echo esc_attr(get_post_meta($post_id,'wpeevent_button_desc_a',true)); ?>">
								</td><td> Name & Price are required.</td></tr><tr><td>
								
								2  - Name: </td><td><input type="text" name="wpeevent_button_name_b" value="<?php echo esc_attr(get_post_meta($post_id,'wpeevent_button_name_b',true)); ?>" style="width:94px;">
								Price: <input style="width:57px;" type="text" name="wpeevent_button_price_b" value="<?php echo esc_attr(get_post_meta($post_id,'wpeevent_button_price_b',true)); ?>">
								ID: <input style="width:45px;" type="text" name="wpeevent_button_id_b" value="<?php echo esc_attr(get_post_meta($post_id,'wpeevent_button_id_b',true)); ?>">
								Quantity: <input style="width:45px;" type="text" name="wpeevent_button_qty_b" value="<?php echo esc_attr(get_post_meta($post_id,'wpeevent_button_qty_b',true)); ?>">
								Description: <input style="width:200px;" type="text" name="wpeevent_button_desc_b" value="<?php echo esc_attr(get_post_meta($post_id,'wpeevent_button_desc_b',true)); ?>">
								</td><td> Optional</td></tr><tr><td>
								
								3  - Name: </td><td><input type="text" name="wpeevent_button_name_c" value="<?php echo esc_attr(get_post_meta($post_id,'wpeevent_button_name_c',true)); ?>" style="width:94px;">
								Price: <input style="width:57px;" type="text" name="wpeevent_button_price_c" value="<?php echo esc_attr(get_post_meta($post_id,'wpeevent_button_price_c',true)); ?>">
								ID: <input style="width:45px;" type="text" name="wpeevent_button_id_c" value="<?php echo esc_attr(get_post_meta($post_id,'wpeevent_button_id_c',true)); ?>">
								Quantity: <input style="width:45px;" type="text" name="wpeevent_button_qty_c" value="<?php echo esc_attr(get_post_meta($post_id,'wpeevent_button_qty_c',true)); ?>">
								Description: <input style="width:200px;" type="text" name="wpeevent_button_desc_c" value="<?php echo esc_attr(get_post_meta($post_id,'wpeevent_button_desc_c',true)); ?>">
								</td><td> Optional</td></tr><tr><td>
								
							</td></tr></table>
							
						<?php wp_nonce_field( 'edit_'.$post_id ); ?>
						<input type="hidden" name="update">
							
						</td></tr></table>						
				</div>
				
			</form>