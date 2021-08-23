<?php

namespace DhlShipping\ThirdApi\DHL;

use Curl\Curl;
use Exception;
use DhlShipping\Models\Settings;

/**
 * DHL Location Finder API
 * * Singleton
 * 
 * @since   1.0.0
 * @package DhlShipping\ThirdApi\DHL
 */
class LocationFinder extends Base
{
    /**
     * DHL api key
     * 
     * @since   1.0.0
     * @access  protected
     * @var     string
     */
    protected $api_key;

    /**
     * DHL api secret
     * 
     * @since   1.0.0
     * @access  protected
     * @var     string
     */
    protected $api_secret;

    /**
     * Instance of current API object
     * 
     * @since   1.0.0
     * @access  protected
     * @var     LocationFinder
     */
    protected static $instance;

    /**
     * Instance of Curl lib
     * 
     * @since   1.0.0
     * @access  protected
     * @var     Curl
     */
    protected $curl;


    /**
     * Define main settings
     * 
     * @since   1.0.0
     * @access  public
     */
    private function __construct()
    {
        $options = Settings::get();

        $this->base_url     = 'https://api.dhl.com/location-finder/v1';
        $this->api_key      = $options['dhl_api_key'];
        $this->api_secret   = $options['dhl_api_secret'];

        $curl = new Curl();
        $curl->setHeader( 'DHL-API-Key', $this->api_key );
        $curl->setHeader( 'contet-type', 'application/json' );

        $this->curl         = $curl;
    }

    /**
     * @since   1.0.0
     * @access  private
     */
    private function __clone() { }

    /**
     * @since   1.0.0
     * @access  private
     */
    private function __wakeup() { }


    /**
     * Get existing instance of the class. If not exists - create it
     * 
     * @since   1.0.0
     * @access  public
     */
    public static function getInstance()
    {
        if ( empty( self::$instance ) )
            self::$instance = new static();
            
        return self::$instance;
    }

    /**
     * Find DHL office locations by address
     * 
     * @param   array   $address    from WC()->session->customer
     * @param   int     $radius     to the farthest location in meters
     * @return  object
     * @throws  Exception
     * 
     * @since   1.0.0
     * @access  public
     */
    public static function findByAddress( $address, $radius = 500 )
    {
        $instance = self::getInstance();
        $url = $instance->base_url . '/find-by-address';
        
        // address array should contain only requred elements. Skipped to economy time
        $instance->curl->get( $url, [
            'countryCode'       => $address['shipping_country'],
            'addressLocality'   => $address['shipping_city'],
            'postalCode'        => $address['shipping_postcode'],
            'streetAddress'     => $address['shipping_address'],
            'radius'            => $radius
        ]);

        if ($instance->curl->error) {
            throw new Exception( $instance->curl->errorMessage, $instance->curl->errorCode );

        } else {
            return $instance->curl->response;
        }
    }
}