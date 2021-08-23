<h1 class="wp-heading-inline"><?= DHL_SHIPPING_TITLE ?> settings</h1>

<?php
    $setting = DHL_SHIPPING_ID_UNDERSCORED . '_messages';
    $code = DHL_SHIPPING_ID_UNDERSCORED . '_message';

    // add error/update messages
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( $setting, $code, __( 'Settings Saved', DHL_SHIPPING_ID_UNDERSCORED ), 'updated' );
    }

    // show error/update messages
    settings_errors( $setting );
?>

<div class="wrap settings">
    <form action="options.php" method="post">
        <?php
            settings_fields( DHL_SHIPPING_ID_UNDERSCORED );
            do_settings_sections( DHL_SHIPPING_ID_UNDERSCORED );
            submit_button( __( 'Save Settings', DHL_SHIPPING_ID_UNDERSCORED ) );
        ?>
    </form>
</div>