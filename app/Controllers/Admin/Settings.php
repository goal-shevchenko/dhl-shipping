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
        $this->init_main_settings();
    }

    /**
     * Init main settings
     * 
     * @since 1.0.0
     * @access public
     */
    public function init_main_settings()
    {
        register_setting( DHL_SHIPPING_ID_UNDERSCORED, DHL_SHIPPING_ID_UNDERSCORED . '_options' );

        add_settings_section( DHL_SHIPPING_ID_UNDERSCORED . '_main_settings', DHL_SHIPPING_TITLE, '', DHL_SHIPPING_ID_UNDERSCORED );
        
        add_settings_field( 
            'plugin_enabled',
            __( 'Plugin status', DHL_SHIPPING_ID_UNDERSCORED ),
            [$this, 'plugin_enabled_view'],
            DHL_SHIPPING_ID_UNDERSCORED,
            DHL_SHIPPING_ID_UNDERSCORED . '_main_settings',
            [
                'name'  => 'plugin_enabled',
                'class' => 'plugin_enabled_row'
            ]
        );

        add_settings_field( 
            'enabled_shipping_types',
            __( 'Enabled shipping types', DHL_SHIPPING_ID_UNDERSCORED ),
            [$this, 'enabled_shipping_types_view'],
            DHL_SHIPPING_ID_UNDERSCORED,
            DHL_SHIPPING_ID_UNDERSCORED . '_main_settings',
            [
                'name'  => 'enabled_shipping_types',
                'class' => 'enabled_shipping_types_row'
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
    public function plugin_enabled_view( $args )
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
     * Generate view for enabled shipping options
     * 
     * @param array $args
     * 
     * @since 1.0.0
     * @access public
     */
    public function enabled_shipping_types_view( $args )
    {
        $shiping_types = ShippingTypes::get_all();

        foreach ( $shiping_types as $id => $name ) {
            $enabled = !empty( $this->options[ $args['name'] ][ $id ] );
            ?>
                <div class="delivery-type-line">
                    <input type="checkbox" 
                        id="shipping-type-<?= $id ?>" 
                        name="<?= DHL_SHIPPING_ID_UNDERSCORED ?>_options[<?= $args['name'] ?>][<?= $id ?>]" <?= $enabled ? 'checked' : '' ?>
                        value="true" />
                    <label for="shipping-type-<?= $id ?>"><?= $name ?></label>
                </div>
                
            <?php
        }
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