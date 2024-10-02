<?php


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// shortcode
add_shortcode('wpeevent', 'wpeevent_options');

function wpeevent_options($atts) {

	// get shortcode id
		$atts = shortcode_atts(array(
			'id' => '',
			'align' => '',
			'widget' => ''
		), $atts);
			
		$post_id = intval($atts['id']);

	// get settings page values
	$options = get_option('wpeevent_settingsoptions');
	foreach ($options as $k => $v ) { $value[$k] = $v; }
	
	$pp_text = get_post_meta($post_id,'wpeevent_button_pp_text',true);
	
	// price dropdown
	$wpeevent_button_name_a = get_post_meta($post_id,'wpeevent_button_name_a',true);
	$wpeevent_button_name_b = get_post_meta($post_id,'wpeevent_button_name_b',true);
	$wpeevent_button_name_c = get_post_meta($post_id,'wpeevent_button_name_c',true);
	$wpeevent_button_name_d = get_post_meta($post_id,'wpeevent_button_name_d',true);
	$wpeevent_button_name_e = get_post_meta($post_id,'wpeevent_button_name_e',true);
	
	$wpeevent_button_price_a = get_post_meta($post_id,'wpeevent_button_price_a',true);
	$wpeevent_button_price_b = get_post_meta($post_id,'wpeevent_button_price_b',true);
	$wpeevent_button_price_c = get_post_meta($post_id,'wpeevent_button_price_c',true);
	$wpeevent_button_price_d = get_post_meta($post_id,'wpeevent_button_price_d',true);
	$wpeevent_button_price_e = get_post_meta($post_id,'wpeevent_button_price_e',true);
	
	$wpeevent_button_id_a = get_post_meta($post_id,'wpeevent_button_id_a',true);
	$wpeevent_button_id_b = get_post_meta($post_id,'wpeevent_button_id_b',true);
	$wpeevent_button_id_c = get_post_meta($post_id,'wpeevent_button_id_c',true);
	$wpeevent_button_id_d = get_post_meta($post_id,'wpeevent_button_id_d',true);
	$wpeevent_button_id_e = get_post_meta($post_id,'wpeevent_button_id_e',true);
	
	$wpeevent_button_qty_a = get_post_meta($post_id,'wpeevent_button_qty_a',true);
	$wpeevent_button_qty_b = get_post_meta($post_id,'wpeevent_button_qty_b',true);
	$wpeevent_button_qty_c = get_post_meta($post_id,'wpeevent_button_qty_c',true);
	$wpeevent_button_qty_d = get_post_meta($post_id,'wpeevent_button_qty_d',true);
	$wpeevent_button_qty_e = get_post_meta($post_id,'wpeevent_button_qty_e',true);
	
	$wpeevent_button_desc_a = get_post_meta($post_id,'wpeevent_button_desc_a',true);
	$wpeevent_button_desc_b = get_post_meta($post_id,'wpeevent_button_desc_b',true);
	$wpeevent_button_desc_c = get_post_meta($post_id,'wpeevent_button_desc_c',true);
	$wpeevent_button_desc_d = get_post_meta($post_id,'wpeevent_button_desc_d',true);
	$wpeevent_button_desc_e = get_post_meta($post_id,'wpeevent_button_desc_e',true);

	$post_data = 	get_post($post_id);
	$name = 		$post_data->post_title;
	
	// header names
	$wpeevent_button_h_title = get_post_meta($post_id,'wpeevent_button_h_title',true);
	$wpeevent_button_h_name = get_post_meta($post_id,'wpeevent_button_h_name',true);
	$wpeevent_button_h_price = get_post_meta($post_id,'wpeevent_button_h_price',true);
	$wpeevent_button_h_desc = get_post_meta($post_id,'wpeevent_button_h_desc',true);

	// live of test mode
	if ($value['mode'] == "1") {
		$account = $value['sandboxaccount'];
		$path = "sandbox.paypal";
	} else {
		$account = $value['liveaccount'];
		$path = "paypal";
	}
	
	$account_a = get_post_meta($post_id,'wpeevent_button_account',true);
	if (!empty($account_a)) { $account = $account_a; }

	// currency
	$currency_a = get_post_meta($post_id,'wpeevent_button_currency',true);
	if (!empty($currency_a)) { $value['currency'] = $currency_a; }
		
	if ($value['currency'] == "1") { $currency = "AUD"; }
	if ($value['currency'] == "2") { $currency = "BRL"; }
	if ($value['currency'] == "3") { $currency = "CAD"; }
	if ($value['currency'] == "4") { $currency = "CZK"; }
	if ($value['currency'] == "5") { $currency = "DKK"; }
	if ($value['currency'] == "6") { $currency = "EUR"; }
	if ($value['currency'] == "7") { $currency = "HKD"; }
	if ($value['currency'] == "8") { $currency = "HUF"; }
	if ($value['currency'] == "9") { $currency = "ILS"; }
	if ($value['currency'] == "10") { $currency = "JPY"; }
	if ($value['currency'] == "11") { $currency = "MYR"; }
	if ($value['currency'] == "12") { $currency = "MXN"; }
	if ($value['currency'] == "13") { $currency = "NOK"; }
	if ($value['currency'] == "14") { $currency = "NZD"; }
	if ($value['currency'] == "15") { $currency = "PHP"; }
	if ($value['currency'] == "16") { $currency = "PLN"; }
	if ($value['currency'] == "17") { $currency = "GBP"; }
	if ($value['currency'] == "18") { $currency = "RUB"; }
	if ($value['currency'] == "19") { $currency = "SGD"; }
	if ($value['currency'] == "20") { $currency = "SEK"; }
	if ($value['currency'] == "21") { $currency = "CHF"; }
	if ($value['currency'] == "22") { $currency = "TWD"; }
	if ($value['currency'] == "23") { $currency = "THB"; }
	if ($value['currency'] == "24") { $currency = "TRY"; }
	if ($value['currency'] == "25") { $currency = "USD"; }
	
	// language
	$language_a = get_post_meta($post_id,'wpeevent_button_language',true);
	if (!empty($language_a)) { $value['language'] = $language_a; }

	if ($value['language'] == "1") {
		$language = "da_DK";
		$image = "https://www.paypalobjects.com/da_DK/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/da_DK/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/da_DK/DK/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/da_DK/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/da_DK/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/da_DK/DK/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //Danish
	
	if ($value['language'] == "2") {
	$language = "nl_BE";
		$image = "https://www.paypalobjects.com/nl_NL/NL/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/nl_NL/NL/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/nl_NL/NL/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/nl_NL/NL/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/nl_NL/NL/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/nl_NL/NL/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //Dutch
	
	if ($value['language'] == "3") {
	$language = "EN_US";
		$image = "https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/en_US/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //English
	
	if ($value['language'] == "20") {
	$language = "en_GB";
		$image = "https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/en_US/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //English - UK
	
	if ($value['language'] == "4") {
		$language = "fr_CA";
		$image = "https://www.paypalobjects.com/fr_CA/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/fr_CA/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/fr_CA/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/fr_CA/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/fr_CA/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/fr_CA/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //French
	
	if ($value['language'] == "5") {
		$language = "de_DE";
		$image = "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //German
	
	if ($value['language'] == "6") {
		$language = "he_IL";
		$image = "https://www.paypalobjects.com/he_IL/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/he_IL/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/he_IL/IL/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/he_IL/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/he_IL/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/he_IL/IL/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //Hebrew
	
	if ($value['language'] == "7") {
		$language = "it_IT";
		$image = "https://www.paypalobjects.com/it_IT/IT/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/it_IT/IT/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/it_IT/IT/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/it_IT/IT/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/it_IT/IT/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/it_IT/IT/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //Italian
	
	if ($value['language'] == "8") {
		$language = "ja_JP";
		$image = "https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //Japanese
	
	if ($value['language'] == "9") {
		$language = "no_NO";
		$image = "https://www.paypalobjects.com/no_NO/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/no_NO/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/no_NO/NO/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/no_NO/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/no_NO/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/no_NO/NO/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //Norwgian
	
	if ($value['language'] == "10") {
		$language = "pl_PL";
		$image = "https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //Polish

	if ($value['language'] == "11") {
		$language = "pt_BR";
		$image = "https://www.paypalobjects.com/pt_PT/PT/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/pt_PT/PT/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/pt_PT/PT/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/pt_PT/PT/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/pt_PT/PT/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/pt_PT/PT/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //Portuguese

	if ($value['language'] == "12") {
		$language = "ru_RU";
		$image = "https://www.paypalobjects.com/ru_RU/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/ru_RU/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/ru_RU/RU/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/ru_RU/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/ru_RU/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/ru_RU/RU/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //Russian
	
	if ($value['language'] == "13") {
		$language = "es_ES";
		$image = "https://www.paypalobjects.com/es_ES/ES/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/es_ES/ES/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/es_ES/ES/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/es_ES/ES/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/es_ES/ES/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/es_ES/ES/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //Spanish
	
	if ($value['language'] == "14") {
		$language = "sv_SE";
		$image = "https://www.paypalobjects.com/sv_SE/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/sv_SE/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/sv_SE/SE/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/sv_SE/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/sv_SE/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/sv_SE/SE/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //Swedish
	
	if ($value['language'] == "15") {
		$language = "zh_CN";
		$image = "https://www.paypalobjects.com/zh_XC/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/zh_XC/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/zh_XC/C2/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/zh_XC/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/zh_XC/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/zh_XC/C2/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //Simplified Chinese - China
	
	if ($value['language'] == "16") {
		$language = "zh_HK";
		$image = "https://www.paypalobjects.com/zh_HK/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/zh_HK/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/zh_HK/HK/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/zh_HK/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/zh_HK/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/zh_HK/HK/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //Traditional Chinese - Hong Kong
	
	if ($value['language'] == "17") {
		$language = "zh_TW";
		$image = "https://www.paypalobjects.com/zh_TW/TW/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/zh_TW/TW/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/zh_TW/TW/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/zh_TW/TW/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/zh_TW/TW/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/zh_TW/TW/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //Traditional Chinese - Taiwan
	
	if ($value['language'] == "18") {
		$language = "tr_TR";
		$image = "https://www.paypalobjects.com/tr_TR/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/tr_TR/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/tr_TR/TR/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/tr_TR/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/tr_TR/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/tr_TR/TR/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //Turkish
	
	if ($value['language'] == "19") {
		$language = "th_TH";
		$image = "https://www.paypalobjects.com/th_TH/i/btn/btn_buynow_SM.gif";
		$imageb = "https://www.paypalobjects.com/th_TH/i/btn/btn_buynow_LG.gif";
		$imagecc = "https://www.paypalobjects.com/th_TH/TH/i/btn/btn_buynowCC_LG.gif";
		$pimage = "https://www.paypalobjects.com/th_TH/i/btn/btn_paynow_SM.gif";
		$pimageb = "https://www.paypalobjects.com/th_TH/i/btn/btn_paynow_LG.gif";
		$pimagecc = "https://www.paypalobjects.com/th_TH/TH/i/btn/btn_paynowCC_LG.gif";
		$imagenew = "https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png";
	} //Thai


	// custom button size
	$wpeevent_button_buttonsize = get_post_meta($post_id,'wpeevent_button_buttonsize',true);
	
	if ($wpeevent_button_buttonsize != "0") {
		$value['size'] = $wpeevent_button_buttonsize;
	}
	
	// button size
	if ($value['size'] == "1") { $img = $image; }
	if ($value['size'] == "2") { $img = $imageb; }
	if ($value['size'] == "3") { $img = $imagecc; }
	if ($value['size'] == "4") { $img = $pimage; }
	if ($value['size'] == "5") { $img = $pimageb; }
	if ($value['size'] == "6") { $img = $pimagecc; }
	if ($value['size'] == "7") { $img = $imagenew; }
	if ($value['size'] == "8") { $img = $value['image_1']; }
		
	// return url
	$return = "";
	$return = $value['return'];
	$return_a = get_post_meta($post_id,'wpeevent_button_return',true);
	if (!empty($return_a)) { $return = $return_a; }
	
	// show name / title
	$wpeevent_button_show = get_post_meta($post_id,'wpeevent_button_show',true);
	
	// show border
	$wpeevent_button_border = get_post_meta($post_id,'wpeevent_button_border',true);
	
	// show menu header
	$wpeevent_button_header = get_post_meta($post_id,'wpeevent_button_header',true);

	// window action
	if ($value['opens'] == "1") { $target = ""; }
	if ($value['opens'] == "2") { $target = "_blank"; }

	// alignment
	if ($atts['align'] == "left") { $alignment = "style='float: left;'"; }
	if ($atts['align'] == "right") { $alignment = "style='float: right;'"; }
	if ($atts['align'] == "center") { $alignment = "style='margin-left: auto;margin-right: auto;width:220px'"; }
	if (empty($atts['align'])) { $alignment = ""; }
	
	// sold out text
	$sold_out_text = $wpeevent_button_qty_e = get_post_meta($post_id,'wpeevent_button_sold_out',true);
	
	// notify url
	$notify_url = get_admin_url() . "admin-post.php?action=add_wpeevent_button_ipn";
	
	//redirect url
	$redirect_url = get_admin_url() . "admin-post.php?action=add_wpeevent_button_redirect";
	
	$output = "";
	$output .= "<div " . esc_attr($alignment) . ">";
	
	if ($wpeevent_button_show == "1") {
		$output .= "<label class='wpeevent_eventname'>" . esc_html($name) . "</label>";
	}
	
	$output .= "<form target='" . esc_attr($target) . "' action='" . esc_url($redirect_url) . "' method='post'>";
	$output .= "<input type='hidden' name='cmd' value='_cart' />";
	$output .= "<input type='hidden' name='path' value='" . esc_attr($path) . "' />";
	$output .= "<input type='hidden' name='business' value='" . esc_attr($account) . "' />";
	$output .= "<input type='hidden' name='item_name' value='" . esc_attr($name) . "' />";
	$output .= "<input type='hidden' name='custom' value='" . esc_attr($post_id) . "' />";
	$output .= "<input type='hidden' name='currency_code' value='" . esc_attr($currency) . "' />";
	$output .= "<input type='hidden' name='no_note' value='" . esc_attr($value['no_note']) ."'>";
	$output .= "<input type='hidden' name='no_shipping' value='" . esc_attr($value['no_shipping']) ."'>";
	$output .= "<input type='hidden' name='notify_url' value='" . esc_attr($notify_url) . "'>";
	$output .= "<input type='hidden' name='lc' value='" . esc_attr($language) . "'>";
	$output .= "<input type='hidden' name='bn' value='WPPlugin_SP'>";
	$output .= "<input type='hidden' name='return' value='" . esc_attr($return) . "' />";
	$output .= "<input type='hidden' name='cancel_return' value='" . esc_attr($value['cancel']) . "' />";
	
	$output .= "<input type='hidden' name='upload' value='1' />";
	
	
	// border
	if ($wpeevent_button_border == "1") {
		$output .= "<style> .main-table_" . esc_attr($post_id) . " tr { border: 1px solid #d1d1d1 !important; } table { border-collapse: collapse; } .row-qty { width: 15%; } .row-name { width: 30%; } .row-price { width: 15%; } .row-desc { width: 40%; }</style>";
	} else {
	// no border
		$output .= "<style> .main-table_" . esc_attr($post_id) . ",.main-table_" . esc_attr($post_id) . " td,main-table_" . esc_attr($post_id) . " tr { border: 0px solid #000000 !important; } .row-qty { width: 15%; } .row-name { width: 30%; } .row-price { width: 15%; } .row-desc { width: 40%; }</style>";
	}
	
	// draw menu
	$output .= "<table class='main-table_" . esc_attr($post_id) . "' style='width: 100% !important;'>";
	
	// display column headers
	if ($wpeevent_button_header == "1") {
		$output .= "<tr><td class='row-qty'>" . esc_html($wpeevent_button_h_title) . "</td><td class='row-name'>" . esc_html($wpeevent_button_h_name) . "</td><td class='row-price'>" . esc_html($wpeevent_button_h_price) . "</td><td class='row-desc'>" . esc_html($wpeevent_button_h_desc) . "</td></tr>";
	}
	
	// row a
	$output .= "<tr><td class='row-qty'>"; if (empty($wpeevent_button_qty_a)) { $output .= esc_html($sold_out_text) . "<input type='hidden' name='wpeevent_button_qty_a' value='0'>";  } else { $output .= "<select name='wpeevent_button_qty_a'>"; for ($x = 0; $x <= $wpeevent_button_qty_a; $x++) { $output .= "<option value='" . esc_attr($x) . "'>" . esc_html($x) . "</option>"; } $output .= "</select>"; } $output .= "</td>";
	$output .= "<td class='row-name'>"; if (!empty($wpeevent_button_name_a)) { $output .= esc_html($wpeevent_button_name_a); } $output .= "</td>";
	$output .= "<td class='row-price'>"; if (!empty($wpeevent_button_price_a)) { $output .= esc_html($wpeevent_button_price_a); } if ($value['show_currency'] == "0") { $output .= " ".esc_html($currency); } $output .= "</td>";
	$output .= "<td class='row-desc'>"; if (!empty($wpeevent_button_desc_a)) { $output .= esc_html($wpeevent_button_desc_a); }
	$output .= "<input type='hidden' name='item_name_1' value='" . esc_attr($wpeevent_button_name_a) . "'><input type='hidden' name='id_1' value='" . esc_attr($wpeevent_button_id_a) . "'><input type='hidden' name='amount_1' value='" . esc_attr($wpeevent_button_price_a) . "'></td></tr>";
	
	
	// row b
	if (!empty($wpeevent_button_name_b)) {
		$output .= "<tr><td>"; if (empty($wpeevent_button_qty_b)) { $output .= esc_html($sold_out_text) . "<input type='hidden' name='wpeevent_button_qty_b' value='0'>";  } else { $output .= "<select name='wpeevent_button_qty_b'>"; for ($x = 0; $x <= $wpeevent_button_qty_b; $x++) { $output .= "<option value='" . esc_attr($x) . "'>" . esc_html($x) . "</option>"; } $output .= "</select>"; } $output .= "</td>";
		$output .= "<td>"; if (!empty($wpeevent_button_name_b)) { $output .= esc_html($wpeevent_button_name_b); } $output .= "</td>";
		$output .= "<td>"; if (!empty($wpeevent_button_price_b)) { $output .= esc_html($wpeevent_button_price_b); } if ($value['show_currency'] == "0") { $output .= " ".esc_html($currency); }  $output .= "</td>";
		$output .= "<td>"; if (!empty($wpeevent_button_desc_b)) { $output .= esc_html($wpeevent_button_desc_b); }
		$output .= "<input type='hidden' name='item_name_2' value='" . esc_attr($wpeevent_button_name_b) . "'><input type='hidden' name='id_2' value='" . esc_attr($wpeevent_button_id_b) . "'><input type='hidden' name='amount_2' value='" . esc_attr($wpeevent_button_price_b) . "'></td></tr>";
	}
	
	// row c
	if (!empty($wpeevent_button_name_c)) {
		$output .= "<tr><td>"; if (empty($wpeevent_button_qty_c)) { $output .= esc_html($sold_out_text) . "<input type='hidden' name='wpeevent_button_qty_c' value='0'>";  } else { $output .= "<select name='wpeevent_button_qty_c'>"; for ($x = 0; $x <= $wpeevent_button_qty_c; $x++) { $output .= "<option value='" . esc_attr($x) . "'>" . esc_html($x) . "</option>"; } $output .= "</select>"; } $output .= "</td>";
		$output .= "<td>"; if (!empty($wpeevent_button_name_c)) { $output .= esc_html($wpeevent_button_name_c); } $output .= "</td>";
		$output .= "<td>"; if (!empty($wpeevent_button_price_c)) { $output .= esc_html($wpeevent_button_price_c); } if ($value['show_currency'] == "0") { $output .= " ".esc_html($currency); }  $output .= "</td>";
		$output .= "<td>"; if (!empty($wpeevent_button_desc_c)) { $output .= esc_html($wpeevent_button_desc_c); }
		$output .= "<input type='hidden' name='item_name_3' value='" . esc_attr($wpeevent_button_name_c) . "'><input type='hidden' name='id_3' value='" . esc_attr($wpeevent_button_id_c) . "'><input type='hidden' name='amount_3' value='" . esc_attr($wpeevent_button_price_c) . "'></td></tr>";
	}
	
	// row d
	if (!empty($wpeevent_button_name_d)) {
		$output .= "<tr><td>"; if (empty($wpeevent_button_qty_d)) { $output .= esc_html($sold_out_text) . "<input type='hidden' name='wpeevent_button_qty_d' value='0'>";  } else { $output .= "<select name='wpeevent_button_qty_d'>"; for ($x = 0; $x <= $wpeevent_button_qty_d; $x++) { $output .= "<option value='" . esc_attr($x) . "'>" . esc_html($x) . "</option>"; } $output .= "</select>"; } $output .= "</td>";
		$output .= "<td>"; if (!empty($wpeevent_button_name_d)) { $output .= esc_html($wpeevent_button_name_d); } $output .= "</td>";
		$output .= "<td>"; if (!empty($wpeevent_button_price_d)) { $output .= esc_html($wpeevent_button_price_d); } if ($value['show_currency'] == "0") { $output .= " ".esc_html($currency); }  $output .= "</td>";
		$output .= "<td>"; if (!empty($wpeevent_button_desc_d)) { $output .= esc_html($wpeevent_button_desc_d); }
		$output .= "<input type='hidden' name='item_name_4' value='" . esc_attr($wpeevent_button_name_d) . "'><input type='hidden' name='id_4' value='" . esc_attr($wpeevent_button_id_d) . "'><input type='hidden' name='amount_4' value='" . esc_attr($wpeevent_button_price_d) . "'></td></tr>";
	}
	
	// row e
	if (!empty($wpeevent_button_name_e)) {
		$output .= "<tr><td>"; if (empty($wpeevent_button_qty_e)) { $output .= esc_html($sold_out_text) . "<input type='hidden' name='wpeevent_button_qty_e' value='0'>";  } else { $output .= "<select name='wpeevent_button_qty_e'>"; for ($x = 0; $x <= $wpeevent_button_qty_e; $x++) { $output .= "<option value='" . esc_attr($x) . "'>" . esc_html($x) . "</option>"; } $output .= "</select>"; } $output .= "</td>";
		$output .= "<td>"; if (!empty($wpeevent_button_name_e)) { $output .= esc_html($wpeevent_button_name_e); } $output .= "</td>";
		$output .= "<td>"; if (!empty($wpeevent_button_price_e)) { $output .= esc_html($wpeevent_button_price_e); } if ($value['show_currency'] == "0") { $output .= " ".esc_html($currency); }  $output .= "</td>";
		$output .= "<td>"; if (!empty($wpeevent_button_desc_e)) { $output .= esc_html($wpeevent_button_desc_e); }
		$output .= "<input type='hidden' name='item_name_5' value='" . esc_attr($wpeevent_button_name_e) . "'><input type='hidden' name='id_5' value='" . esc_attr($wpeevent_button_id_e) . "'><input type='hidden' name='amount_5' value='" . esc_attr($wpeevent_button_price_e) . "'></td></tr>";
	}
	
	$output .= "</table>";	
	
	$output .= esc_html($pp_text)."<br />";
	
	$output .= "<input class='wpeevent_paypalbuttonimage' type='image' src='" . esc_attr($img) . "' border='0' name='submit' alt='Make your payments with PayPal. It is free, secure, effective.' style='border: none;'>";
	$output .= "<img alt='' border='0' style='border:none;display:none;' src='https://www.paypal.com/" . esc_attr($language) . "/i/scr/pixel.gif' width='1' height='1'>";
	$output .= "</form></div>";

	return $output;
	
}