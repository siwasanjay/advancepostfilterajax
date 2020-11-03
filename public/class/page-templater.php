<?php
/**
 * Creates page template for filter.
 *
 * This template can be overwritten by copying into.
 * @since       0.0.1
 * @package     advance-post-filter-ajax
 * @subpackage  advance-post-filter-ajax/public
 */

class APFA_Page_templater {

    /**
     * A reference to an instance of this class.
     */
    private static $instance;

    /**
     * Returns an instance of this class.
     * @since       0.0.1
     * @return      self
     */
    public static function get_instance() {
    	if( null == self::$instance ) {
    		self::$instance = new APFA_Page_templater();
    	}

    	return self::$instance;
    }

    /**
     * constructor
     */
    function __construct() {
        $this->templates = array();

        // Add a filter to the attributes metabox to inject the template into the cache.
        if( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {
            // version 4.6 or older
            add_filter(
                'page_attributes_dropdown_pages_args',
                array( $this, 'register_apfa_templates' )
            );
        } else {
            // Add filter to wordpress 4.7 and greater version.
            add_filter(
                'theme_page_templates',
                array( $this, 'add_new_template' )
            );
        }

        // Save post to inject out the template to page cache.
        add_filter( 'wp_insert_post_data', array( $this, 'register_apfa_templates' ) );

        // Determine if the page has our template assigned and return it's path.
        add_filter( 'template_include', array( $this, 'view_apfa_template' ) );

        // Add template to this array.
        $this->templates = array(
            'filter-page.php' => 'APFA Filter',
        );
    }

    /**
	 * Adds our template to the page dropdown for v4.7+
	 *
     * @since       0.0.1
     * @param       $posts_templates
     * @return      $posts_templates
	 */
	public function add_new_template( $posts_templates ) {
		$posts_templates = array_merge( $posts_templates, $this->templates );
		return $posts_templates;
	}

    /**
     * Manipulate WordPress’s cache, inserting the relevant data about our page
     * templates at the right places.
     *
     * @since       0.0.1
     * @param       $atts
     * @return      $atts
     */
    public function register_apfa_templates( $atts ) {
        // Create the key used for the themes cache.
        // Using the md5() function simply creates a unique string identifier to avoid any conflicts.
        $cache_key = 'page-templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

        // Retrive the cache list.
        // If doesnot exists or it's empty prepare an array.
        $templates = wp_get_theme()->get_page_templates();
        if( empty( $templates ) ) {
            $templates = array();
        }

        // New cache, so delete the old one.
        wp_cache_delete( $cache_key, 'theme' );

        // Adding our template to the list of templates by merging our
        // templates to the existing templates arrya from the cache.
        $templates = array_merge( $templates, $this->templates );

        // Add the modified cache to allow WordPress to pick it up for listing
	    // available templates.
        wp_cache_add( $cache_key, $templates, 'theme', 1800 );

        return $atts;
    }

    /**
     * Checks if the template is assigned to the page.
     * Tell WordPress where the real page template file is.
     *
     * @since       0.0.1
     * @param       $template
     * @return      $template
     */
    public function view_apfa_template( $template ) {
        // Get global post.
        global $post;
        // Return template if the post is empty.
        if( ! $post ) {
            return $template;
        }

        // Return default template if we do not have a custom template.
        if( ! isset( $this->templates[get_post_meta(
            $post->ID, '_wp_page_template', true )] ) ) {
            return $template;
        }

        // Just changing the page template path.
        // WordPress will now look for page templates in the subfolder 'templates',
        // instead of the root
        $file = plugin_dir_path( dirname( __FILE__ ) ) . 'views/' . get_post_meta(
        	$post->ID, '_wp_page_template', true
        );

        // If file exists
        if( file_exists( $file ) ) {
            return $file;
        } else {
            echo $file;
        }

        // Return template.
        return $template;
    }

}
add_action( 'plugin_loaded', array( 'APFA_Page_templater', 'get_instance' ) );
