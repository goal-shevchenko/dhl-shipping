<?php

namespace DhlShipping\Models\ShippingTypes;

/**
 * DHL Local Pickup shipping method
 * 
 * @since   1.0.0
 * @package DhlShipping\Models\ShippingTypes
 */
class DhlLocalPickup extends Base
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
    public static $dhl_id = "dhl_local_pickup";

    /**
     * Title of the shipping type
     * 
     * @since   1.0.0
     * @access  public
     * @var     string
     */
    public static $dhl_title = "DHL local pickup";

    /**
     * Method title of the shipping type
     * 
     * @since   1.0.0
     * @access  public
     * @var     string
     */
    public static $dhl_method_title = "DHL local pickup";

    /**
     * Method dscription of the shipping type
     * 
     * @since   1.0.0
     * @access  public
     * @var     string
     */
    public static $dhl_method_description = "Pickup the parcel in local DHL office";

    /**
     * Cost of the shipping
     * 
     * @since   1.0.0
     * @access  public
     * @var     string
     */
    public static $dhl_cost = "10.50";
}