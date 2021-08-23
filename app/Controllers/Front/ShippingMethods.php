<?php

namespace DhlShipping\Controllers\Front;

use Exception;
use DhlShipping\Models\ShippingTypes\DhlLocalPickup;
use DhlShipping\ThirdApi\DHL\LocationFinder;

/**
 * Process requests related to shipping options on front part
 * Note: in future code should be splitted on different controllers by each shipping method
 *
 * @since      1.0.0
 * @package    DhlShipping\Controllers\Front
 */
class ShippingMethods
{
	/**
	 * Add actions and change layout depending from shipping method
	 * 
	 * @param   WC_Shipping_Rate $method
	 * @since   1.0.0
	 * @access  public
	 */
	public function cartShippingMethodsLayoutChange( $method )
	{
        $selected_method = current( WC()->session->get( 'chosen_shipping_methods' ) ?? [] );

        if ( $selected_method == $method->id && DhlLocalPickup::$dhl_id == $method->method_id ) {
            $this->showDhlLocalPickupDestinations();
        }
	}

    /**
     * Disable checkout button on cart page
     *
     * @since   1.0.0
	 * @access  public
     */
    public function removeCheckoutButtonIfShippingNotAvailable()
    {
        $selected_method = current( WC()->session->get( 'chosen_shipping_methods' ) ?? [] );
        $method_id = current( explode( ':', $selected_method ) );

        if ( DhlLocalPickup::$dhl_id == $method_id ) {
            $this->removeCheckoutButtonByDhlLocalPickup();
        }
    }

    /**
     * Disable Place order button on checkout page
     *
     * @param   string  $button
     * 
     * @since   1.0.0
	 * @access  public
     */
    public function disablePlaceOrderButtonIfShippingNotAvailable ( $button )
    {
        $selected_method = current( WC()->session->get( 'chosen_shipping_methods' ) ?? [] );
        $method_id = current( explode( ':', $selected_method ) );

        if ( DhlLocalPickup::$dhl_id == $method_id ) {
            $button = $this->disablePlaceOrderButtonByDhlLocalPickup( $button );
        }

        echo $button;
    }

    /**
     * Validate shipping fields on checkout page before place order
     *
     * @param	array	    $fields
	 * @param	WP_Error    $errors
	 * 
	 * @since 	1.0.0
	 * @access 	public
     */
    public function checkoutValidation( $fields, $errors )
    {
        $selected_method = current( $fields['shipping_method'] ?? [] );
        $method_id = current( explode( ':', $selected_method ) );

        if ( DhlLocalPickup::$dhl_id == $method_id ) {
            $this->checkoutValidateDhlLocalPickup( $fields, $errors );
        }
    }

    /**
     * Validate Dhl Local Pickup fields
     *
     * @param	array	    $fields
	 * @param	WP_Error    $errors
	 * 
	 * @since 	1.0.0
	 * @access 	public
     */
    public function checkoutValidateDhlLocalPickup( $fields, $errors )
    {
        $dhl_shipping_session = WC()->session->get( 'dhl_shipping' );

        if ( empty( $dhl_shipping_session['destination_shipping_offices']->locations ) ) {
            $error = 'Currend shipping method not available. Please choose another.';

        } else if ( empty( $_POST['dhl_pickup_destination_id'] ) ) {
            $error = 'Please choose DHL local office where you would like to pickup the parcel.';

        } else {
            foreach ( $dhl_shipping_session['destination_shipping_offices']->locations as $location ) {
                $found = false;
                $location_id = $this->getLocationId( $location );

                if ( $location_id == $_POST['dhl_pickup_destination_id'] ) {
                    $found = true;
                    break;
                }

                if ( !$found )
                    $error = 'Please choose another DHL local office where you would like to pickup the parcel.';
            }
        }

        if ( !empty( $error ) )
            $errors->add( 'validation', __( $error, DHL_SHIPPING_ID_UNDERSCORED) );
    }

    /**
     * Add DHL shipping methods to product meta
     *
     * @param	int     $order_id
	 * 
	 * @since 	1.0.0
	 * @access 	public
     */
    public function updateOrderMetaOnCheckout( $order_id )
	{
        if ( !empty( $_POST['dhl_pickup_destination_id'] ) ) {
            $pickup_destination_id = sanitize_text_field( $_POST['dhl_pickup_destination_id'] );

			update_post_meta( $order_id, 'dhl_pickup_destination_id', $pickup_destination_id );
            
            $locations = WC()->session->get( 'dhl_shipping' )['destination_shipping_offices']->locations ?? '';

            foreach ( $locations as $location ) {
                $location_id = $this->getLocationId( $location );

                if ( $location_id == $pickup_destination_id ) {
                    update_post_meta( $order_id, 'dhl_pickup_destination_name', $this->getLocationName( $location ) );
                    break;
                }
            }
		}
	}

