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

if( ! class_exists( 'DevHelper_Plugin_Wizard_Template' ) ) {
    include DH_PATH . 'src/DevHelper_Plugin_Wizard_Template.php';
}

if( ! class_exists( 'DevHelper_Wizard_Screen_Prototype' ) ) {
    include DH_PATH . 'src/DevHelper_Wizard_Screen_Prototype.php';
}

if( ! class_exists( 'DevHelper_Plugin_Wizard_Screen' ) ) :

/**
 * Class that implements screen of Plugin wizard.
 * 
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @since 0.1.0
 */
class DevHelper_Plugin_Wizard_Screen extends DevHelper_Wizard_Screen_Prototype {

	/**
	 * Constructor.
	 * 
	 * @param \WP_Screen $screen Optional.
	 * @since 0.1.0
	 * @uses add_filter()
	 */
	public function __construct( \WP_Screen $screen = null ) {
		
		// Main properties
		$this->slug = 'plugin_wizard';
		$this->menu_title = __( 'New plugin', DH_SLUG );
		$this->page_title = __( 'Plugin wizard', DH_SLUG );

		// Specify help tabs
		$this->help_tabs[] = array(
			'id'      => $this->slug . '-help_tab',
			'title'   => __( 'Tables', DH_SLUG ),
			'content' => __( '<p style"colof: #f30;"><code>XXX</code> Fill this screen help!<p>', DH_SLUG ),
		);

		// Specify help sidebars
		$this->help_sidebars[] = sprintf(
			__( '<b>Usefull links</b><p><a href="%1$s" target="blank"><code>WP_List_Table</code></a> on <b>WordPress Codex</b>.</p><p><a href="%2$s" target="blank"><code>WP_List_Table</code></a> on <b>WordPress Code Reference</b>.</a></p><!-- <p><a href="%3$s" target="blank">Link 3</a> is the third link.</p> -->', DH_SLUG ),
			'http://codex.wordpress.org/Class_Reference/WP_List_Table',
			'https://developer.wordpress.org/reference/classes/wp_list_table/',
			'#'
		);

		// Set template
		$this->template = new DevHelper_Plugin_Wizard_Template();

		// Process screen's for

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
			'default' => __( 'Default', DH_SLUG ),
		);
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

}

endif;
