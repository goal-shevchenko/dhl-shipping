<?php

namespace DhlShipping\Controllers\Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines hooks related to admin area.
 *
 * @package    DhlShipping\Admin
 */
class PluginAdmin
{
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
		// wp_enqueue_style( DHL_SHIPPING_ID, plugin_dir_url( __FILE__ ) . 'assets/css/admin/dhl-shipping-admin.css', array(), DHL_SHIPPING_VERSION, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		// wp_enqueue_script( DHL_SHIPPING_ID, plugin_dir_url( __FILE__ ) . 'assets/js/admin/dhl-shipping-admin.js', array( 'jquery' ), DHL_SHIPPING_ID, false );
	}

	/**
	 * Register menu for admin area.
	 *
	 * @since    1.0.0
	 */
	public function init_menu()
	{
		
	}
}
