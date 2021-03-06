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

if( ! class_exists( 'DevHelper_CustomPostType_Wizard_Template' ) ) {
    include DH_PATH . 'src/DevHelper_CustomPostType_Wizard_Template.php';
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

		// Set template
		$this->template = new DevHelper_CustomPostType_Wizard_Template();

		// Process screen's form
		$this->process_form();

		// Process test submit
		$this->process_test();

		// Process download submit
		$this->process_download();

		// Finish screen constuction
		parent::__construct( $screen );
	}

	/**
	 * Set templates types for the wizard.
	 * 
	 * @param array $templates
	 * @return array
	 * @since 0.1.0
	 */
	public function filter_templates( $templates ) {
		return array(
			'simple' => __( 'Simple function', DH_SLUG ),
			'class'  => __( 'Singleton class', DH_SLUG ),
		);
	}

	/**
	 * Action for `init` hook (see {@see DevHelper::admin_enqueue_scripts} for more details).
	 * 
	 * @return void
	 * @since 0.1.0
	 * @uses plugins_url()
	 * @uses wp_register_script()
	 * @uses wp_enqueue_script()
	 */
	public function admin_enqueue_scripts() {
		$screen = $this->get_screen();

		if ( $screen->base != $this->hookname) {
			return;
		}

		$script_url = plugins_url( 'assets/js/screen-cpt_wizard.js', dirname( __FILE__ ) );

		wp_register_script( $this->slug, $script_url, array( 'jquery' ), false, true );
		wp_enqueue_script( $this->slug );
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
	 * Process wizard's form.
	 *
	 * @return void
	 * @since 0.1.0
	 * @todo Check NONCE!
	 */
	public function process_form() {
		$values = array();

		if( ! isset( $_POST['wizard-submit1'] ) && ! isset( $_POST['wizard-submit2'] ) ) {
			return;
		}

		// Collect common values
		//...

		// Validate common values
		//...

		// Append advanced values
		$values = array_merge( $this->process_advanced_options(), $values );

		// Set values into the template
		$this->template->values = $values;

		// Indicate that we should save wizard
		if( isset( $_POST['wizard-submit2'] ) ) {
			$this->should_save = true;
		}
	}

	/**
	 * Process test submit from wizard's form.
	 *
	 * @return void
	 * @since 0.1.0
	 * @todo Check NONCE!
	 */
	public function process_test() {

		// Check if we should process test
		if( ! isset( $_POST['wizard-submit3'] ) ) {
			return;
		}

		//...

		$this->should_test = true;
	}

	/**
	 * Process download submit from wizard's form.
	 *
	 * @return void
	 * @since 0.1.0
	 * @todo Check NONCE!
	 */
	public function process_download() {

		// Check if we should process download
		if( ! isset( $_POST['wizard-submit4'] ) ) {
			return;
		}

		//...

		$this->should_download = true;
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
