<?php

namespace DhlShipping;

/**
 * Fired during plugin activation.
 *
 * @since      1.0.0
 * @subpackage DhlShipping\PluginActivator
 */
class PluginActivator
{
	/**
	 * Main activation function
	 * 
	 * @since   1.0.0
	 * @access	public
	 */
	public static function activate()
    {
        self::initSettings();
		// self::createDbTables();
    }

    /**
     * Add/update plugin options
	 * 
	 * @since	1.0.0
	 * @access	protected
     */
    protected static function initSettings()
    {
        add_option( DHL_SHIPPING_ID_UNDERSCORED . '_db_version', DHL_SHIPPING_DB_VERSION );
        add_option( DHL_SHIPPING_ID_UNDERSCORED . '_options', [
            'plugin_enabled'    => false,
            'dhl_api_key'       => '',
            'dhl_api_secret'    => ''
        ] );
    }


	/**
     * Create required database tables
	 * 
	 * @since	1.0.0
	 * @access	protected
     */
    protected static function createDbTables()
    {
        global $wpdb;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    }
}
