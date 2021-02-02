<?php
/**
 * Class for generating settings page for admin.
 *
 * @since       0.0.1
 * @package     advance-post-filter-ajax
 * @subpackage  advance-post-filter-ajax/admin/class
 */
class APFA_Settings {

    /**
     * Plugin name
     *
     * @since   0.0.1
     * @var     string
     */
    private $plugin_name;

    /**
     * Class constructor
     */
    public function __construct() {

        if( defined( APFA_NAME ) ) {
            $this->plugin_name = APFA_NAME;
        } else {
            $this->plugin_name = "Advance Post Filter - Ajax";
        }
        add_action( 'admin_menu', array( $this, 'apfa_menu' ) ); // Plugin Admin Menu
        add_action( 'admin_init', array( $this, 'setup_fields' ) ); // setting filds
        add_action( 'admin_init', array( $this, 'setup_sections' ) ); // Settings page
    }

    /**
     * Custom options and settings
     */
    public function setup_sections() {
        $sections = array(
            // General settings
            array(
                'uid'   => 'apfa_settings_general',
                'title' => __( 'General', 'advance-post-filter-ajax' ),
            ),
            // Customize
            array(
                'uid'   => 'apfa_settings_customize',
                'title' => __( 'Customize', 'advance-post-filter-ajax' ),
            ),
        );

        // Register a new section in the "apcfa" page.
        if( $sections ) {
            foreach ( $sections as $section ) {
                add_settings_section(
                    $section['uid'], // Slug-name to identify the section
                    $section['title'], // Title
                    array( $this, 'section_callback' ), // callback
                    'apfa' // setting page
                );
            }
        }

    }

    /**
     * Setting Section callback
     * Function that echos out any content at the top of the section
     */
    public function section_callback( $args ) {
        switch ( $args['id'] ) {
            case 'apfa_settings_general':
                // echo '<p>'. $args['title'] .'</p>';
                // Register a new setting for "apcfa" page.
                register_setting( 'apfa', $args['id'] );
                // register_setting( 'apfa', $args['uid'] );
                break;

            case 'apfa_settings_customize':
                // echo '<p>'. $args['title'] .'</p>';
                // Register a new setting for "apcfa" page.
                register_setting( 'apfa', $args['id'] );
                // register_setting( 'apfa', $args['uid'] );
                break;
        }
    }

    /**
     * Setting field Callback
     * Function that fills the field with the desired form inputs
     */
    public function setup_fields(){
        // fields example :https://github.com/rayman813/smashing-custom-fields/blob/master/smashing-fields-approach-1/smashing-fields.php
        $fields = array(
            /* General */
            // Hide uncategorized
            array(
                'uid'         => 'hide_uncat',
                'label'       => __( 'Hide uncategorized', 'advance-post-filter-ajax' ),
                'section'     => 'apfa_settings_general',
                'type'        => 'checkbox',
                'description' => __( 'Remove uncategorized option from filter option.', 'advance-post-filter-ajax' ),
                'options'     => array(
                    '1' => __( 'Hide uncategorized', 'advance-post-filter-ajax' ),
                ),
                'default'     => array(),
            ),
            // Hide empty categories
            array(
                'uid'         => 'hide_empty_cat',
                'label'       => __( 'Hide empty category', 'advance-post-filter-ajax' ),
                'section'     => 'apfa_settings_general',
                'type'        => 'checkbox',
                'description' => __( 'Remove empty category option from filter option.', 'advance-post-filter-ajax' ),
                'options'     => array(
                    '1' => __( 'Hide empty category', 'advance-post-filter-ajax' ),
                ),
                'default'     => array(),
            ),
            // Number of posts(results) to show
            array(
        		'uid'     => 'numbers_of_post',
        		'label'   => __( 'Number of result posts', 'advance-post-filter-ajax' ),
                'default'   => 6,
                'placeholder' => 6,
        		'section' => 'apfa_settings_general',
        		'type'    => 'number',
                'description' => __( 'Number of found post for filter result to show.', 'advance-post-filter-ajax' ),
        	),
            // Load more
            array(
                'uid'         => 'load_more',
        		'label'       => __( 'Load More', 'advance-post-filter-ajax' ),
        		'section'     => 'apfa_settings_general',
        		'type'        => 'select',
        		'options'     => array(
        			'button' => __( 'Button', 'advance-post-filter-ajax' ),
        			'scroll' => __( 'Scroll', 'advance-post-filter-ajax' ),
        		),
                'description' => __( 'Load more results on either button click or on scroll.', 'advance-post-filter-ajax' ),
                'default' => array()
            ),
            // Load more button text
            array(
        		'uid' => 'button_text',
        		'label' => __( 'Load more button text', 'advance-post-filter-ajax' ),
        		'section' => 'apfa_settings_general',
        		'type' => 'text',
        		'placeholder' => __( 'Load More', 'advance-post-filter-ajax' ),
                'default'   => __( 'Load More', 'advance-post-filter-ajax' ),
        		'description' => __( 'Text to desplay for the load more button.<br> Empty for default (Load More).', 'advance-post-filter-ajax' ),
        	),
            // Give plugin credit
            array(
                'uid'         => 'show_credit',
                'label'       => __( 'Give plugin a credit', 'advance-post-filter-ajax' ),
                'section'     => 'apfa_settings_general',
                'type'        => 'checkbox',
                'description' => __( 'A small support. Show plugin name and link to plugin author below the filter page.', 'advance-post-filter-ajax' ),
                'options'     => array(
                    '1' => __( 'Show plugin name on filter page.', 'advance-post-filter-ajax' ),
                ),
                'default'     => array(),
            ),
            /* customize */
            // additional css
            array(
        		'uid' => 'add_css',
        		'label' => __( 'Additional CSS', 'advance-post-filter-ajax' ),
        		'section' => 'apfa_settings_customize',
        		'type' => 'textarea',
                'default' => '',
                'placeholder' => '',
                'description' => '',
        	),
            // additional JavaScript
            array(
        		'uid' => 'add_js',
        		'label' => __( 'Additional JavaScript', 'advance-post-filter-ajax' ),
        		'section' => 'apfa_settings_customize',
        		'type' => 'textarea',
                'default' => '',
                'placeholder' => '',
                'description' => '',
        	),
        );

        if( $fields ) {
            foreach ( $fields as $field ) {
                // Add a new field to a section of a settings page.
                add_settings_field(
                    $field['uid'], // ID
                    $field['label'], // Title
                    array( $this, 'field_callback' ), // Callback
                    'apfa', // Page
                    $field['section'], // Section
                    $field,
                );
                // Registers a setting and its data.
                register_setting(
                    'apfa', // Option grounp
                    $field['uid'], // Option name
                );
            }
        }
    }

