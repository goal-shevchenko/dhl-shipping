<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * @since      1.0.0
 *
 * @package    DhlShipping
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

function dhl_shipping_delete_plugin()
{
	delete_option( DHL_SHIPPING_ID_UNDERSCORED . '_db_version' );
	delete_option( DHL_SHIPPING_ID_UNDERSCORED . '_options' );
	delete_option( DHL_SHIPPING_ID_UNDERSCORED . '_makito' );
}

dhl_shipping_delete_plugin();