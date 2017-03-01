<?php
/**
 * Screen for "WordPress Widget" wizard.
 *
 * @author Ondřej Doněk <ondrejd@gmail.com>
 * @package odwp-devhelper
 * @since 0.1.0
 */

if ( ! class_exists( 'Screen_Widget_Wizard' ) ):

/**
 * Screen for "WordPress Widget" wizard.
 * @since 0.1.0
 */
class Screen_Widget_Wizard extends DevHelper_Screen_Prototype {
	/**
	 * Constructor.
	 * @param WP_Screen $screen Optional.
	 * @since 0.1.0
	 * @uses add_filter()
	 */
	public function __construct( WP_Screen $screen = null ) {
		// Main properties
		$this->slug = 'widget_wizard';
		$this->menu_title = __( 'New widget', DevHelper::SLUG );
		$this->page_title = __( 'WordPress widget wizard', DevHelper::SLUG );

		// Specify help tabs
		$this->help_tabs[] = array(
			'id'      => $this->slug . '-main_help_tab',
			'title'   => __( 'Widget Wizard', DevHelper::SLUG ),
			'content' => __( '<p><code>XXX</code> Finish this screen help!<p>', DevHelper::SLUG )
		);

		// Specify help sidebars
		$this->help_sidebars[] = sprintf(
			__( '<b>Usefull links</b><p><a href="%1$s" target="blank">Wordpress Widgets</a><br><a href="%2$s" target="blank">Widgets API</a>.</p>', DevHelper::SLUG ),
			'https://codex.wordpress.org/WordPress_Widgets',
            'https://codex.wordpress.org/Widgets_API'
		);

		// Finish screen constuction
		parent::__construct( $screen );
	}
}

endif;

/**
 * @var Screen_Widget_Wizard $odwpdevhelper_screen_widget_wizard
 */
$odwpdevhelper_screen_widget_wizard = new Screen_Widget_Wizard();
DevHelper::add_screen( $odwpdevhelper_screen_widget_wizard );
