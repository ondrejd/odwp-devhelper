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
	 * @since 0.0.1
	 * @return string
	 */
	public function get_page_title() {
		if ( empty( $this->page_title ) ) {
			$this->page_title = __( '', DevHelper::SLUG );
		}

		return $this->page_title;
	}

	/**
	 * @since 0.0.1
	 * @return string
	 */
	public function get_menu_title() {
		if ( empty( $this->menu_title ) ) {
			$this->menu_title = __( '', DevHelper::SLUG );
		}

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
	 * @internal
	 * @param string $slug
	 * @return array
	 * @since 0.0.1
	 */
	protected function get_screen_options( $slug ) {
		$options = array(
			'display_description' => ( bool ) DevHelper::get_option( $slug . '-display_description', true ),
			'used_template' => DevHelper::get_option( $slug . '-used_template', 'default' ),
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
	 * @internal
	 * @param string $slug
	 * @since 0.0.1
	 * @uses plugin_dir_path()
	 * @uses update_option()
	 */
	protected function _screen_options( $slug ) {
		$screen = $this->get_screen();
		$form_prefix = $slug . '_options';

		extract( $this->get_screen_options( $slug ) );

		include_once( plugin_dir_path( dirname( __FILE__ ) ) . 'partials/screen_options-wizard.php' );
	}

	/**
	 * @internal
	 * @param string $slug
	 * @since 0.0.1
	 * @uses wp_verify_nonce
	 */
	protected function _save_screen_options( $slug ) {
		$form_prefix = $slug . '_options';

		if ( 
			filter_input( INPUT_POST, $form_prefix . '-submit' ) &&
			( bool ) wp_verify_nonce( filter_input( INPUT_POST, $form_prefix . '-nonce' ) ) === true
		) {
			$display_description = ( string ) filter_input( INPUT_POST, $form_prefix . '-checkbox1' );
			$display_description = ( strtolower( $display_description ) == 'on' ) ? true : false;
			$this->update_option( $slug . '-display_description', $display_description );

			$used_template = ( string ) filter_input( INPUT_POST, $form_prefix . '-select1' );
			$this->update_option( $slug . '-used_template', $used_template );
		}
	}
}

endif;
