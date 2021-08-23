<?php

namespace DhlShipping\Controllers\Front;

use DhlShipping\Controllers\Front\ShippingMethods;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines all the hooks related to admin area
 *
 * @package DhlShipping\Front
 */
class PluginFront
{
	/**
	 * Initialize the class
	 *
	 * @since	1.0.0
	 */
	public function __construct( )
	{

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since	1.0.0
	 */
	public function enqueueStyles()
	{
		wp_enqueue_style( DHL_SHIPPING_ID, DHL_SHIPPING_ROOT_URL . 'assets/css/public/dhl-shipping-public.css', array(), DHL_SHIPPING_VERSION );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since	1.0.0
	 */
	public function enqueueScripts()
	{
		// wp_enqueue_script( DHL_SHIPPING_ID, DHL_SHIPPING_ROOT_URL . 'assets/js/public/dhl-shipping-public.js', array( 'jquery' ), DHL_SHIPPING_VERSION );
	}

	/**
	 * Head request to From shipping methods controller when change shipping method on cart/checkout pages
	 * 
	 * @param 	WC_Shipping_Rate $method
	 * 
	 * @since 	1.0.0
	 * @access 	public
	 */
	public function changeShippingMethod( $method )
	{
		if( !is_checkout() && !is_cart() ) 
			return;

		$shipping_controller = new ShippingMethods();
		$shipping_controller->cartShippingMethodsLayoutChange( $method );
	}

	/**
	 * Disable checkout button depending from shipping method
	 * 
	 * @since 	1.0.0
	 * @access 	public
	 */
	public function updateCheckoutButton()
	{
		$shipping_controller = new ShippingMethods();
		$shipping_controller->removeCheckoutButtonIfShippingNotAvailable();
	}

	/**
	 * Disable Place order button on checkout page depending from shipping method
	 * 
	 * @param	string $button
	 * 
	 * @since 	1.0.0
	 * @access 	public
	 */
	public function updatePlaceOrderButton( $button )
	{
		$shipping_controller = new ShippingMethods();
		$shipping_controller->disablePlaceOrderButtonIfShippingNotAvailable( $button );
	}

	/**
	 * Validate shipping methods on checkout page
	 * 
	 * @param	array	$fields
	 * @param	object	$errors
	 * 
	 * @since 	1.0.0
	 * @access 	public
	 */
	public function checkoutValidationShippingMethods( $fields, $errors )
	{
		$shipping_controller = new ShippingMethods();
		$shipping_controller->checkoutValidation( $fields, $errors );
	}
}
