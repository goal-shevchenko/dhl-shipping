<?php

namespace DhlShipping\Controllers\Admin;

use DhlShipping\Controllers\Admin\Settings;
use DhlShipping\Models\ShippingTypes;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines hooks related to admin area.
 *
 * @since 	1.0.0
 * @package	DhlShipping\Admin
 */
class PluginAdmin
{
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since	1.0.0
	 * @access 	public
	 */
	public function __construct()
	{
		$this->settings = new Settings();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since	1.0.0
	 * @access 	public
	 */
	public function enqueueStyles()
	{
		wp_enqueue_style( DHL_SHIPPING_ID, DHL_SHIPPING_ROOT_URL . '/assets/css/admin/dhl-shipping-admin.css', array(), DHL_SHIPPING_VERSION, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since   1.0.0
	 * @access 	public
	 */
	public function enqueueScripts()
	{
		// wp_enqueue_script( DHL_SHIPPING_ID, DHL_SHIPPING_ROOT_URL . '/assets/js/admin/dhl-shipping-admin.js', array( 'jquery' ), DHL_SHIPPING_ID, false );
	}

	/**
	 * Register menu for admin area
	 *
	 * @since   1.0.0
	 * @access 	public
	 */
	public function initMenu()
	{
		add_menu_page( DHL_SHIPPING_TITLE, DHL_SHIPPING_TITLE, 'manage_options', DHL_SHIPPING_ID, [$this->settings, 'view'] );
		add_submenu_page( DHL_SHIPPING_ID, DHL_SHIPPING_TITLE, "Settings", 'manage_options', DHL_SHIPPING_ID );
	}

	/**
	 * Register all functional on admin_init hook
	 * 
	 * @since 	1.0.0
	 * @access	public
	 */
	public function adminInit()
	{
		$this->settings->init();
	}

	/**
	 * Add new shipping methods. Just create new class in shipping methods folder
	 * 
	 * @param 	array $methods
	 * @return	array
	 * 
	 * @since 	1.0.0
	 * @access 	public
	 */
	public function shippingMethodsAdd( $methods )
	{
		$shipping_classes = ShippingTypes::getAllClasses();

		foreach( $shipping_classes as $class ) {
			$methods[ $class::$dhl_id ] = $class;
		}

		return $methods;
	}

	/**
	 * Display field value on the order edit page
	 * 
	 * @param 	array 		$items
	 * @param 	WC_Order	$order
	 * @param	array		$types
	 * @return 	array		of items
	 * 
	 * @since 	1.0.0
	 * @access 	public
	 */
	function orderUpdateShippingItems( $items, $order, $types )
	{
		foreach ( $types as $type ) {
			if ( $type == 'shipping' ) {
				foreach ( $items as $item ) {
					if ( $item->get_method_id() == 'dhl_local_pickup' ) {
						
						$updated_name = $item->get_data()['name'] . '. Office: ' . $order->get_meta( 'dhl_pickup_destination_name' );
						$item->set_name( $updated_name );
						break;
					}
				}
			}
		}

		return $items;	
	}
}
