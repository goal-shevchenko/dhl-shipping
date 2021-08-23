<?php

namespace DhlShipping\Models;

use DhlShipping\Models\ShippingTypes\DhlLocalPickup;
use DhlShipping\Models\ShippingTypes\DhlExpressDelivery;

/**
 * Provides DHL shipping types that can be shown on checkout page.
 * To create new shipping type create class in Models/ShippingTypes and place class name to getAllClasses method
 * 
 * @since   1.0.0
 * @package DhlShipping\Models
 */
class ShippingTypes
{   
    /**
     * Return each shipping options details
     * 
     * @since   1.0.0
     * @access  public
     * @return  array
     */
    public static function getAll()
    {
        return [
            DhlLocalPickup::getInfo(),
            DhlExpressDelivery::getInfo()
        ];
    }
    
    /**
     * Return each shipping option class
     * 
     * @since   1.0.0
     * @access  public
     * @return  array
     */
    public static function getAllClasses()
    {
        return [
            DhlLocalPickup::class,
            DhlExpressDelivery::class
        ];
    }

    /**
     * Get enabled_shipping_types options
     * 
     * @return  array
     * @since   1.0.0
     * @access  public
     */
    public static function getOptions()
    {
        $options = get_option( DHL_SHIPPING_ID_UNDERSCORED . '_options', [] );
        return $options['enabled_shipping_types'] ?? [];
    }
}