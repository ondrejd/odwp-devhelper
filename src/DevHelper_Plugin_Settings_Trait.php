<?php
/**
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @link https://github.com/ondrejd/odwp-devhelper for the canonical source repository
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @package odwp-devhelper
 * @since 0.1.0
 */

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( ! trait_exists( 'DevHelper_Plugin_Settings_Trait' ) ) :

/**
 * Trait with settings functionality for {@see DevHelper_Plugin}.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @link https://developer.wordpress.org/plugins/settings/settings-api/
 * @since 0.1.0
 */
trait DevHelper_Plugin_Settings_Trait {

    /**
     * @var string
     * @since 0.1.0
     */
    public static $options_page_hook;

    /**
     * @return array Default values for settings of the plugin.
     * @since 0.1.0
     */
    public static function get_default_options() {
        return array(
            'show_advanced_options' => true,
            'generate_full_plugin' => false,
        );
    }

    /**
     * @return array Settings of the plugin.
     * @since 0.1.0
     */
    public static function get_options() {
        $defaults = self::get_default_options();
        $options = get_option( self::SETTINGS_KEY, array() );
        $update = false;

        // Fill defaults for the options that are not set yet
        foreach( $defaults as $key => $val ) {
            if( ! array_key_exists( $key, $options ) ) {
                $options[$key] = $val;
                $update = true;
            }
        }

        // Updates options if needed
        if( $update === true ) {
            update_option( self::SETTINGS_KEY, $options );
        }

        return $options;
    }

    /**
     * Returns value of option with given key.
     * 
     * @param string $key Option's key.
     * @param mixed $default Option's default value.
     * @return mixed Option's value.
     * @since 0.1.0
     */
    public static function get_option( $key, $default = null ) {
        $options = self::get_options();

        if( array_key_exists( $key, $options ) ) {
            return $options[$key];
        }

        return $default;
    }

    /**
     * Register plugin settings.
     * 
     * @return void
     * @since 0.1.0
     * @uses get_option()
     * @uses register_setting()
     * @uses shortcode_atts()
     */
    public static function register_settings() {
        $defaults = self::get_default_options();
        $options = get_option( self::SETTINGS_KEY );
        $data = shortcode_atts( $defaults, $options );

        register_setting( DH_SLUG, self::SETTINGS_KEY, [__CLASS__, 'validate_settings'] );

        self::init_settings(/* $data */);
    }

    /**
     * Initialize plugin settings.
     * 
     * @return void
     * @since 0.1.0
     * @uses add_settings_field()
     * @uses add_settings_section()
     * @uses esc_attr()
     */
    protected static function init_settings() {
        $section1 = self::SETTINGS_KEY . '_section_1';

        add_settings_section(
                $section1,
                __( 'Wizards options' ),
                [__CLASS__, 'render_settings_section_1'],
                DH_SLUG
        );

        add_settings_field(
            'show_advanced_options',
            __( 'Show advanced options', DH_SLUG ),
            [__CLASS__, 'render_setting_show_advanced_options'],
            DH_SLUG,
            $section1
        );

        add_settings_field(
            'generate_full_plugin',
            __( 'Always generate full plugin', DH_SLUG ),
            [__CLASS__, 'render_setting_generate_full_plugin'],
            DH_SLUG,
            $section1
        );
    }

    /**
     * Validate plugin settings.
     * 
     * @param array $values
     * @return array
     * @since 0.1.0
     * @uses add_settings_field()
     * @uses add_settings_section()
     * @uses esc_attr()
     */
    public static function validate_settings( $values ) {
        $defaults = self::get_default_options();
        $option_page = isset( $_POST['option_page'] ) ? $_POST['option_page'] : '';
        $update = ( isset( $_POST['submit'] ) && $option_page == DH_SLUG );
        $out = array();

        // Compare keys in deault options and given values
        foreach( $defaults as $key => $value ) {

            // Process all options
            switch( $key ) {

                // These are checkboxes...
                case 'show_advanced_options':
                case 'generate_full_plugin':

                    if( empty( $values[$key] ) ) {
                        $out[$key] = $update ? false : $value;
                    } else {
                        $out[$key] = ( 'on' == strtolower( $values[$key] ) );
                    }
                    break;
            }
        }
        
        return $out;
    }

    /**
     * @internal Renders the first settings section.
     * @return void
     * @since 0.1.0
     */
    public static function render_settings_section_1() {
        echo self::load_template( 'setting-section_1' );
    }

    /**
     * @internal Renders setting `show_advanced_options`.
     * @return void
     * @since 0.1.0
     */
    public static function render_setting_show_advanced_options() {
        echo self::load_template( 'setting-show_advanced_options', [
            'show_advanced_options' => self::get_option( 'show_advanced_options' )
        ] );
    }

    /**
     * @internal Renders setting `generate_full_plugin`.
     * @return void
     * @since 0.1.0
     */
    public static function render_setting_generate_full_plugin() {
        echo self::load_template( 'setting-generate_full_plugin', [
            'generate_full_plugin' => self::get_option( 'generate_full_plugin' )
        ] );
    }
    
}

endif;