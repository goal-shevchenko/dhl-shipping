<?php

namespace DhlShipping\Models;

/**
 * Provides DHL shipping types that can be shown on checkout page
 * 
 * @since 1.0.0
 */
class ShippingTypes
{
    /**
     * Type of the shipping - local pickup from DHL office
     * 
     * @since 1.0.0
     * @var string
     */
    const TYPE_LOCAL_PICKUP = 'dhl_local_pickup';

    /**
     * Name of local pickup type
     * 
     * @since 1.0.0
     * @var string
     */
    const TYPE_LOCAL_PICKUP_NAME = 'DHL local pickup from office';


    /**
     * Type of the shipping - express delivery to door
     * 
     * @since 1.0.0
     * @var string
     */
    const TYPE_EXPRESS_DELIVERY = 'dhl_express_delivery';

    /**
     * Name of express delivery type
     * 
     * @since 1.0.0
     * @var string
     */
    const TYPE_EXPRESS_DELIVERY_NAME = 'DHL express delivery to door';

    
    /**
     * Return all shipping types in form [id => name]
     * 
     * @since 1.0.0
     * @access public
     * @return array
     */
    public static function get_all()
    {
        return [
            self::TYPE_LOCAL_PICKUP     => self::TYPE_LOCAL_PICKUP_NAME,
            self::TYPE_EXPRESS_DELIVERY => self::TYPE_EXPRESS_DELIVERY_NAME
        ];
    }
}