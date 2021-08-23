<?php

namespace DhlShipping;

use DhlShipping\PluginI18n;
use DhlShipping\Controllers\Admin\PluginAdmin;
use DhlShipping\Controllers\Front\PluginFront;

/**
 * The core plugin class
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks
 *
 * @since      1.0.0
 * @package    DhlShipping\Plugin
 */
class Plugin
{
	/**
	 * Define the core functionality of the plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the PluginI18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function setLocale()
	{
		$plugin_i18n = new PluginI18n();

		add_action( 'plugins_loaded', [$plugin_i18n, 'load_plugin_textdomain'] );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function defineAdminHooks()
	{
		$plugin_admin = new PluginAdmin();

		add_action( 'admin_enqueue_scripts', [$plugin_admin, 'enqueueStyles'] );
		add_action( 'admin_enqueue_scripts', [$plugin_admin, 'enqueueScripts'] );

		add_action( 'admin_menu', [$plugin_admin, 'initMenu'] );

		add_action( 'admin_init', [$plugin_admin, 'adminInit'] );

		add_filter( 'woocommerce_shipping_methods', [$plugin_admin, 'shippingMethodsAdd'] );
		add_filter( 'woocommerce_order_get_items', [$plugin_admin, 'orderUpdateShippingItems'], 10, 3 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function definePublicHooks()
	{
		$plugin_front = new PluginFront();

		add_action( 'wp_enqueue_scripts', [$plugin_front, 'enqueueStyles'] );
		add_action( 'wp_enqueue_scripts', [$plugin_front, 'enqueueScripts'] );

		add_action( 'woocommerce_after_shipping_rate', [$plugin_front, 'changeShippingMethod'] );
		add_filter( 'woocommerce_proceed_to_checkout', [$plugin_front, 'updateCheckoutButton'] );
		add_filter( 'woocommerce_order_button_html', [$plugin_front, 'updatePlaceOrderButton'] );
		add_action( 'woocommerce_after_checkout_validation', [$plugin_front, 'checkoutValidationShippingMethods'], 20, 2 );
		add_action( 'woocommerce_checkout_update_order_meta', [$plugin_front, 'updateOrderMetaOnCheckout'] );
	}

	/**
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Define the locale, set the hooks for the admin area and
	 * the public-facing side of the site.
	 * 
	 * @since	1.0.0
	 * @access	public
	 */
	public function run()
	{
		$this->setLocale();
		$this->defineAdminHooks();
		$this->definePublicHooks();
	}
}
