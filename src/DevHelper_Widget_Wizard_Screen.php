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

if( ! class_exists( 'DevHelper_Widget_Wizard_Screen' ) ) :

/**
 * Class that implements screen of Widget wizard.
 * 
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @since 0.1.0
 */
class DevHelper_Widget_Wizard_Screen extends DevHelper_Wizard_Screen_Prototype {

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

		// Set template class
		$this->template = new DevHelper_Widget_Wizard_Template();

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
			'default' => __( 'Default', DH_SLUG ),
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
		$classname = filter_input( INPUT_POST, 'classname' );
		$title = filter_input( INPUT_POST, 'title' );
		$description = filter_input( INPUT_POST, 'description' );
		$has_options = isset( $_POST['has_options' ] ) ? filter_input( INPUT_POST, 'has_options' ) : 'off';

		// Validate common values
		$values['classname'] = empty( $classname ) ? $this->template->get_default( 'classname' ) : $classname;
		$values['title'] = empty( $title ) ? $this->template->get_default( 'title' ) : $title;
		$values['description'] = empty( $description ) ? '' : $description;
		$values['has_options'] = ( strtolower( $has_options ) === 'on' ) ? true : false;

		// Append advanced values
		$values = array_merge( $this->process_advanced_options(), $values );

		// Set values into the template
		$this->template->values = $values;

		// Indicate that we should save wizard
		$this->should_save = true;
	}

	/**
	 * Render page self.
	 * 
	 * @param array $args (Optional.) Arguments for rendered template.
	 * @since 0.1.0
	 */
	public function render( $args = array() ) {

        // Check arguments
        if( ! is_array( $args ) ) {
            $args = array();
		}

		// ...

		// Gather all arguments
		$all_args = array_merge( $args, array(
			//...
		) );

		// Pass them...
		parent::render( $all_args );
	}

}
endif;
