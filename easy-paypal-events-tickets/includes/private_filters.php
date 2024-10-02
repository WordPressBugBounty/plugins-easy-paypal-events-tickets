<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// media button inserter - change button text

function wpeevent_change_button_text( $translation, $text, $domain )
{
    if ( 'default' == $domain and 'Insert into Post' == $text )
    {
        remove_filter( 'gettext', 'wpeevent_change_button_text' );
        return 'Use this image';
    }
    return $translation;
}
add_filter( 'gettext', 'wpeevent_change_button_text', 10, 3 );


// currency validation

function wpeevent_sanitize_currency_meta( $value ) {

	if (!empty($value)) {
		$value = (float) preg_replace('/[^0-9.]*/','',$value);
		return number_format((float)$value, 2, '.', '');
	}
}
add_filter( 'sanitize_post_meta_currency_wpeevent', 'wpeevent_sanitize_currency_meta' );