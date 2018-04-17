<?php
/**
 * @author Ondřej Doněk <ondrejd@gmail.com>
 * @link https://github.com/ondrejd/odwp-devhelper for the canonical source repository
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @package odwp-devhelper
 * @since 0.1.0
 */

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( ! class_exists( 'DevHelper_Template_Prototype' ) ) {
    include DH_PATH . 'src/DevHelper_Template_Prototype.php';
}

if( ! class_exists( 'DevHelper_Widget_Wizard_Template' ) ):

/**
 * Prototype class for administration screens.
 * 
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @since 0.1.0
 */
class DevHelper_Widget_Wizard_Template extends DevHelper_Template_Prototype {

    /**
     * Constructor.
     * 
     * @param array $files Optional.
     * @param array $values Optional.
     * @return void
     * @since 0.1.0
     */
    public function __construct( $files = array(), $defaults = array(), $values = array() ) {

		// Files which will be generated
        $files = array(
            array(
                'filename' => 'class-my_widget.php',
                'filetype' => 'php',
            )
        );

		// Default template values
        $defaults = array(
            // Widget's own options
            'classname'      => __( 'My_Widget', DH_SLUG ),
            'title'          => __( 'My Widget', DH_SLUG ),
            'description'    => __( 'My awesome widget', DH_SLUG ),
            'has_options'    => false,
            // These are from `wizard-advanced_options.phtml`
            'use_textdomain' => true,
            'textdomain'     => 'textdomain',
            'textdomain_php' => null,
		);

		// Submitted (or default) values
		$values = $defaults;

		// Finalize class construction
		parent::__construct( $files, $defaults, $values );
    }

    /**
     * Render template preview.
     *
     * @param array $args Optional.
     * @since 0.1.0
     * @return void
     */
    public function preview( $args = array() ) {
?>
/**
 * File description ...
 *
 * @package my-example-widget
 * @since 1.0
 */

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

if ( ! class_exists( '<?php echo $this->values['classname']?>' ) ):

/**
 * Class description ...
 *
 * @link https://developer.wordpress.org/reference/classes/wp_widget/
 * @see \WP_Widget
 * @since 1.0
 */
class <?php echo $this->values['classname']?> extends \WP_Widget {

	/**
	 * Constructor.
	 *
	 * @return void
	 * @since 1.0
	 */
	function __construct() {
		$widget_ops = array( 
			'classname' => '<?php echo strtolower( $this->values['classname'] )?>',
<?php if( ! empty( $this->values['description'] ) ) : ?>
			'description' => <?php $this->textdomainize( $this->values['description'] )?>,
<?php endif ?>
		);
		parent::__construct( false, <?php $this->textdomainize( $this->values['title'] )?>, $widget_opts );
	}

	/**
	 * Widget output.
	 *
	 * @param array $args Display arguments including 'before_title', 'after_title', 'before_widget', and 'after_widget'.
     * @param array $instance The settings for the particular instance of the widget.
	 * @return void
	 * @since 1.0
	 */
	function widget( $args, $instance ) {
		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		echo <?php echo ( $this->values['use_textdomain'] ) ? "esc_html__( 'Hello, World!', {$this->get_textdomain_as_str_arg()} )" : "'Hello, World!'";?>;
		echo $args['after_widget'];
	}
<?php if( $this->values['has_options'] ) : ?>
	/**
	 * Save widget options.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array|bool Settings to save or bool false to cancel saving.
	 * @since 1.0
	 */
	function update( $new_instance, $old_instance ) {
		// ...
	}

	/**
	 * Output admin widget options form.
	 *
	 * @param array $instance Current settings.
     * @return string Default return is 'noform'.
	 * @since 1.0
	 */
	function form( $instance ) {
		// ...
	}<?php endif ?>

} // End of <?php echo $this->values['classname']?>

endif;

// Initialize widget
add_action( 'widgets_init', function() {
	register_widget( '<?php echo $this->values['classname']?>' );
});
<?php
    }

}

endif;