<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Dhl_Shipping
 * @subpackage Dhl_Shipping/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Dhl_Shipping
 * @subpackage Dhl_Shipping/public
 * @author     Your Name <email@example.com>
 */
class Dhl_Shipping_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $dhl_shipping    The ID of this plugin.
	 */
	private $dhl_shipping;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $dhl_shipping       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $dhl_shipping, $version ) {

		$this->dhl_shipping = $dhl_shipping;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dhl_Shipping_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dhl_Shipping_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->dhl_shipping, plugin_dir_url( __FILE__ ) . 'css/dhl-shipping-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dhl_Shipping_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dhl_Shipping_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->dhl_shipping, plugin_dir_url( __FILE__ ) . 'js/dhl-shipping-public.js', array( 'jquery' ), $this->version, false );

	}

}
