<?php
/**
 * @package odwp-devhelper
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
	 */
	public function __construct( WP_Screen $screen = null ) {
		$this->slug = 'cpt_wizard';
		$this->menu_title = __( 'New post type', DevHelper::SLUG );
		$this->page_title = __( 'Custom Post Type wizard', DevHelper::SLUG );
		$this->help_tabs[] = array(
			'id'      => $this->slug . '-help_tab',
			'title'   => __( 'CPT Wizard', DevHelper::SLUG ),
			'content' => __( '<p style"colof: #f30;"><code>XXX</code> Fill this screen help!<p>', DevHelper::SLUG ),
		);
		$this->help_sidebars[] = sprintf(
			__( '<b>Usefull links</b><p><a href="%1$s" target="blank">Post Types</a> on <b>WordPress Codex</b>.</p>', DevHelper::SLUG ),
			'https://codex.wordpress.org/Post_Types'
		);

		parent::__construct( $screen );
	}
}

endif;

/**
 * @var Screen_Cpt_Wizard $odwpdevhelper_screen_cpt_wizard
 */
$odwpdevhelper_screen_cpt_wizard = new Screen_Cpt_Wizard();
DevHelper::add_screen( $odwpdevhelper_screen_cpt_wizard );