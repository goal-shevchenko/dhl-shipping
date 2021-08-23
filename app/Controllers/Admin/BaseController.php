<?php

namespace DhlShipping\Controllers\Admin;

/**
 * Base controller for Admin controllers
 * 
 * @since 1.0.0
 */
class BaseController
{
    /**
     * Load file with required view
     * 
     * @since 1.0.0
     * @access protected
     */
    protected static function load_view( $name )
    {
        require_once( plugin_dir_path( __FILE__ ) . '../../../app/Views/Admin/' . $name . '.php' );
    }
}