    /**
     *  Function that fills the field with the desired form inputs.
     */
    public function field_callback( $args ) {

        $value = get_option( $args['uid'] ); // Get the current value
        if( ! $value ) { // If no value exists
            $value = $args['default']; // Set to default
        }

        // Check the field type
        switch( $args['type'] ) {

            case 'text':
            case 'password':
            case 'number':
                printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $args['uid'], $args['type'], $args['placeholder'], $value );
                break;

            case 'radio':
            case 'checkbox':
                if( ! empty ( $args['options'] ) && is_array( $args['options'] ) ) {
                    $options_markup = '';
                    $iterator = 0;
                    
                    foreach ( $args['options'] as $key => $label ) {
                        $iterator++;
                        $checked = ' '; // checked
                        if ( !empty( $value ) && $value[0] == $key ) {
                            $checked = ' checked="checked" ';
                        }
                        $options_markup .= sprintf( '<label for="%1$s_%6$s">
                            <input
                            id="%1$s_%6$s"
                            name="%1$s[]"
                            type="%2$s"
                            value="%3$s"
                            %4$s /> %5$s</label></br>',
                            $args['uid'], $args['type'],
                            $key,
                            $checked,
                            $label,
                            $iterator
                        );
                        printf( '<fieldset>%s</fieldset>', $options_markup );
                    }
                break;
            }

            case 'select':
            case 'multiselect':
            if( ! empty ( $args['options'] ) && is_array( $args['options'] ) ){
                    $attributes = '';
                    $options_markup = '';
                    foreach( $args['options'] as $key => $label ){
                        $options_markup .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $value[ array_search( $key, $value, true ) ], $key, false ), $label );
                    }
                    if( $args['type'] === 'multiselect' ){
                        $attributes = ' multiple="multiple" ';
                    }
                    printf( '<select name="%1$s[]" id="%1$s" %2$s>%3$s</select>', $args['uid'], $attributes, $options_markup );
                }
                break;

            case 'textarea':
            printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>', $args['uid'], $args['placeholder'], $value );
            break;
        }
        // If there is help text
        if( isset($args['helper']) && $helper = $args['helper'] ){
            printf( '<span class="helper"> %s</span>', $helper ); // Show it
        }

        // If there is supplemental text
        if( $description = $args['description'] ){
            printf( '<p class="description">%s</p>', $description ); // Show it
        }
    }
    /**
     * Add menu page
     */
    public function apfa_menu() {
        add_menu_page(
            $this->plugin_name,
            'APCFA',
            'manage_options',
            'apfa',
            array( $this,'settings_html' ),
            'dashicons-filter'
        );
    }

    /**
     * Setting page view
     */
    public function settings_html() {
        // Check user capabilities
        if( !current_user_can( 'manage_options' ) ) {
            return;
        }
        // view
        if ( is_file( plugin_dir_path( dirname( __FILE__ ) ) . 'views/settings.php' ) ) {
            include_once plugin_dir_path( dirname( __FILE__ ) ) . 'views/settings.php';
        }
    }

    public function admin_notice() {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Your settings have been updated!', 'advance-post-filter-ajax' ); ?></p>
        </div>
        <?php
    }
}
