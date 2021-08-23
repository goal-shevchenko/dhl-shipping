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
        self::init_settings();
		// self::create_db_tables();
    }

    /**
     * Add/update plugin options
	 * 
	 * @since	1.0.0
	 * @access	protected
     */
    protected static function init_settings()
    {
        add_option( DHL_SHIPPING_ID_UNDERSCORED . '_db_version', DHL_SHIPPING_DB_VERSION );
        add_option( DHL_SHIPPING_ID_UNDERSCORED . '_options', [
            'plugin_enabled'            => false,
            'enabled_shipping_types'    => []
        ] );
    }


	/**
     * Create required database tables
	 * 
	 * @since	1.0.0
	 * @access	protected
     */
    protected static function create_db_tables()
    {
        global $wpdb;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    }
}
