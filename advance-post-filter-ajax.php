<?php
/**
*
* @since             0.0.1
* @package           plugin-practice
*
* @wordpress-plugin
* Plugin Name: 	  	 Advance Post Filter - Ajax
* Description:       Filters the post with category and tag. Light and fast Ajax filter.
* Version:           0.0.1
* Requires at least: 5.2
* Requires PHP:      7.2
* Author:            WP Playground
* License:           GPL v2 or later
* License URI:       https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain:       advance-post-filter-ajax
* Domain Path:       /languages
*/

// If file is called directly.
if( !defined( 'WPINC' ) ) {
	die();
}

// Current Plugin Version
define( 'APFA_VERSION', '0.0.1' );

// Plugin Name
define( 'APFA_NAME', 'Advance Post Filter - Ajax' );

/**
 * Plugin core class.
 */
require plugin_dir_path( __FILE__ ) . 'includes/advance-post-filter-ajax.php';

/**
 * Run the plugin.
 */
function advance_post_filter_ajax() {
	new APFA();
}

advance_post_filter_ajax();
