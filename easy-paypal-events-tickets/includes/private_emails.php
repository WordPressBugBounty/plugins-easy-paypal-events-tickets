<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

		$optionsa = get_option('wpeevent_settingsoptions');
		foreach ($optionsa as $ka => $va ) { $valuea[$ka] = $va; }
		
		// admin email
		
		if (!isset($send_admin_email)) {
			$send_admin_email = "0";
		}
		
		if ($valuea['send_admin_email'] == "1" && $send_admin_email == "1") {
			
			
			$admin_email = $valuea['admin_email'];
			$admin_from = $valuea['admin_from'];
			
			if (!empty($valuea['admin_cc_email'])) {
				$admin_cc_email = $valuea['admin_cc_email'];
				$admin_to = $admin_email.",".$admin_cc_email;
			} else {
				$admin_to = $admin_email;
			}
			
			$admin_email_wp = get_bloginfo('admin_email');

			$admin_subject = $valuea['admin_subject'];
			
			$message = $valuea['admin_email_template'];
			
			$message = stripslashes($message);
			
			$headers[] = 'From: '. $admin_from .' <'. $admin_email_wp .'>' . "\r\n";
			$headers[] = "Content-type: text/html" ;
			
			 if ($send_admin_email_test == "1") {
				$payer_email = "test@example.com";
				$item_name = "<table width='400px'><td colspan='3' style='border-top:1px dashed #888;'></td></tr><tr><td width='30px'>#1 </td><td width='120px'>Name:</td><td>test</td></tr><tr><td></td><td>Quantity:</td><td>1</td></tr><tr><td></td><td>Price:</td><td>2.21</td></tr><tr><td></td></tr><tr><td colspan='3' style='border-top:1px dashed #888;'></td></tr><tr><td width='30px'>#2 </td><td width='120px'>Name:</td><td>test2</td></tr><tr><td></td><td>Quantity:</td><td>2</td></tr><tr><td></td><td>Price:</td><td>2.00</td></tr><tr><td></td></tr><tr><td colspan='3' style='border-top:1px dashed #888;'></td></tr><tr><td width='30px'>#3 </td><td width='120px'>Name:</td><td>test3</td></tr><tr><td></td><td>Quantity:</td><td>3</td></tr><tr><td></td><td>Price:</td><td>12.00</td></tr><tr><td colspan='3' style='border-top:1px dashed #888;'></td></tr><tr></tr></table>";
				$payment_amount = "50.00";
				$txn_id = "9XS549502E280412S";
				$event_name = "Test Event Name";
				$post_id = "001";
			 }
			
			// replace
			$message = str_replace("{payer_email}",$payer_email,$message);
			$message = str_replace("{sold_table}",$item_name,$message);
			$message = str_replace("{txn_total}",$payment_amount,$message);
			$message = str_replace("{txn_id}",$txn_id,$message);
			$message = str_replace("{order_num}",$post_id,$message);
			$message = str_replace("{event_name}",$event_name,$message);
			
			$admin_subject = str_replace("{payer_email}",$payer_email,$admin_subject);
			$admin_subject = str_replace("{sold_table}",$item_name,$admin_subject);
			$admin_subject = str_replace("{txn_total}",$payment_amount,$admin_subject);
			$admin_subject = str_replace("{txn_id}",$txn_id,$admin_subject);
			$admin_subject = str_replace("{order_num}",$post_id,$admin_subject);
			$admin_subject = str_replace("{event_name}",$event_name,$admin_subject);
			
			$message = nl2br($message);

			if (isset($message_start)) {
                $message = $message_start.$message;
            }

            if (isset($message_end)) {
                $message = $message.$message_end;
            }

			wp_mail($admin_to, $admin_subject, $message, $headers);
			
			
		}
		
		
		
		// customer email
		
		if (!isset($send_customer_email)) {
			$send_customer_email = "0";
		}
		
		if ($valuea['send_customer_email'] == "1" && $send_customer_email == "1") {
			
			$message = $valuea['customer_email_template'];
			$message = stripslashes($message);
			
			$customer_subject = $valuea['customer_subject'];
			$admin_from = $valuea['admin_from'];
			$admin_email = get_bloginfo('admin_email');
			
			 if ($send_customer_email_test == "1") {
				$payer_email = $valuea['admin_email'];
				$item_name = "<table width='400px'><td colspan='3' style='border-top:1px dashed #888;'></td></tr><tr><td width='30px'>#1 </td><td width='120px'>Name:</td><td>test</td></tr><tr><td></td><td>Quantity:</td><td>1</td></tr><tr><td></td><td>Price:</td><td>2.21</td></tr><tr><td></td></tr><tr><td colspan='3' style='border-top:1px dashed #888;'></td></tr><tr><td width='30px'>#2 </td><td width='120px'>Name:</td><td>test2</td></tr><tr><td></td><td>Quantity:</td><td>2</td></tr><tr><td></td><td>Price:</td><td>2.00</td></tr><tr><td></td></tr><tr><td colspan='3' style='border-top:1px dashed #888;'></td></tr><tr><td width='30px'>#3 </td><td width='120px'>Name:</td><td>test3</td></tr><tr><td></td><td>Quantity:</td><td>3</td></tr><tr><td></td><td>Price:</td><td>12.00</td></tr><tr><td colspan='3' style='border-top:1px dashed #888;'></td></tr><tr></tr></table>";
				$payment_amount = "50.00";
				$txn_id = "9XS549502E280412S";
				$event_name = "Test Event Name";
				$post_id = "001";
				
				
				$site_url = get_site_url();
				
				//echo "$site_url%2Fwp-admin%2Fadmin-post.php%3Faction%3Dadd_wpeevent_button_qr%26order%3D1321|1321|test&choe=UTF-8";
				
				$qr_code = "<img src='https://quickchart.io/chart?cht=qr&chs=150x150&chl=$site_url%2Fwp-admin%2Fadmin-post.php%3Faction%3Dadd_wpeevent_button_qr%26order%3D1321|1321|test&choe=UTF-8' />";
			 }
			 
			 
			 
			 
			$headers[] = 'From: '. $admin_from .' <'. $admin_email .'>' . "\r\n";
			$headers[] = "Content-type: text/html" ;
			
			
			// replace
			$message = str_replace("{payer_email}",$payer_email,$message);
			$message = str_replace("{sold_table}",$item_name,$message);
			$message = str_replace("{txn_total}",$payment_amount,$message);
			$message = str_replace("{txn_id}",$txn_id,$message);
			$message = str_replace("{order_num}",$post_id,$message);
			$message = str_replace("{event_name}",$event_name,$message);
			$message = str_replace("{qr_code}",$qr_code,$message);
			
			$customer_subject = str_replace("{payer_email}",$payer_email,$customer_subject);
			$customer_subject = str_replace("{sold_table}",$item_name,$customer_subject);
			$customer_subject = str_replace("{txn_total}",$payment_amount,$customer_subject);
			$customer_subject = str_replace("{txn_id}",$txn_id,$customer_subject);
			$customer_subject = str_replace("{order_num}",$post_id,$customer_subject);
			$customer_subject = str_replace("{event_name}",$event_name,$customer_subject);
			$customer_subject = str_replace("{qr_code}",$qr_code,$customer_subject);
			
			$message = nl2br($message);
			
			wp_mail($payer_email, $customer_subject, $message, $headers);
			
			
		}