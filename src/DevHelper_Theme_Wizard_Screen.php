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

if( ! class_exists( 'DevHelper_Theme_Wizard_Template' ) ) {
    include DH_PATH . 'src/DevHelper_Theme_Wizard_Template.php';
}

if( ! class_exists( 'DevHelper_Wizard_Screen_Prototype' ) ) {
    include DH_PATH . 'src/DevHelper_Wizard_Screen_Prototype.php';
}

if( ! class_exists( 'DevHelper_Theme_Wizard_Screen' ) ) :

/**
 * Class that implements screen of Theme wizard.
 * 
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @since 0.1.0
 */
class DevHelper_Theme_Wizard_Screen extends DevHelper_Wizard_Screen_Prototype {

	/**
	 * Constructor.
	 * 
	 * @param \WP_Screen $screen Optional.
	 * @since 0.1.0
	 * @uses add_filter()
	 */
	public function __construct( \WP_Screen $screen = null ) {

		// Main properties
		$this->slug = 'theme_wizard';
		$this->menu_title = __( 'New theme', DH_SLUG );
		$this->page_title = __( 'Theme wizard', DH_SLUG );

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
		$this->template = new DevHelper_Theme_Wizard_Template();

		// Process screen's form
		$this->process_form();

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
			'simple' => __( 'Simple', DH_SLUG ),
			'advanced' => __( 'Advanced', DH_SLUG ),
			'wpframework'  => __( 'With WP Framework', DH_SLUG ),
		);
	}

	/**
	 * Process wizard's form.
	 *
	 * @return void
	 * @since 0.1.0
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
	}
	
}

endif;
