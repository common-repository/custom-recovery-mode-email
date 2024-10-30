<?php


if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit; // Exit if uninstall not called from WordPress.
}


/* Remove all plugin options on uninstall */

if ( is_multisite() ) 
{
	global $wpdb;

	$blogs = $wpdb->get_results( "SELECT blog_id FROM {$wpdb->blogs}", ARRAY_A );

	if ( $blogs )
	{
		foreach ( $blogs as $blog )
		{
			switch_to_blog( $blog['blog_id'] );
			delete_option( 'dm-rme-options' );
		}
		restore_current_blog();
	}
} 
else 
{
	delete_option( 'dm-rme-options' );
}

