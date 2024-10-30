<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/* function which gets the options */

function dm_rme_get_settings()
{
	$dm_rme_options = get_option('dm-rme-options', null);
	return $dm_rme_options;
}


/* we get the options */

$settings = dm_rme_get_settings();

if ( is_array($settings) )
{
	/* set the email recipient */
	
	
	if ( array_key_exists('recovery-mode-email', $settings) && is_email( $settings['recovery-mode-email'] ) )
	{
		add_filter( 'recovery_mode_email', function( $email_data ) 
		{
			$settings = dm_rme_get_settings();
			$email_data['to'] = $settings['recovery-mode-email'];
			return $email_data;
		} );
	}
	
	
	/* set the email rate limit */
	
	if ( array_key_exists('recovery-mode-email-rate-limit', $settings) && is_numeric( $settings['recovery-mode-email-rate-limit'] ) )
	{
		add_filter( 'recovery_mode_email_rate_limit', function( $interval )
		{
			$settings = dm_rme_get_settings();
			return $settings['recovery-mode-email-rate-limit'] * DAY_IN_SECONDS;
		} );
	}
	
	
	/* set the email sender */
	
	if ( array_key_exists('recovery-mode-mail-sender-email', $settings) && is_email( $settings['recovery-mode-mail-sender-email'] ) )
	{
		add_filter( 'wp_mail_from', function( $mail_from )
		{
			$settings = dm_rme_get_settings();
			return $settings['recovery-mode-mail-sender-email'];
		} );
	}
	
	
	/* set the name sender */
	
	if ( array_key_exists('recovery-mode-mail-sender-name', $settings) && sanitize_text_field( $settings['recovery-mode-mail-sender-name'] ) )
	{
		add_filter( 'wp_mail_from_name', function( $mail_from_name )
		{
			$settings = dm_rme_get_settings();
			return $settings['recovery-mode-mail-sender-name'];
		} );
	}
}


