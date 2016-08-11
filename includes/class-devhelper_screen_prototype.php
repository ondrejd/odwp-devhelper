<?php
/**
 * @package odwp-devhelper
 */

if ( ! class_exists( 'DevHelper_Screen_Prototype' ) ):

/**
 * @since 0.0.1
 */
class DevHelper_Screen_Prototype {
	/**
	 * @since 0.1.0
	 * @var string $slug
	 */
	protected $slug;

	/**
	 * @since 0.0.1
	 * @var string $page_title
	 */
	protected $page_title;

	/**
	 * @since 0.0.1
	 * @var string $menu_title
	 */
	protected $menu_title;

	/**
	 * @since 0.1.0
	 * @var array
	 */
	protected $help_tabs = array();

	/**
	 * @since 0.1.0
	 * @var array
	 */
	protected $help_sidebars = array();

	/**
	 * @internal
	 * @since 0.0.1
	 * @var string $hookname Name of the admin menu page hook.
	 */
	protected $hookname;

	/**
	 * @access private
	 * @since 0.0.1
	 * @var WP_Screen $screen
	 */
	private $screen;

	/**
	 * @param WP_Screen $screen Optional.
	 * @since 0.0.1
	 */
	public function __construct( WP_Screen $screen = null ) {
		$this->screen = $screen;
	}

	/**
	 * @since 0.1.0
	 * @return string
	 */
	public function get_slug() {
		return $this->slug;
	}

	/**
	 * @since 0.0.1
	 * @return string
	 */
	public function get_page_title() {
		return $this->page_title;
	}

	/**
	 * @since 0.0.1
	 * @return string
	 */
	public function get_menu_title() {
		return $this->menu_title;
	}

	/**
	 * @since 0.0.1
	 * @return WP_Screen
	 * @uses get_current_screen()
	 */
	public function get_screen() {
		if ( ! ( $this->screen instanceof WP_Screen ) ) {
			$this->screen = get_current_screen();
		}

		return $this->screen;
	}

	/**
	 * Returns current screen options.
	 * @return array
	 * @since 0.0.1
	 * @since 0.1.0 Access changed from `protected` to `public`.
	 * @uses get_current_user_id()
	 * @uses get_user_meta()
	 * @uses WP_Screen::get_option()
	 */
	public function get_screen_options() {
		$screen = $this->get_screen();
		$user = get_current_user_id();

		$display_description = get_user_meta( $user, $this->slug . '-display_description', true );
		if ( strlen( $display_description ) == 0 ) {
			$display_description = $screen->get_option( $this->slug . '-display_description', 'default' );
		}

		$used_template = get_user_meta( $user, $this->slug . '-used_template', true );
		if ( strlen( $used_template ) == 0 ) {
		    $used_template = $screen->get_option( $this->slug . '-used_template', 'default' );
		}

		return array(
			'display_description' => (bool) $display_description,
			'used_template' => $used_template,
		);

		return $options;
	}

	/**
	 * @internal
	 * @param string $key
	 * @param mixed $value
	 * @since 0.0.1
	 * @uses update_option()
	 */
	protected function update_option( $key, $value ) {
		$options = DevHelper::get_options();
		$need_update = false;

		if ( ! array_key_exists( $key, $options ) ) {
			$need_update = true;
		}

		if ( ! $need_update && $options[$key] != $value ) {
			$need_update = true;
		}

		if ( $need_update === true ) {
			$options[$key] = $value;
			update_option( $key, $value );
		}
	}

	/**
	 * Action for `init` hook (see {@see DevHelper::init} for more details).
	 * @since 0.1.0
	 * @uses add_filter()
	 */
	public function init() {
		add_action( 'admin_init', array( $this, 'save_screen_options' ) );
	}

	/**
	 * Action for `admin_init` hook (see {@see DevHelper::admin_init} for more details).
	 * @since 0.0.1
	 */
	public function admin_init() {
		// ...
	}

	/**
	 * Action for `init` hook (see {@see DevHelper::admin_enqueue_scripts} for more details).
	 * @since 0.0.1
	 * @uses plugins_url()
	 * @uses wp_register_script()
	 * @uses wp_enqueue_script()
	 */
	public function admin_enqueue_scripts() {
		// ...
	}

