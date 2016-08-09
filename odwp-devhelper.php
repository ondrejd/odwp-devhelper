<?php
/**
 * Plugin Name: odwp-devhelper
 * Plugin URI: https://bitbucket.org/ondrejd/odwp-devhelper
 * Description: Helper plugin for developers of WordPress plugins.
 * Version: 0.0.1
 * Author: Ondřej Doněk
 * Author URI: http://ondrejdonek.blogspot.cz/
 * Requires at least: 4.3
 * Tested up to: 4.5
 *
 * Text Domain: odwp-devhelper
 * Domain Path: /languages/
 *
 * @author Ondrej Donek, <ondrejd@gmail.com>
 * @link https://bitbucket.org/ondrejd/odwp-devhelper for the canonical source repository
 * @license https://www.mozilla.org/MPL/2.0/ Mozilla Public License 2.0
 * @package odwp-devhelper
 */

if ( ! class_exists( 'DevHelper' ) ):

/**
 * Main class of the plugin.
 * @since 0.0.1
 * @todo Add options page.
 */
class DevHelper {
	const SLUG = 'odwp-devhelper';
	const VERSION = '0.0.1';

	/**
	 * Screens added.
	 * @since 0.0.1
	 * @var array
	 */
	public static $screens;

	/**
	 * Default options of the plugin.
	 * @since 0.0.1
	 * @var array
	 */
	private static $default_options = array();

	/**
	 * Set up hooks.
	 * @since 0.0.1
	 * @uses add_action()
	 * @uses is_admin()
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );

		if ( is_admin() ) {
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			//add_action( 'admin_init', array( $this, 'save_screen_options' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
			add_action( 'admin_head', array( $this, 'admin_head' ) );
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		}
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - {@see Screen_Tables}. Defines {@see WP_Screen} for page "Admin Tables".
	 * - {@see Screen_Toc}. Defines {@see WP_Screen} for main plugin's page.
	 *
	 * @access private
	 * @since 0.0.1
	 */
	private function load_dependencies() {
		$plugin_dir = plugin_dir_path( __FILE__ );
		$main_files = array(
			$plugin_dir . 'includes/class-devhelper_screen_prototype.php',
			$plugin_dir . 'includes/class-wizard_post_type.php',
			$plugin_dir . 'includes/class-screen_plugin_wizard.php',
			$plugin_dir . 'includes/class-screen_theme_wizard.php',
			$plugin_dir . 'includes/class-screen_table_wizard.php',
		);

		foreach ( $main_files as $file ) {
			if ( file_exists( $file ) && is_readable( $file ) ) {
				require_once $file;
			}
		}
	}

	/**
	 * Initialize plugin.
	 * @since 0.0.1
	 * @uses load_plugin_textdomain()
	 */
	public function init() {
		// Load locales
		load_plugin_textdomain( self::SLUG, false, self::SLUG . '/languages' );
		// Load dependencies
		$this->load_dependencies();
		// Ensure that options are initialized
		self::get_options();
		// Define screens
		//if ( is_admin() ) {
		self::$screens[Screen_Plugin_Wizard::SLUG] = new Screen_Plugin_Wizard();
		self::$screens[Screen_Theme_Wizard::SLUG] = new Screen_Theme_Wizard();
		self::$screens[Screen_Table_Wizard::SLUG] = new Screen_Table_Wizard();
		//}
	}

	/**
	 * @internal Initialize administration.
	 * @since 0.0.1
	 */
	public function admin_init() {
		foreach ( self::$screens as $screen_slug => $screen ) {
			if ( method_exists( $screen, 'admin_init' ) ) {
				$screen->admin_init();
			}

			if ( method_exists( $screen, 'save_screen_options' ) ) {
				$screen->save_screen_options();
			}
		}
	}

	/**
	 * @since 0.0.1
	 */
	public function admin_enqueue_scripts() {
		wp_enqueue_style( 'odwpdh-admin-style', plugins_url( 'css/admin.css', __FILE__ ), false );
		wp_enqueue_style( 'odwpdh-prism-style', plugins_url( 'css/prism.css', __FILE__ ), false );
		wp_enqueue_script( 'odwpdh-prism-js', plugins_url( 'js/prism.js', __FILE__ ), false );

		foreach ( self::$screens as $screen_slug => $screen ) {
			if ( method_exists( $screen, 'admin_enqueue_scripts' ) ) {
				$screen->admin_enqueue_scripts();
			}
		}
	}

	/**
	 * @since 0.0.1
	 */
	public function admin_head() {
		foreach ( self::$screens as $screen_slug => $screen ) {
			if ( method_exists( $screen, 'admin_head' ) ) {
				$screen->admin_head();
			}
		}
	}

	/**
	 * @since 0.0.1
	 */
	public function admin_menu() {
		foreach ( self::$screens as $screen_slug => $screen ) {
			if ( method_exists( $screen, 'admin_menu' ) ) {
				$screen->admin_menu( );
			}
		}
	}

	/**
	 * Returns plugin's options
	 * @return array
	 * @since 0.0.1
	 * @uses get_option()
	 * @uses update_option()
	 */
	public static function get_options() {
		$options = get_option( self::SLUG . '-options' );
		$need_update = false;

		if ( !is_array( $options) ) {
			$need_update = true;
			$options = array();
		}

		foreach ( self::$default_options as $key => $value ) {
			if ( !array_key_exists( $key, $options ) ) {
				$options[$key] = $value;
				$need_update = true;
			}
		}

		if ( !array_key_exists( 'latest_used_version', $options ) ) {
			$options['latest_used_version'] = self::VERSION;
			$need_update = true;
		}

		if ( $need_update === true ) {
			update_option( self::SLUG . '-options', $options );
		}

		return $options;
	} // end get_options()

	/**
	 * Returns value of option with given key. If key doesn't exist
	 * returns empty string or NULL if `$null_if_not_exist` is set on TRUE.
	 * @param string $key
	 * @param boolean $null_if_not_exist Optional. Default TRUE.
	 * @return mixed Returns empty string if option with given key was not found.
	 * @since 0.0.1
	 * @uses get_option()
	 */
	public static function get_option( $key, $null_if_not_exist = false ) {
		$options = get_option( self::SLUG . '-options' );

		if ( array_key_exists( $key, $options ) ) {
			return $options[$key];
		}

		if ( $null_if_not_exist === true ) {
			return NULL;
		}

		return '';
	}
} // End of DevHelper

endif;

/**
 * @var DevHelper $odwp_devhelper
 */
$odwp_devhelper = new DevHelper();
