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
     * Constructor.
     * 
     * @author Ondřej Doněk, <ondrejd@gmail.com>
     * @return void
     */
    public function __construct() {

        // We need to remove "Add new wizard" link.
        add_action( 'admin_menu', array( 'DevHelper_Wizard_CustomPostType', 'adjust_admin_menu' ), 999 );

        // Just show the message that post was successfully created
        if( isset( $_GET['created_new'] ) ) {
            DevHelper_Plugin::print_admin_notice(
                __( 'New wizard was successfully inserted. [2]', DH_SLUG ),
                'success', true
            );
        }
    }

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
            'menu_name' => __( 'Wizards', DH_SLUG ),
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
            'has_archive' => true,
            'show_in_admin_bar' => false,
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

    /**
     * Insert new item (from one of wizard forms). 
     * Given values SHOULD be already sanitized!
     * 
     * @param array $values Wizard values from the submitted form.
     * @return integer ID of the new post (wizard).
     * @since 0.1.0
     * @todo Values for `comment_status`, `ping_status` and `post_status` should be taken from plugin options!
     * @uses sanitize_title()
     * @uses wp_insert_post()
     */
    public static function insert_new( $args ) {

        // Finalize new post options
        $post_options = array(
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_status' => 'publish',
            'post_type' => self::SLUG,
        );

        // Create new post
        return wp_insert_post( array_merge( $post_options, $args ) );
    }

    /**
     * Hide "Add new wizard" link (which was created automatically).
     * 
     * @return void
     * @since 0.1.0
     */
    public static function adjust_admin_menu() {
        remove_submenu_page( 'edit.php?post_type=odwpdh-wizard', 'post-new.php?post_type=odwpdh-wizard' );
    }

}

endif;