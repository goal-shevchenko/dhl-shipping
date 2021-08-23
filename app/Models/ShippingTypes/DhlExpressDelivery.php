<?php

namespace DhlShipping\Models\ShippingTypes;

/**
 * DHL Express Delivery shipping method
 * 
 * @since 1.0.0
 * @package DhlShipping\Models\ShippingTypes
 */
class DhlExpressDelivery extends Base
{
    /**
     * Is shipping type enabled
     * 
     * @since   1.0.0
     * @access  public
     * @var     string yes|no
     */
    public static $dhl_enabled = "yes";

    /**
     * Id of the shipping type
     * 
     * @since   1.0.0
     * @access  public
     * @var     string
     */
    public static $dhl_id = "dhl_express_delivery";

    /**
     * Title of the shipping type
     * 
     * @since   1.0.0
     * @access  public
     * @var     string
     */
    public static $dhl_title = "DHL express delivery to door";

    /**
     * Method title of the shipping type
     * 
     * @since   1.0.0
     * @access  public
     * @var     string
     */
    public static $dhl_method_title = "DHL express delivery to door";

    /**
     * Method dscription of the shipping type
     * 
     * @since   1.0.0
     * @access  public
     * @var     string
     */
    public static $dhl_method_description = "Ship the parcel from DHL office right to your door";

    /**
     * Cost of the shipping
     * 
     * @since   1.0.0
     * @access  public
     * @var     string
     */
    public static $dhl_cost = "20.50";
}