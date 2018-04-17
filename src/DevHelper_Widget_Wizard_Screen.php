<?php
/**
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @link https://github.com/ondrejd/odwp-devhelper for the canonical source repository
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @package odwp-devhelper
 * @since 0.1.0
 */

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( ! class_exists( 'DevHelper_Widget_Wizard_Template' ) ) {
    include DH_PATH . 'src/DevHelper_Widget_Wizard_Template.php';
}

if( ! class_exists( 'DevHelper_Widget_Wizard_Screen' ) ) :

/**
 * Class that implements screen of Widget wizard.
 * 
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @since 0.1.0
 */
class DevHelper_Widget_Wizard_Screen extends DevHelper_Wizard_Screen_Prototype {

	/**
	 * @var DevHelper_Widget_Wizard_Template $template
	 * @since 0.1.0
	 */
	public $template;

	/**
	 * Constructor.
	 * 
	 * @param \WP_Screen $screen Optional.
	 * @since 0.1.0
	 * @uses add_filter()
	 */
	public function __construct( \WP_Screen $screen = null ) {

		// Main properties
		$this->slug = 'widget_wizard';
		$this->menu_title = __( 'New widget', DH_SLUG );
		$this->page_title = __( 'WordPress widget wizard', DH_SLUG );

		// Specify help tabs
		$this->help_tabs[] = array(
			'id'      => $this->slug . '-main_help_tab',
			'title'   => __( 'Widget Wizard', DH_SLUG ),
			'content' => __( '<p><code>XXX</code> Finish this screen help!<p>', DH_SLUG )
		);

		// Specify help sidebars
		$this->help_sidebars[] = sprintf(
			__( '<b>Usefull links</b><p><a href="%1$s" target="blank">Wordpress Widgets</a><br><a href="%2$s" target="blank">Widgets API</a>.</p>', DH_SLUG ),
			'https://codex.wordpress.org/WordPress_Widgets',
            'https://codex.wordpress.org/Widgets_API'
		);

		// Customize code templates
		add_filter( "devhelper_{$this->slug}_templates", function( $templates ) {
			return array(
				'default' => __( 'Default', DH_SLUG ),
			);
		} );

		// Set template
		$this->template = new DevHelper_Widget_Wizard_Template();

		// Finish screen constuction
		parent::__construct( $screen );
	}

}
endif;
