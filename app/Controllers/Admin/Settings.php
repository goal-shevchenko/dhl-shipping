<?php

namespace DhlShipping\Controllers\Admin;

use DhlShipping\Models\ShippingTypes;

/**
 * Settings page on admin panel
 * 
 * @since 1.0.0
 */
class Settings extends BaseController
{
    /**
     * Plugin main options
     * 
     * @since 1.0.0
     * @access protected
     * @var array
     */
    protected $options;

    /**
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->options = get_option( DHL_SHIPPING_ID_UNDERSCORED . '_options', [] );
    }

    /**
     * Init all settings
     * 
     * @since 1.0.0
     * @access public
     */
    public function init()
    {
        $this->initMainSettings();
    }

    /**
     * Init main settings
     * 
     * @since 1.0.0
     * @access public
     */
    public function initMainSettings()
    {
        register_setting( DHL_SHIPPING_ID_UNDERSCORED, DHL_SHIPPING_ID_UNDERSCORED . '_options' );

        add_settings_section( DHL_SHIPPING_ID_UNDERSCORED . '_main_settings', DHL_SHIPPING_TITLE, '', DHL_SHIPPING_ID_UNDERSCORED );
        
        add_settings_field( 
            'plugin_enabled',
            __( 'Plugin status', DHL_SHIPPING_ID_UNDERSCORED ),
            [$this, 'pluginEnabledView'],
            DHL_SHIPPING_ID_UNDERSCORED,
            DHL_SHIPPING_ID_UNDERSCORED . '_main_settings',
            [
                'name'  => 'plugin_enabled',
                'class' => 'plugin_enabled_row'
            ]
        );
    }

    /**
     * Generate view for plugin enabled option
     * 
     * @param array $args
     * 
     * @since 1.0.0
     * @access public
     */
    public function pluginEnabledView( $args )
    {
        $enabled = !empty( $this->options[ $args['name'] ] );
        ?>
            <select name="<?= DHL_SHIPPING_ID_UNDERSCORED ?>_options[<?= $args['name'] ?>]" id="plugin-enabled">
                <option value="" <?= !$enabled ? 'selected' : '' ?> >Disabled</option>
                <option value="true" <?= $enabled ? 'selected' : '' ?>>Enabled</option>
            </select>
        <?php
    }

    /**
     * Load settings page view
     * 
     * @since 1.0.0
     * @access public
     */
    public function view()
    {
        self::load_view( 'settings' );
    }
}