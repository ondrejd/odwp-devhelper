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

if( ! class_exists( 'DevHelper_Template_File_Prototype' ) ) {
    include DH_PATH . 'src/DevHelper_Template_File_Prototype.php';
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
     * Template files.
     * 
     * @var array $values Array of `DevHelper_Template_File` instances.
     * @since 0.1.0
     */
    public $files = array();

    /**
     * Default template values.
     * 
     * @var array $defaults
     * @since 0.1.0
     */
    public $defaults = array();

    /**
     * Template values.
     * 
     * @var array $values
     * @since 0.1.0
     */
    public $values = array();

    /**
     * Constructor.
     * 
     * @param array $files Optional.
     * @param array $defaults Optional.
     * @param array $values Optional.
     * @return void
     * @since 0.1.0
     */
    public function __construct( $files = array(), $defaults = array(), $values = array() ) {

        if( ! is_array( $files ) ) {
            $files = array();
        }

        if( ! is_array( $defaults ) ) {
            $defaults = array();
        }

        if( ! is_array( $values ) ) {
            $values = array();
        }

        $this->files = $files;
        $this->defaults = $defaults;
        $this->values = $values;
    }

    /**
     * @internal Returns value for the default value by the key.
     * @param string $key
     * @return mixed
     * @since 0.1.0
     */
    public function get_default( $key ) {
        return $this->defaults[$key];
    }

    /**
     * Returns all default values.
     * 
     * @return array
     * @since 0.1.0
     */
    public function get_defaults() {
        return $this->defaults;
    }

    /**
     * @internal Returns value for the value by the key.
     * @param string $key
     * @return mixed
     * @since 0.1.0
     */
    public function get_value( $key ) {
        return isset( $this->values[$key] ) ? $this->values[$key] : $this->defaults[$key];
    }

    /**
     * Returns all values.
     * 
     * @return array
     * @since 0.1.0
     */
    public function get_values() {
        return $this->values;
    }

    /**
     * Render template preview.
     *
     * @param array $args Optional.
     * @since 0.1.0
     * @return void
     */
    abstract public function preview( $args = array() );

    /**
     * Create ZIP package from processed template.
     *
     * @param array $args Optional.
     * @since 0.1.0
     * @return string Path to the created ZIP file.
     *
     * @todo Finish this!
     */
    public function zip( $args = array() ) {
        throw new Exception( 'Not finished yet!' );
    }

}

endif;