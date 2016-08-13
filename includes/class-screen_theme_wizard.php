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
	 * Constructor.
	 * @param WP_Screen $screen Optional.
	 * @since 0.0.1
	 */
	public function __construct( WP_Screen $screen = null ) {
		// Main properties
		$this->slug = 'theme_wizard';
		$this->menu_title = __( 'New theme', DevHelper::SLUG );
		$this->page_title = __( 'Theme wizard', DevHelper::SLUG );

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
				'simple' => __( 'Simple', DevHelper::SLUG ),
				'advanced' => __( 'Advanced', DevHelper::SLUG ),
				'wpframework'  => __( 'With WP Framework', DevHelper::SLUG ),
			);
		} );*/

		// Finish screen constuction
		parent::__construct( $screen );
	}
}

endif;

/**
 * @var Screen_Theme_Wizard $odwpdevhelper_screen_theme_wizard
 */
$odwpdevhelper_screen_theme_wizard = new Screen_Theme_Wizard();
DevHelper::add_screen( $odwpdevhelper_screen_theme_wizard );