    /**
     * Disable checkout button on cart page if there's no locations for local pickup
     * 
     * @param   string  $button
     * 
     * @since   1.0.0
	 * @access  protected
     */
    protected function disablePlaceOrderButtonByDhlLocalPickup( $button )
    {
        $dhl_shipping_session = WC()->session->get( 'dhl_shipping' );

        if ( empty( $dhl_shipping_session['destination_shipping_offices']->locations ) ) {
            $tooltip = __( 'Delivery type not available. Please choose another', DHL_SHIPPING_ID_UNDERSCORED );
            $str_replace_with = '<button disabled title="' . $tooltip . '" ';
            $button = str_replace( '<button ', $str_replace_with, $button );
        }

        return $button;
    }

    /**
     * Remove checkout button on cart page if there's no locations for local pickup
     * 
     * @since   1.0.0
	 * @access  protected
     */
    protected function removeCheckoutButtonByDhlLocalPickup()
    {
        $dhl_shipping_session = WC()->session->get( 'dhl_shipping' );

        if ( empty( $dhl_shipping_session['destination_shipping_offices']->locations ) )
            remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
    }
    /**
     * Get closest DHL pickup destinations according to user location
     * 
     * @since   1.0.0
     * @access  protected
     */
    protected function showDhlLocalPickupDestinations()
    {
        $address_session = WC()->session->get( 'customer' );
        $dhl_shipping_session = WC()->session->get( 'dhl_shipping' );

        // caching of offices for not to make not required API call each time
        if ( $this->pickupDestinationsShippingAddressChanged() ) {
            try {
                $dhl_shipping_offices = LocationFinder::findByAddress( $address_session, 1500 );

                $dhl_shipping_session['last_delivery_address'] = $this->customerDeliveryAddress();
                $dhl_shipping_session['destination_shipping_offices'] = $dhl_shipping_offices;

                WC()->session->set( 'dhl_shipping', $dhl_shipping_session );

            } catch ( Exception $e ) {
                // later exception can be logged to show the errors in admin-panel
                $dhl_shipping_offices = (object) [ 'locations' => [] ];
            }

        } else {
            $dhl_shipping_offices = $dhl_shipping_session['destination_shipping_offices'];
        }

        $destinations_formatted = $this->formatDhlPickupDestinationsHtml( $dhl_shipping_offices->locations );

        echo $destinations_formatted;
    }

    /**
     * Get html for finded DHL pickup destinations by current address
     * 
     * @param   stdObject $locations
     * @return  string $html
     * 
     * @since   1.0.0
     * @access  protected
     */
    protected function formatDhlPickupDestinationsHtml( $locations )
    {
        $html = '<div class="dhl-pickup-destinations">';

        if ( !empty( $locations ) ) {
            foreach ( $locations as $location ) {
                $address_obj = $location->place->address;

                $location_id = $this->getLocationId( $location );
                $location_address = $this->getLocationName( $location );

                $html .= '
                    <div>
                        <input type="radio" name="dhl_pickup_destination_id" id="dhl_pickup_destination_"' . $location_id . '" value="' . $location_id . '" required />
                        <label for="dhl_pickup_destination_"' . $location_id . '" >' . $location_address . '</label>
                    </div>';
            }

        } else {
            $html .= '<p>' . __( 'No pickup destinations found', DHL_SHIPPING_ID_UNDERSCORED ) . '</p>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Return location id of location retrieved from DHL API response
     * 
     * @param   stdObject   $location
     * 
     * @since   1.0.0
     * @access  protected 
     */
    protected function getLocationId( $location )
    {
        return current( $location->location->ids )->locationId;
    }

    /**
     * Return location id of location retrieved from DHL API response
     * 
     * @param   stdObject   $location
     * 
     * @since   1.0.0
     * @access  protected 
     */
    protected function getLocationName( $location )
    {
        return ( 
            $location->place->address->streetAddress 
            . ', ' . $location->place->address->postalCode 
            . ', ' . $location->place->address->addressLocality
        );
    }

    /**
     * Determine if the shipping address changed since last time we got shipping destinations from API
     * 
     * @return  bool
     * 
     * @since   1.0.0
     * @access  protected
     */
    protected function pickupDestinationsShippingAddressChanged()
    {
        $dhl_shipping_session = WC()->session->get( 'dhl_shipping', [ 'last_delivery_address' ] );
        $current_delivery_address = $this->customerDeliveryAddress();
                                    
        return $dhl_shipping_session['last_delivery_address'] != $current_delivery_address;
    }

    /**
     * Generate customer delivery address from session
     * 
     * @return  string
     * 
     * @since   1.0.0
     * @access  protected
     */
    protected function customerDeliveryAddress()
    {
        $address_session = WC()->session->get( 'customer' );

        $address = $address_session['shipping_country'] . ' ' 
                    . $address_session['shipping_city'] . ' '
                    . $address_session['shipping_postcode'] . ' '
                    . $address_session['shipping_address'];

        return $address;
    }
}
