<?php

namespace DhlShipping\Models;

/**
 * Plugin settings that retrieved by get_option
 * 
 * @since   1.0.0
 * @package DhlShipping\Models
 */
class Settings
{   
    /**
     * Plugin options
     * 
     * @
     */
    // protected $plugin_options;

    /**
     * Get plugin main options
     * 
     * @since   1.0.0
     * @access  public
     * @return  array
     */
    public static function get()
    {
        return get_option( DHL_SHIPPING_ID_UNDERSCORED . '_options', [] );
    }
}