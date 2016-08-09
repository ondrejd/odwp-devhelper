<?php
/**
 * @package odwp-devhelper
 */

if ( ! class_exists( 'Screen_Table_Wizard' ) ):

/**
 * @since 0.0.1
 */
class Screen_Table_Wizard extends DevHelper_Screen_Prototype {
	/**
	 * @var string
	 */
	const SLUG = 'table_wizard';

	/**
	 * @param WP_Screen $screen Optional.
	 * @since 0.0.1
	 */
	public function __construct( WP_Screen $screen = null ) {
		parent::__construct( $screen );
		// ...
	}

	/**
	 * Hook for `admin_init` action (called from {@see DevHelper::admin_init()}).
	 * @since 0.0.1
	 */
	public function admin_init() {
		// ...
	}

	/**
	 * @since 0.0.1
	 * @uses plugins_url()
	 * @uses wp_register_script()
	 * @uses wp_enqueue_script()
	 */
	public function admin_enqueue_scripts() {
		$screen = $this->get_screen();

		if ( $screen->base != $this->hookname) {
			return;
		}

		$script_slug = 'table_wizard';
		$script_url = plugins_url( 'js/screen-table_wizard.js', dirname( __FILE__ ) );

		wp_register_script( $script_slug, $script_url, array( 'jquery' ), false, true );
		wp_enqueue_script( $script_slug );
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
	 * @uses add_action()
	 */
	public function admin_menu() {
		$this->hookname = add_submenu_page(
			'edit.php?post_type=wizard',
			__( 'Table list wizard', DevHelper::SLUG ),
			__( 'New table', DevHelper::SLUG ),
			'manage_options',
			self::SLUG,
			array( $this, 'render' )
		);

		add_action( 'load-' . $this->hookname, array( $this, 'screen_load' ) );
	}

	/**
	 * @since 0.0.1
	 * @uses plugin_dir_path()
	 */
	public function render() {
		$plugin_dir = plugin_dir_path( dirname( __FILE__ ) );

		extract( $this->get_screen_options( self::SLUG ) );

		require_once $plugin_dir . 'partials/screen-table_wizard.phtml';
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

		$screen->add_option( self::SLUG . '-display_description', NULL );
		$screen->add_option( self::SLUG . '-used_template', NULL );
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