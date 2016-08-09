<?php
/**
 * @package odwp-devhelper
 */

if ( ! class_exists( 'Screen_Theme_Wizard' ) ):

/**
 * @since 0.0.1
 */
class Screen_Theme_Wizard extends DevHelper_Screen_Prototype {
	/**
	 * @var string
	 */
	const SLUG = 'theme_wizard';

	/**
	 * @param WP_Screen $screen Optional.
	 * @since 0.0.1
	 */
	public function __construct( WP_Screen $screen = null ) {
		parent::__construct( $screen );
		// ...
	}

	/**
	 * @since 0.0.1
	 */
	public function admin_init() {
		// ...
	}

	/**
	 * @since 0.0.1
	 */
	public function admin_enqueue_scripts() {
		// ...
	}

	/**
	 * @since 0.0.1
	 */
	public function admin_head() {
		// ...
	}

	/**
	 * @since 0.0.1
	 * @uses add_submenu_page()
	 */
	public function admin_menu() {
		$this->hookname = add_submenu_page(
			'edit.php?post_type=wizard',
			__( 'Theme wizard', DevHelper::SLUG ),
			__( 'New theme', DevHelper::SLUG ),
			'manage_options',
			self::SLUG,
			array( $this, 'render' )
		);
	}

	/**
	 * @since 0.0.1
	 * @uses plugin_dir_path()
	 */
	public function render() {
		$plugin_dir = plugin_dir_path( dirname( __FILE__ ) );

		// These are used in the partial:
		$display_description = ( bool ) DevHelper::get_option( self::SLUG . '-display_description' );
		$used_template = DevHelper::get_option( self::SLUG . '-used_template' );

		require_once $plugin_dir . 'partials/screen-theme_wizard.phtml';
	}

	/**
	 * Create screen help and add filter for screen options.
	 * @since 0.0.1
	 */
	public function screen_load() {
		$screen = $this->get_screen();

		// Screen help
		$screen->add_help_tab(
			array(
				'id'      => 'wpsg_tables_help_tab',
				'title'   => __( 'Tables', DevHelper::SLUG ),
				'content' => __( '<p style"colof: #f30;"><code>XXX</code> Fill this screen help!<p>', DevHelper::SLUG ),
			)
		);
		$screen->set_help_sidebar(
			sprintf(
				__( '<b>Usefull links</b><p><a href="%1$s" target="blank"><code>WP_List_Table</code></a> on <b>WordPress Codex</b>.</p><p><a href="%2$s" target="blank"><code>WP_List_Table</code></a> on <b>WordPress Code Reference</b>.</a></p><!-- <p><a href="%3$s" target="blank">Link 3</a> is the third link.</p> -->', DevHelper::SLUG ),
				'http://codex.wordpress.org/Class_Reference/WP_List_Table',
				'https://developer.wordpress.org/reference/classes/wp_list_table/',
				'#'
			)
		);

		// Screen options
		add_filter( 'screen_layout_columns', array( $this, 'screen_options' ) );

		$screen->add_option( 'display_detail_description', '' );
	}

	/**
	 * Render screen options form.
	 * @since 0.0.1
	 * @uses plugin_dir_path()
	 * @uses update_option()
	 */
	public function screen_options() {
		$this->_screen_options( self::SLUG );
	}

	/**
	 * Save screen options (called from {@see DevHelper::admin_init()}).
	 * @since 0.0.1
	 */
	public function save_screen_options() {
		$this->_save_screen_options( self::SLUG );
	}
}

endif;
