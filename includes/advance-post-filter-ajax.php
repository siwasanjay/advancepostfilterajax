<?php
/**
 * The file that defines the core plugin class
 *
 * @since 		0.0.1
 * @package 	advance-post-filter-ajax
 * @subpackage 	advance-post-filter-ajax/includes
 */
class APFA {

	/**
	 * Initialize and get class instance
	 *
	 * @since 	0.0.1
	 * @return 	APFA
	 */
	public function __construct() {
		$this->run();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * @since 	0.0.1
	 *
	 */
	public function run() {
		// Admin
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class/settings.php'; // admin settings_errors
		// Ajax filter action.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class/filter.php';
		if( is_admin() ) { // if is admin area
			new APFA_Settings();
		} else {
			// Public
			// load necessary dependencies (assets).
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class/dependencies.php';
			// Creates page template for filter page.
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class/page-templater.php';


		}


	}


}
