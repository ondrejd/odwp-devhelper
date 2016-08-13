<?php
/**
 * @package odwp-devhelper
 */

if ( ! class_exists( 'Screen_Plugin_Wizard' ) ):

/**
 * @since 0.0.1
 */
class Screen_Plugin_Wizard extends DevHelper_Screen_Prototype {
	/**
	 * Constructor.
	 * @param WP_Screen $screen Optional.
	 * @since 0.0.1
	 */
	public function __construct( WP_Screen $screen = null ) {
		// Main properties
		$this->slug = 'plugin_wizard';
		$this->menu_title = __( 'New plugin', DevHelper::SLUG );
		$this->page_title = __( 'Plugin wizard', DevHelper::SLUG );

		// Specify help tabs
		$this->help_tabs[] = array(
			'id'      => $this->slug . '-help_tab',
			'title'   => __( 'Tables', DevHelper::SLUG ),
			'content' => __( '<p style"colof: #f30;"><code>XXX</code> Fill this screen help!<p>', DevHelper::SLUG ),
		);

		// Specify help sidebars
		$this->help_sidebars[] = sprintf(
			__( '<b>Usefull links</b><p><a href="%1$s" target="blank"><code>WP_List_Table</code></a> on <b>WordPress Codex</b>.</p><p><a href="%2$s" target="blank"><code>WP_List_Table</code></a> on <b>WordPress Code Reference</b>.</a></p><!-- <p><a href="%3$s" target="blank">Link 3</a> is the third link.</p> -->', DevHelper::SLUG ),
			'http://codex.wordpress.org/Class_Reference/WP_List_Table',
			'https://developer.wordpress.org/reference/classes/wp_list_table/',
			'#'
		);

		// TODO Overwrite available templates in screen options
		/*add_filter( "devhelper_{$this->slug}_templates", function( $templates ) {
			return array(
				'default' => __( 'Default', DevHelper::SLUG ),
			);
		} );*/

		// Finish screen constuction
		parent::__construct( $screen );
	}
}

endif;

/**
 * @var Screen_Plugin_Wizard $odwpdevhelper_screen_plugin_wizard
 */
$odwpdevhelper_screen_plugin_wizard = new Screen_Plugin_Wizard();
DevHelper::add_screen( $odwpdevhelper_screen_plugin_wizard );
