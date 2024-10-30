<?php

/*
 * Plugin Name: Custom Recovery Mode Email
 * Plugin URI: https://www.dixitalmedia.com/#que-hacemos
 * Description: Change the recipient address when WordPress sends an email if a Fatal Error occurs.
 * Version: 1.0.4
 * Author: jairoochoa
 * Author URI: https://www.dixitalmedia.com
 * License: GPL v2 or later
 * Text Domain: custom-recovery-mode-email
 * Domain Path: /languages/
 *
 */	


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}



/* load textdomain */

function dm_rme_load_textdomain() 
{
	load_plugin_textdomain( 'custom-recovery-mode-email', false, dirname( plugin_basename(__FILE__) ).'/languages/' );
}

add_action( 'plugins_loaded', 'dm_rme_load_textdomain' );




/* deactivate plugin if multisite */

if ( is_multisite() )
{
	add_action( 'init', 'dm_rme_deactivate_plugin' );
}


function dm_rme_error_notice()
{
	?>
	<div id="message" class="error notice is-dismissible"><p><?php printf ( __( '<em>Custom Recovery Mode Email</em> has been deactivated because WordPress Multisite is not supported yet!', 'custom-recovery-mode-email' ) ) ?></p><button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'custom-recovery-mode-email' ); ?></span></button></div>
	<?php
}


function dm_rme_admin_style()
{
	echo '<style>.updated { display: none; }</style>';
}


function dm_rme_deactivate_plugin()
{
	if ( !function_exists( 'deactivate_plugins' ) ) 
	{
		include( ABSPATH . 'wp-admin/includes/plugin.php' ); 
	}
	deactivate_plugins( plugin_basename(__FILE__) );
	
	add_action( 'admin_notices', 'dm_rme_error_notice' );
	add_action( 'network_admin_notices', 'dm_rme_error_notice' );
	add_action( 'admin_enqueue_scripts', 'dm_rme_admin_style' );
}




/* load includes */

if ( !is_multisite() )
{
	if ( !function_exists( 'wp_get_current_user' ) ) 
	{
		include( ABSPATH . 'wp-includes/pluggable.php' ); 
	}
	
	require_once ( 'dm-rme-filter.php' );
	
	if ( current_user_can('manage_options') || current_user_can('manage_network') )
	{	
		require_once ( 'dm-rme-settings.php' );
	}
}

