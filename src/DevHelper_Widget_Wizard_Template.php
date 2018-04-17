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

if ( ! class_exists( 'My_Widget' ) ):

/**
 * Class description ...
 *
 * @link https://developer.wordpress.org/reference/classes/wp_widget/
 * @see \WP_Widget
 * @since 1.0
 */
class My_Widget extends \WP_Widget {

	/**
	 * Constructor.
	 *
	 * @return void
	 * @since 1.0
	 */
	function __construct() {
		$widget_ops = array( 
			'classname' => 'my_widget',
			'description' => 'My Widget is awesome',
		);
		parent::__construct( false, __( 'My New Widget Title', 'textdomain' ), $widget_opts );
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

		echo esc_html__( 'Hello, World!', 'text_domain' );
		echo $args['after_widget'];
	}

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
	}

} // End of My_Widget

endif;

// Initialize widget
add_action( 'widgets_init', function() {
	register_widget( 'My_Widget' );
});
<?php
    }

}

endif;