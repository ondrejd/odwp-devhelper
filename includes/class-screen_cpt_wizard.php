<?php
/**
 * Screen for Custom Post Type wizard.
 *
 * @author Ondřej Doněk <ondrejd@gmail.com>
 * @package odwp-devhelper
 * @since 0.1.0
 */

if ( ! class_exists( 'Screen_Cpt_Wizard' ) ):

/**
 * Screen for Custom Post Type wizard.
 * @since 0.1.0
 */
class Screen_Cpt_Wizard extends DevHelper_Screen_Prototype {
	/**
	 * Constructor.
	 * @param WP_Screen $screen Optional.
	 * @since 0.1.0
	 * @uses add_filter()
	 */
	public function __construct( WP_Screen $screen = null ) {
		// Main properties
		$this->slug = 'cpt_wizard';
		$this->menu_title = __( 'New post type', DevHelper::SLUG );
		$this->page_title = __( 'Custom Post Type wizard', DevHelper::SLUG );

		// Specify help tabs
		$this->help_tabs[] = array(
			'id'      => $this->slug . '-main_help_tab',
			'title'   => __( 'CPT Wizard', DevHelper::SLUG ),
			'content' => __( '<p><code>XXX</code> Finish this screen help!<p>', DevHelper::SLUG )
		);

		// Specify help sidebars
		$this->help_sidebars[] = sprintf(
			__( '<b>Usefull links</b><p><a href="%1$s" target="blank">Post Types</a> on <b>WordPress Codex</b> especially part about <a href="%2$s" target="blank">Custom Post Types</a>.</p>', DevHelper::SLUG ),
			'https://codex.wordpress.org/Post_Types',
			'https://codex.wordpress.org/Post_Types#Custom_Post_Types'
		);

		// Overwrite available templates in screen options
		add_filter( "devhelper_{$this->slug}_templates", function( $templates ) {
			return array(
				'simple' => __( 'Simple function', DevHelper::SLUG ),
				'class'  => __( 'Singleton class', DevHelper::SLUG ),
			);
		} );

		// Finish screen constuction
		parent::__construct( $screen );
	}

	/**
	 * Render page self.
	 * @param array $args (Optional.) Arguments for rendered template.
	 * @since 0.1.0
	 * @uses apply_filters()
	 */
	public function render( $args = array() ) {
		parent::render( array(
			'menu_position_options' => $this->get_menu_position_select(),
			'supports_options'      => $this->get_supports_options(),
		) );
	}

	/**
	 * Return array with options for custom post type menu position select.
	 * @since 0.1.0
	 * @uses apply_filters()
	 */
	public function get_menu_position_select() {
		$options = array(
			5   => __( 'Below Posts', DevHelper::SLUG ),
			10  => __( 'Below Media', DevHelper::SLUG ),
			15  => __( 'Below Links', DevHelper::SLUG ),
			20  => __( 'Below Pages', DevHelper::SLUG ),
			25  => __( 'Below Comments', DevHelper::SLUG ),
			60  => __( 'Below first separator', DevHelper::SLUG ),
			65  => __( 'Below Plugins', DevHelper::SLUG ),
			70  => __( 'Below Users', DevHelper::SLUG ),
			75  => __( 'Below Tools', DevHelper::SLUG ),
			80  => __( 'Below Settings', DevHelper::SLUG ),
			100 => __( 'Below second separator', DevHelper::SLUG ),
		);

		/**
		 * Filter array with options for custom post type menu position select.
		 *
		 * @since 0.1.0
		 *
		 * @param array $options Array with options.
		 */
		return apply_filters( "devhelper_{$this->slug}_supports_select_options", $options );
	}

	/**
	 * Return array with options for custom post type supports select.
	 * @since 0.1.0
	 * @uses apply_filters()
	 */
	public function get_supports_options() {
		$options = array(
		  'title'           => __( 'title', DevHelper::SLUG ),
		  'editor'          => __( 'editor (content)', DevHelper::SLUG ),
		  'author'          => __( 'author', DevHelper::SLUG ),
		  'thumbnail'       => __( 'thumbnail', DevHelper::SLUG ),
		  'excerpt'         => __( 'excerpt', DevHelper::SLUG ),
		  'trackbacks'      => __( 'trackbacks', DevHelper::SLUG ),
		  'custom-fields'   => __( 'custom-fields', DevHelper::SLUG ),
		  'comments'        => __( 'comments', DevHelper::SLUG ),
		  'revisions'       => __( 'revisions', DevHelper::SLUG ),
		  'page-attributes' => __( 'page-attributes', DevHelper::SLUG ),
		  'post-formats'    => __( 'post-formats', DevHelper::SLUG ),
		);

		/**
		 * Filter array with options for custom post type supports select.
		 *
		 * @since 0.1.0
		 *
		 * @param array $supports_arr Array with options.
		 */
		return apply_filters( "devhelper_{$this->slug}_supports_select_options", $options );
	}
}

endif;

/**
 * @var Screen_Cpt_Wizard $odwpdevhelper_screen_cpt_wizard
 */
$odwpdevhelper_screen_cpt_wizard = new Screen_Cpt_Wizard();
DevHelper::add_screen( $odwpdevhelper_screen_cpt_wizard );
