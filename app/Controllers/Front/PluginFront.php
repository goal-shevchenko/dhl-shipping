<?php

namespace DhlShipping\Controllers\Front;

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
	public function enqueue_styles()
	{
		// wp_enqueue_style( DHL_SHIPPING_ID, plugin_dir_url( __FILE__ ) . 'assets/css/public/dhl-shipping-public.css', array(), DHL_SHIPPING_VERSION, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since	1.0.0
	 */
	public function enqueue_scripts()
	{
		wp_enqueue_script( DHL_SHIPPING_ID, plugin_dir_url( __FILE__ ) . 'assets/js/public/dhl-shipping-public.js', array( 'jquery' ), DHL_SHIPPING_VERSION, false );
	}

}
