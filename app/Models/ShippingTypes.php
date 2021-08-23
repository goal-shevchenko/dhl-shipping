<?php

namespace DhlShipping\Models;

use DhlShipping\Models\ShippingTypes\DhlLocalPickup;
use DhlShipping\Models\ShippingTypes\DhlExpressDelivery;

/**
 * Provides DHL shipping types that can be shown on checkout page.
 * To create new shipping type create class in Models/ShippingTypes and place class name to getAllClasses method,
 * and add additional functionality in Front\ShippingMethods.
 * 
 * @since   1.0.0
 * @package DhlShipping\Models
 */
class ShippingTypes
{   
    /**
     * Return each shipping types class
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
     * Return each shipping typess details
     * 
     * @since   1.0.0
     * @access  public
     * @return  array
     */
    public static function getAll()
    {
        $result = [];

        foreach ( self::getAllClasses() as $class ) {
            $result[] = $class::getInfo();    
        }

        return $result;
    }
}