<?php
/**
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @link https://github.com/ondrejd/odwp-devhelper for the canonical source repository
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @package odwp-devhelper
 * @since 0.1.0
 * 
 * @todo Don't save options to user meta values one by one but as a JSON array.
 */

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( ! class_exists( 'DevHelper_Wizard_Screen_Prototype' ) ) :

/**
 * Prototype class that is common for screen classes of all wizards.
 * 
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @since 0.1.0
 */
abstract class DevHelper_Wizard_Screen_Prototype extends DevHelper_Screen_Prototype {

	/**
	 * Constructor.
	 * 
	 * @param \WP_Screen $screen
	 * @return void
	 * @since 0.1.0
	 */
	public function __construct( \WP_Screen $screen = null ) {

		// Enable screen options
		$this->enable_screen_options = true;

		// Define screen options
		$this->options[$this->slug . '-used_template'] = array(
			'default' => 'simple',
			'label'   => __( 'Used template', DH_SLUG ),
			'option'  => $this->slug . '-used_template',
			'type'    => 'string',
		);
		$this->options[$this->slug . '-show_description'] = array(
			'label'   => __( 'Show description', DH_SLUG ),
			'default' => true,
			'option'  => $this->slug . '-show_description',
			'type'    => 'boolean',
		);

		// Set default help tabs
		$title = __( 'Screen options', DH_SLUG );
		$para1 = __( 'Pay attention to screen options - there is a setting named %1$s if you don\'t know what they are you can choose them and see in %2$s if they fit your needs.', DH_SLUG );
		$para2 = __( 'You can choose source codes template by your needs - if you are not satisfied with these templates they can be also extended via %1$sfilter%2$s  - for more details see %3$sdocumentation%4$s.', DH_SLUG );
		$link1 = __( 'Used template', DH_SLUG );
		$link2 = __( 'Generated Code', DH_SLUG );

		$this->help_tabs[] = array(
            'id'      => $this->slug . '-options_help_tab',
            'title'   => $title,
			'content' => sprintf(
				'<h4>%1$s</h4><p>%2$s</p><p>%3$s</p>',
				$title,
				sprintf( $para1, "<b>$link1</b>", "<b>$link2</b>" ),
				// TODO Add correct URLs!
				sprintf( $para2,
					'<a href="#" target="blank">', '</a>',
					'<a href="#" target="blank">', '</a>'
				)
			),
		);

		// Finish screen constuction
		parent::__construct( $screen );
	}

    /**
     * Action for `admin_menu` hook.
	 * 
     * @return void
	 * @see DevHelper_Screen_Prototype::admin_menu()
     * @since 0.1.0
     */
    public function admin_menu() {
		$this->hookname = add_submenu_page(
			'edit.php?post_type=' . DH_SLUG . '-wizard',
			$this->page_title,
			$this->menu_title,
			'manage_options',
			$this->slug,
			array( $this, 'render' )
		);

		add_action( 'load-' . $this->hookname, array( $this, 'screen_load' ) );
	}

	/**
	 * Returns array with available source code templates.
	 * 
	 * @return array
	 * @since 0.1.0
	 * @uses apply_filters()
	 */
	public function get_source_templates() {
		$templates = array(
			'default' => __( 'Default', DH_SLUG ),
		);
		
		/**
		 * Filter the templates used for the DevHelper wizard.
		 *
		 * Name of filter corresponds with slug of the particular wizard.
		 * For example for `Custom Post Type wizard` is filter name
		 * "devhelper_cpt_wizard_templates".
		 *
		 * @param array $templates Array with templates provided by DevHelper.
		 * @since 0.1.0
		 */
		return apply_filters( "devhelper_{$this->slug}_templates", $templates );
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

		$user = get_current_user_id();
		$opt_key_1 = $this->slug . '-used_template';
		$opt_key_2 = $this->slug . '-show_description';
		$opt_val_1 = get_user_meta( $user, $opt_key_1, true );
		$opt_val_2 = get_user_meta( $user, $opt_key_2, true );

		// Gather all arguments
		$all_args = array_merge( $args, array(
			'used_template'    => ( ! empty( $opt_val_1 ) ) ? $opt_val_1 : 'default',
			'show_description' => ( ! empty( $opt_val_2 ) ) ? $opt_val_2 : true,
			'wizard'           => $this,
		) );

		// Pass them...
		parent::render( $all_args );
	}

	/**
	 * Render common advanced options.
	 *
	 * @param boolean $show_description
	 * @return string
	 * @since 0.1.0
	 * @uses apply_filters()
	 */
	public function render_advanced_options( $show_description ) {
		ob_start();
		include( DH_PATH . 'partials/wizard-advanced_options.phtml' );

		$output = ob_get_clean();

		/**
		 * Filter wizard advanced options (HTML with part of form in <tr> element).
		 *
		 * Name of filter corresponds with slug of the particular wizard.
		 * For example for `Custom Post Type wizard` is filter name
		 * "devhelper_cpt_wizard_advanced_options_form".
		 *
		 * @param string $output Rendered HTML.
		 * @since 0.1.0
		 */
		return apply_filters( "devhelper_{$this->slug}_advanced_options_form", $output );
	}
	
	/**
	 * Render wizard form submit buttons.
	 * 
	 * @return string
	 * @since 0.1.0
	 * @uses apply_filters()
	 */
	public function render_submit_buttons() {
		ob_start();
		include( DH_PATH . 'partials/wizard-submit_buttons.phtml' );

		$output = ob_get_clean();

		/**
		 * Filter wizard form submit buttons.
		 *
		 * Name of filter corresponds with slug of the particular wizard.
		 * For example for `Custom Post Type wizard` is filter name
		 * "devhelper_cpt_wizard_form_submit_buttons".
		 *
		 * @param string $output Rendered HTML.
		 * @since 0.1.0
		 */
		return apply_filters( "devhelper_{$this->slug}_form_submit_buttons", $output );
	}

    /**
     * Renders screen options form.
     * 
     * @param array $additional_template_args Optional.
     * @return void
	 * @see DevHelper_Screen_Prototype::screen_options()
     * @since 0.1.0
     */
    public function screen_options( $additional_template_args = array() ) {
		$options = $this->get_screen_options();

		parent::screen_options( array(
			'show_description' => ( isset( $options['show_description'] ) ) ? $options['show_description'] : true,
			'templates' => $this->get_source_templates(),
			'used_template' => ( isset( $options['used_template'] ) ) ? $options['used_template'] : 'default',
		) );
	}

}

endif;
