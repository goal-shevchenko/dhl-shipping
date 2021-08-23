<?php

namespace DhlShipping\Models\ShippingTypes;

use WC_Shipping_Method;

/**
 * Base class for Shipping Types
 * 
 * @since   1.0.0
 * @package DhlShipping\Models\ShippingTypes
 */
class Base extends WC_Shipping_Method
{
    /**
     * Is shipping type enabled
     * 
     * @since   1.0.0
     * @access  public
     * @var     string
     */
    public static $dhl_enabled = "";

    /**
     * Id of the shipping type
     * 
     * @since   1.0.0
     * @access  public
     * @var     string
     */
    public static $dhl_id = "";

    /**
     * Title of the shipping type
     * 
     * @since   1.0.0
     * @access  public
     * @var     string
     */
    public static $dhl_title = "";

    /**
     * Method title of the shipping type
     * 
     * @since   1.0.0
     * @access  public
     * @var     string
     */
    public static $dhl_method_title = "";

    /**
     * Method dscription of the shipping type
     * 
     * @since   1.0.0
     * @access  public
     * @var     string
     */
    public static $dhl_method_description = "";

    /**
     * Cost of the shipping
     * 
     * @since   1.0.0
     * @access  public
     * @var     string
     */
    public static $dhl_cost = "";


    /**
     * @param   int     $instance_id
     * @since   1.0.0
     * @access  public
     */
    public function __construct( $instance_id = 0 )
    {
        parent::__construct( $instance_id );

        $this->id                   = $this::$dhl_id;
        $this->method_description   = __( $this::$dhl_method_description );

        $this->supports              = [
			'shipping-zones',
			'instance-settings', 
        ];

        $this->init();
        
        $this->enabled              = $this->get_option( 'enabled', $this::$dhl_enabled );
		$this->title                = $this->get_option( 'title', $this::$dhl_method_title );
        $this->method_title         = $this->title; 

        add_action( 'woocommerce_update_options_shipping_' . $this->id, [ $this, 'process_admin_options' ] );
    }

    /**
     * Init shipping settings
     *
     * @since   1.0.0
     * @access  public
     */
    public function init()
    {
        $this->init_form_fields();
        $this->init_settings();
    }

    /**
     * Calculate shipping cost
     *
     * @param   array $package
     * @since   1.0.0
     * @access  public
     */
    public function calculate_shipping( $package = array() ) 
    {
        $rate = [
            'label'     => $this->title,
            'cost'      => $this::$dhl_cost,
            'calc_tax'  => 'per_item'
        ];

        $this->add_rate( $rate );
    }

    /**
     * Init settings fields
     * Note: later can be added additional fields like cost, tax type, etc.
     * 
     * @since   1.0.0
     * @access  public
     */
    public function init_form_fields() { 
 
        $this->instance_form_fields = [    
            'title' => [
                'title'         => __( 'Title', DHL_SHIPPING_ID_UNDERSCORED ),
                'type'          => 'text',
                'description'   => __( 'Set title', DHL_SHIPPING_ID_UNDERSCORED ),
                'default'       => __( static::$dhl_method_title, DHL_SHIPPING_ID_UNDERSCORED )
            ]
        ];
    }


    /**
     * Get array of information about shipping type
     * 
     * @return  array with keys [ enabled, id, title, method_title, method_description, cost ] 
     * @since   1.0.0
     * @access  public
     */
    public static function getInfo()
    {
        return [
            'enabled'               => static::$dhl_enabled,
            'id'                    => static::$dhl_id,
            'title'                 => static::$dhl_title,
            'method_title'          => static::$dhl_method_title,
            'method_description'    => static::$dhl_method_description,
            'cost'                  => static::$dhl_cost,
        ];
    }
}