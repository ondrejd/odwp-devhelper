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

if( ! class_exists( 'DevHelper_Wizard_Screen_Prototype' ) ) {
    include DH_PATH . 'src/DevHelper_Wizard_Screen_Prototype.php';
}

if( ! class_exists( 'DevHelper_CustomPostType_Wizard_Screen' ) ) :

/**
 * Class that implements screen of Custom Post Type wizard.
 * 
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @since 0.1.0
 */
class DevHelper_CustomPostType_Wizard_Screen extends DevHelper_Wizard_Screen_Prototype {

	/**
	 * Constructor.
	 * 
	 * @param \WP_Screen $screen Optional.
	 * @since 0.1.0
	 * @uses add_filter()
	 */
	public function __construct( \WP_Screen $screen = null ) {

		// Main properties
		$this->slug = 'cpt_wizard';
		$this->menu_title = __( 'New post type', DH_SLUG );
		$this->page_title = __( 'Custom Post Type wizard', DH_SLUG );

		// Specify help tabs
		$this->help_tabs[] = array(
			'id'      => $this->slug . '-main_help_tab',
			'title'   => __( 'CPT Wizard', DH_SLUG ),
			'content' => __( '<p><code>XXX</code> Finish this screen help!<p>', DH_SLUG )
		);

		// Specify help sidebars
		$this->help_sidebars[] = sprintf(
			__( '<b>Usefull links</b><p><a href="%1$s" target="blank">Post Types</a> on <b>WordPress Codex</b> especially part about <a href="%2$s" target="blank">Custom Post Types</a>.</p>', DH_SLUG ),
			'https://codex.wordpress.org/Post_Types',
			'https://codex.wordpress.org/Post_Types#Custom_Post_Types'
		);

		// Customize code templates
		add_filter( "devhelper_{$this->slug}_templates", function( $templates ) {
			return array(
				'simple' => __( 'Simple function', DH_SLUG ),
				'class'  => __( 'Singleton class', DH_SLUG ),
			);
		} );

		// Finish screen constuction
		parent::__construct( $screen );
	}

	/**
	 * Render page self.
	 * 
	 * @param array $args (Optional.) Arguments for rendered template.
	 * @since 0.1.0
	 */
	public function render( $args = array() ) {
		parent::render( array(
			'menu_position_options' => $this->get_menu_position_select(),
			'supports_options'      => $this->get_supports_options(),
		) );
	}

	/**
	 * Return array with options for custom post type menu position select.
	 * 
	 * @return void
	 * @since 0.1.0
	 * @uses apply_filters()
	 */
	public function get_menu_position_select() {
		$options = array(
			5   => __( 'Below Posts', DH_SLUG ),
			10  => __( 'Below Media', DH_SLUG ),
			15  => __( 'Below Links', DH_SLUG ),
			20  => __( 'Below Pages', DH_SLUG ),
			25  => __( 'Below Comments', DH_SLUG ),
			60  => __( 'Below first separator', DH_SLUG ),
			65  => __( 'Below Plugins', DH_SLUG ),
			70  => __( 'Below Users', DH_SLUG ),
			75  => __( 'Below Tools', DH_SLUG ),
			80  => __( 'Below Settings', DH_SLUG ),
			100 => __( 'Below second separator', DH_SLUG ),
		);

		/**
		 * Filter array with options for custom post type menu position select.
		 *
		 * @param array $options Array with options.
		 * @since 0.1.0
		 */
		return apply_filters( "devhelper_{$this->slug}_supports_select_options", $options );
	}

	/**
	 * Return array with options for custom post type supports select.
	 * @return void
	 * @since 0.1.0
	 * @uses apply_filters()
	 */
	public function get_supports_options() {
		$options = array(
		  'title'           => __( 'title', DH_SLUG ),
		  'editor'          => __( 'editor (content)', DH_SLUG ),
		  'author'          => __( 'author', DH_SLUG ),
		  'thumbnail'       => __( 'thumbnail', DH_SLUG ),
		  'excerpt'         => __( 'excerpt', DH_SLUG ),
		  'trackbacks'      => __( 'trackbacks', DH_SLUG ),
		  'custom-fields'   => __( 'custom-fields', DH_SLUG ),
		  'comments'        => __( 'comments', DH_SLUG ),
		  'revisions'       => __( 'revisions', DH_SLUG ),
		  'page-attributes' => __( 'page-attributes', DH_SLUG ),
		  'post-formats'    => __( 'post-formats', DH_SLUG ),
		);

		/**
		 * Filter array with options for custom post type supports select.
		 *
		 * @param array $supports_arr Array with options.
		 * @since 0.1.0
		 */
		return apply_filters( "devhelper_{$this->slug}_supports_select_options", $options );
	}

}

endif;
