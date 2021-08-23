<?php

namespace DhlShipping\Controllers\Admin;

use DhlShipping\Models\Settings as SettingsModel;

/**
 * Settings page on admin panel
 * 
 * @since   1.0.0
 * @package DhlShipping\Controllers\Admin
 */
class Settings extends BaseController
{
    /**
     * Plugin main options
     * 
     * @since   1.0.0
     * @access  protected
     * @var     array
     */
    protected $options;

    /**
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->options = SettingsModel::get();
    }

    /**
     * Init all settings
     * 
     * @since   1.0.0
     * @access  public
     */
    public function init()
    {
        $this->initMainSettings();
    }

    /**
     * Init main settings
     * 
     * @since   1.0.0
     * @access  public
     */
    public function initMainSettings()
    {
        register_setting( DHL_SHIPPING_ID_UNDERSCORED, DHL_SHIPPING_ID_UNDERSCORED . '_options' );

        add_settings_section( DHL_SHIPPING_ID_UNDERSCORED . '_main_settings', DHL_SHIPPING_TITLE, '', DHL_SHIPPING_ID_UNDERSCORED );
        
        $this->addSettingField( 'plugin_enabled', 'Plugin status', 'pluginEnabledView', 'main_settings' );
        $this->addSettingField( 'dhl_api_key', 'DHL API key', 'dhlApiKeyView', 'main_settings' );
        $this->addSettingField( 'dhl_api_secret', 'DHL API secret', 'dhlApiSecretView', 'main_settings' );
        $this->addSettingField( 'dhl_api_sandbox', 'DHL API sandbox', 'dhlApiSandboxView', 'main_settings' );
    }

    /**
     * Generate view for plugin enabled option
     * 
     * @param array $args
     * 
     * @since   1.0.0
     * @access  public
     */
    public function pluginEnabledView( $args )
    {
        $enabled = !empty( $this->options[ $args['name'] ] );
        ?>
            <select name='<?= DHL_SHIPPING_ID_UNDERSCORED ?>_options[<?= $args['name'] ?>]' id='<?= $args['id'] ?>'>
                <option value='' <?= !$enabled ? 'selected' : '' ?> ><?= __( 'Disabled', DHL_SHIPPING_ID_UNDERSCORED ) ?></option>
                <option value='true' <?= $enabled ? 'selected' : '' ?>><?= __( 'Enabled', DHL_SHIPPING_ID_UNDERSCORED ) ?></option>
            </select>
        <?php
    }

    /**
     * Generate view for dhl api key field
     * 
     * @param array $args
     * 
     * @since   1.0.0
     * @access  public
     */
    public function dhlApiKeyView( $args )
    {
        ?>
            <input type='text' 
                name='<?= DHL_SHIPPING_ID_UNDERSCORED ?>_options[<?= $args['name'] ?>]' 
                id='<?= $args['name'] ?>'
                value='<?= $this->options[ $args['name'] ] ?>' />
        <?php
    }

    /**
     * Generate view for dhl api secret field
     * 
     * @param array $args
     * 
     * @since   1.0.0
     * @access  public
     */
    public function dhlApiSecretView( $args )
    {
        ?>
            <input type='text' 
                name='<?= DHL_SHIPPING_ID_UNDERSCORED ?>_options[<?= $args['name'] ?>]' 
                id='<?= $args['name'] ?>' 
                value='<?= $this->options[ $args['name'] ] ?>' />
        <?php
    }

    /**
     * Generate view for DHL sandbox field
     * 
     * @param array $args
     * 
     * @since   1.0.0
     * @access  public
     */
    public function dhlApiSandboxView( $args )
    {
        $enabled = !empty( $this->options[ $args['name'] ] );
        ?>
            <select name='<?= DHL_SHIPPING_ID_UNDERSCORED ?>_options[<?= $args['name'] ?>]' id='<?= $args['id'] ?>'>
                <option value='' <?= !$enabled ? 'selected' : '' ?> ><?= __( 'Disabled', DHL_SHIPPING_ID_UNDERSCORED ) ?></option>
                <option value='true' <?= $enabled ? 'selected' : '' ?>><?= __( 'Enabled', DHL_SHIPPING_ID_UNDERSCORED ) ?></option>
            </select>
        <?php
    }


    /**
     * Load settings page view
     * 
     * @since   1.0.0
     * @access  public
     */
    public function view()
    {
        self::load_view( 'settings' );
    }


    /**
     * Wrapper for wordpress add_settings_field function
     * 
     * @param   string $id
     * @param   string $title
     * @param   string $callback from current class instance to show field HTML
     * @param   string $section_ending
     * 
     * @since   1.0.0
     * @access  protected
     */
    protected function addSettingField( $id, $title, $callback_name, $section_ending )
    {
        add_settings_field( 
            $id,
            __( $title, DHL_SHIPPING_ID_UNDERSCORED ),
            [$this, $callback_name],
            DHL_SHIPPING_ID_UNDERSCORED,
            DHL_SHIPPING_ID_UNDERSCORED . '_' . $section_ending,
            [
                'name'  => $id,
                'class' => $id . '_row'
            ]
        );
    }
}