	/**
	 * Action for `admin_head` hook (see {@see DevHelper::admin_head} for more details).
	 * @since 0.0.1
	 */
	public function admin_head() {
		// ...
	}

	/**
	 * Action for `admin_menu` hook (see {@see DevHelper::admin_menu} for more details).
	 * @since 0.0.1
	 * @uses add_submenu_page()
	 * @uses add_action()
	 */
	public function admin_menu() {
		$this->hookname = add_submenu_page(
			'edit.php?post_type=wizard',
			$this->page_title,
			$this->menu_title,
			'manage_options',
			$this->slug,
			array( $this, 'render' )
		);

		add_action( 'load-' . $this->hookname, array( $this, 'screen_load' ) );
	}

	/**
	 * Action for `load-{$hookname}` hook (see {@see DevHelper_Screen_Prototype::admin_menu} for more details).
	 *
	 * Creates screen help and add filter for screen options.
	 *
	 * @since 0.1.0
	 * @uses add_filter()
	 * @uses WP_Screen::add_help_tab()
	 * @uses WP_Screen::set_help_sidebar()
	 * @uses WP_Screen::add_option()
	 */
	public function screen_load() {
		$screen = $this->get_screen();

		// Screen help
		foreach ( $this->help_tabs as $tab ) {
			$screen->add_help_tab( $tab );
		}

		foreach ( $this->help_sidebars as $sidebar ) {
			$screen->set_help_sidebar( $sidebar );
		}

		// Screen options
		add_filter( 'screen_layout_columns', array( $this, 'screen_options' ) );

		$screen->add_option( $this->slug . '-display_description', array(
			'label' => __( 'Display detail descriptions?', DevHelper::SLUG ),
			'default' => 1,
			'option' => $this->slug . '-display_description'
		) );
		$screen->add_option( $this->slug . '-used_template', array(
			'label' => __( 'Used source codes template', DevHelper::SLUG ),
			'default' => 'default',
			'option' => $this->slug . '-used_template'
		) );
	}

	/**
	 * Handler for `screen_layout_columns` filter (see {@see DevHelper_Screen_Prototype::screen_load}).
	 *
	 * Renders screen options form.
	 *
	 * @since 0.1.0
	 * @uses plugin_dir_path()
	 * @uses update_option()
	 */
	public function screen_options() {
		// These are used in the template:
		$slug = $this->slug;
		$screen = $this->get_screen();
		extract( $this->get_screen_options() );

		include_once( DevHelper::plugin_path( 'partials/screen_options-wizard.php' ) );
	}

	/**
	 * Action for `admin_init` hook (see {@see DevHelper_Screen_Prototype::init} for more details).
	 *
	 * Saves screen options.
	 *
	 * @since 0.1.0
	 * @uses get_current_user_id()
	 * @uses wp_verify_nonce()
	 * @uses update_user_meta()
	 */
	public function save_screen_options() {
		$user = get_current_user_id();

		if (
			filter_input( INPUT_POST, $this->slug . '-submit' ) &&
			( bool ) wp_verify_nonce( filter_input( INPUT_POST, $this->slug . '-nonce' ) ) === true
		) {
			$display_description = ( string ) filter_input( INPUT_POST, $this->slug . '-checkbox1' );
			$display_description = ( strtolower( $display_description ) == 'on' ) ? 1 : 0;
			update_user_meta( $user, $this->slug . '-display_description', $display_description );

			$used_template = ( string ) filter_input( INPUT_POST, $this->slug . '-select1' );
			update_user_meta( $user, $this->slug . '-used_template', $used_template );
		}
	}

	/**
	 * Render page self.
	 * @since 0.1.0
	 */
	public function render() {
		// These are used in the template:
		$slug = $this->slug;
		$screen = $this->get_screen();
		extract( $this->get_screen_options() );

		require_once DevHelper::plugin_path( 'partials/screen-' . $this->slug . '.phtml' );
	}
}

endif;
