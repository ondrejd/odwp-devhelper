<?php
/**
 * Custom post type "Wizard".
 *
 * @author Ondřej Doněk <ondrejd@gmail.com>
 * @package odwp-devhelper
 * @since 0.0.1
 */

if ( ! class_exists( 'Wizard_Post_Type' ) ):

/**
 * Custom post type "Wizard".
 * @since 0.0.1
 */
class Wizard_Post_Type {
	/**
	 * @var string
	 * @since 0.0.1
	 */
	const SLUG = 'wizard';

	/**
	 * Holds instance of self (part of singleton implementation).
	 * @access private
	 * @since 0.0.1
	 * @var Wizard_Post_Type $instance
	 */
	private static $instance;

	/**
	 * Returns instance of self (part of singleton implementation).
	 * @return Wizard_Post_Type
	 * @since 0.0.1
	 */
	public static function get_instance() {
		if ( ! ( self::$instance instanceof self ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 * @access private
	 * @since 0.0.1
	 * @uses apply_filters()
	 * @uses register_post_type()
	 */
	private function __construct() {
		$labels = array(
			'name' => _x( 'Wizards', 'post type general name', DevHelper::SLUG ),
			'singular_name' => _x( 'New wizard', 'post type singular name', DevHelper::SLUG ),
			'add_new' => _x( 'Add wizard', 'add new course', DevHelper::SLUG ),
			'add_new_item' => __( 'Add new wizard', DevHelper::SLUG ),
			'edit_item' => __( 'Edit wizard', DevHelper::SLUG ),
			'new_item' => __( 'New wizard', DevHelper::SLUG ),
			'view_item' => __( 'Show wizard', DevHelper::SLUG ),
			'search_items' => __( 'Search wizards', DevHelper::SLUG ),
			'not_found' => __( 'No wizard was found.', DevHelper::SLUG ),
			'not_found_in_trash' => __( 'No wizard was found in trash.', DevHelper::SLUG ),
			'all_items' => __( 'Finished', DevHelper::SLUG ),
			'archives' => __( 'Wizards archive', DevHelper::SLUG ),
			'menu_name' => __( 'Wizards', DevHelper::SLUG )
		);

		$args = array(
			'labels' => $labels,
			'description' => __( 'Wizards created by DevHelper.', DevHelper::SLUG ),
			'public' => true,
			'menu_position' => 5,
			'menu_icon' => 'dashicons-welcome-learn-more',
			//'capability_type' => 'course',
			//'map_meta_cap' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments','revisions','author' ),
			'taxonomies' => array(),
			'has_archive' => true
		);

		/**
		 * Filter wizard post type arguments.
		 *
		 * @since 0.1.0
		 *
		 * @param array $arguments Wizard post type arguments.
		 */
		$args = apply_filters( 'devhelper_' . self::SLUG . '_post_type_arguments', $args );

		register_post_type( self::SLUG, $args );
	}
}

endif;

// Initialize custom post type
Wizard_Post_Type::get_instance();
