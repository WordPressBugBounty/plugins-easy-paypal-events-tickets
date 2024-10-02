<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wpeevent_plugin_options() {

	if ( !current_user_can( "manage_options" ) )  {
		wp_die( __( "You do not have sufficient permissions to access this page. Please sign in as an administrator." ));
	}

	?>
	
	<form method='post' action='<?php esc_url($_SERVER["REQUEST_URI"]); ?>'>
		
		<?php
		// save and update options
		if (isset($_POST['update'])) {

			if (!isset($_POST['action_save']) || ! wp_verify_nonce($_POST['action_save'],'nonce_save') ) {
			   print 'Sorry, your nonce did not verify.';
			   exit;
			}
			
			$options['currency'] =			intval($_POST['currency']);
			if (!$options['currency']) { 	$options['currency'] = "25"; }
				
			$options['language'] = 			intval($_POST['language']);
			if (!$options['language']) { 	$options['language'] = "3";	}
				
			$options['mode'] = 				intval($_POST['mode']);
			if (!$options['mode']) { 		$options['mode'] = "1";	}
				
			$options['size'] = 				intval($_POST['size']);
			if (!$options['size']) { 		$options['size'] = "1";	}
				
			$options['opens'] = 			intval($_POST['opens']);
			if (!$options['opens']) { 		$options['opens'] = "1"; }
				
			$options['no_shipping'] = 		intval($_POST['no_shipping']);
			if (!$options['no_shipping']) { $options['no_shipping'] = "0"; }
				
			$options['no_note'] = 			intval($_POST['no_note']);
			if (!$options['no_note']) { 	$options['no_note'] = "0"; }
			
			$options['show_currency'] = 	intval($_POST['show_currency']);
			if (!$options['show_currency']) { 	$options['show_currency'] = "0"; }
			
			$options['liveaccount'] = 		sanitize_text_field($_POST['liveaccount']);
			$options['sandboxaccount'] = 	sanitize_text_field($_POST['sandboxaccount']);
			//$options['image_1'] = 			sanitize_text_field($_POST['image_1']);
			$options['cancel'] = 			sanitize_text_field($_POST['cancel']);
			$options['return'] = 			sanitize_text_field($_POST['return']);

			$options['send_admin_email'] = isset($_POST['send_admin_email']) ? sanitize_text_field($_POST['send_admin_email']) : "0";

            $options['send_customer_email'] = isset($_POST['send_customer_email']) ? sanitize_text_field($_POST['send_customer_email']) : "0";
			
			$options['admin_from'] = 				sanitize_text_field($_POST['admin_from']);
			$options['admin_email'] = 				sanitize_text_field($_POST['admin_email']);
			$options['admin_cc_email'] = 			sanitize_text_field($_POST['admin_cc_email']);
			$options['admin_subject'] =				sanitize_text_field($_POST['admin_subject']);
			$options['customer_subject'] = 			sanitize_text_field($_POST['customer_subject']);
			
			// sanatize templates
			$options['admin_email_template'] =  wp_kses($_POST['admin_email_template'], array(
					'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			));
				
			$options['customer_email_template'] =  wp_kses($_POST['customer_email_template'], array(
					'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			));	
			
			update_option("wpeevent_settingsoptions", $options);
			
			echo "<br /><div class='updated'><p><strong>"; _e("Settings Updated."); echo "</strong></p></div>";
		}
		
		
		$options = get_option('wpeevent_settingsoptions');
		foreach ($options as $k => $v ) {
			
			$value[$k] =  wp_kses($v, array(
					'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			));	
			
		}
		
		$siteurl = get_site_url();
		
		// tabs menu
		?>
		
		<table width='100%'><tr><td width='75%' valign='top'><br />
	
		<table width="100%"><tr><td>
			<br />
			<span style="font-size:20pt;">Easy PayPal Events Settings</span>
			</td><td valign="bottom">
			<?php echo wp_nonce_field('nonce_save','action_save'); ?>
			<input type="submit" name='btn2' class='button-primary' style='font-size: 14px;height: 30px;float: right;' value="Save Settings">
		</td></tr></table>
			
			<?php
			if (isset($saved)) {
				echo "<div class='updated'><p>Settings Updated.</p></div>";
			}
			?>
		
		<?php
		
		if (isset($_POST['hidden_tab_value'])) {
			$active_tab =  sanitize_text_field($_POST['hidden_tab_value']);
		} else {
			$active_tab = isset( $_GET[ 'tab' ] ) ? sanitize_text_field($_GET[ 'tab' ]) : '1';
		}
		
		
		
		// media uploader
		function wpplugin_paypal_button_load_scripts() {
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
		}
		wpplugin_paypal_button_load_scripts();
		?>

		<script>
			jQuery(document).ready(function() {
				var formfield;
				jQuery('.upload_image_button').click(function() {
					jQuery('html').addClass('Image');
					formfield = jQuery(this).prev().attr('name');
					tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
					return false;
				});
				window.original_send_to_editor = window.send_to_editor;
				window.send_to_editor = function(html){
					if (formfield) {
						fileurl = jQuery('img',html).attr('src');
						jQuery('#'+formfield).val(fileurl);
						tb_remove();
						jQuery('html').removeClass('Image');
					} else {
						window.original_send_to_editor(html);
					}
				};
			});
		</script>
		
		<script type="text/javascript">
			function closetabs(ids) {
				var x = ids;
				y = x.split(",");
				
				for(var i = 0; i < y.length; i++) {
					//console.log(y[i]);
					document.getElementById(y[i]).style.display = 'none';
					document.getElementById("id"+y[i]).classList.remove('nav-tab-active');
				}
			}
			
			function newtab(id) {
				var x = id;
				document.getElementById(x).style.display = 'block';
				document.getElementById("id"+x).classList.add('nav-tab-active');
				document.getElementById('hidden_tab_value').value=x;
			}
		</script>
		
		<br />
		
		<?php
		//global $kstatus;
		//if (isset($kstatus) && $kstatus == "true") {
		?>
			<a style='border-bottom:1px solid #ccc' onclick='closetabs("1,2,3,4,8");newtab("1");' href="#" id="id1" class="nav-tab <?php echo $active_tab == '1' ? 'nav-tab-active' : ''; ?>">Getting Started</a>
			<!--
			<a style='border-bottom:1px solid #ccc' onclick='closetabs("1,2,3,4,8,9");newtab("9");' href="#" id="id9" class="nav-tab <?php echo $active_tab == '9' ? 'nav-tab-active' : ''; ?>">License</a>
			-->
			<a style='border-bottom:1px solid #ccc' onclick='closetabs("1,2,3,4,8");newtab("3");' href="#" id="id3" class="nav-tab <?php echo $active_tab == '3' ? 'nav-tab-active' : ''; ?>">PayPal</a>
			<a style='border-bottom:1px solid #ccc' onclick='closetabs("1,2,3,4,8");newtab("8");' href="#" id="id8" class="nav-tab <?php echo $active_tab == '8' ? 'nav-tab-active' : ''; ?>">Buttons</a>
			<a style='border-bottom:1px solid #ccc' onclick='closetabs("1,2,3,4,8");newtab("2");' href="#" id="id2" class="nav-tab <?php echo $active_tab == '2' ? 'nav-tab-active' : ''; ?>">Language & Currency</a>
			<a style='border-bottom:1px solid #ccc' onclick='closetabs("1,2,3,4,8");newtab("4");' href="#" id="id4" class="nav-tab <?php echo $active_tab == '4' ? 'nav-tab-active' : ''; ?>">Email & eTickets</a>
		<?php //} else { ?>
			
			<!--
			<a style='border-bottom:1px solid #ccc' onclick='closetabs("1,2,3,4,8,9");newtab("9");' href="#" id="id9" class="nav-tab <?php echo $active_tab == '9' ? 'nav-tab-active' : ''; ?>">License Key</a>
			-->
			
			<?php
			
			//$active_tab = "9";
			
			//} ?>
			
		
		<br /><br /><br />
		
		<div id="1" style="display:none;border: 1px solid #CCCCCC;<?php echo $active_tab == '1' ? 'display:block;' : ''; ?>">
			<div style="background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;">
				&nbsp; Getting Started
			</div>
			<div style="background-color:#fff;padding:8px;">
				
				<h3>How to use this plugin</h3>
				<br />
				This plugin will allow you to sell eTickets on your website via PayPal. Here is a quick start guide on how to use this plugin:
				<br /><br />
				1. In this settings page go to the <a href="?page=wpeevent_settings&tab=3">PayPal tab</a> and enter your PayPal information. After you are done, save your changes by clicking on "Save Settings".<br />
				2. In the PayPal Events menu, naviate to the <a href="?page=wpeevent_buttons">Events page</a>. Click on the "New Event" button.<br />
				3. Fill out at least the Event Name, Ticket Type 1 Name, Price, and quantity fields. After you are done, click on the "Save Event" Button to save the event.<br />
				4. In the Admin menu, nagivate to your <a href="edit.php?post_type=page">Pages</a> page. Make a new page or click to open an existing page.<br />
				5. You should see a new button in the menu beside the "Add Media" button called "PayPal Events". Click on that.<br />
				6. Find the button you just created in the dropdown menu and click on the "Insert Button".<br />
				7. Save or Update the page and click the "View Page" link to view the page live on your site.
				You should now see a button showing on that page.
				<br /><br />
				From the customers perspective: <br /><br />
				After a customer purchased a ticket for your event they will automatically receive an email containing a QR code - this is their eTicket. You can use any QR code reader app for your 
				Android, Apple, or Microsoft phone to scan the QR code. It will open a webpage where you can see the customers ticket details.
				
				<br /><br /><br />
				
				<span style="color:#777;float:right;"><i>WP Plugin is an offical PayPal Partner. Various trademarks held by their respective owners.</i></span>
				
				<br />
				
			</div>
		</div>
		
		
		<div id="2" style="display:none;border: 1px solid #CCCCCC;<?php echo $active_tab == '2' ? 'display:block;' : ''; ?>">
			<div style="background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;">
				&nbsp; Language & Currency Settings
			</div>
			<div style="background-color:#fff;padding:8px;">
			
				<table><tr><td colspan="2">
				<h3>Language Settings</h3></td></tr><tr><td>
				
				<b>Language:</b> </td><td>
				<select name="language" style="width: 280px">
				<option <?php selected($value['language'], '1'); ?> value="1">Danish</option>
				<option <?php selected($value['language'], '2'); ?> value="2">Dutch</option>
				<option <?php selected($value['language'], '3'); ?> value="3">English</option>
				<option <?php selected($value['language'], '20'); ?> value="20">English - UK</option>
				<option <?php selected($value['language'], '4'); ?> value="4">French</option>
				<option <?php selected($value['language'], '5'); ?> value="5">German</option>
				<option <?php selected($value['language'], '6'); ?> value="6">Hebrew</option>
				<option <?php selected($value['language'], '7'); ?> value="7">Italian</option>
				<option <?php selected($value['language'], '8'); ?> value="8">Japanese</option>
				<option <?php selected($value['language'], '9'); ?> value="9">Norwgian</option>
				<option <?php selected($value['language'], '10'); ?> value="10">Polish</option>
				<option <?php selected($value['language'], '11'); ?> value="11">Portuguese</option>
				<option <?php selected($value['language'], '12'); ?> value="12">Russian</option>
				<option <?php selected($value['language'], '13'); ?> value="13">Spanish</option>
				<option <?php selected($value['language'], '14'); ?> value="14">Swedish</option>
				<option <?php selected($value['language'], '15'); ?> value="15">Simplified Chinese -China only</option>
				<option <?php selected($value['language'], '16'); ?> value="16">Traditional Chinese - Hong Kong only</option>
				<option <?php selected($value['language'], '17'); ?> value="17">Traditional Chinese - Taiwan only</option>
				<option <?php selected($value['language'], '18'); ?> value="18">Turkish</option>
				<option <?php selected($value['language'], '19'); ?> value="19">Thai</option>
				</select></td><td>
				
				PayPal currently supports 18 languages.</td></tr><tr><td colspan="2">
				
				<br />
				<h3>Currency Settings</h3></td></tr><tr><td>
				
				<b>Currency:</b> </td><td>
				<select name="currency" style="width: 280px">
				<option <?php selected($value['currency'], '1'); ?> value="1">Australian Dollar - AUD</option>
				<option <?php selected($value['currency'], '2'); ?> value="2">Brazilian Real - BRL</option>
				<option <?php selected($value['currency'], '3'); ?> value="3">Canadian Dollar - CAD</option>
				<option <?php selected($value['currency'], '4'); ?> value="4">Czech Koruna - CZK</option>
				<option <?php selected($value['currency'], '5'); ?> value="5">Danish Krone - DKK</option>
				<option <?php selected($value['currency'], '6'); ?> value="6">Euro - EUR</option>
				<option <?php selected($value['currency'], '7'); ?> value="7">Hong Kong Dollar - HKD</option>
				<option <?php selected($value['currency'], '8'); ?> value="8">Hungarian Forint - HUF</option>
				<option <?php selected($value['currency'], '9'); ?> value="9">Israeli New Sheqel - ILS</option>
				<option <?php selected($value['currency'], '10'); ?> value="10">Japanese Yen - JPY</option>
				<option <?php selected($value['currency'], '11'); ?> value="11">Malaysian Ringgit - MYR</option>
				<option <?php selected($value['currency'], '12'); ?> value="12">Mexican Peso - MXN</option>
				<option <?php selected($value['currency'], '13'); ?> value="13">Norwegian Krone - NOK</option>
				<option <?php selected($value['currency'], '14'); ?> value="14">New Zealand Dollar - NZD</option>
				<option <?php selected($value['currency'], '15'); ?> value="15">Philippine Peso - PHP</option>
				<option <?php selected($value['currency'], '16'); ?> value="16">Polish Zloty - PLN</option>
				<option <?php selected($value['currency'], '17'); ?> value="17">Pound Sterling - GBP</option>
				<option <?php selected($value['currency'], '18'); ?> value="18">Russian Ruble - RUB</option>
				<option <?php selected($value['currency'], '19'); ?> value="19">Singapore Dollar - SGD</option>
				<option <?php selected($value['currency'], '20'); ?> value="20">Swedish Krona - SEK</option>
				<option <?php selected($value['currency'], '21'); ?> value="21">Swiss Franc - CHF</option>
				<option <?php selected($value['currency'], '22'); ?> value="22">Taiwan New Dollar - TWD</option>
				<option <?php selected($value['currency'], '23'); ?> value="23">Thai Baht - THB</option>
				<option <?php selected($value['currency'], '24'); ?> value="24">Turkish Lira - TRY</option>
				<option <?php selected($value['currency'], '25'); ?> value="25">U.S. Dollar - USD</option>
				</select></td><td>
				
				PayPal currently supports 25 currencies.
				
				</td></tr></table>
				
				<br /><br />
			</div>
		</div>
			
			
		<div id="3" style="display:none;border: 1px solid #CCCCCC;<?php echo $active_tab == '3' ? 'display:block;' : ''; ?>">
			<div style="background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;">
				&nbsp; PayPal Settings </div>
			<div style="background-color:#fff;padding:8px;">
			
			
			<table><tr><td colspan="2">
				<h3>PayPal Accounts</h3></td></tr><tr><td>
				
				<b>Live Account:</b> </td><td><input type='text' name='liveaccount' value='<?php echo esc_attr($value['liveaccount']); ?>'> Required </td></tr><tr><td>
				</td><td colspan="2">
				<br />Enter a valid Merchant account ID (strongly recommend) or PayPal account email address. All payments will go to this account.
				<br /><br />You can find your Merchant account ID in your PayPal account under Profile -> My business info -> Merchant account ID
				
				<br /><br />If you don't have a PayPal account, you can sign up for free at <a target='_blank' href='https://paypal.com'>PayPal</a>. <br /><br />
				
				</td></tr><tr><td>
				
				<b>Sandbox Account:</b> </td><td><input type='text' name='sandboxaccount' value='<?php echo esc_attr($value['sandboxaccount']); ?>'> Optional</td></tr><tr><td>
				</td><td colspan="2">
				<br />Enter a valid sandbox PayPal account email address. A Sandbox account is a PayPal accont with fake money used for testing. <br />This is useful to make sure your PayPal account and settings are working properly being going live.
				<br /><br />To create a Sandbox account, you first need a Developer Account. You can sign up for free at the <a target='_blank' href='https://www.paypal.com/webapps/merchantboarding/webflow/unifiedflow?execution=e1s2'>PayPal Developer</a> site. <br /><br />
				
				Once you have made an account, create a Sandbox Business and Personal Account <a target='_blank' href='https://developer.paypal.com/webapps/developer/applications/accounts'>here</a>.<br /><br /> Enter the Business account email on this page and use the Personal account username and password to buy something on your site as a customer.
				<br />
				
				</td></tr><tr><td colspan="2">
				
				<br />
				
				<h3>PayPal Options</h3></td></tr><tr><td>
				
				<b>Sandbox Mode:</b> </td><td colspan="2">
				&nbsp; &nbsp; <input <?php checked($value['mode'], '1'); ?> type='radio' name='mode' value='1'>On (Sandbox mode)
				&nbsp; &nbsp;  &nbsp;<input <?php checked($value['mode'], '2'); ?> type='radio' name='mode' value='2'>Off (Live mode)
				
				</td></tr><tr><td>				
				
				<b>Statements Name:</b> </td><td>
				&nbsp; &nbsp; <a target="_blank" href="https://www.paypal.com/cgi-bin/customerprofileweb?cmd=_profile-pref&rc2_eligible=yes&#ccName">Set name that shows on buyer credit card statements<a>

				</td></tr></table>

				<br /><br />
			</div>
		</div>
		
		
		<div id="4" style="display:none;border: 1px solid #CCCCCC;<?php echo $active_tab == '4' ? 'display:block;' : ''; ?>">
			<div style="background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;">
				&nbsp; Email Settings
			</div>
			<div style="background-color:#fff;padding:8px;">
			
				<table><tr><td>
				
				<h3>Admin Email Settings</h3></td></tr><tr><td valign="top">

				<b>Send email to admin when item is sold:</b> &nbsp; </td><td>
				
				<input type="checkbox" name="send_admin_email" value="1" <?php checked($value['send_admin_email'], '1'); ?>><br /><br /></td></tr><tr><td valign="top">
				
				<b>Send test admin email to admin: </b></td><td><a href="?page=wpeevent_settings&send_admin_email&tab=4">Send test email</a> (uses test data)<br /><br /></td></tr><tr><td valign="top">
				
				<?php
				if (isset($_GET['send_admin_email'])) {
					$payer_email = "";
					$send_admin_email = "1";
					$send_admin_email_test = "1";
					include_once ('private_emails.php');
					?>
					<script type="text/javascript">
						<!--
						window.location = "?page=wpeevent_settings&tab=4"
						//-->
					</script>
					<?php
				}
				?>
				
				<b>From name:</b></td><td>
				<input type="text" name="admin_from" value="<?php echo esc_attr($value['admin_from']); ?>">Required if admin email enabled, default: Wordpress.</td></tr><tr><td valign="top">
				
				<b>Admin email address:</b></td><td>
				<input type="text" name="admin_email" value="<?php echo esc_attr($value['admin_email']); ?>"> Required if admin email enabled</td></tr><tr><td valign="top">
				
				<b>Admin CC email address:</b></td><td>
				<input type="text" name="admin_cc_email" value="<?php echo esc_attr($value['admin_cc_email']); ?>"> Optional</td></tr><tr><td valign="top">
				
				<b>Admin email subject line:</b></td><td>
				<input type="text" name="admin_subject" value="<?php echo esc_attr($value['admin_subject']); ?>"> Required if admin email enabled </td></tr><tr><td valign="top">
				
				<br /><b>Admin email template:</b></td><td>
				
				<?php
				$content = $value['admin_email_template'];
				$content = stripslashes($content);
				$editor_id = 'admin_email_template_id';
				wp_editor($content, $editor_id, $settings = array(
					'textarea_name' => 'admin_email_template'				
				));
				?>
				
				</td></tr><tr><td></td><td>
				<br /><u>Variables:</u>
				<br />{order_num} = Order ID
				<br />{payer_email} = Buyer email
				<br />{sold_table} = Items sold table (item name, quantity, amount)
				<br />{txn_total} = Total payment amount
				<br />{txn_id} = PayPal transaction id
				<br />{event_name} = Event Name
				
				</td></tr><tr><td>
				<br />
				</td></tr><tr><td>
				
				<h3>Customer Email Settings</h3></td></tr><tr><td valign="top">
				<b>Send email to customer when item is purchased:</b></td><td>
				
				<input type="checkbox" name="send_customer_email" value="1" <?php checked($value['send_customer_email'], '1'); ?>><br /><br /></td></tr><tr><td valign="top">
				
				
				
				<b>Send test customer email to admin: </b></td><td><a href="?page=wpeevent_settings&send_customer_email&tab=4">Send test email</a> (uses test data)<br /><br /></td></tr><tr><td valign="top">
				
				<?php
				if (isset($_GET['send_customer_email'])) {
					$send_customer_email = "1";
					$send_customer_email_test = "1";
					include_once ('private_emails.php');
					?>
					<script type="text/javascript">
						<!--
						window.location = "?page=wpeevent_settings&tab=4"
						//-->
					</script>
					<?php
				}
				?>
				
				
				<b>Customer email subject line:</b></td><td>
				<input type="text" name="customer_subject" value="<?php echo esc_attr($value['customer_subject']); ?>"> Required if customer email enabled </td></tr><tr><td valign="top">
				

				<br /><b>Customer email template:</b></td><td>
				
				<?php
				//$content = "";
				$content = $value['customer_email_template'];
				$content = stripslashes($content);
				$editor_id = 'customer_email_template_id';
				wp_editor($content, $editor_id, $settings = array(
					'textarea_name' => 'customer_email_template'				
				));
				?>
				
				</td></tr><tr><td></td><td>
				<br /><u>Variables:</u>
				<br />{order_num} = Order ID
				<br />{payer_email} = Buyer email
				<br />{sold_table} = Items sold table (item name, quantity, amount)
				<br />{txn_total} = Total payment amount
				<br />{txn_id} = PayPal transaction id
				<br />{event_name} = Event Name
				<br />{qr_code} = QR code
				
				
				</td></tr></table>
				
				
			</div>
		</div>
		
		
		
		<div id="8" style="display:none;border: 1px solid #CCCCCC;<?php echo $active_tab == '8' ? 'display:block;' : ''; ?>">
			<div style="background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;">
			&nbsp; Button Settings
			</div>
			<div style="background-color:#fff;padding:8px;">
			
				<table><tr><td colspan="2">
				<h3>Button Settings</h3></td></tr><tr><td colspan="2">
				
				<b>Default Button Size and style:</b>
				</td></tr><tr><td valign="top">
				<input <?php checked($value['size'], '1'); ?> type='radio' name='size' value='1'>Small Buy Now <br /><img src='https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif'></td><td valign='top' style='text-align: center;'>
				<input <?php checked($value['size'], '2'); ?> type='radio' name='size' value='2'>Big Buy Now<br /><img src='https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif'></td><td valign='top' style='text-align: center;'>
				<input <?php checked($value['size'], '3'); ?> type='radio' name='size' value='3'>Big Buy Now with Credit Cards <br /><img src='https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif'></td><td valign='top' style='text-align: center;'>
				<input <?php checked($value['size'], '7'); ?> type='radio' name='size' value='7'>Gold (English only)<br /><img src='https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png'>
				
				</td></tr><tr><td valign="top">
				<input <?php checked($value['size'], '4'); ?> type='radio' name='size' value='4'>Small Pay Now <br /><img src='https://www.paypalobjects.com/en_US/i/btn/btn_paynow_SM.gif'></td><td valign='top' style='text-align: center;'>
				<input <?php checked($value['size'], '5'); ?> type='radio' name='size' value='5'>Big Pay Now <br /><img src='https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif'></td><td valign='top' style='text-align: center;'>
				<input <?php checked($value['size'], '6'); ?> type='radio' name='size' value='6'>Big Pay Now with Credit Cards <br /><img src='https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif'></td><td valign='top' style='text-align: center;'>
				
				<!--
				<input <?php checked($value['size'], '8'); ?> type='radio' name='size' value='8'>Custom <br />
				<input type="text" id="image_1" name="image_1" size="14" value="<?php //echo $value['image_1']; ?>">
				<input id="_btn" class="upload_image_button" type="button" value="Upload Image"></td></tr>
				-->

				<tr><td colspan="4">
				Buttons will automatically change to your language of choice when displayed on site.</td>
				</tr></table>
				
				<br />
				
				<table><tr><td valign="top">
				
				<b>Button opens in:</b></td><td valign="top">
				<input <?php checked($value['opens'], '1'); ?> type='radio' name='opens' value='1'>Same window
				<input <?php checked($value['opens'], '2'); ?> type='radio' name='opens' value='2'>New window
				
				<br /><br /></td></tr><tr><td valign="top">
				
				<b>Prompt buyers to include a note with<br /> their payment:</b></td><td valign="top">
				<input <?php checked($value['no_note'], '0'); ?> type='radio' name='no_note' value='0'>Yes
				<input <?php checked($value['no_note'], '1'); ?> type='radio' name='no_note' value='1'>No
				
				<br /><br /></td></tr><tr><td valign="top">
				
				<b>Prompt buyers for a shipping address:</b></td><td valign="top">
				<input <?php checked($value['no_shipping'], '0'); ?> type='radio' name='no_shipping' value='0'>Yes
				<input <?php checked($value['no_shipping'], '1'); ?> type='radio' name='no_shipping' value='1'>No
				<input <?php checked($value['no_shipping'], '2'); ?> type='radio' name='no_shipping' value='2'>Yes, and require
				
				<br /><br /></td></tr><tr><td valign="top">
				
				<b>Include currency code after amount<br /> in event table:</b></td><td valign="top">
				<input <?php checked($value['show_currency'], '0'); ?> type='radio' name='show_currency' value='0'>Yes
				<input <?php checked($value['show_currency'], '1'); ?> type='radio' name='show_currency' value='1'>No
				
				<br /><br /></td></tr><tr><td valign="top">
				
				<b>Default Cancel URL: </b></td><td valign="top">
				<input type='text' name='cancel' value='<?php echo esc_attr($value['cancel']); ?>'> Optional </td></tr><tr><td colspan="2">
				If the customer goes to PayPal and clicks the cancel button, where do they go. <br />Example: <?php echo esc_url($siteurl); ?>/cancel. Max length: 1,024.
				
				<br /><br /></td></tr><tr><td valign="top">
				
				<b>Default Return URL: </b></td><td valign="top">
				<input type='text' name='return' value='<?php echo esc_attr($value['return']); ?>'> Optional </td></tr><tr><td colspan="2">
				If the customer goes to PayPal and successfully pays, where are they redirected to after. <br />Example: <?php echo esc_url($siteurl); ?>/thankyou. Max length: 1,024.
				
				</td></tr></table>
				
				<br />
			</div>
		</div>
		
		
		<input type='hidden' name='update'>
		<input type='hidden' name='hidden_tab_value' id="hidden_tab_value" value="<?php echo esc_attr($active_tab); ?>">
		
	</form>
	
	
	
	
	
	</td><td width='3%'>
	</td><td width='22%' valign='top'>

	<br /><br />

	<div style="background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border: 1px solid #CCCCCC;">
	&nbsp; Like this Free plugin?
	</div>

	<div style="background-color:#fff;padding:8px;border: 1px solid #CCCCCC;border-top: 1px solid #fff;"><br />

<center><label style="font-size:14pt;">With the Pro version you'll <br /> be able to: </label></center>
 
<br />
<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Add Up To 15 Items Per Event<br />
<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Sale Reduces Tickets Available <br />
<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> PayPal Account For Each Event<br />
<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Return URL For Each Event<br />
<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Limit Quantity Available<br />
<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Clone Events <br />
<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Charge Tax <br />
<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Custom Button Image<br />
<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Further Plugin Development <br />

<br />
<center><a target='_blank' href="https://wpplugin.org/downloads/easy-paypal-events-pro/" class='button-primary' style='font-size: 17px;line-height: 28px;height: 32px;'>Learn More</a></center>
<br />
<center><a target='_blank' href="https://wpplugin.org/downloads/easy-paypal-events-pro/#demo" class='button-secondary'>View Demo</a></center>
<br />

	</div>

	<br /><br />

	<div style="background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border: 1px solid #CCCCCC;">
	&nbsp; Quick Links
	</div>

	<div style="background-color:#fff;padding:8px;border: 1px solid #CCCCCC;border-top: 1px solid #fff;"><br />

	<div class="dashicons dashicons-arrow-right" style="margin-bottom: 6px;"></div> <a target="_blank" href="https://wordpress.org/support/plugin/easy-paypal-events">Support Forum</a> <br />

	<div class="dashicons dashicons-arrow-right" style="margin-bottom: 6px;"></div> <a target="_blank" href="https://wpplugin.org/documentation">FAQ</a> <br />

	</div>



	</td><td width='1%'>

	</td></tr></table>
	
	
	
	
	
	
	
	
	<?php
	
}
