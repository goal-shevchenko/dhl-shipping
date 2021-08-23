<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:      Dhl shipping plugin
 * Description:       Extend Woocommerce with new DHL shipping options
 * Version:           1.0.0
 * Author:            Anton
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( __DIR__ . '/vendor/autoload.php' );

/**
 * Currently plugin version.
 */
define( 'DHL_SHIPPING_VERSION', '1.0.0' );
define( 'DHL_SHIPPING_DB_VERSION', '1.0.0' );
define( 'DHL_SHIPPING_ID', 'dhl-shipping' );

/**
 * Register file resible for plugin activation 
 * 
 * @since 1.0.0
 */
function dhlShippingActivate()
{
	include_once( __DIR__ . '/dhl-shipping/plugin-activator.php' );
	$activator = new DhlShipping\PluginActivator();

	register_activation_hook( __FILE__, [$activator, 'activate'] );
}

/**
 * Register file resible for plugin deactivation 
 * 
 * @since 1.0.0
 */
function dhlShippingDeactivate()
{
	include_once( __DIR__ . '/dhl-shipping/plugin-deactivator.php' );
	$deactivator = new DhlShipping\PluginDeactivator();

	register_deactivation_hook( __FILE__, [$deactivator, 'deactivate'] );
}

/**
 * Start point of the plugin
 *
 * @since    1.0.0
 */
function runDhlShipping()
{
	$plugin = new DhlShipping\Plugin();
	$plugin->run();
}

runDhlShipping();
