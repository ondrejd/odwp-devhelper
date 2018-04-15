<?php
/**
 * Plugin Name: DevHelper
 * Plugin URI: https://github.com/ondrejd/odwp-devhelper
 * Description: Plugin that helps developers of WordPress plugins.
 * Version: 0.1.0
 * Author: Ondřej Doněk
 * Author URI: https://ondrejd.com/
 * License: GPLv3
 * Requires at least: 4.7
 * Tested up to: 4.8.5
 * Tags: custom post type,development,plugins
 * Donate link: https://www.paypal.me/ondrejd
 * Text Domain: odwp-devhelper
 * Domain Path: /languages/
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @link https://github.com/ondrejd/odwp-devhelper for the canonical source repository
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @package odwp-devhelper
 * @since 0.0.1
 */

/**
 * This file is just a bootstrap. It checks if requirements of plugins
 * are met and accordingly either allow activating the plugin or stops
 * the activation process.
 *
 * Requirements can be specified either for PHP interperter or for
 * the WordPress self. In both cases you can specify minimal required
 * version and required extensions/plugins.
 *
 * If you are using copy of original file in your plugin you should change
 * prefix "odwpdh" and name "odwp-devhelper" to your own values.
 *
 * To set the requirements go down to line 200 and define array that
 * is used as a parameter for `odwpdh_check_requirements` function.
 */

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Some constants
defined( 'DH_SLUG' ) || define( 'DH_SLUG', 'odwpdh' );
defined( 'DH_NAME' ) || define( 'DH_NAME', 'odwp-devhelper' );
defined( 'DH_PATH' ) || define( 'DH_PATH', dirname( __FILE__ ) . '/' );
defined( 'DH_FILE' ) || define( 'DH_FILE', __FILE__ );
defined( 'DH_CPT' )  || define( 'DH_CPT', 'odwpdh-wizard' );


if( ! function_exists( 'odwpdh_check_requirements' ) ) :
    /**
     * Checks requirements of our plugin.
     * @global string $wp_version
     * @param array $requirements
     * @return array
     * @since 1.0.0
     */
    function odwpdh_check_requirements( array $requirements ) {
        global $wp_version;

        // Initialize locales
        load_plugin_textdomain( DH_SLUG, false, DH_NAME . '/languages' );

        /**
         * @var array Hold requirement errors
         */
        $errors = [];

        // Check PHP version
        if( ! empty( $requirements['php']['version'] ) ) {
            if( version_compare( phpversion(), $requirements['php']['version'], '<' ) ) {
                $errors[] = sprintf(
                        __( 'Used PHP interpreter doesn\'t meet requirements of this plugin (is required version <b>%1$s</b> at least)!'),
                        $requirements['php']['version']
                );
            }
        }

        // Check PHP extensions
        if( count( $requirements['php']['extensions'] ) > 0 ) {
            foreach( $requirements['php']['extensions'] as $req_ext ) {
                if( ! extension_loaded( $req_ext ) ) {
                    $errors[] = sprintf(
                            __( 'PHP extension <b>%1$s</b> is required but not installed!', DH_SLUG ),
                            $req_ext
                    );
                }
            }
        }

        // Check WP version
        if( ! empty( $requirements['wp']['version'] ) ) {
            if( version_compare( $wp_version, $requirements['wp']['version'], '<' ) ) {
                $errors[] = sprintf(
                        __( 'This plugin requires higher version of <b>WordPress</b> (at least version <b>%1$s</b>)!', DH_SLUG ),
                        $requirements['wp']['version']
                );
            }
        }

        // Check WP plugins
        if( count( $requirements['wp']['plugins'] ) > 0 ) {
            $active_plugins = (array) get_option( 'active_plugins', [] );
            foreach( $requirements['wp']['plugins'] as $req_plugin ) {
                if( ! in_array( $req_plugin, $active_plugins ) ) {
                    $errors[] = sprintf(
                            __( 'The plugin <b>%1$s</b> is required but not installed!', DH_SLUG ),
                            $req_plugin
                    );
                }
            }
        }

        return $errors;
    }
endif;


if( ! function_exists( 'odwpdh_deactivate_raw' ) ) :
    /**
     * Deactivate plugin by the raw way (it updates directly WP options).
     * @return void
     * @since 1.0.0
     */
    function odwpdh_deactivate_raw() {
        $active_plugins = get_option( 'active_plugins' );
        $out = [];
        foreach( $active_plugins as $key => $val ) {
            if( $val != DH_NAME . '/' . DH_NAME . '.php' ) {
                $out[$key] = $val;
            }
        }
        update_option( 'active_plugins', $out );
    }
endif;


if( ! function_exists( 'readonly' ) ) :
    /**
     * Prints HTML readonly attribute. It's an addition to WP original
     * functions {@see disabled()} and {@see checked()}.
     * @param mixed $value
     * @param mixed $current (Optional.) Defaultly TRUE.
     * @return string
     * @since 1.0.0
     */
    function readonly( $current, $value = true ) {
        if( $current == $value ) {
            echo ' readonly';
        }
    }
endif;


/**
 * Errors from the requirements check
 * @var array
 */
$odwpdh_errs = odwpdh_check_requirements( [
    'php' => [
        // Enter minimum PHP version you needs
        'version' => '5.6',
        // Enter extensions that your plugin needs
        'extensions' => [
            //'gd',
        ],
    ],
    'wp' => [
        // Enter minimum WP version you need
        'version' => '4.7',
        // Enter WP plugins that your plugin needs
        'plugins' => [
            //'woocommerce/woocommerce.php',
        ],
    ],
] );

// Check if requirements are met or not
if( count( $odwpdh_errs ) > 0 ) {
    // Requirements are not met
    odwpdh_deactivate_raw();

    // In administration print errors
    if( is_admin() ) {
        add_action( 'admin_notices', function() use ( $odwpdh_errs ) {
            $err_head = __( '<b>Debug Log Viewer</b>: ', DH_SLUG );

            foreach( $odwpdh_errs as $err ) {
                printf( '<div class="error"><p>%1$s</p></div>', $err_head . $err );
            }
        } );
    }
} else {
    // Requirements are met so initialize the plugin.
    include( DH_PATH . 'src/DevHelper_Screen_Prototype.php' );
	include( DH_PATH . 'src/DevHelper_Plugin.php' );
	
    DevHelper_Plugin::initialize();
}
