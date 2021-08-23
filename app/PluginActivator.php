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
        self::checkErrors();
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
            'dhl_api_key'       => '',
            'dhl_api_secret'    => '',
            'dhl_api_sandbox'   => true
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


    protected static function checkErrors()
	{
        $errors = [];
        
        $active_plugins = get_option( 'active_plugins', [] );

        if ( !in_array( 'woocommerce/woocommerce.php', $active_plugins, true ) )
            $errors[] = 'Plugin "Woocommerce" is not active.';

        if ( !empty( $errors ) ) {
            $errors = implode( '<br>', $errors );

            exit( "<div class='notice notice-error is-dismissible'>$errors</div>" ); 
        }
	}
}
