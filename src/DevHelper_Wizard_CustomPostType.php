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

if( ! class_exists( 'DevHelper_Wizard_CustomPostType' ) ) :

/**
 * Our custom post type.
 * 
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @since 0.1.0
 */
class DevHelper_Wizard_CustomPostType {

    /**
     * @var string
     * @since 0.1.0
     */
    const SLUG = DH_SLUG . '-wizard';

    /**
     * Initialize our custom post type.
     * 
     * @return void
     * @since 0.1.0
     */
    public static function init_cpt() {

        /**
         * @var array $labels Labels for new custom post type.
         */
        $labels = array(
            'name' => _x( 'Wizards', 'post type general name', DH_SLUG ),
            'singular_name' => _x( 'New wizard', 'post type singular name', DH_SLUG ),
            'add_new' => _x( 'Add wizard', 'add new course', DH_SLUG ),
            'add_new_item' => __( 'Add new wizard', DH_SLUG ),
            'edit_item' => __( 'Edit wizard', DH_SLUG ),
            'new_item' => __( 'New wizard', DH_SLUG ),
            'view_item' => __( 'Show wizard', DH_SLUG ),
            'search_items' => __( 'Search wizards', DH_SLUG ),
            'not_found' => __( 'No wizard was found.', DH_SLUG ),
            'not_found_in_trash' => __( 'No wizard was found in trash.', DH_SLUG ),
            'all_items' => __( 'Finished', DH_SLUG ),
            'archives' => __( 'Wizards archive', DH_SLUG ),
            'menu_name' => __( 'Wizards', DH_SLUG )
        );

        /**
         * @var array $args Custom post type arguments.
         */
        $args = array(
            'labels' => $labels,
            'description' => __( 'Wizards created by DevHelper.', DH_SLUG ),
            'public' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-welcome-learn-more',
            'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'author' ),
            'taxonomies' => array(),
            'has_archive' => true
        );

        /**
         * Filter wizard post type arguments.
         * 
         * @param array $arguments Wizard post type arguments.
         * @since 0.1.0
         */
        $args = apply_filters( 'devhelper_' . self::SLUG . '_post_type_arguments', $args );

        register_post_type( self::SLUG, $args );
    }

}

endif;