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

if( ! class_exists( 'DevHelper_Template_Prototype' ) ):

/**
 * Prototype class for administration screens.
 * 
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @since 0.1.0
 */
abstract class DevHelper_Template_Prototype {

    /**
     * Render template preview.
     *
     * @param array $args Optional.
     * @since 0.1.0
     * @return void
     */
    abstract public function preview( $args = array() );

}

endif;