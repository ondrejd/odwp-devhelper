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
	 * @param WP_Screen $screen Optional.
	 * @since 0.0.1
	 */
	public function __construct( WP_Screen $screen = null ) {
		$this->slug = 'table_wizard';
		$this->menu_title = __( 'New table', DevHelper::SLUG );
		$this->page_title = __( 'Table list wizard', DevHelper::SLUG );
		$this->help_tabs[] = array(
				'id'      => 'wpsg_tables_help_tab',
				'title'   => __( 'Tables', DevHelper::SLUG ),
				'content' => __( '<p style"colof: #f30;"><code>XXX</code> Fill this screen help!<p>', DevHelper::SLUG ),
		);
		$this->help_sidebars[] = sprintf(
				__( '<b>Usefull links</b><p><a href="%1$s" target="blank"><code>WP_List_Table</code></a> on <b>WordPress Codex</b>.</p><p><a href="%2$s" target="blank"><code>WP_List_Table</code></a> on <b>WordPress Code Reference</b>.</a></p><!-- <p><a href="%3$s" target="blank">Link 3</a> is the third link.</p> -->', DevHelper::SLUG ),
				'http://codex.wordpress.org/Class_Reference/WP_List_Table',
				'https://developer.wordpress.org/reference/classes/wp_list_table/',
				'#'
		);

		parent::__construct( $screen );
	}

	/**
	 * Action for `init` hook (see {@see DevHelper::admin_enqueue_scripts} for more details).
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

		wp_register_script( $this->slug, $script_url, array( 'jquery' ), false, true );
		wp_enqueue_script( $this->slug );
	}
}

endif;

/**
 * @var Screen_Table_Wizard $odwpdevhelper_screen_table
 */
$odwpdevhelper_screen_table = new Screen_Table_Wizard();
DevHelper::add_screen( $odwpdevhelper_screen_table );
