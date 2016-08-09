<?php
/**
 * @package odwp-devhelper
 */

if ( ! class_exists( 'Wizard_Post_Type' ) ):

/**
 * Custom post type "Wizard".
 * @since 0.0.1
 */
class Wizard_Post_Type {
	/**
	 * @const string
	 * @since 0.0.1
	 */
	const SLUG = 'wizard';

	/**
	 * @access private
	 * @since 0.0.1
	 * @var Wizard_Post_Type $instance
	 */
	private static $instance;

	/**
	 * @return Wizard_Post_Type
	 * @since 0.0.1
	 */
	public static function get_instance() {
		if ( ! ( self::$instance instanceof Wizard_Post_Type ) ) {
			self::$instance = new Wizard_Post_Type();
		}

		return self::$instance;
	}

	/**
	 * @access private
	 * @since 0.0.1
	 * @uses plugin_dir_path()
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

		register_post_type( self::SLUG, $args );
	}
}

endif;

// Initialize custom post type
Wizard_Post_Type::get_instance();