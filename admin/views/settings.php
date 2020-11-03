<div class="wrap">
    <h1><?php _e( 'Advance Post Category Filter - Ajax', 'advance-post-category-filter-ajax' ); ?></h1>
    <form action="options.php" method="post">
        <?php
        if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) {
            $this->admin_notice();
        }
        // output security fields for the registered setting "wporg"
        settings_fields( 'apfa' );
        // Output seting sections and their fields.
        do_settings_sections( 'apfa' );
        // Output save submit button.
        submit_button( 'Save Settings' );
        ?>
    </form>
</div>
