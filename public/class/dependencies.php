<?php
/**
 *
 */
class publicScripts{

    function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_script' ) );
    }

    public function enqueue_script() {
        add_filter( 'body_class', function( $classes ) {
            if ( in_array( 'page-template-filter-page', $classes ) ) {
                wp_enqueue_style( 'apfa-css', plugin_dir_url( dirname( __FILE__ ) ) . 'asstes/css/bootstrap.min.css' );
                wp_enqueue_script( 'jquery' );
                wp_enqueue_script( 'apfa-bundlejs', plugin_dir_url( dirname( __FILE__ ) ) . 'asstes/js/bootstrap.bundle.min.js', array (), '', true );
                wp_enqueue_script( 'apfa-js', plugin_dir_url( dirname( __FILE__ ) ) . 'asstes/js/bootstrap.min.js', array ( 'jquery', 'apfa-bundlejs' ), '4.5.3', true );
            }
            return $classes;
        });
    }
}
new publicScripts();
